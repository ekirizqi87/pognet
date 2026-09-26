/**
 * assets/js/admin-po-list.js — GNetindo Admin PO Workflow
 */
(function () {
  "use strict";

  var BASE = (window.GNETINDO && window.GNETINDO.baseUrl) || "";

  var state = {
    periode: "all", // all | today | week | month | year | custom
    from: "",
    to: "",
    status: "all",
    search: "",
    page: 1,
    limit: 10,
  };

  var $ = function (s) {
    return document.querySelector(s);
  };

  // DOM
  var elTbody = $("#poTableBody");
  var elInfo = $("#paginationInfo");
  var elCtrl = $("#paginationControls");
  var elSearch = $("#searchInput");
  var elSuggest = $("#searchSuggest");
  var elPeriode = $("#filterPeriode");
  var elStatus = $("#filterStatus");
  var elFrom = $("#filterFrom");
  var elTo = $("#filterTo");
  var elCustom = $("#customRange");
  var elApply = $("#btnApply");
  var elReset = $("#btnReset");

  // Modal
  var modal = $("#wfModal");
  var mTitle = $("#wfTitle");
  var mBody = $("#wfBody");
  var mSubmit = $("#wfSubmit");
  var mCancel = $("#wfCancel");
  var mClose = $("#wfClose");
  var currentPo = null;
  var currentAction = null;

  // ============ HELPERS ============
  function esc(s) {
    return String(s ?? "").replace(/[&<>"']/g, function (c) {
      return {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
      }[c];
    });
  }
  function fmtRupiah(n) {
    n = Number(n) || 0;
    return "Rp " + n.toLocaleString("id-ID");
  }
  function fmtDate(s) {
    if (!s) return "-";
    var bulan = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "Mei",
      "Jun",
      "Jul",
      "Agu",
      "Sep",
      "Okt",
      "Nov",
      "Des",
    ];
    var d = new Date(String(s).replace(" ", "T"));
    if (isNaN(d.getTime())) return s;
    return (
      String(d.getDate()).padStart(2, "0") +
      " " +
      bulan[d.getMonth()] +
      " " +
      d.getFullYear()
    );
  }
  function badgeFor(s) {
    var map = {
      1: ["pending", "Diajukan"],
      2: ["install", "Diproses"],
      3: ["install", "Instalasi"],
      4: ["active", "Aktif"],
      5: ["cancel", "Batal"],
    };
    return map[s] || ["pending", "?"];
  }
  function apiFetch(url, opts) {
    return fetch(
      BASE + url,
      Object.assign({ credentials: "same-origin" }, opts || {}),
    ).then(function (r) {
      return r.json();
    });
  }
  function debounce(fn, ms) {
    var t;
    return function () {
      var args = arguments,
        ctx = this;
      clearTimeout(t);
      t = setTimeout(function () {
        fn.apply(ctx, args);
      }, ms);
    };
  }

  // ============ BUILD QUERY ============
  function buildQuery(extra) {
    var q = [];
    q.push("periode=" + encodeURIComponent(state.periode));
    q.push("status=" + encodeURIComponent(state.status));
    q.push("search=" + encodeURIComponent(state.search));
    q.push("page=" + state.page);
    q.push("limit=" + state.limit);

    if (state.periode === "custom") {
      if (state.from) q.push("from=" + encodeURIComponent(state.from));
      if (state.to) q.push("to=" + encodeURIComponent(state.to));
    }
    if (extra) q = q.concat(extra);
    return q.join("&");
  }

  // ============ LOAD LIST ============
  function loadList() {
    elTbody.innerHTML =
      '<tr><td colspan="7" class="table-empty">Memuat data…</td></tr>';
    var url = "/admin/api/po-list.php?" + buildQuery();
    return apiFetch(url)
      .then(function (res) {
        if (!res.success) throw new Error(res.message || "Gagal memuat");
        renderTable(res.data, res.pagination);
        updateStats(res.data);
      })
      .catch(function (err) {
        elTbody.innerHTML =
          '<tr><td colspan="7" class="table-empty">Gagal memuat: ' +
          esc(err.message) +
          "</td></tr>";
      });
  }

  function updateStats(rows) {
    var c = { 1: 0, 2: 0, 3: 0, 4: 0 };
    rows.forEach(function (r) {
      if (c[r.status_progress] !== undefined) c[r.status_progress]++;
    });
    $("#statPending").textContent = c[1];
    $("#statProcess").textContent = c[2];
    $("#statInstall").textContent = c[3];
    $("#statActive").textContent = c[4];
  }

  function renderTable(rows, pag) {
    if (!rows.length) {
      elTbody.innerHTML =
        '<tr><td colspan="7" class="table-empty">Tidak ada data PO.</td></tr>';
      renderPagination(pag);
      return;
    }
    var html = "";
    rows.forEach(function (r) {
      var b = badgeFor(r.status_progress);
      var bayar =
        r.payment_status === "paid"
          ? '<span class="badge badge--active">Lunas</span>'
          : '<span class="badge badge--pending">Belum</span>';

      html +=
        '<tr data-id="' +
        r.id_po +
        '">' +
        '<td class="po-cell-number">' +
        esc(r.kode_po) +
        "</td>" +
        '<td class="po-cell-name">' +
        esc(r.nm_customer) +
        '<span class="po-cell-sub">' +
        esc(r.no_telp || "-") +
        "</span></td>" +
        "<td>" +
        esc(r.nm_paket || "-") +
        '<span class="po-cell-sub">' +
        fmtRupiah(r.harga_jual) +
        "</span></td>" +
        "<td>" +
        fmtDate(r.tgl_diajukan) +
        "</td>" +
        '<td><span class="badge badge--' +
        b[0] +
        '">' +
        b[1] +
        "</span></td>" +
        "<td>" +
        bayar +
        "</td>" +
        '<td><div class="row-actions">' +
        '<button class="btn-action btn-action--primary" data-act="detail" data-id="' +
        r.id_po +
        '">Detail</button>' +
        (r.status_progress === 1
          ? '<button class="btn-action" data-act="process" data-id="' +
            r.id_po +
            '">Proses</button>'
          : "") +
        (r.status_progress === 2
          ? '<button class="btn-action btn-action--success" data-act="install" data-id="' +
            r.id_po +
            '">Instalasi</button>'
          : "") +
        (r.status_progress === 3
          ? '<button class="btn-action btn-action--success" data-act="activate" data-id="' +
            r.id_po +
            '">Aktivasi</button>'
          : "") +
        (r.status_progress >= 1 && r.status_progress < 4
          ? '<button class="btn-action btn-action--danger" data-act="cancel" data-id="' +
            r.id_po +
            '">Batal</button>'
          : "") +
        (r.status_progress === 4
          ? '<a class="btn-action" href="' +
            BASE +
            "/admin/po-print/" +
            r.id_po +
            '" target="_blank">Cetak</a>'
          : "") +
        (r.status_progress === 4 && r.payment_status !== "paid"
          ? '<button class="btn-action btn-action--primary" data-act="payment" data-id="' +
            r.id_po +
            '">Bayar</button>'
          : "") +
        (r.status_progress === 4 && r.payment_status === "paid"
          ? '<a class="btn-action btn-action--success" href="' +
            BASE +
            "/admin/po-berita-acara/" +
            r.id_po +
            '" target="_blank">BA</a>'
          : "") +
        "</div></td>" +
        "</tr>";
    });
    elTbody.innerHTML = html;
    renderPagination(pag);
  }

  function renderPagination(pag) {
    if (!pag || !pag.total) {
      elInfo.textContent = "Menampilkan 0 data";
      elCtrl.innerHTML = "";
      return;
    }
    var start = (pag.page - 1) * pag.limit + 1;
    var end = Math.min(pag.page * pag.limit, pag.total);
    elInfo.textContent =
      "Menampilkan " + start + "–" + end + " dari " + pag.total + " data";
    elCtrl.innerHTML = "";

    function makeBtn(label, page, opts) {
      opts = opts || {};
      var b = document.createElement("button");
      b.className = "page-btn" + (opts.active ? " is-active" : "");
      b.type = "button";
      b.textContent = label;
      b.disabled = !!opts.disabled;
      b.addEventListener("click", function () {
        state.page = page;
        loadList();
      });
      return b;
    }
    elCtrl.appendChild(makeBtn("‹", pag.page - 1, { disabled: pag.page <= 1 }));
    var max = 5;
    var sp = Math.max(1, pag.page - Math.floor(max / 2));
    var ep = Math.min(pag.totalPages, sp + max - 1);
    sp = Math.max(1, ep - max + 1);
    for (var p = sp; p <= ep; p++) {
      elCtrl.appendChild(makeBtn(String(p), p, { active: p === pag.page }));
    }
    elCtrl.appendChild(
      makeBtn("›", pag.page + 1, { disabled: pag.page >= pag.totalPages }),
    );
  }

  // ============ FILTER EVENTS ============
  if (elPeriode) {
    elPeriode.addEventListener("change", function () {
      state.periode = elPeriode.value;
      if (state.periode === "custom") {
        elCustom.classList.add("is-visible");
      } else {
        elCustom.classList.remove("is-visible");
        // Langsung apply untuk preset
        state.page = 1;
        loadList();
      }
    });
  }
  if (elStatus) {
    elStatus.addEventListener("change", function () {
      state.status = elStatus.value;
      state.page = 1;
      loadList();
    });
  }
  if (elApply) {
    elApply.addEventListener("click", function () {
      state.from = elFrom ? elFrom.value : "";
      state.to = elTo ? elTo.value : "";
      state.page = 1;
      loadList();
    });
  }
  if (elReset) {
    elReset.addEventListener("click", function () {
      state.periode = "all";
      state.status = "all";
      state.search = "";
      state.from = "";
      state.to = "";
      state.page = 1;
      if (elPeriode) elPeriode.value = "all";
      if (elStatus) elStatus.value = "all";
      if (elFrom) elFrom.value = "";
      if (elTo) elTo.value = "";
      if (elSearch) elSearch.value = "";
      elCustom.classList.remove("is-visible");
      loadList();
    });
  }

  // ============ SEARCH AUTOCOMPLETE ============
  var searchInputWrap = elSearch ? elSearch.parentElement : null;
  var suggestTimer = null;

  var doSuggest = debounce(function () {
    var q = elSearch.value.trim();
    if (q.length < 2) {
      elSuggest.classList.remove("is-open");
      elSuggest.innerHTML = "";
      return;
    }
    apiFetch("/admin/api/po-search-suggest.php?q=" + encodeURIComponent(q))
      .then(function (res) {
        if (!res.success || !res.data.length) {
          elSuggest.innerHTML =
            '<div class="search-suggest__empty">Tidak ada hasil untuk "' +
            esc(q) +
            '"</div>';
          elSuggest.classList.add("is-open");
          return;
        }
        var html = "";
        res.data.forEach(function (r) {
          html +=
            '<div class="search-suggest__item" data-value="' +
            esc(r.kode_po) +
            '">' +
            "<div><strong>" +
            esc(r.kode_po) +
            "</strong><br>" +
            "<small>" +
            esc(r.nm_customer) +
            " — " +
            esc(r.no_telp || "-") +
            "</small></div>" +
            "<small>" +
            esc(r.status) +
            "</small>" +
            "</div>";
        });
        elSuggest.innerHTML = html;
        elSuggest.classList.add("is-open");
      })
      .catch(function () {
        /* silent */
      });
  }, 250);

  if (elSearch) {
    elSearch.addEventListener("input", function () {
      doSuggest();
    });
    elSearch.addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        state.search = elSearch.value.trim();
        state.page = 1;
        elSuggest.classList.remove("is-open");
        loadList();
      }
      if (e.key === "Escape") {
        elSuggest.classList.remove("is-open");
      }
    });
    elSearch.addEventListener("blur", function () {
      // Delay agar klik pada suggest tetap terdaftar
      setTimeout(function () {
        elSuggest.classList.remove("is-open");
      }, 180);
    });
  }

  if (elSuggest) {
    elSuggest.addEventListener("click", function (e) {
      var item = e.target.closest(".search-suggest__item");
      if (!item) return;
      var val = item.getAttribute("data-value");
      elSearch.value = val;
      state.search = val;
      state.page = 1;
      elSuggest.classList.remove("is-open");
      loadList();
    });
  }

  // Close suggest on outside click
  document.addEventListener("click", function (e) {
    if (!searchInputWrap) return;
    if (!searchInputWrap.contains(e.target)) {
      elSuggest.classList.remove("is-open");
    }
  });

  // ============ MODAL WORKFLOW ============
  function openModal(title, html, action, po) {
    mTitle.textContent = title;
    mBody.innerHTML = html;
    currentAction = action;
    currentPo = po;
    modal.hidden = false;
  }
  function closeModal() {
    modal.hidden = true;
    mBody.innerHTML = "";
    currentAction = null;
    currentPo = null;
  }
  mClose.addEventListener("click", closeModal);
  mCancel.addEventListener("click", closeModal);
  modal.addEventListener("click", function (e) {
    if (e.target === modal) closeModal();
  });

  elTbody.addEventListener("click", function (e) {
    var btn = e.target.closest("[data-act]");
    if (!btn) return;
    var act = btn.getAttribute("data-act");
    var id = btn.getAttribute("data-id");
    if (!id) return;
    handleAction(act, id);
  });

  function handleAction(act, id) {
    apiFetch("/admin/api/po-detail.php?id=" + id).then(function (res) {
      if (!res.success) {
        alert(res.message);
        return;
      }
      var po = res.data;
      switch (act) {
        case "detail":
          showDetail(po);
          break;
        case "process":
          showProcess(po);
          break;
        case "install":
          showInstall(po);
          break;
        case "activate":
          showActivate(po);
          break;
        case "cancel":
          showCancel(po);
          break;
        case "payment":
          showPayment(po);
          break;
      }
    });
  }

  function poInfoHtml(po) {
    return (
      '<div class="info-grid">' +
      '<div><span class="lbl">Kode PO</span><span class="val">' +
      esc(po.kode_po) +
      "</span></div>" +
      '<div><span class="lbl">Pelanggan</span><span class="val">' +
      esc(po.nm_customer) +
      "</span></div>" +
      '<div><span class="lbl">Telepon</span><span class="val">' +
      esc(po.no_telp || "-") +
      "</span></div>" +
      '<div><span class="lbl">Paket</span><span class="val">' +
      esc(po.nm_paket || "-") +
      "</span></div>" +
      '<div><span class="lbl">Harga Jual</span><span class="val">' +
      fmtRupiah(po.harga_jual) +
      "</span></div>" +
      '<div><span class="lbl">Biaya Instalasi</span><span class="val">' +
      fmtRupiah(po.biaya_instalasi) +
      "</span></div>" +
      '<div><span class="lbl">Alamat</span><span class="val">' +
      esc(po.alamat || "-") +
      "</span></div>" +
      '<div><span class="lbl">Tanggal Ajukan</span><span class="val">' +
      fmtDate(po.tgl_diajukan) +
      "</span></div>" +
      "</div>"
    );
  }

  function showDetail(po) {
    openModal("Detail PO — " + po.kode_po, poInfoHtml(po), "detail", po);
    mSubmit.hidden = true;
  }
  function showProcess(po) {
    openModal(
      "Proses PO — " + po.kode_po,
      poInfoHtml(po) +
        '<p style="font-size:13px;color:var(--text-muted);">PO akan dipindahkan ke status <strong>Diproses</strong>.</p>',
      "process",
      po,
    );
    mSubmit.hidden = false;
    mSubmit.textContent = "Proses Sekarang";
  }
  function showInstall(po) {
    openModal(
      "Data Instalasi — " + po.kode_po,
      poInfoHtml(po) +
        '<div class="field"><label>Teknisi</label><input type="number" id="f_teknisi"></div>' +
        '<div class="field"><label>ODP ID</label><input type="number" id="f_odp"></div>' +
        '<div class="field"><label>SN ONT</label><input type="text" id="f_sn_ont"></div>' +
        '<div class="field"><label>Redaman</label><input type="text" id="f_redaman"></div>' +
        '<div class="field"><label>Panjang Kabel (m)</label><input type="text" id="f_kabel"></div>' +
        '<div class="field"><label>SSID WiFi</label><input type="text" id="f_ssid"></div>' +
        '<div class="field"><label>Password WiFi</label><input type="text" id="f_pwd_wifi"></div>' +
        '<div class="field"><label>ID PPPoE</label><input type="text" id="f_pppoe"></div>' +
        '<div class="field"><label>Password PPPoE</label><input type="text" id="f_pwd_pppoe"></div>' +
        '<div class="field"><label>Keterangan</label><textarea id="f_ket" rows="2"></textarea></div>',
      "install",
      po,
    );
    mSubmit.hidden = false;
    mSubmit.textContent = "Simpan Data Instalasi";
    if (po.teknisi_id) $("#f_teknisi").value = po.teknisi_id;
    if (po.odp_id) $("#f_odp").value = po.odp_id;
    if (po.sn_ont) $("#f_sn_ont").value = po.sn_ont;
    if (po.redaman) $("#f_redaman").value = po.redaman;
    if (po.panjang_kabel) $("#f_kabel").value = po.panjang_kabel;
    if (po.ssid_wifi) $("#f_ssid").value = po.ssid_wifi;
    if (po.id_pppoe) $("#f_pppoe").value = po.id_pppoe;
  }
  function showActivate(po) {
    openModal(
      "Aktivasi PO — " + po.kode_po,
      poInfoHtml(po) +
        '<p style="font-size:13px;color:var(--text-muted);">PO akan diaktifkan. Sistem otomatis membuat record <strong>pelanggan</strong> baru.</p>',
      "activate",
      po,
    );
    mSubmit.hidden = false;
    mSubmit.textContent = "Aktifkan Sekarang";
  }
  function showCancel(po) {
    openModal(
      "Batalkan PO — " + po.kode_po,
      poInfoHtml(po) +
        '<div class="field"><label>Alasan Pembatalan</label><textarea id="f_ket" rows="3" required></textarea></div>',
      "cancel",
      po,
    );
    mSubmit.hidden = false;
    mSubmit.textContent = "Batalkan PO";
  }
  function showPayment(po) {
    var total =
      (Number(po.biaya_instalasi) || 0) + (Number(po.harga_jual) || 0);
    openModal(
      "Konfirmasi Pembayaran — " + po.kode_po,
      poInfoHtml(po) +
        '<div class="info-grid">' +
        '<div><span class="lbl">Biaya Instalasi</span><span class="val">' +
        fmtRupiah(po.biaya_instalasi) +
        "</span></div>" +
        '<div><span class="lbl">Bulan Pertama</span><span class="val">' +
        fmtRupiah(po.harga_jual) +
        "</span></div>" +
        '<div><span class="lbl">Total</span><span class="val" style="color:var(--red-600);">' +
        fmtRupiah(total) +
        "</span></div>" +
        "</div>" +
        '<div class="field"><label>Metode Pembayaran</label>' +
        '<select id="f_via"><option value="cash">Cash</option><option value="transfer">Transfer</option>' +
        '<option value="qris">QRIS</option><option value="lainnya">Lainnya</option></select></div>' +
        '<div class="field"><label>Nominal Diterima</label><input type="number" id="f_amount" value="' +
        total +
        '"></div>' +
        '<div class="field"><label>Catatan / Referensi</label><input type="text" id="f_ref"></div>',
      "payment",
      po,
    );
    mSubmit.hidden = false;
    mSubmit.textContent = "Konfirmasi Pembayaran";
  }

  mSubmit.addEventListener("click", function () {
    if (!currentAction || !currentPo) return;
    var id = currentPo.id_po;
    var fd = new FormData();
    fd.append("id_po", id);
    fd.append("action", currentAction);

    if (currentAction === "install") {
      fd.append("teknisi_id", $("#f_teknisi")?.value || "");
      fd.append("odp_id", $("#f_odp")?.value || "");
      fd.append("sn_ont", $("#f_sn_ont")?.value || "");
      fd.append("redaman", $("#f_redaman")?.value || "");
      fd.append("panjang_kabel", $("#f_kabel")?.value || "");
      fd.append("ssid_wifi", $("#f_ssid")?.value || "");
      fd.append("password_wifi", $("#f_pwd_wifi")?.value || "");
      fd.append("id_pppoe", $("#f_pppoe")?.value || "");
      fd.append("password_pppoe", $("#f_pwd_pppoe")?.value || "");
      fd.append("keterangan", $("#f_ket")?.value || "");
    }
    if (currentAction === "cancel")
      fd.append("keterangan", $("#f_ket")?.value || "");
    if (currentAction === "payment") {
      fd.append("payment_amount", $("#f_amount")?.value || 0);
      fd.append("payment_ref", $("#f_ref")?.value || "");
    }

    mSubmit.disabled = true;
    var old = mSubmit.textContent;
    mSubmit.textContent = "Memproses…";

    apiFetch("/admin/api/po-update-status.php", { method: "POST", body: fd })
      .then(function (res) {
        if (res.success) {
          closeModal();
          loadList();
        } else alert(res.message);
      })
      .catch(function (err) {
        alert("Error: " + err.message);
      })
      .finally(function () {
        mSubmit.disabled = false;
        mSubmit.textContent = old;
      });
  });

  // ============ INIT ============
  loadList();
})();

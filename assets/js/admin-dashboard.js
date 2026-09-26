/**
 * assets/js/admin-dashboard.js — GNetindo
 */
(function () {
  "use strict";

  var BASE = (window.GNETINDO && window.GNETINDO.baseUrl) || "";
  var state = { range: "all", search: "", page: 1, limit: 10 };

  var elTotal = document.getElementById("statTotal");
  var elPending = document.getElementById("statPending");
  var elInstall = document.getElementById("statInstall");
  var elActive = document.getElementById("statActive");
  var elRevenue = document.getElementById("statRevenue");
  var elTbody = document.getElementById("poTableBody");
  var elFilterTabs = document.getElementById("filterTabs");
  var elSearch = document.getElementById("searchInput");
  var elPagInfo = document.getElementById("paginationInfo");
  var elPagCtrl = document.getElementById("paginationControls");

  function fmtRupiah(n) {
    n = Number(n) || 0;
    if (!n) return "Rp 0";
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
    var d = new Date(s.replace(" ", "T"));
    if (isNaN(d.getTime())) return s;
    return (
      d.getDate().toString().padStart(2, "0") +
      " " +
      bulan[d.getMonth()] +
      " " +
      d.getFullYear()
    );
  }

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

  function loadStats() {
    var url =
      BASE +
      "/admin/api/po-stats.php?range=" +
      encodeURIComponent(state.range) +
      "&search=" +
      encodeURIComponent(state.search);
    return fetch(url, { credentials: "same-origin" })
      .then(function (r) {
        return r.json();
      })
      .then(function (res) {
        if (!res.success) throw new Error(res.message);
        elTotal.textContent = res.data.total;
        elPending.textContent = res.data.pending;
        elInstall.textContent = res.data.install;
        elActive.textContent = res.data.active;
        elRevenue.textContent = fmtRupiah(res.data.revenue_paid);
      });
  }

  function loadList() {
    var url =
      BASE +
      "/admin/api/po-list.php?range=" +
      encodeURIComponent(state.range) +
      "&search=" +
      encodeURIComponent(state.search) +
      "&page=" +
      state.page +
      "&limit=" +
      state.limit;
    return fetch(url, { credentials: "same-origin" })
      .then(function (r) {
        return r.json();
      })
      .then(function (res) {
        if (!res.success) throw new Error(res.message);
        renderTable(res.data, res.pagination);
      });
  }

  function renderTable(rows, pag) {
    if (!rows.length) {
      elTbody.innerHTML =
        '<tr><td colspan="5" class="table-empty">Tidak ada data PO.</td></tr>';
      renderPagination(pag);
      return;
    }

    var html = "";
    rows.forEach(function (r) {
      html +=
        "<tr>" +
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
        esc(r.status_badge) +
        '">' +
        esc(r.status_label) +
        "</span></td>" +
        "</tr>";
    });
    elTbody.innerHTML = html;
    renderPagination(pag);
  }

  function renderPagination(pag) {
    if (!pag || !pag.total) {
      elPagInfo.textContent = "Menampilkan 0 data";
      elPagCtrl.innerHTML = "";
      return;
    }
    var start = (pag.page - 1) * pag.limit + 1;
    var end = Math.min(pag.page * pag.limit, pag.total);
    elPagInfo.textContent =
      "Menampilkan " + start + "–" + end + " dari " + pag.total + " data";

    elPagCtrl.innerHTML = "";

    function makeBtn(label, page, opts) {
      opts = opts || {};
      var btn = document.createElement("button");
      btn.className = "page-btn" + (opts.active ? " is-active" : "");
      btn.type = "button";
      btn.textContent = label;
      btn.disabled = !!opts.disabled;
      btn.addEventListener("click", function () {
        state.page = page;
        refresh();
      });
      return btn;
    }

    elPagCtrl.appendChild(
      makeBtn("‹", pag.page - 1, { disabled: pag.page <= 1 }),
    );

    var max = 5;
    var sp = Math.max(1, pag.page - Math.floor(max / 2));
    var ep = Math.min(pag.totalPages, sp + max - 1);
    sp = Math.max(1, ep - max + 1);

    for (var p = sp; p <= ep; p++) {
      elPagCtrl.appendChild(makeBtn(String(p), p, { active: p === pag.page }));
    }

    elPagCtrl.appendChild(
      makeBtn("›", pag.page + 1, { disabled: pag.page >= pag.totalPages }),
    );
  }

  function refresh() {
    loadStats().catch(function (err) {
      console.error("stats:", err);
    });
    loadList().catch(function (err) {
      console.error("list:", err);
      elTbody.innerHTML =
        '<tr><td colspan="5" class="table-empty">Gagal memuat data.</td></tr>';
    });
  }

  // Events
  if (elFilterTabs) {
    elFilterTabs.addEventListener("click", function (e) {
      var btn = e.target.closest(".filter-tab");
      if (!btn) return;
      elFilterTabs.querySelectorAll(".filter-tab").forEach(function (b) {
        b.classList.toggle("is-active", b === btn);
      });
      state.range = btn.getAttribute("data-range");
      state.page = 1;
      refresh();
    });
  }

  if (elSearch) {
    var t;
    elSearch.addEventListener("input", function (e) {
      clearTimeout(t);
      t = setTimeout(function () {
        state.search = e.target.value.trim();
        state.page = 1;
        refresh();
      }, 300);
    });
  }

  // Init
  refresh();
})();

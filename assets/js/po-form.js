/**
 * ============================================================
 * assets/js/po-form.js — GNetindo
 * Form Input PO — interaksi lengkap
 * ============================================================
 */
(function () {
  "use strict";

  // ============================================================
  // KONFIGURASI
  // ============================================================
  var CFG = window.GNETINDO || {};
  var API = CFG.apiBase || "/api/form-data";

  // ============================================================
  // DOM SHORTCUT
  // ============================================================
  var $ = function (sel) {
    return document.querySelector(sel);
  };
  var $$ = function (sel) {
    return Array.prototype.slice.call(document.querySelectorAll(sel));
  };

  // ============================================================
  // ELEMENT
  // ============================================================
  var elForm = $("#poForm");
  var elTabsWrap = $("#customerTypeTabs");
  var elPoPreview = $("#poNumberPreview");
  var elTypeBadge = $("#summaryTypeBadge");
  var elBtnSubmit = $("#btnSubmitPO");
  var elToast = $("#toast");

  // Wilayah
  var elProvinsi = $("#provinsi_id");
  var elKabupaten = $("#kabupaten_id");
  var elKecamatan = $("#kecamatan_id");

  // Cabang & produk
  var elCabang = $("#cabang_id");
  var elProduk = $("#produk_id");
  var elHargaDisplay = $("#harga_jual_display");
  var elHargaHidden = $("#harga_jual");
  var elKomisiDisplay = $("#komisi_display");
  var elKomisiHidden = $("#komisi");
  var elBiayaDisplay = $("#biaya_instalasi_display");
  var elBiayaHidden = $("#biaya_instalasi");

  // Teknis
  var elMarketer = $("#marketer_id");
  var elTeknisi = $("#teknisi_id");

  // Autocomplete
  var elOdpSearch = $("#odp_search");
  var elOdpList = $("#odpList");
  var elOdpHidden = $("#odp_id");
  var elOntSearch = $("#sn_ont_search");
  var elOntList = $("#ontList");
  var elOntHidden = $("#sn_ont");

  // ============================================================
  // STATE
  // ============================================================
  var state = {
    type: "personal", // personal | corporate
    provinsi_id: null,
    kabupaten_id: null,
    kecamatan_id: null,
    cabang_id: null,
    produk_id: null,
    produk_map: {}, // produk_id → { harga, komisi }
    odp_map: {}, // odp value → id
    ont_map: {}, // ont value → sn
  };

  // ============================================================
  // UTILITY
  // ============================================================
  function setOptions(selectEl, items, placeholder, valueKey, labelFn) {
    if (!selectEl) return;
    selectEl.innerHTML = "";

    var opt0 = document.createElement("option");
    opt0.value = "";
    opt0.textContent = placeholder;
    selectEl.appendChild(opt0);

    if (!items || !items.length) return;

    items.forEach(function (it) {
      var opt = document.createElement("option");
      opt.value = it[valueKey];
      opt.textContent = labelFn ? labelFn(it) : it.nama;
      selectEl.appendChild(opt);
    });
  }

  function setLoading(selectEl, text) {
    if (!selectEl) return;
    selectEl.innerHTML = '<option value="">' + text + "</option>";
  }

  function showToast(msg, kind) {
    if (!elToast) return;
    elToast.textContent = msg;
    elToast.className = "toast is-visible" + (kind ? " is-" + kind : "");
    clearTimeout(showToast._t);
    showToast._t = setTimeout(function () {
      elToast.classList.remove("is-visible");
    }, 3500);
  }

  function fmtRupiah(n) {
    n = Number(String(n).replace(/[^0-9]/g, "")) || 0;
    if (!n) return "";
    return "Rp " + n.toLocaleString("id-ID");
  }

  function parseRupiah(s) {
    return Number(String(s).replace(/[^0-9]/g, "")) || 0;
  }

  function fetchJSON(url) {
    return fetch(url, { credentials: "same-origin" }).then(function (r) {
      if (!r.ok) throw new Error("HTTP " + r.status);
      return r.json();
    });
  }

  // ============================================================
  // THEME (opsional — kalau theme.js sudah handle, ini redundant)
  // ============================================================
  // (Biarkan theme.js yang handle, tidak perlu di sini)

  // ============================================================
  // 1. TAB SWITCH: PELANGGAN / CORPORATE
  // ============================================================
  function setType(type) {
    state.type = type;
    if (elForm) elForm.setAttribute("data-form-type", type);

    $$(".customer-type-tabs__btn").forEach(function (btn) {
      var active = btn.getAttribute("data-type") === type;
      btn.classList.toggle("is-active", active);
      btn.setAttribute("aria-selected", active ? "true" : "false");
    });

    if (elTypeBadge) {
      elTypeBadge.textContent =
        type === "corporate" ? "Corporate" : "Pelanggan";
    }

    // Di form ini, field NIK/Nama Pelanggan tetap dipakai untuk personal,
    // nanti di Batch 3 kita bisa tambahkan field khusus corporate (Nama PT, NPWP, dll).
    // Untuk sekarang, label dinamis:
    var labelNama = document.querySelector('label[for="nm_pelanggan"]');
    if (labelNama) {
      labelNama.innerHTML =
        type === "corporate"
          ? 'Nama Perusahaan / Customer <span class="req">*</span>'
          : 'Nama Pelanggan <span class="req">*</span>';
    }
    var labelNik = document.querySelector('label[for="nik"]');
    if (labelNik) {
      labelNik.innerHTML =
        type === "corporate" ? "NPWP / NIB" : 'NIK <span class="req">*</span>';
    }
  }

  if (elTabsWrap) {
    elTabsWrap.addEventListener("click", function (e) {
      var btn = e.target.closest(".customer-type-tabs__btn");
      if (!btn) return;
      setType(btn.getAttribute("data-type"));
    });
  }

  // ============================================================
  // 2. LOAD PROVINSI (default saat page ready)
  // ============================================================
  function loadProvinces() {
    setLoading(elProvinsi, "Memuat provinsi…");
    fetchJSON(API + "/provinces.php")
      .then(function (res) {
        if (!res.success) throw new Error(res.message || "Gagal load provinsi");
        setOptions(elProvinsi, res.data, "— Pilih Provinsi —", "id");
      })
      .catch(function (err) {
        setLoading(elProvinsi, "Gagal memuat provinsi");
        showToast("Gagal memuat provinsi: " + err.message, "error");
      });
  }

  // ============================================================
  // 3. CASCADE: PROVINSI → KABUPATEN → KECAMATAN
  // ============================================================
  if (elProvinsi) {
    elProvinsi.addEventListener("change", function () {
      var pid = elProvinsi.value;
      state.provinsi_id = pid || null;

      // Reset kabupaten & kecamatan
      setLoading(elKabupaten, "Memuat kabupaten…");
      setLoading(elKecamatan, "Pilih kabupaten dulu");
      elKabupaten.disabled = true;
      elKecamatan.disabled = true;

      if (!pid) {
        setLoading(elKabupaten, "Pilih provinsi dulu");
        return;
      }

      fetchJSON(API + "/regencies.php?provinsi_id=" + encodeURIComponent(pid))
        .then(function (res) {
          if (!res.success)
            throw new Error(res.message || "Gagal load kabupaten");
          setOptions(elKabupaten, res.data, "— Pilih Kabupaten —", "id");
          elKabupaten.disabled = false;
        })
        .catch(function (err) {
          setLoading(elKabupaten, "Gagal memuat kabupaten");
          showToast("Gagal memuat kabupaten: " + err.message, "error");
        });
    });
  }

  if (elKabupaten) {
    elKabupaten.addEventListener("change", function () {
      var kid = elKabupaten.value;
      state.kabupaten_id = kid || null;

      setLoading(elKecamatan, "Memuat kecamatan…");
      elKecamatan.disabled = true;

      if (!kid) {
        setLoading(elKecamatan, "Pilih kabupaten dulu");
        return;
      }

      fetchJSON(API + "/districts.php?kota_id=" + encodeURIComponent(kid))
        .then(function (res) {
          if (!res.success)
            throw new Error(res.message || "Gagal load kecamatan");
          setOptions(elKecamatan, res.data, "— Pilih Kecamatan —", "id");
          elKecamatan.disabled = false;
        })
        .catch(function (err) {
          setLoading(elKecamatan, "Gagal memuat kecamatan");
          showToast("Gagal memuat kecamatan: " + err.message, "error");
        });
    });
  }

  if (elKecamatan) {
    elKecamatan.addEventListener("change", function () {
      state.kecamatan_id = elKecamatan.value || null;
    });
  }

  // ============================================================
  // 4. LOAD CABANG → PRODUK
  // ============================================================
  function loadBranches() {
    if (!elCabang) return;
    setLoading(elCabang, "Memuat cabang…");
    fetchJSON(API + "/branches.php")
      .then(function (res) {
        if (!res.success) throw new Error(res.message || "Gagal load cabang");
        setOptions(elCabang, res.data, "— Pilih Cabang —", "id", function (it) {
          return it.nama + (it.kode ? " (" + it.kode + ")" : "");
        });
      })
      .catch(function (err) {
        setLoading(elCabang, "Gagal memuat cabang");
        showToast("Gagal memuat cabang: " + err.message, "error");
      });
  }

  if (elCabang) {
    elCabang.addEventListener("change", function () {
      var cid = elCabang.value;
      state.cabang_id = cid || null;

      setLoading(elProduk, "Memuat paket layanan…");
      if (elProduk) elProduk.disabled = true;
      if (elHargaDisplay) elHargaDisplay.value = "";
      if (elHargaHidden) elHargaHidden.value = "0";
      if (elKomisiDisplay) elKomisiDisplay.value = "";
      if (elKomisiHidden) elKomisiHidden.value = "0";
      state.produk_map = {};

      if (!cid) {
        setLoading(elProduk, "Pilih cabang dulu");
        return;
      }

      fetchJSON(API + "/products.php?cabang_id=" + encodeURIComponent(cid))
        .then(function (res) {
          if (!res.success) throw new Error(res.message || "Gagal load produk");
          setOptions(
            elProduk,
            res.data,
            "— Pilih Paket Layanan —",
            "id",
            function (it) {
              return it.nama;
            },
          );
          res.data.forEach(function (p) {
            state.produk_map[p.id] = {
              harga: parseInt(p.harga, 10) || 0,
              komisi: 0,
            };
          });
          if (elProduk) elProduk.disabled = false;
        })
        .catch(function (err) {
          setLoading(elProduk, "Gagal memuat paket");
          showToast("Gagal memuat paket: " + err.message, "error");
        });
    });
  }

  // ============================================================
  // 5. AUTO-FILL HARGA & KOMISI saat pilih PRODUK
  // ============================================================
  if (elProduk) {
    elProduk.addEventListener("change", function () {
      var pid = elProduk.value;
      state.produk_id = pid || null;

      var info = state.produk_map[pid];
      if (info) {
        if (elHargaDisplay) elHargaDisplay.value = fmtRupiah(info.harga);
        if (elHargaHidden) elHargaHidden.value = info.harga;
        if (elKomisiDisplay) elKomisiDisplay.value = fmtRupiah(info.komisi);
        if (elKomisiHidden) elKomisiHidden.value = info.komisi;
      } else {
        if (elHargaDisplay) elHargaDisplay.value = "";
        if (elHargaHidden) elHargaHidden.value = "0";
        if (elKomisiDisplay) elKomisiDisplay.value = "";
        if (elKomisiHidden) elKomisiHidden.value = "0";
      }
    });
  }

  // ============================================================
  // 6. FORMAT RUPIAH pada input biaya instalasi
  // ============================================================
  if (elBiayaDisplay) {
    elBiayaDisplay.addEventListener("input", function () {
      var raw = parseRupiah(elBiayaDisplay.value);
      elBiayaDisplay.value = fmtRupiah(raw);
      elBiayaHidden.value = raw;
    });
  }

  // ============================================================
  // 7. LOAD MARKETER & TEKNISI
  // ============================================================
  function loadKaryawan(url, selectEl, placeholder) {
    setLoading(selectEl, "Memuat…");
    fetchJSON(url)
      .then(function (res) {
        if (!res.success) throw new Error(res.message || "Gagal load");
        setOptions(selectEl, res.data, placeholder, "id", function (it) {
          return it.nama + (it.nik ? " — " + it.nik : "");
        });
      })
      .catch(function (err) {
        setLoading(selectEl, "Gagal memuat");
        showToast("Gagal memuat data: " + err.message, "error");
      });
  }

  function loadMarketers() {
    if (!elMarketer) return;
    loadKaryawan(API + "/marketers.php", elMarketer, "— Pilih Marketer —");
  }

  function loadTechnicians() {
    if (!elTeknisi) return;
    loadKaryawan(API + "/technicians.php", elTeknisi, "— Pilih Teknisi —");
  }

  // ============================================================
  // 8. AUTOCOMPLETE ODP
  // ============================================================
  var odpTimer;
  if (elOdpSearch && elOdpList) {
    elOdpSearch.addEventListener("input", function () {
      var q = elOdpSearch.value.trim();
      elOdpHidden.value = ""; // reset karena user edit manual

      clearTimeout(odpTimer);
      odpTimer = setTimeout(function () {
        fetchJSON(API + "/odps.php?q=" + encodeURIComponent(q))
          .then(function (res) {
            if (!res.success) return;
            elOdpList.innerHTML = "";
            state.odp_map = {};
            res.data.forEach(function (o) {
              // Value: kode ODP (string yang ditampilkan di input)
              // Kita simpan mapping kode → id
              var label = o.kode + (o.alamat ? " — " + o.alamat : "");
              state.odp_map[label] = o.id;

              var opt = document.createElement("option");
              opt.value = label;
              elOdpList.appendChild(opt);
            });
          })
          .catch(function () {
            /* silent */
          });
      }, 250);
    });

    // Saat user pilih dari datalist (input value match label)
    elOdpSearch.addEventListener("change", function () {
      var v = elOdpSearch.value.trim();
      if (state.odp_map[v]) {
        elOdpHidden.value = state.odp_map[v];
      } else {
        elOdpHidden.value = "";
      }
    });
  }

  // ============================================================
  // 9. AUTOCOMPLETE SN ONT
  // ============================================================
  var ontTimer;
  if (elOntSearch && elOntList) {
    elOntSearch.addEventListener("input", function () {
      var q = elOntSearch.value.trim();
      elOntHidden.value = "";

      clearTimeout(ontTimer);
      ontTimer = setTimeout(function () {
        fetchJSON(API + "/onts.php?q=" + encodeURIComponent(q))
          .then(function (res) {
            if (!res.success) return;
            elOntList.innerHTML = "";
            state.ont_map = {};
            res.data.forEach(function (o) {
              var label = o.sn + (o.kategori ? " — " + o.kategori : "");
              state.ont_map[label] = o.sn;

              var opt = document.createElement("option");
              opt.value = label;
              elOntList.appendChild(opt);
            });
          })
          .catch(function () {
            /* silent */
          });
      }, 250);
    });

    elOntSearch.addEventListener("change", function () {
      var v = elOntSearch.value.trim();
      if (state.ont_map[v]) {
        elOntHidden.value = state.ont_map[v];
      } else {
        elOntHidden.value = "";
      }
    });
  }

  // ============================================================
  // 10. DEFAULT TANGGAL
  // ============================================================
  var elTglPesanan = $("#tgl_pesanan");
  if (elTglPesanan && !elTglPesanan.value) {
    elTglPesanan.value = new Date().toISOString().slice(0, 10);
  }

  // ============================================================
  // 11. PREVIEW NOMOR PO (dari API)
  // ============================================================
  function previewPoNumber() {
    if (!elPoPreview) return;
    elPoPreview.textContent = "Memuat…";

    fetchJSON(API + "/next-po-number.php")
      .then(function (res) {
        if (res.success && res.kode) {
          elPoPreview.textContent = res.kode;
        } else {
          elPoPreview.textContent = "PO-GNet-…";
        }
      })
      .catch(function () {
        elPoPreview.textContent = "PO-GNet-…";
      });
  }

  // ============================================================
  // 12. SUBMIT HANDLER — Kirim ke API po-save.php
  // ============================================================
  if (elBtnSubmit) {
    elBtnSubmit.addEventListener("click", function () {
      var form = elForm;
      if (!form) return;

      // ---- Validasi HTML5 native ----
      if (!form.checkValidity()) {
        form.reportValidity();
        showToast("Mohon lengkapi field yang bertanda *", "error");
        return;
      }

      // ---- Validasi autocomplete (harus pilih dari list) ----
      if (elOdpSearch && elOdpSearch.offsetParent !== null) {
        // Field visible → form admin → validasi wajib
        if (elOdpSearch.value.trim() && !elOdpHidden.value) {
          showToast("ODP harus dipilih dari daftar autocomplete", "error");
          elOdpSearch.focus();
          return;
        }
      }
      if (elOntSearch && elOntSearch.offsetParent !== null) {
        if (elOntSearch.value.trim() && !elOntHidden.value) {
          showToast("SN ONT harus dipilih dari daftar autocomplete", "error");
          elOntSearch.focus();
          return;
        }
      }

      // ---- Kumpulkan data form ----
      var fd = new FormData(form);

      // Mapping field agar sesuai dengan kolom `po_baru`
      // (form pakai nm_pelanggan → API pakai nm_customer)
      fd.append("nm_customer", fd.get("nm_pelanggan") || "");
      fd.append("type_po", state.type === "corporate" ? "2" : "1");

      // Field tambahan (hidden / state)
      fd.append("odp_id", elOdpHidden ? elOdpHidden.value : "");
      fd.append(
        "sn_ont",
        elOntHidden
          ? elOntHidden.value
          : elOntSearch
            ? elOntSearch.value.trim()
            : "",
      );
      fd.append("harga_jual", elHargaHidden ? elHargaHidden.value : "0");
      fd.append("komisi", elKomisiHidden ? elKomisiHidden.value : "0"); // ← aman
      fd.append("biaya_instalasi", elBiayaHidden ? elBiayaHidden.value : "0");

      // ---- UI Loading state ----
      elBtnSubmit.disabled = true;
      var txt = elBtnSubmit.querySelector(".btn-submit__text");
      var ldr = elBtnSubmit.querySelector(".btn-submit__loading");
      if (txt) txt.hidden = true;
      if (ldr) ldr.hidden = false;

      // ---- Kirim ke API ----
      fetch(CFG.baseUrl + "/admin/api/po-save.php", {
        method: "POST",
        body: fd,
        credentials: "same-origin",
      })
        .then(function (r) {
          // Tangani jika server balas bukan JSON (misal error PHP)
          return r.text().then(function (text) {
            try {
              return JSON.parse(text);
            } catch (e) {
              throw new Error(
                "Respons server tidak valid: " + text.substring(0, 120),
              );
            }
          });
        })
        .then(function (res) {
          if (res.success) {
            // Support 2 format response:
            //   1. { success, kode_po, pelanggan_id, ... }        ← po-save.php sekarang
            //   2. { success, data: { kode_po, pelanggan_id, ... } } ← format lama
            var kodePo = res.kode_po || (res.data && res.data.kode_po) || "";

            if (!kodePo) {
              showToast(
                "PO tersimpan tapi kode PO tidak diterima dari server",
                "error",
              );
              console.error("[GNetindo] Response tanpa kode_po:", res);
              resetBtn();
              return;
            }

            showToast(
              "PO " + kodePo + " berhasil dibuat! Mengalihkan…",
              "success",
            );

            // Deteksi: apakah user berada di area admin?
            var isAdminArea =
              CFG.isAdminArea === true ||
              window.location.pathname.indexOf("/admin/") !== -1;

            var redirectUrl = isAdminArea
              ? CFG.baseUrl + "/admin/po-list"
              : CFG.baseUrl + "/po/" + encodeURIComponent(kodePo);

            setTimeout(function () {
              window.location.href = redirectUrl;
            }, 1200);
          } else {
            showToast(res.message || "Gagal menyimpan PO", "error");
            resetBtn();
          }
        })
        .catch(function (err) {
          showToast("Error: " + err.message, "error");
          console.error("[GNetindo] Submit PO error:", err);
          resetBtn();
        });

      // Helper reset tombol
      function resetBtn() {
        if (txt) txt.hidden = false;
        if (ldr) ldr.hidden = true;
        elBtnSubmit.disabled = false;
      }
    });
  }

  // ============================================================
  // 13. INIT
  // ============================================================
  function init() {
    setType("personal");
    loadProvinces();
    loadBranches();
    loadMarketers();
    loadTechnicians();
    previewPoNumber();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  // ============================================================
  // 14. EXPOSE untuk debugging
  // ============================================================
  window.GNetindoFormPO = {
    state: state,
    setType: setType,
    refreshPoNumber: previewPoNumber,
  };
})();

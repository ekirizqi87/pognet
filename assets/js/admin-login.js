/**
 * assets/js/admin-login.js — GNetindo
 */
(function () {
  "use strict";

  var BASE = (window.GNETINDO && window.GNETINDO.baseUrl) || "";
  var form = document.getElementById("loginForm");
  var errEl = document.getElementById("loginError");
  var btn = form ? form.querySelector(".btn-login") : null;
  var toggleBtn = document.getElementById("togglePass");
  var passInput = document.getElementById("password");

  if (toggleBtn && passInput) {
    toggleBtn.addEventListener("click", function () {
      var isPwd = passInput.type === "password";
      passInput.type = isPwd ? "text" : "password";
      toggleBtn.setAttribute(
        "aria-label",
        isPwd ? "Sembunyikan kata sandi" : "Tampilkan kata sandi",
      );
    });
  }

  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    errEl.hidden = true;

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    btn.disabled = true;
    btn.textContent = "Memeriksa…";

    var fd = new FormData(form);

    fetch(BASE + "/admin/api/admin-login.php", {
      method: "POST",
      body: fd,
      credentials: "same-origin",
    })
      .then(function (r) {
        return r.json();
      })
      .then(function (res) {
        if (res.success) {
          window.location.href = BASE + "/admin/dashboard";
        } else {
          errEl.textContent = res.message || "Login gagal";
          errEl.hidden = false;
          btn.disabled = false;
          btn.textContent = "Masuk";
        }
      })
      .catch(function (err) {
        errEl.textContent = "Error: " + err.message;
        errEl.hidden = false;
        btn.disabled = false;
        btn.textContent = "Masuk";
      });
  });
})();

/* ==========================================================================
   BENGKEL G8 — INTERAKSI RINGAN
   Tidak ada dependensi. Aman kalau JS dimatikan (semua konten tetap tampil).
   ========================================================================== */
(function () {
  'use strict';

  /* ------------------------------------------------------------------
     1. Fade-in saat scroll (IntersectionObserver)
     ------------------------------------------------------------------ */
  var revealItems = document.querySelectorAll('.reveal');

  if (revealItems.length) {
    if ('IntersectionObserver' in window) {
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

      revealItems.forEach(function (el, i) {
        el.style.transitionDelay = Math.min(i * 45, 260) + 'ms';
        observer.observe(el);
      });
    } else {
      revealItems.forEach(function (el) { el.classList.add('is-visible'); });
    }
  }

  /* ------------------------------------------------------------------
     2. Jaring pengaman: kalau observer tidak sempat jalan (mis. tab
        dibuka di background), paksa semua konten tampil.
     ------------------------------------------------------------------ */
  window.setTimeout(function () {
    document.querySelectorAll('.reveal:not(.is-visible)').forEach(function (el) {
      el.classList.add('is-visible');
    });
  }, 1500);

  /* ------------------------------------------------------------------
     3. Navbar: tambah bayangan saat halaman di-scroll
     ------------------------------------------------------------------ */
  var nav = document.querySelector('.site-nav');
  if (nav) {
    var onScroll = function () {
      nav.classList.toggle('is-scrolled', window.scrollY > 12);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ------------------------------------------------------------------
     4. Alert sukses: hilangkan otomatis setelah 6 detik
     ------------------------------------------------------------------ */
  document.querySelectorAll('.alert-success[data-auto-dismiss]').forEach(function (alert) {
    window.setTimeout(function () {
      alert.style.transition = 'opacity .4s ease, transform .4s ease';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-6px)';
      window.setTimeout(function () { alert.remove(); }, 420);
    }, 6000);
  });

  /* ------------------------------------------------------------------
     5. Tahun berjalan di footer
     ------------------------------------------------------------------ */
  var yearEls = document.querySelectorAll('[data-year]');
  if (yearEls.length) {
    var year = new Date().getFullYear();
    yearEls.forEach(function (el) { el.textContent = year; });
  }
})();

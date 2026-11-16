/**
 * Menu HP: mengubah sidebar menjadi drawer yang bisa dibuka/ditutup.
 * File ini hanya melakukan sesuatu jika halaman memiliki elemen .sidebar.
 */
(function () {
    'use strict';

    var sidebar = document.querySelector('.sidebar');

    if (!sidebar) {
        return;
    }

    var body = document.body;
    var OPEN_CLASS = 'oc-mobile-nav-open';

    var toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'oc-mobile-menu';
    toggle.setAttribute('aria-label', 'Buka menu navigasi');
    toggle.setAttribute('aria-controls', 'oc-mobile-sidebar');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.innerHTML =
        '<svg class="oc-icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>' +
        '<svg class="oc-icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>';

    var overlay = document.createElement('div');
    overlay.className = 'oc-mobile-overlay';
    overlay.setAttribute('aria-hidden', 'true');

    sidebar.id = sidebar.id || 'oc-mobile-sidebar';
    toggle.setAttribute('aria-controls', sidebar.id);

    body.appendChild(overlay);
    body.appendChild(toggle);

    function isOpen() {
        return body.classList.contains(OPEN_CLASS);
    }

    function openMenu() {
        body.classList.add(OPEN_CLASS);
        toggle.setAttribute('aria-expanded', 'true');
        toggle.setAttribute('aria-label', 'Tutup menu navigasi');
    }

    function closeMenu() {
        body.classList.remove(OPEN_CLASS);
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Buka menu navigasi');
    }

    toggle.addEventListener('click', function () {
        if (isOpen()) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener('click', closeMenu);

    sidebar.addEventListener('click', function (event) {
        var link = event.target.closest('a');
        if (link) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && isOpen()) {
            closeMenu();
            toggle.focus();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && isOpen()) {
            closeMenu();
        }
    });
})();

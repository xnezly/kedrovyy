document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const toggles = document.querySelectorAll('[data-admin-sidebar-toggle]');
    const closeTriggers = document.querySelectorAll('[data-admin-sidebar-close]');
    const mobileBreakpoint = 991;

    document.querySelectorAll('.admin-table, .admin-recent-table__table, .admin-rooms__table').forEach(function (table) {
        const headers = Array.from(table.querySelectorAll('thead th')).map(function (header) {
            return header.textContent.trim();
        });

        if (!headers.length) {
            return;
        }

        table.querySelectorAll('tbody tr').forEach(function (row) {
            row.querySelectorAll('td').forEach(function (cell, index) {
                if (!cell.dataset.label && headers[index]) {
                    cell.dataset.label = headers[index];
                }
            });
        });
    });

    function isMobile() {
        return window.innerWidth <= mobileBreakpoint;
    }

    function setMenuState(open) {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.toggle('show', open);
        overlay.classList.toggle('show', open);
        document.body.classList.toggle('admin-menu-open', open);
        sidebar.setAttribute('aria-hidden', open ? 'false' : 'true');

        toggles.forEach(function (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    function toggleMenu() {
        if (!isMobile()) {
            return;
        }

        setMenuState(!sidebar.classList.contains('show'));
    }

    function closeMenu() {
        setMenuState(false);
    }

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            toggleMenu();
        });
    });

    closeTriggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            closeMenu();
        });
    });

    document.querySelectorAll('.sidebar-nav .nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobile()) {
                closeMenu();
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            closeMenu();
        }
    });

    document.querySelectorAll('.admin-alert__close').forEach(function (button) {
        button.addEventListener('click', function () {
            const alert = button.closest('.admin-alert');

            if (alert) {
                alert.remove();
            }
        });
    });
});

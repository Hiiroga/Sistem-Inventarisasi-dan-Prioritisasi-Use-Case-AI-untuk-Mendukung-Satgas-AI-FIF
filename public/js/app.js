document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-close').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const alertBox = btn.closest('.alert');
            if (alertBox) alertBox.remove();
        });
    });

    const sidebar = document.querySelector('.app-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.querySelector('.sidebar-toggle');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
});
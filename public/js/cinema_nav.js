document.addEventListener('DOMContentLoaded', function () {
    // إدارة القائمة الجوال
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenuButton.addEventListener('click', function () {
        mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
    });

    closeMobileMenu.addEventListener('click', function () {
        mobileMenu.style.display = 'none';
    });

    // إدارة البحث
    const searchButton = document.getElementById('searchButton');
    const searchBox = document.getElementById('searchBox');

    // إدارة المسارح
    const theatersButton = document.getElementById('theatersButton');
    const theatersBox = document.getElementById('theatersBox');

    searchButton.addEventListener('click', function () {
        searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
        theatersBox.style.display = 'none'; // إخفاء مربع المسارح عند فتح البحث
    });

    theatersButton.addEventListener('click', function () {
        theatersBox.style.display = theatersBox.style.display === 'block' ? 'none' : 'block';
        searchBox.style.display = 'none'; // إخفاء شريط البحث عند فتح المسارح
    });

    // إغلاق الصناديق بالنقر خارجها
    document.addEventListener('click', function (e) {
        if (!searchButton.contains(e.target) && !searchBox.contains(e.target) &&
            !theatersButton.contains(e.target) && !theatersBox.contains(e.target)) {
            searchBox.style.display = 'none';
            theatersBox.style.display = 'none';
        }
    });

    // إدارة تسجيل الدخول
    const loginButton = document.getElementById('loginButton');
    const mobileLoginButton = document.getElementById('mobileLoginButton');
    const loginModalOverlay = document.querySelector('.login-modal-overlay');
    const closeLoginModal = document.querySelector('.close-login-modal');

    loginButton.addEventListener('click', function () {
        loginModalOverlay.classList.add('active');
    });

    mobileLoginButton.addEventListener('click', function () {
        loginModalOverlay.classList.add('active');
    });

    closeLoginModal.addEventListener('click', function () {
        loginModalOverlay.classList.remove('active');
    });

    // إغلاق النافذة بالنقر خارجها
    document.addEventListener('click', function (e) {
        if (e.target === loginModalOverlay) {
            loginModalOverlay.classList.remove('active');
        }
    });

    // إرسال النموذج
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        loginForm.submit();
    });

    // تحديد الرابط المختار
    const links = document.querySelectorAll('.mobile-menu a');

    links.forEach(link => {
        link.addEventListener('click', function () {
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

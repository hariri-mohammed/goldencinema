document.addEventListener('DOMContentLoaded', function () {
    // إدارة القائمة الجوال
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const closeMobileMenu = document.getElementById('closeMobileMenu');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
        });
    }

    if (closeMobileMenu) {
        closeMobileMenu.addEventListener('click', function () {
            mobileMenu.style.display = 'none';
        });
    }

    // إدارة البحث
    const searchButton = document.getElementById('searchButton');
    const searchBox = document.getElementById('searchBox');

    // إدارة المسارح
    const theatersButton = document.getElementById('theatersButton');
    const theatersBox = document.getElementById('theatersBox');

    if (searchButton) {
        searchButton.addEventListener('click', function () {
            searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
            theatersBox.style.display = 'none'; // إخفاء مربع المسارح عند فتح البحث
        });
    }

    if (theatersButton) {
        theatersButton.addEventListener('click', function () {
            theatersBox.style.display = theatersBox.style.display === 'block' ? 'none' : 'block';
            searchBox.style.display = 'none'; // إخفاء شريط البحث عند فتح المسارح
        });
    }

    // إغلاق الصناديق بالنقر خارجها
    document.addEventListener('click', function (e) {
        if (!searchButton && !searchBox && !theatersButton && !theatersBox) {
            searchBox.style.display = 'none';
            theatersBox.style.display = 'none';
        }
    });

    // إدارة تسجيل الدخول
    const loginButton = document.getElementById('loginButton');
    const mobileLoginButton = document.getElementById('mobileLoginButton');
    const loginModalOverlay = document.querySelector('.login-modal-overlay');
    const closeLoginModal = document.querySelector('.close-login-modal');

    if (loginButton) {
        loginButton.addEventListener('click', function () {
            loginModalOverlay.classList.add('active');
        });
    }

    if (mobileLoginButton) {
        mobileLoginButton.addEventListener('click', function () {
            loginModalOverlay.classList.add('active');
        });
    }

    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', function () {
            loginModalOverlay.classList.remove('active');
        });
    }

    // إغلاق النافذة بالنقر خارجها
    document.addEventListener('click', function (e) {
        if (e.target === loginModalOverlay) {
            loginModalOverlay.classList.remove('active');
        }
    });

    // إرسال النموذج
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            loginForm.submit();
        });
    }

    // تحديد الرابط المختار
    const links = document.querySelectorAll('.mobile-menu a');

    if (links) {
        links.forEach(link => {
            if (link) {
                link.addEventListener('click', function () {
                    links.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            }
        });
    }

    // إدارة زر الدفع (Pay Now Modal)
    const payNowBtn = document.getElementById('payNowBtn');
    const payConfirmModalEl = document.getElementById('payConfirmModal');
    const modalPayConfirmBtn = document.getElementById('modalPayConfirmBtn');
    const paymentForm = document.querySelector('form');

    if (typeof bootstrap !== 'undefined' && payNowBtn && payConfirmModalEl && modalPayConfirmBtn && paymentForm) {
        const payConfirmModal = new bootstrap.Modal(payConfirmModalEl);

        payNowBtn.addEventListener('click', function (e) {
            e.preventDefault();
            payConfirmModal.show();
        });

        modalPayConfirmBtn.addEventListener('click', function () {
            paymentForm.submit();
        });
    }
});

console.log(typeof bootstrap);
console.log(document.getElementById('payNowBtn'));
console.log(document.getElementById('payConfirmModal'));

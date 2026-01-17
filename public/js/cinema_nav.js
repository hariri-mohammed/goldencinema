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
        if (searchBox && theatersBox) {
            if (!searchButton.contains(e.target) && !searchBox.contains(e.target) &&
                !theatersButton.contains(e.target) && !theatersBox.contains(e.target)) {
                searchBox.style.display = 'none';
                theatersBox.style.display = 'none';
            }
        }
    });
}); 
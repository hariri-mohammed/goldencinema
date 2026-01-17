document.addEventListener('DOMContentLoaded', () => {
    // 1. جلب العناصر من HTML
    const filterButtons = document.querySelectorAll('.filter-btn');
    const categorySelect = document.querySelector('.category-select');
    const categoryOptions = document.getElementById('categoryOptions');
    const selectedCategoryText = document.getElementById('selectedCategoryText');
    const moviesGrid = document.getElementById('movies-grid');

    // 2. تعريف الحالة الابتدائية
    let activeStatus = 'all';
    let selectedCategories = [];

    const filterMovies = () => {
        if (!moviesGrid) return;

        const movies = moviesGrid.querySelectorAll('.movie-item');

        // إخفاء جميع الأفلام أولاً
        movies.forEach(movie => {
            movie.style.display = 'none';
        });

        // تصفية الأفلام بناءً على الحالة والفئة
        movies.forEach(movie => {
            const status = movie.dataset.status;
            const categories = JSON.parse(movie.dataset.categories || '[]');

            const statusMatch = activeStatus === 'all' || status == activeStatus;
            const categoryMatch = selectedCategories.length === 0 || selectedCategories.some(cat => categories.includes(parseInt(cat)));

            if (statusMatch && categoryMatch) {
                movie.style.display = 'flex';
            }
        });
    };

    // 3. حدث النقر على أزرار الفلترة
    if (filterButtons) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeStatus = btn.dataset.filter;
                filterMovies();
            });
        });
    }

    // 4. حدث اختيار الفئة
    if (categorySelect && categoryOptions && selectedCategoryText) {
        categorySelect.addEventListener('click', (e) => {
            e.stopPropagation();
            categoryOptions.classList.toggle('show');
        });

        categoryOptions.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI') {
                const value = e.target.dataset.value;

                if (value === 'all') {
                    categoryOptions.querySelectorAll('li').forEach(li => li.classList.remove('selected'));
                    e.target.classList.add('selected');
                    selectedCategories = [];
                    selectedCategoryText.textContent = 'All Categories';
                } else {
                    e.target.classList.toggle('selected');
                    categoryOptions.querySelector('li[data-value="all"]').classList.remove('selected');

                    selectedCategories = Array.from(categoryOptions.querySelectorAll('li.selected'))
                        .map(li => li.dataset.value)
                        .filter(val => val !== 'all');

                    selectedCategoryText.textContent = selectedCategories.length > 0 ? `${selectedCategories.length} selected` : 'All Categories';
                }

                filterMovies();
            }
        });

        document.addEventListener('click', (e) => {
            if (!categorySelect.contains(e.target)) {
                categoryOptions.classList.remove('show');
            }
        });
    }

    // 5. تطبيق الفلترة عند تحميل الصفحة
    filterMovies();

    // ===== SWIPER CAROUSEL =====

    // التحقق من وجود Swiper في الصفحة
    if (typeof Swiper !== 'undefined') {
        initializeSwiper();
    } else {
        // تحميل Swiper.js ديناميكياً إذا لم يكن موجوداً
        loadSwiperAndInitialize();
    }

    function loadSwiperAndInitialize() {
        // إضافة CSS
        const swiperCSS = document.createElement('link');
        swiperCSS.rel = 'stylesheet';
        swiperCSS.href = 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css';
        document.head.appendChild(swiperCSS);

        // إضافة JavaScript
        const swiperJS = document.createElement('script');
        swiperJS.src = 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js';
        swiperJS.onload = initializeSwiper;
        document.head.appendChild(swiperJS);
    }

    function initializeSwiper() {
        // تهيئة Swiper مباشرة
        const swiper = new Swiper('.movie-swiper', {
            // عدد الأفلام المعروضة
            slidesPerView: 4,

            // المسافة بين الأفلام
            spaceBetween: 15,

            // عدد الأفلام التي تتحرك في كل مرة (2 من اليمين، 2 من اليسار)
            slidesPerGroup: 2,

            // حلقة لا نهائية
            loop: true,

            // التمرير التلقائي
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            // أزرار التنقل
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // نقاط التنقل
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },

            // تأثيرات الانتقال
            effect: 'slide',
            speed: 600,

            // التجاوب مع أحجام الشاشات المختلفة
            breakpoints: {
                // الشاشات الصغيرة جداً
                320: {
                    slidesPerView: 1,
                    slidesPerGroup: 1,
                    spaceBetween: 10,
                },
                // الشاشات الصغيرة
                576: {
                    slidesPerView: 2,
                    slidesPerGroup: 1,
                    spaceBetween: 12,
                },
                // الشاشات المتوسطة
                768: {
                    slidesPerView: 3,
                    slidesPerGroup: 2,
                    spaceBetween: 15,
                },
                // الشاشات الكبيرة
                1024: {
                    slidesPerView: 4,
                    slidesPerGroup: 2,
                    spaceBetween: 15,
                },
                // الشاشات الكبيرة جداً
                1200: {
                    slidesPerView: 4,
                    slidesPerGroup: 2,
                    spaceBetween: 20,
                }
            },

            // إعدادات إضافية
            grabCursor: true,
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },

            // تحسين الأداء
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 2,
            }
        });
    }
});

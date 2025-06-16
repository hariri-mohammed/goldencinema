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

    // 3. دالة لإنشاء رسالة "لا توجد نتائج"
    // const createNoResultsMessage = () => {
    //     const messageDiv = document.createElement('div');
    //     messageDiv.className = 'col-12 text-center py-5 no-results-message'; // أضفنا 'no-results-message' هنا
    //     messageDiv.innerHTML = '<h4 class="text-muted">No Movies Yet.</h4>';
    //     return messageDiv;
    // };

    const filterMovies = () => {
        if (!moviesGrid) return;

        const movies = moviesGrid.querySelectorAll('.movie-item');
        let visibleCount = 0;

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
                visibleCount++;
            }
        });

        // إزالة أي رسالة سابقة
        const existingMessage = moviesGrid.querySelector('.no-results-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // عرض رسالة "لا توجد نتائج" إذا لم تكن هناك أفلام مرئية
        // if (visibleCount === 0) {
        //     const noResultsMessage = createNoResultsMessage();
        //     noResultsMessage.classList.add('no-results-message');
        //     moviesGrid.appendChild(noResultsMessage);
        // }
    };

    // 5. حدث النقر على أزرار الفلترة
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

    // 6. حدث اختيار الفئة
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

    // 7. تطبيق الفلترة عند تحميل الصفحة
    filterMovies();
});

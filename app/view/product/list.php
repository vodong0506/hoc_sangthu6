<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm - Badminton Store</title>
</head>

<body>
    <?php include_once __DIR__ . '/../shares/header.php'; ?>

    <main class="page">
        <!-- Hero Banner -->
        <div class="hero-banner">
            <h1>Sản Phẩm Cầu Lông</h1>
            <p>Khám phá bộ sưu tập thiết bị và phụ kiện cầu lông chuyên nghiệp, chính hãng từ các thương hiệu hàng đầu thế giới.</p>
        </div>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success"><span>✅</span> ' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger"><span>⚠️</span> ' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <!-- Search & Filters Section -->
        <div class="search-filter-section">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-input" id="searchInput" placeholder="Tìm kiếm sản phẩm theo tên, giá, danh mục..." onkeyup="filterAndSortProducts()">
            </div>
            
            <div class="sort-wrapper">
                <select id="sortSelect" class="form-control" onchange="filterAndSortProducts()" style="padding: 10px 16px; min-width: 200px; height: auto;">
                    <option value="default">↕ Sắp xếp: Mặc định</option>
                    <option value="price-asc">💵 Giá: Thấp đến Cao</option>
                    <option value="price-desc">💵 Giá: Cao đến Thấp</option>
                    <option value="name-asc">🔤 Tên: A đến Z</option>
                </select>
            </div>
        </div>

        <!-- Category Filter Tabs -->
        <div class="filter-tabs" id="categoryTabs" style="margin-bottom: 30px;">
            <button class="filter-tab active" data-category="all" onclick="selectCategory(this)">Tất cả</button>
            <!-- Sẽ nạp động qua API -->
        </div>

        <!-- Product Grid -->
        <div class="products-grid" id="productsGrid">
            <div class="text-center py-5" style="grid-column: 1 / -1; color: var(--text-muted);">
                <div style="font-size: 40px; margin-bottom: 15px;">🔄</div>
                <p>Đang tải danh sách sản phẩm qua RESTful API...</p>
            </div>
        </div>
    </main>

    <script>
        const BASE_API_URL = '<?php echo BASE_URL; ?>/api';
        const BASE_URL = '<?php echo BASE_URL; ?>';
        
        let allProducts = [];
        let currentCategory = 'all';

        document.addEventListener("DOMContentLoaded", function () {
            // Load Categories and Products via API
            fetchCategories();
            fetchProducts();

            // Auto-close alerts after 4s
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 400);
                }, 4000);
            });
        });

        function fetchCategories() {
            fetch(`${BASE_API_URL}/category`)
                .then(res => res.json())
                .then(categories => {
                    const tabsContainer = document.getElementById('categoryTabs');
                    tabsContainer.innerHTML = '<button class="filter-tab active" data-category="all" onclick="selectCategory(this)">Tất cả</button>';
                    
                    categories.forEach(category => {
                        const btn = document.createElement('button');
                        btn.className = 'filter-tab';
                        btn.setAttribute('data-category', category.name.toLowerCase());
                        btn.onclick = function() { selectCategory(this); };
                        btn.textContent = category.name;
                        tabsContainer.appendChild(btn);
                    });
                })
                .catch(err => console.error("Lỗi tải danh mục từ API:", err));
        }

        function fetchProducts() {
            fetch(`${BASE_API_URL}/product`)
                .then(res => res.json())
                .then(products => {
                    allProducts = products;
                    renderProductGrid(allProducts);
                })
                .catch(err => {
                    console.error("Lỗi tải sản phẩm từ API:", err);
                    document.getElementById('productsGrid').innerHTML = `
                        <div class="text-center py-5" style="grid-column: 1 / -1; color: var(--color-danger);">
                            <div style="font-size: 40px; margin-bottom: 15px;">⚠️</div>
                            <p>Không thể tải sản phẩm từ API: ${err.message}</p>
                        </div>
                    `;
                });
        }

        function renderProductGrid(products) {
            const grid = document.getElementById('productsGrid');
            grid.innerHTML = '';

            if (products.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background-color: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                        <div style="font-size: 64px; margin-bottom: 20px;">🏸</div>
                        <h2>Chưa có sản phẩm nào</h2>
                        <p style="color: var(--text-muted); margin-bottom: 24px;">Hiện tại cửa hàng chưa có sản phẩm nào.</p>
                    </div>
                `;
                return;
            }

            products.forEach((product, index) => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.setAttribute('data-index', index);
                card.setAttribute('data-name', product.name.toLowerCase());
                card.setAttribute('data-category', (product.category_name || '').toLowerCase());
                card.setAttribute('data-price', product.price);

                const imageHtml = product.image 
                    ? `<a href="${BASE_URL}/product/show/${product.id}">
                           <img src="${BASE_URL}/common/access/${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}">
                       </a>`
                    : `<a href="${BASE_URL}/product/show/${product.id}" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e2e8f0; color: #64748b;">
                           📷 Không có ảnh
                       </a>`;

                card.innerHTML = `
                    <!-- Image -->
                    <div class="product-card-image">
                        ${imageHtml}
                        <span class="product-card-badge">
                            ${escapeHtml(product.category_name || 'Chưa phân loại')}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="product-card-body">
                        <h3 class="product-card-title" title="${escapeHtml(product.name)}">
                            <a href="${BASE_URL}/product/show/${product.id}">
                                ${escapeHtml(product.name)}
                            </a>
                        </h3>
                        
                        <p class="product-card-desc" title="${escapeHtml(product.description)}">
                            ${escapeHtml(truncateString(product.description, 90))}
                        </p>

                        <div class="product-card-price-row">
                            <div class="price-container">
                                <span class="price-label">Giá bán</span>
                                <span class="price-value">${formatMoney(product.price)} đ</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="product-card-actions">
                            <a href="${BASE_URL}/product/show/${product.id}" class="btn btn-secondary">
                                🔍 Chi tiết
                            </a>
                            <a href="${BASE_URL}/product/addToCart/${product.id}" class="btn btn-accent">
                                🛒 Thêm giỏ
                            </a>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function selectCategory(button) {
            document.querySelectorAll('#categoryTabs .filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            button.classList.add('active');
            currentCategory = button.getAttribute('data-category');
            
            filterAndSortProducts();
        }

        function filterAndSortProducts() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
            const grid = document.getElementById('productsGrid');
            if (!grid) return;

            const cards = Array.from(grid.querySelectorAll('.product-card'));
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const category = card.getAttribute('data-category') || '';
                const price = card.getAttribute('data-price') || '';

                const matchesSearch = name.includes(searchInput) || category.includes(searchInput) || price.includes(searchInput);
                const matchesCategory = (currentCategory === 'all' || category === currentCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Sắp xếp
            const sortVal = document.getElementById('sortSelect').value;
            cards.sort((a, b) => {
                if (sortVal === 'price-asc') {
                    return parseFloat(a.getAttribute('data-price')) - parseFloat(b.getAttribute('data-price'));
                } else if (sortVal === 'price-desc') {
                    return parseFloat(b.getAttribute('data-price')) - parseFloat(a.getAttribute('data-price'));
                } else if (sortVal === 'name-asc') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                } else {
                    return parseInt(a.getAttribute('data-index')) - parseInt(b.getAttribute('data-index'));
                }
            });

            cards.forEach(card => grid.appendChild(card));

            let noResult = grid.querySelector('.no-results');
            if (visibleCount === 0) {
                if (!noResult) {
                    noResult = document.createElement('div');
                    noResult.className = 'no-results';
                    noResult.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted); font-weight: 500; font-size: 16px;';
                    noResult.innerHTML = '🔍 Không tìm thấy sản phẩm nào phù hợp.';
                    grid.appendChild(noResult);
                }
            } else if (noResult) {
                noResult.remove();
            }
        }

        // Helpers
        function formatMoney(num) {
            return parseFloat(num).toLocaleString('vi-VN');
        }

        function truncateString(str, length) {
            if (!str) return '';
            if (str.length <= length) return str;
            return str.substring(0, length) + '...';
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, "&amp;")
                      .replace(/</g, "&lt;")
                      .replace(/>/g, "&gt;")
                      .replace(/"/g, "&quot;")
                      .replace(/'/g, "&#039;");
        }
    </script>

    <?php include_once __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
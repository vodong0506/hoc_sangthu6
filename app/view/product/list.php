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
        <?php if (isset($categories) && count($categories) > 0): ?>
            <div class="filter-tabs" style="margin-bottom: 30px;">
                <button class="filter-tab active" data-category="all" onclick="selectCategory(this)">Tất cả</button>
                <?php foreach ($categories as $category): ?>
                    <button class="filter-tab" data-category="<?php echo htmlspecialchars(strtolower($category->name)); ?>" onclick="selectCategory(this)">
                        <?php echo htmlspecialchars($category->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Product Grid -->
        <?php if (isset($products) && count($products) > 0): ?>
            <div class="products-grid" id="productsGrid">
                <?php foreach ($products as $index => $product): ?>
                    <div class="product-card" 
                         data-index="<?php echo $index; ?>"
                         data-name="<?php echo strtolower(htmlspecialchars($product->name)); ?>"
                         data-category="<?php echo strtolower(htmlspecialchars($product->category_name ?? '')); ?>"
                         data-price="<?php echo $product->price; ?>">
                        
                        <!-- Image -->
                        <div class="product-card-image">
                            <?php if ($product->image): ?>
                                <a href="<?php echo BASE_URL; ?>/product/show/<?php echo $product->id; ?>">
                                    <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                                </a>
                            <?php else: ?>
                                <a href="<?php echo BASE_URL; ?>/product/show/<?php echo $product->id; ?>" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #e2e8f0; color: #64748b;">
                                    📷 Không có ảnh
                                </a>
                            <?php endif; ?>
                            
                            <span class="product-card-badge">
                                <?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại'); ?>
                            </span>
                        </div>

                        <!-- Body -->
                        <div class="product-card-body">
                            <h3 class="product-card-title" title="<?php echo htmlspecialchars($product->name); ?>">
                                <a href="<?php echo BASE_URL; ?>/product/show/<?php echo $product->id; ?>">
                                    <?php echo htmlspecialchars($product->name); ?>
                                </a>
                            </h3>
                            
                            <p class="product-card-desc" title="<?php echo htmlspecialchars($product->description); ?>">
                                <?php echo htmlspecialchars(mb_strimwidth($product->description, 0, 90, '...')); ?>
                            </p>

                            <div class="product-card-price-row">
                                <div class="price-container">
                                    <span class="price-label">Giá bán</span>
                                    <span class="price-value"><?php echo number_format($product->price, 0, ',', '.'); ?> đ</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="product-card-actions">
                                <a href="<?php echo BASE_URL; ?>/product/show/<?php echo $product->id; ?>" class="btn btn-secondary">
                                    🔍 Chi tiết
                                </a>
                                <a href="<?php echo BASE_URL; ?>/product/addToCart/<?php echo $product->id; ?>" class="btn btn-accent">
                                    🛒 Thêm giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state" style="text-align: center; padding: 60px 20px; background-color: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                <div style="font-size: 64px; margin-bottom: 20px;">🏸</div>
                <h2>Chưa có sản phẩm nào</h2>
                <p style="color: var(--text-muted); margin-bottom: 24px;">Hiện tại Badminton Store chưa có sản phẩm nào.</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
        let currentCategory = 'all';

        function selectCategory(button) {
            // Remove active class from all tabs
            document.querySelectorAll('.filter-tabs .filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            // Add active class to clicked tab
            button.classList.add('active');
            currentCategory = button.getAttribute('data-category');
            
            // Filter and sort products
            filterAndSortProducts();
        }

        // Search, category filter and sort function combined
        function filterAndSortProducts() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
            const grid = document.getElementById('productsGrid');
            if (!grid) return;

            const cards = Array.from(grid.querySelectorAll('.product-card'));
            let visibleCount = 0;

            // Filter cards
            cards.forEach(card => {
                const name = card.dataset.name || '';
                const category = card.dataset.category || '';
                const price = card.dataset.price || '';

                const matchesSearch = name.includes(searchInput) || category.includes(searchInput) || price.includes(searchInput);
                const matchesCategory = (currentCategory === 'all' || category === currentCategory);

                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Sort cards
            const sortVal = document.getElementById('sortSelect').value;
            cards.sort((a, b) => {
                if (sortVal === 'price-asc') {
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                } else if (sortVal === 'price-desc') {
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                } else if (sortVal === 'name-asc') {
                    return a.dataset.name.localeCompare(b.dataset.name);
                } else {
                    // default order by index
                    return parseInt(a.dataset.index) - parseInt(b.dataset.index);
                }
            });

            // Re-append cards to grid in sorted order
            cards.forEach(card => grid.appendChild(card));

            // Handle no results message
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
    </script>

    <?php include_once __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
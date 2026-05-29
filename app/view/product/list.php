<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <style>
        :root {
            --bg-start: #f0f4f8;
            --bg-end: #e8eef5;
            --card: rgba(255, 255, 255, 0.95);
            --card-border: rgba(108, 140, 255, 0.12);
            --accent: #5a7cff;
            --accent-strong: #4a6bff;
            --text-main: #1a2844;
            --text-muted: #666d7a;
            --surface: rgba(255, 255, 255, 0.98);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            min-height: 100vh;
            padding: 2rem 1rem 3rem;
        }

        body::before {
            content: '';
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 20%, rgba(108, 140, 255, 0.08), transparent 25%),
                radial-gradient(circle at 80% 15%, rgba(108, 140, 255, 0.06), transparent 28%);
            pointer-events: none;
        }

        .container {
            max-width: 1180px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .page-header {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1.75rem 1.5rem;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(108, 140, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(18px);
        }

        .page-title {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .page-title h1 {
            font-size: clamp(2rem, 2.6vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            color: var(--text-main);
        }

        .page-title p {
            color: var(--text-muted);
            font-size: 0.98rem;
            max-width: 680px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-add-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: white;
            padding: 0.95rem 1.55rem;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.03em;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 10px 28px rgba(90, 124, 255, 0.25);
        }

        .btn-add-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 38px rgba(90, 124, 255, 0.3);
        }

        .actions-note {
            color: var(--text-muted);
            font-size: 0.95rem;
            text-align: right;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            padding: 1.4rem 1.25rem;
            border-radius: 22px;
            background: var(--surface);
            border: 1px solid rgba(108, 140, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            display: grid;
            gap: 0.5rem;
        }

        .stat-title {
            color: var(--text-muted);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .search-panel {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1.75rem;
        }

        .search-box {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(108, 140, 255, 0.12);
            border-radius: 18px;
            padding: 1rem 1.25rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(14px);
        }

        .search-input {
            width: 100%;
            padding: 0.95rem 1rem;
            border: none;
            border-radius: 14px;
            background: rgba(108, 140, 255, 0.06);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.04);
            color: var(--text-main);
            font-size: 1rem;
        }

        .search-input::placeholder {
            color: rgba(26, 40, 68, 0.65);
        }

        .search-input:focus {
            outline: 2px solid rgba(90, 124, 255, 0.35);
            background: rgba(108, 140, 255, 0.08);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .product-card {
            background: var(--surface);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(90, 124, 255, 0.3);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        }

        .product-image {
            position: relative;
            min-height: 220px;
            background: linear-gradient(180deg, rgba(108, 140, 255, 0.06), rgba(108, 140, 255, 0.1));
            display: grid;
            place-items: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-image .image-fallback {
            color: rgba(255, 255, 255, 0.65);
            font-size: 1.05rem;
            text-align: center;
            padding: 1.5rem;
        }

        .product-body {
            padding: 1.4rem 1.4rem 1.2rem;
            display: grid;
            gap: 0.85rem;
            flex: 1;
        }

        .product-category {
            display: inline-flex;
            padding: 0.45rem 0.9rem;
            background: rgba(90, 124, 255, 0.12);
            color: var(--accent);
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            width: fit-content;
        }

        .product-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.35;
            margin-bottom: 0.15rem;
        }

        .product-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            min-height: 3rem;
        }

        .product-price {
            display: flex;
            align-items: baseline;
            gap: 0.6rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--accent);
        }

        .price-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .product-actions {
            display: flex;
            gap: 0.9rem;
            margin-top: auto;
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1 1 calc(50% - 0.45rem);
            min-width: 120px;
            padding: 0.9rem 0.95rem;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.88rem;
            transition: transform 0.22s ease, box-shadow 0.22s ease;
            letter-spacing: 0.04em;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .btn-edit {
            background: rgba(90, 124, 255, 0.12);
            color: var(--accent);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(90, 124, 255, 0.15);
            background: rgba(90, 124, 255, 0.18);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.12);
            color: #d63545;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.15);
            background: rgba(220, 53, 69, 0.18);
        }

        .btn-cart {
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: white;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(90, 124, 255, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(108, 140, 255, 0.15);
            border-radius: 26px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1.25rem;
        }

        .empty-state h2 {
            color: var(--text-main);
            margin-bottom: 0.85rem;
            font-size: 1.75rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .empty-state .btn-add-primary {
            padding: 1rem 1.75rem;
        }

        .alert {
            padding: 1rem 1.2rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            animation: slideDown 0.4s ease-out;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            border: 1px solid rgba(72, 187, 120, 0.3);
            color: #2e7d32;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #c41c3b;
        }

        .no-results {
            grid-column: 1 / -1;
            padding: 3rem 1.5rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px dashed rgba(108, 140, 255, 0.15);
            color: rgba(26, 40, 68, 0.75);
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1000;
            animation: fadeIn 0.3s ease-out;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            width: min(420px, calc(100% - 2rem));
            text-align: center;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(108, 140, 255, 0.12);
        }

        .modal-content h2 {
            color: var(--text-main);
            margin-bottom: 1rem;
            font-size: 1.45rem;
        }

        .modal-content p {
            color: var(--text-muted);
            margin-bottom: 1.75rem;
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .modal-actions {
            display: flex;
            gap: 0.9rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .modal-actions button {
            padding: 0.95rem 1.25rem;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 700;
            transition: background 0.25s ease, transform 0.25s ease;
            min-width: 120px;
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, #d63545, #c41c3b);
            color: white;
        }

        .modal-btn-confirm:hover {
            transform: translateY(-2px);
        }

        .modal-btn-cancel {
            background: rgba(108, 140, 255, 0.08);
            color: var(--text-main);
        }

        .modal-btn-cancel:hover {
            background: rgba(108, 140, 255, 0.14);
            transform: translateY(-2px);
        }

        @media (max-width: 900px) {
            .page-header {
                grid-template-columns: 1fr;
            }

            .top-actions {
                justify-content: flex-start;
            }
        }

        @media (max-width: 720px) {
            .search-panel {
                grid-template-columns: 1fr;
            }

            .product-actions {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Danh Sách Sản Phẩm</h1>
            <a href="<?php echo BASE_URL; ?>/product/cart" class="btn-add-primary">
                🛒 Giỏ Hàng
            </a>
        </div>

        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <!-- Thống kê -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">
                    <?php echo isset($products) ? count($products) : 0; ?>
                </div>
                <div class="stat-label">Tổng Sản Phẩm</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php echo isset($categories) ? count($categories) : 0; ?>
                </div>
                <div class="stat-label">Danh Mục</div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-box">
            <input type="text" class="search-input" id="searchInput"
                placeholder="🔍 Tìm kiếm sản phẩm theo tên, giá, danh mục..." onkeyup="filterProducts()">
        </div>

        <!-- Danh sách sản phẩm -->
        <?php if (isset($products) && count($products) > 0) { ?>
            <div class="products-grid" id="productsGrid">
                <?php foreach ($products as $product) { ?>
                    <div class="product-card" data-name="<?php echo strtolower(htmlspecialchars($product->name)); ?>"
                        data-category="<?php echo strtolower(htmlspecialchars($product->category_name ?? '')); ?>"
                        data-price="<?php echo $product->price; ?>">
                        <!-- Ảnh sản phẩm -->
                        <div class="product-image">
                            <?php if ($product->image) { ?>
                                <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($product->image); ?>"
                                    alt="<?php echo htmlspecialchars($product->name); ?>">
                            <?php } else { ?>
                                <div
                                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f0; color: #999;">
                                    📷 Không có ảnh
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Nội dung sản phẩm -->
                        <div class="product-body">
                            <span class="product-category">
                                <?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại'); ?>
                            </span>

                            <h3 class="product-name" title="<?php echo htmlspecialchars($product->name); ?>">
                                <?php echo htmlspecialchars($product->name); ?>
                            </h3>

                            <p class="product-description" title="<?php echo htmlspecialchars($product->description); ?>">
                                <?php echo htmlspecialchars(substr($product->description, 0, 80)); ?>...
                            </p>

                            <div class="price-label">Giá</div>
                            <div class="product-price">
                                <?php echo number_format($product->price, 0, ',', '.'); ?> đ
                            </div>

                            <!-- Nút hành động -->
                            <div class="product-actions">
                                <a href="<?php echo BASE_URL; ?>/product/addToCart/<?php echo $product->id; ?>"
                                    class="btn-action btn-cart" style="flex: 1 1 100%; min-width: 100%;">
                                    🛒 Thêm vào giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <!-- Trạng thái trống -->
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h2>Chưa có sản phẩm</h2>
                <p>Hiện tại cửa hàng chưa có sản phẩm nào.</p>
                <a href="<?php echo BASE_URL; ?>/product/cart" class="btn-add-primary">
                    🛒 Xem Giỏ Hàng
                </a>
            </div>
        <?php } ?>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h2>⚠️ Xác Nhận Xóa</h2>
            <p>Bạn có chắc chắn muốn xóa sản phẩm "<span id="productNameDisplay"></span>" không? Hành động này không thể
                hoàn tác.</p>
            <div class="modal-actions">
                <form id="deleteForm" action="" method="POST" style="display: inline;">
                    <button type="submit" class="modal-btn-confirm">Xóa</button>
                </form>
                <button class="modal-btn-cancel" onclick="closeDeleteModal()">Hủy</button>
            </div>
        </div>
    </div>

    <script>
        let deleteProductId = null;

        function confirmDelete(productId, productName) {
            deleteProductId = productId;
            document.getElementById('productNameDisplay').textContent = productName;
            document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>/product/delete?id=' + productId;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteProductId = null;
        }

        // Đóng modal khi click ngoài
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Chức năng tìm kiếm
        function filterProducts() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const products = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            products.forEach(product => {
                const name = product.dataset.name;
                const category = product.dataset.category;
                const price = product.dataset.price;

                if (name.includes(input) || category.includes(input) || price.includes(input)) {
                    product.style.display = '';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Hiển thị thông báo nếu không tìm thấy
            const grid = document.getElementById('productsGrid');
            let noResult = grid.querySelector('.no-results');

            if (visibleCount === 0 && input) {
                if (!noResult) {
                    noResult = document.createElement('div');
                    noResult.className = 'no-results';
                    noResult.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 40px; color: #999;';
                    noResult.innerHTML = '🔍 Không tìm thấy sản phẩm nào';
                    grid.appendChild(noResult);
                }
            } else if (noResult) {
                noResult.remove();
            }
        }

        // Tự động đóng alert sau 5 giây
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideUp 0.4s ease-out reverse';
                setTimeout(() => alert.remove(), 400);
            }, 5000);
        });
    </script>
</body>

</html>
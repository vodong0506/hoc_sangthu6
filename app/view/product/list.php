<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease-out;
        }

        .header h1 {
            color: white;
            font-size: 32px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-add-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: #667eea;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-add-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .btn-add-primary:active {
            transform: translateY(-1px);
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out 0.2s both;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            animation: fadeIn 0.8s ease-out 0.3s both;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            animation: scaleIn 0.6s ease-out backwards;
        }

        .product-card:nth-child(1) {
            animation-delay: 0.4s;
        }

        .product-card:nth-child(2) {
            animation-delay: 0.5s;
        }

        .product-card:nth-child(3) {
            animation-delay: 0.6s;
        }

        .product-card:nth-child(4) {
            animation-delay: 0.7s;
        }

        .product-card:nth-child(5) {
            animation-delay: 0.8s;
        }

        .product-card:nth-child(6) {
            animation-delay: 0.9s;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
            position: relative;
            overflow: hidden;
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .product-body {
            padding: 20px;
        }

        .product-category {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-description {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .price-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-action {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-delete:active {
            transform: translateY(0);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out 0.2s both;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .empty-state .btn-add-primary {
            display: inline-flex;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            border: 2px solid #e74c3c;
            color: #721c24;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
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
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s ease-out;
        }

        .modal-content h2 {
            color: #333;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .modal-actions button {
            padding: 10px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .modal-btn-confirm {
            background: #e74c3c;
            color: white;
        }

        .modal-btn-confirm:hover {
            background: #c0392b;
        }

        .modal-btn-cancel {
            background: #e0e0e0;
            color: #333;
        }

        .modal-btn-cancel:hover {
            background: #d0d0d0;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                margin-bottom: 30px;
            }

            .header h1 {
                font-size: 24px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .btn-action {
                font-size: 11px;
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Danh Sách Sản Phẩm</h1>
            <a href="<?php echo BASE_URL; ?>/product/create" class="btn-add-primary">
                ➕ Thêm Sản Phẩm
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
                                <a href="<?php echo BASE_URL; ?>/product/edit/<?php echo $product->id; ?>"
                                    class="btn-action btn-edit">
                                    ✏️ Sửa
                                </a>
                                <button class="btn-action btn-delete"
                                    onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars(str_replace("'", "\\'", $product->name)); ?>')">
                                    🗑️ Xóa
                                </button>
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
                <p>Hãy thêm sản phẩm đầu tiên để bắt đầu</p>
                <a href="<?php echo BASE_URL; ?>/product/create" class="btn-add-primary">
                    ➕ Thêm Sản Phẩm Đầu Tiên
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
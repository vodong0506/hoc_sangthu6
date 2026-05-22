<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
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
            max-width: 900px;
            margin: 0 auto;
        }

        .breadcrumb {
            color: white;
            margin-bottom: 30px;
            font-size: 14px;
            animation: fadeIn 0.8s ease-out;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: white;
            text-decoration: underline;
        }

        .breadcrumb span {
            color: rgba(255, 255, 255, 0.6);
            margin: 0 8px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-detail {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out 0.1s both;
        }

        .product-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }

        .product-image-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideIn 0.6s ease-out 0.3s both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .product-image-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        .product-image {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 10px;
        }

        .no-image {
            width: 100%;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 48px;
            background: #f0f0f0;
            border-radius: 10px;
        }

        .product-info-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideInRight 0.6s ease-out 0.4s both;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .product-category {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: fit-content;
        }

        .product-name {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }

        .stars {
            color: #ffc107;
            font-size: 16px;
        }

        .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        .price-section {
            margin-bottom: 25px;
        }

        .price-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .price-value {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
        }

        .price-note {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .description-section {
            margin-bottom: 25px;
        }

        .description-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .description-text {
            font-size: 14px;
            color: #666;
            line-height: 1.8;
        }

        .product-meta {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .product-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            animation: slideUp 0.6s ease-out 0.6s both;
        }

        button,
        a.btn {
            padding: 14px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            flex: 1;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #3498db;
            color: white;
            flex: 1;
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary:hover {
            background: #2980b9;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(52, 152, 219, 0.4);
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
            flex: 1;
            box-shadow: 0 10px 20px rgba(231, 76, 60, 0.3);
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(231, 76, 60, 0.4);
        }

        .btn-back {
            background: #e0e0e0;
            color: #333;
            flex: 1;
        }

        .btn-back:hover {
            background: #d0d0d0;
            transform: translateY(-3px);
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

        .alert-danger {
            background: #f8d7da;
            border: 2px solid #e74c3c;
            color: #721c24;
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
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease-out;
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
            .product-content {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 30px 20px;
            }

            .product-name {
                font-size: 24px;
            }

            .price-value {
                font-size: 28px;
            }

            .product-actions {
                flex-direction: column;
            }

            button,
            a.btn {
                padding: 12px 20px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/product">📦 Danh sách sản phẩm</a>
            <span>/</span>
            <span>Chi tiết sản phẩm</span>
        </div>

        <?php
        if (isset($errors) && count($errors) > 0) {
            echo '<div class="alert alert-danger">';
            echo '<strong>Có lỗi xảy ra:</strong>';
            echo '<ul style="margin: 10px 0 0 20px;">';
            foreach ($errors as $field => $message) {
                echo '<li>' . htmlspecialchars($message) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

        <div class="product-detail">
            <div class="product-content">
                <!-- Phần hình ảnh -->
                <div class="product-image-section">
                    <div class="product-image-container">
                        <?php if (isset($product) && $product->image) { ?>
                            <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($product->image); ?>"
                                alt="<?php echo htmlspecialchars($product->name); ?>" class="product-image">
                        <?php } else { ?>
                            <div class="no-image">📷</div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Phần thông tin -->
                <div class="product-info-section">
                    <?php if (isset($product)) { ?>
                        <span
                            class="product-category"><?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại'); ?></span>

                        <h1 class="product-name"><?php echo htmlspecialchars($product->name); ?></h1>

                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                            <span>(4.8 từ 125 đánh giá)</span>
                        </div>

                        <div class="divider"></div>

                        <!-- Giá -->
                        <div class="price-section">
                            <div class="price-label">Giá Bán</div>
                            <div class="price-value">
                                <?php echo number_format($product->price, 0, ',', '.'); ?> đ
                            </div>
                            <div class="price-note">Giá gồm VAT, miễn phí vận chuyển nội thành</div>
                        </div>

                        <!-- Thông tin meta -->
                        <div class="product-meta">
                            <div class="meta-item">
                                <div class="meta-label">Mã Sản Phẩm</div>
                                <div class="meta-value">SP-<?php echo str_pad($product->id, 5, '0', STR_PAD_LEFT); ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Kho Hàng</div>
                                <div class="meta-value">
                                    <span style="color: #27ae60;">✓ Còn hàng</span>
                                </div>
                            </div>
                        </div>

                        <!-- Mô tả -->
                        <div class="description-section">
                            <div class="description-label">Mô Tả Chi Tiết</div>
                            <div class="description-text">
                                <?php echo nl2br(htmlspecialchars($product->description)); ?>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Nút hành động -->
                        <div class="product-actions">
                            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-back">← Quay Lại</a>
                            <a href="<?php echo BASE_URL; ?>/product/edit?id=<?php echo $product->id; ?>"
                                class="btn btn-secondary">✏️ Sửa</a>
                            <button class="btn btn-danger"
                                onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars(str_replace("'", "\\'", $product->name)); ?>')">🗑️
                                Xóa</button>
                        </div>
                    <?php } else { ?>
                        <div style="padding: 40px; text-align: center;">
                            <h2 style="color: #e74c3c; margin-bottom: 10px;">Sản phẩm không tồn tại</h2>
                            <p style="color: #666; margin-bottom: 20px;">Sản phẩm bạn tìm kiếm không được tìm thấy</p>
                            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-primary">← Quay Về Danh Sách</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
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
        function confirmDelete(productId, productName) {
            document.getElementById('productNameDisplay').textContent = productName;
            document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>/product/delete?id=' + productId;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Đóng modal khi click ngoài
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</body>

</html>
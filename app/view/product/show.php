<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm - Badminton Store</title>
</head>

<body>
    <?php include_once __DIR__ . '/../shares/header.php'; ?>

    <main class="page">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/product">📦 Danh sách sản phẩm</a>
            <span class="divider">/</span>
            <span class="current">Chi tiết sản phẩm</span>
        </div>

        <?php if (isset($product)): ?>
            <div class="product-detail-layout">
                <!-- Image Section -->
                <div class="detail-image-section">
                    <div class="detail-image-wrapper">
                        <?php if ($product->image): ?>
                            <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>">
                        <?php else: ?>
                            <div style="font-size: 64px; color: #cbd5e1;">📷</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="detail-info-section">
                    <span class="detail-category-badge">
                        <?php echo htmlspecialchars($product->category_name ?? 'Chưa phân loại'); ?>
                    </span>

                    <h1 class="detail-title"><?php echo htmlspecialchars($product->name); ?></h1>

                    <div class="detail-rating">
                        <span class="detail-stars">★★★★★</span>
                        <span>(4.8 từ 125 đánh giá)</span>
                    </div>

                    <div class="detail-divider"></div>

                    <!-- Price -->
                    <div class="detail-price-box">
                        <span class="price-label">Giá Bán</span>
                        <div class="detail-price-value">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> đ
                        </div>
                    </div>

                    <!-- Specifications / Meta -->
                    <div class="detail-specs">
                        <div class="spec-item">
                            <span class="spec-label">Mã sản phẩm</span>
                            <span class="spec-value">SP-<?php echo str_pad($product->id, 5, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Tình trạng</span>
                            <span class="spec-value" style="color: var(--color-success);">✓ Còn hàng</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="description-section">
                        <h3 class="detail-desc-title">Mô Tả Chi Tiết</h3>
                        <p class="detail-desc-text">
                            <?php echo nl2br(htmlspecialchars($product->description)); ?>
                        </p>
                    </div>

                    <div class="detail-divider"></div>

                    <!-- Actions -->
                    <div class="detail-actions">
                        <a href="<?php echo BASE_URL; ?>/product" class="btn btn-secondary">
                            ← Quay Lại
                        </a>
                        <a href="<?php echo BASE_URL; ?>/product/addToCart/<?php echo $product->id; ?>" class="btn btn-accent">
                            🛒 Thêm Vào Giỏ
                        </a>
                        
                        <?php if (SessionHelper::isAdmin()): ?>
                            <a href="<?php echo BASE_URL; ?>/product/edit/<?php echo $product->id; ?>" class="btn btn-primary">
                                ✏️ Sửa
                            </a>
                            <button class="btn btn-danger" onclick="confirmDelete(<?php echo $product->id; ?>, '<?php echo htmlspecialchars(str_replace("'", "\\'", $product->name)); ?>')">
                                🗑️ Xóa
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state" style="text-align: center; padding: 60px 20px; background-color: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
                <div style="font-size: 64px; color: var(--color-danger); margin-bottom: 20px;">⚠️</div>
                <h2>Sản phẩm không tồn tại</h2>
                <p style="color: var(--text-muted); margin-bottom: 24px;">Sản phẩm bạn tìm kiếm không được tìm thấy hoặc đã bị xóa.</p>
                <a href="<?php echo BASE_URL; ?>/product" class="btn btn-primary">← Quay Về Danh Sách</a>
            </div>
        <?php endif; ?>
    </main>

    <!-- Modal xác nhận xóa (chỉ dành cho Admin) -->
    <?php if (SessionHelper::isAdmin()): ?>
        <div class="modal" id="deleteModal">
            <div class="modal-content">
                <span class="modal-icon">⚠️</span>
                <h2>Xác Nhận Xóa</h2>
                <p>Bạn có chắc chắn muốn xóa sản phẩm "<span id="productNameDisplay"></span>" không? Hành động này không thể hoàn tác.</p>
                <div class="modal-actions">
                    <form id="deleteForm" action="" method="POST" style="display: inline;">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                    <button class="btn btn-secondary" onclick="closeDeleteModal()">Hủy</button>
                </div>
            </div>
        </div>

        <script>
            function confirmDelete(productId, productName) {
                document.getElementById('productNameDisplay').textContent = productName;
                document.getElementById('deleteForm').action = '<?php echo BASE_URL; ?>/product/delete/' + productId;
                document.getElementById('deleteModal').classList.add('active');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.remove('active');
            }

            // Đóng modal khi click ra ngoài
            document.getElementById('deleteModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        </script>
    <?php endif; ?>

    <?php include_once __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
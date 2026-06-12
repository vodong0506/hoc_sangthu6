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

        <div class="product-detail-layout" id="productDetailContainer" style="opacity: 0; transition: opacity 0.3s ease;">
            <!-- Image Section -->
            <div class="detail-image-section">
                <div class="detail-image-wrapper" id="productImageWrapper">
                    <!-- Sẽ nạp qua API -->
                </div>
            </div>

            <!-- Info Section -->
            <div class="detail-info-section">
                <span class="detail-category-badge" id="productCategoryBadge">
                    <!-- Sẽ nạp qua API -->
                </span>

                <h1 class="detail-title" id="productName">---</h1>

                <div class="detail-rating">
                    <span class="detail-stars">★★★★★</span>
                    <span>(4.8 từ 125 đánh giá)</span>
                </div>

                <div class="detail-divider"></div>

                <!-- Price -->
                <div class="detail-price-box">
                    <span class="price-label">Giá Bán</span>
                    <div class="detail-price-value" id="productPrice">0 đ</div>
                </div>

                <!-- Specifications / Meta -->
                <div class="detail-specs">
                    <div class="spec-item">
                        <span class="spec-label">Mã sản phẩm</span>
                        <span class="spec-value" id="productCode">SP-00000</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Tình trạng</span>
                        <span class="spec-value" style="color: var(--color-success);">✓ Còn hàng</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="description-section">
                    <h3 class="detail-desc-title">Mô Tả Chi Tiết</h3>
                    <p class="detail-desc-text" id="productDescription">
                        <!-- Sẽ nạp qua API -->
                    </p>
                </div>

                <div class="detail-divider"></div>

                <!-- Actions -->
                <div class="detail-actions">
                    <a href="<?php echo BASE_URL; ?>/product" class="btn btn-secondary">
                        ← Quay Lại
                    </a>
                    <a href="#" class="btn btn-accent" id="addToCartBtn">
                        🛒 Thêm Vào Giỏ
                    </a>
                    
                    <?php if (SessionHelper::isAdmin()): ?>
                        <a href="#" class="btn btn-primary" id="editProductBtn">
                            ✏️ Sửa
                        </a>
                        <button class="btn btn-danger" id="deleteProductBtn">
                            🗑️ Xóa
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="loadingSpinner" class="text-center py-5">
            <div class="spinner" style="font-size: 40px; margin-bottom: 15px; animation: spin 1s linear infinite;">🔄</div>
            <p style="color: var(--text-muted);">Đang tải chi tiết sản phẩm qua RESTful API...</p>
        </div>

        <div id="errorState" class="empty-state d-none" style="text-align: center; padding: 60px 20px; background-color: var(--bg-card); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
            <div style="font-size: 64px; color: var(--color-danger); margin-bottom: 20px;">⚠️</div>
            <h2>Sản phẩm không tồn tại</h2>
            <p style="color: var(--text-muted); margin-bottom: 24px;" id="errorText">Sản phẩm bạn tìm kiếm không được tìm thấy hoặc đã bị xóa.</p>
            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-primary">← Quay Về Danh Sách</a>
        </div>
    </main>

    <!-- Modal xác nhận xóa (chỉ dành cho Admin) -->
    <?php if (SessionHelper::isAdmin()): ?>
        <div class="modal" id="deleteModal">
            <div class="modal-content">
                <span class="modal-icon">⚠️</span>
                <h2>Xác Nhận Xóa</h2>
                <p>Bạn có chắc chắn muốn xóa sản phẩm "<span id="productNameDisplay"></span>" không? Hành động này không thể hoàn tác.</p>
                <div class="modal-actions">
                    <button class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                    <button class="btn btn-secondary" onclick="closeDeleteModal()">Hủy</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .d-none {
            display: none !important;
        }
    </style>

    <script>
        const productId = <?php echo json_encode($id); ?>;
        const BASE_API_URL = '<?php echo BASE_URL; ?>/api';
        const BASE_URL = '<?php echo BASE_URL; ?>';
        let deleteId = null;

        document.addEventListener("DOMContentLoaded", function () {
            if (!productId) {
                showError("Không tìm thấy mã sản phẩm.");
                return;
            }

            fetch(`${BASE_API_URL}/product/${productId}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error("Sản phẩm không tồn tại hoặc lỗi kết nối.");
                    }
                    return res.json();
                })
                .then(product => {
                    document.getElementById('loadingSpinner').classList.add('d-none');
                    const detailContainer = document.getElementById('productDetailContainer');
                    detailContainer.style.opacity = '1';

                    // Điền dữ liệu
                    document.getElementById('breadcrumbProductName').textContent = product.name;
                    document.getElementById('productName').textContent = product.name;
                    document.getElementById('productCategoryBadge').textContent = product.category_name || 'Chưa phân loại';
                    document.getElementById('productPrice').textContent = formatMoney(product.price) + ' đ';
                    document.getElementById('productCode').textContent = 'SP-' + String(product.id).padStart(5, '0');
                    document.getElementById('productDescription').innerHTML = escapeHtml(product.description).replace(/\n/g, '<br>');

                    // Ảnh
                    const imgWrapper = document.getElementById('productImageWrapper');
                    if (product.image) {
                        imgWrapper.innerHTML = `<img src="${BASE_URL}/common/access/${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}">`;
                    } else {
                        imgWrapper.innerHTML = `<div style="font-size: 64px; color: #cbd5e1; height: 300px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border-radius: 12px;">📷 Không có ảnh</div>`;
                    }

                    // Sự kiện và liên kết
                    document.getElementById('addToCartBtn').href = `${BASE_URL}/product/addToCart/${product.id}`;
                    
                    const editBtn = document.getElementById('editProductBtn');
                    if (editBtn) {
                        editBtn.href = `${BASE_URL}/admin/productEdit/${product.id}`;
                    }

                    const deleteBtn = document.getElementById('deleteProductBtn');
                    if (deleteBtn) {
                        deleteBtn.onclick = function() {
                            confirmDelete(product.id, product.name);
                        };
                    }
                })
                .catch(err => {
                    showError(err.message);
                });

            // Gán sự kiện cho nút xác nhận xóa trong modal
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (!deleteId) return;
                    
                    confirmDeleteBtn.disabled = true;
                    confirmDeleteBtn.textContent = 'Đang xóa...';

                    fetch(`${BASE_API_URL}/product/${deleteId}`, {
                        method: 'DELETE'
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.message || "Lỗi khi xóa sản phẩm");
                        return data;
                    })
                    .then(res => {
                        window.location.href = `${BASE_URL}/product`;
                    })
                    .catch(err => {
                        alert("Lỗi xóa sản phẩm: " + err.message);
                        confirmDeleteBtn.disabled = false;
                        confirmDeleteBtn.textContent = 'Xóa';
                        closeDeleteModal();
                    });
                });
            }
        });

        function showError(message) {
            document.getElementById('loadingSpinner').classList.add('d-none');
            document.getElementById('productDetailContainer').classList.add('d-none');
            const errState = document.getElementById('errorState');
            errState.classList.remove('d-none');
            document.getElementById('errorText').textContent = message;
        }

        function confirmDelete(productId, productName) {
            deleteId = productId;
            document.getElementById('productNameDisplay').textContent = productName;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Đóng modal khi click ra ngoài
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });
        }

        function formatMoney(num) {
            return parseFloat(num).toLocaleString('vi-VN');
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
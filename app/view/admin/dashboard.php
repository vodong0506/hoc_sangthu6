<?php include __DIR__ . '/../shares/header.php'; ?>

<!-- CSS and Google Fonts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="admin-container">
    <div class="admin-header d-flex justify-content-between align-items-center mb-5 animate-slide-in">
        <div>
            <h1 class="admin-title">⚡ RESTful API Dashboard</h1>
            <p class="admin-subtitle">Quản trị viên quản lý danh mục và sản phẩm thông qua RESTful API bằng AJAX</p>
        </div>
        <div>
            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-outline-dark rounded-pill px-4 hover-lift">
                ← Cửa Hàng
            </a>
        </div>
    </div>

    <!-- Alert Toast Container -->
    <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060;"></div>

    <!-- Thống kê nhanh -->
    <div class="row g-4 mb-5 animate-slide-in-delay-1">
        <div class="col-md-6">
            <div class="stat-card p-4 d-flex align-items-center">
                <div class="stat-icon bg-primary-light text-primary">📦</div>
                <div class="ms-4">
                    <span class="stat-label text-muted d-block text-uppercase">Tổng Sản Phẩm</span>
                    <strong class="stat-value" id="stats-total-products">0</strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card p-4 d-flex align-items-center">
                <div class="stat-icon bg-success-light text-success">📁</div>
                <div class="ms-4">
                    <span class="stat-label text-muted d-block text-uppercase">Tổng Danh Mục</span>
                    <strong class="stat-value" id="stats-total-categories">0</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu tab -->
    <div class="card admin-card border-0 shadow-sm overflow-hidden mb-5 animate-slide-in-delay-2">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs nav-fill border-bottom-0" id="adminTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3 font-outfit fs-5" id="products-tab" data-bs-toggle="tab" data-bs-target="#products-panel" type="button" role="tab" aria-controls="products-panel" aria-selected="true">
                        📦 Quản Lý Sản Phẩm
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 font-outfit fs-5" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-panel" type="button" role="tab" aria-controls="categories-panel" aria-selected="false">
                        📁 Quản Lý Danh Mục
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="adminTabContent">
                <!-- Tab Sản Phẩm -->
                <div class="tab-pane fade show active" id="products-panel" role="tabpanel" aria-labelledby="products-tab">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 mb-4">
                        <div class="search-wrapper">
                            <span class="search-icon">🔍</span>
                            <input type="text" class="search-input" id="searchProductInput" placeholder="Tìm tên sản phẩm..." onkeyup="filterProducts()">
                        </div>
                        <button class="btn btn-primary rounded-pill px-4 hover-lift" onclick="openAddProductModal()">
                            ➕ Thêm Sản Phẩm Mới
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Danh Mục</th>
                                    <th class="text-end">Giá Bán</th>
                                    <th class="text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                        Đang tải dữ liệu sản phẩm...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Danh Mục -->
                <div class="tab-pane fade" id="categories-panel" role="tabpanel" aria-labelledby="categories-tab">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 mb-4">
                        <div class="search-wrapper">
                            <span class="search-icon">🔍</span>
                            <input type="text" class="search-input" id="searchCategoryInput" placeholder="Tìm tên danh mục..." onkeyup="filterCategories()">
                        </div>
                        <button class="btn btn-success rounded-pill px-4 hover-lift" onclick="openAddCategoryModal()">
                            ➕ Thêm Danh Mục Mới
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Danh Mục</th>
                                    <th>Mô Tả</th>
                                    <th class="text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                                        Đang tải dữ liệu danh mục...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- PRODUCT MODAL (Add/Edit) -->
<!-- ========================================== -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-outfit fs-3 fw-bold" id="productModalLabel">Sản Phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productForm" onsubmit="saveProduct(event)">
                <div class="modal-body py-4">
                    <input type="hidden" id="productId" name="id">
                    
                    <!-- Tên -->
                    <div class="mb-3">
                        <label for="productName" class="form-label fw-bold">Tên Sản Phẩm</label>
                        <input type="text" class="form-control rounded-3" id="productName" placeholder="Ví dụ: Vợt Yonex Astrox 99" required>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-product-name"></div>
                    </div>

                    <!-- Danh mục -->
                    <div class="mb-3">
                        <label for="productCategoryId" class="form-label fw-bold">Danh Mục Phân Loại</label>
                        <select class="form-select rounded-3" id="productCategoryId" required>
                            <option value="">-- Chọn danh mục --</option>
                        </select>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-product-category_id"></div>
                    </div>

                    <!-- Giá -->
                    <div class="mb-3">
                        <label for="productPrice" class="form-label fw-bold">Giá Bán (VNĐ)</label>
                        <input type="number" class="form-control rounded-3" id="productPrice" min="0" placeholder="Ví dụ: 2500000" required>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-product-price"></div>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="productDescription" class="form-label fw-bold">Mô Tả Sản Phẩm</label>
                        <textarea class="form-control rounded-3" id="productDescription" rows="3" placeholder="Nhập chi tiết mô tả sản phẩm..." required></textarea>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-product-description"></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSaveProduct">Lưu Lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CATEGORY MODAL (Add/Edit) -->
<!-- ========================================== -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-outfit fs-3 fw-bold" id="categoryModalLabel">Danh Mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" onsubmit="saveCategory(event)">
                <div class="modal-body py-4">
                    <input type="hidden" id="categoryId" name="id">
                    
                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="categoryName" class="form-label fw-bold">Tên Danh Mục</label>
                        <input type="text" class="form-control rounded-3" id="categoryName" placeholder="Ví dụ: Giày Cầu Lông" required>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-category-name"></div>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label fw-bold">Mô Tả</label>
                        <textarea class="form-control rounded-3" id="categoryDescription" rows="3" placeholder="Mô tả tóm tắt danh mục..."></textarea>
                        <div class="error-feedback text-danger fs-7 mt-1 d-none" id="error-category-description"></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4" id="btnSaveCategory">Lưu Lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Premium Style enhancements -->
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #065f46 100%);
        --bg-card: #ffffff;
        --border-color: #f1f5f9;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --shadow-sm: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
        --text-muted: #64748b;
    }

    .admin-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Inter', sans-serif;
    }
    
    .font-outfit {
        font-family: 'Outfit', sans-serif;
    }
    
    .admin-title {
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        color: #0f172a;
        font-size: 2.2rem;
    }
    
    .admin-subtitle {
        color: #64748b;
        font-size: 1rem;
        margin-top: 5px;
    }
    
    .stat-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid rgba(108, 140, 255, 0.1);
        box-shadow: var(--shadow-sm);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        font-size: 24px;
        display: grid;
        place-items: center;
        border-radius: 16px;
    }
    
    .bg-primary-light {
        background-color: rgba(79, 70, 229, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(16, 185, 129, 0.1);
    }
    
    .stat-label {
        font-size: 0.8rem;
        letter-spacing: 0.1em;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 2.2rem;
        color: #0f172a;
        font-family: 'Outfit', sans-serif;
        line-height: 1;
    }
    
    .admin-card {
        border-radius: var(--radius-lg);
        border: 1px solid #e2e8f0;
    }
    
    .nav-tabs .nav-link {
        color: #64748b;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link.active {
        color: #4f46e5;
        border-color: #4f46e5;
        background: transparent;
    }
    
    .nav-tabs .nav-link:hover {
        color: #4f46e5;
        border-color: rgba(79, 70, 229, 0.3);
    }
    
    .table thead {
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    
    .table th {
        padding: 14px;
        color: #475569 !important;
    }
    
    .table td {
        padding: 16px 14px;
    }

    /* Search Input Wrapper */
    .search-wrapper {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 16px 10px 45px;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        outline: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }
    
    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        color: #94a3b8;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Custom Animations */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-in {
        animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-in-delay-1 {
        animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
    }
    .animate-slide-in-delay-2 {
        animation: slideIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
    }
</style>

<script>
    // Config Base URL
    const BASE_API_URL = '<?php echo BASE_URL; ?>/api';
    
    // Globals
    let allProducts = [];
    let allCategories = [];
    
    // Modal Objects
    let productModal;
    let categoryModal;

    document.addEventListener("DOMContentLoaded", function () {
        productModal = new bootstrap.Modal(document.getElementById('productModal'));
        categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
        
        // Initial Fetch
        fetchCategories();
        fetchProducts();
    });

    // ==========================================
    // DATA FETCHING
    // ==========================================

    function fetchProducts() {
        fetch(`${BASE_API_URL}/product`)
            .then(res => res.json())
            .then(data => {
                allProducts = data;
                renderProducts(allProducts);
                document.getElementById('stats-total-products').textContent = allProducts.length;
            })
            .catch(err => {
                showToast("Lỗi khi tải sản phẩm: " + err.message, "danger");
            });
    }

    function fetchCategories() {
        fetch(`${BASE_API_URL}/category`)
            .then(res => res.json())
            .then(data => {
                allCategories = data;
                renderCategories(allCategories);
                populateCategoryDropdown(allCategories);
                document.getElementById('stats-total-categories').textContent = allCategories.length;
            })
            .catch(err => {
                showToast("Lỗi khi tải danh mục: " + err.message, "danger");
            });
    }

    // ==========================================
    // DOM RENDERING
    // ==========================================

    function renderProducts(products) {
        const tbody = document.getElementById('productsTableBody');
        tbody.innerHTML = '';

        if (products.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">Không tìm thấy sản phẩm nào.</td></tr>`;
            return;
        }

        products.forEach(p => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="font-monospace text-muted" style="width: 80px;">#${p.id}</td>
                <td>
                    <h6 class="mb-0 font-outfit fw-bold text-dark">${escapeHtml(p.name)}</h6>
                    <small class="text-muted d-block text-truncate" style="max-width: 380px;" title="${escapeHtml(p.description)}">
                        ${escapeHtml(p.description)}
                    </small>
                </td>
                <td>
                    <span class="badge bg-light text-dark border">${escapeHtml(p.category_name || 'Chưa phân loại')}</span>
                </td>
                <td class="text-end font-monospace fw-bold text-primary">
                    ${formatMoney(p.price)} đ
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-warning" onclick="editProduct(${p.id})">
                            ✏️ Sửa
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(${p.id})">
                            🗑️ Xóa
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderCategories(categories) {
        const tbody = document.getElementById('categoriesTableBody');
        tbody.innerHTML = '';

        if (categories.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">Không tìm thấy danh mục nào.</td></tr>`;
            return;
        }

        categories.forEach(c => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="font-monospace text-muted" style="width: 80px;">#${c.id}</td>
                <td>
                    <h6 class="mb-0 font-outfit fw-bold text-dark">${escapeHtml(c.name)}</h6>
                </td>
                <td class="text-muted text-truncate" style="max-width: 400px;">
                    ${escapeHtml(c.description || 'Không có mô tả')}
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-warning" onclick="editCategory(${c.id})">
                            ✏️ Sửa
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${c.id})">
                            🗑️ Xóa
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function populateCategoryDropdown(categories) {
        const select = document.getElementById('productCategoryId');
        select.innerHTML = '<option value="">-- Chọn danh mục --</option>';
        categories.forEach(c => {
            const option = document.createElement('option');
            option.value = c.id;
            option.textContent = c.name;
            select.appendChild(option);
        });
    }

    // ==========================================
    // FILTER / SEARCH FUNCTIONS
    // ==========================================

    function filterProducts() {
        const query = document.getElementById('searchProductInput').value.toLowerCase().trim();
        const filtered = allProducts.filter(p => 
            p.name.toLowerCase().includes(query) || 
            (p.category_name && p.category_name.toLowerCase().includes(query)) ||
            p.id.toString().includes(query)
        );
        renderProducts(filtered);
    }

    function filterCategories() {
        const query = document.getElementById('searchCategoryInput').value.toLowerCase().trim();
        const filtered = allCategories.filter(c => 
            c.name.toLowerCase().includes(query) || 
            (c.description && c.description.toLowerCase().includes(query)) ||
            c.id.toString().includes(query)
        );
        renderCategories(filtered);
    }

    // ==========================================
    // CRUD PRODUCT
    // ==========================================

    function openAddProductModal() {
        // Clear forms & errors
        document.getElementById('productForm').reset();
        document.getElementById('productId').value = '';
        clearValidationErrors();
        
        document.getElementById('productModalLabel').textContent = '➕ Thêm Sản Phẩm Mới';
        productModal.show();
    }

    function editProduct(id) {
        clearValidationErrors();
        
        // Fetch product info from API
        fetch(`${BASE_API_URL}/product/${id}`)
            .then(res => {
                if(!res.ok) throw new Error("Không lấy được thông tin sản phẩm");
                return res.json();
            })
            .then(p => {
                document.getElementById('productId').value = p.id;
                document.getElementById('productName').value = p.name;
                document.getElementById('productCategoryId').value = p.category_id || '';
                document.getElementById('productPrice').value = p.price;
                document.getElementById('productDescription').value = p.description;
                
                document.getElementById('productModalLabel').textContent = '✏️ Chỉnh Sửa Sản Phẩm';
                productModal.show();
            })
            .catch(err => {
                showToast(err.message, "danger");
            });
    }

    function saveProduct(event) {
        event.preventDefault();
        clearValidationErrors();

        const id = document.getElementById('productId').value;
        const name = document.getElementById('productName').value.trim();
        const category_id = document.getElementById('productCategoryId').value;
        const price = document.getElementById('productPrice').value;
        const description = document.getElementById('productDescription').value.trim();

        const payload = { name, category_id, price, description };

        const isEdit = id && id !== '';
        const url = isEdit ? `${BASE_API_URL}/product/${id}` : `${BASE_API_URL}/product`;
        const method = isEdit ? 'PUT' : 'POST';

        document.getElementById('btnSaveProduct').disabled = true;
        document.getElementById('btnSaveProduct').innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang lưu...`;

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                // validation or other errors
                if (data.errors) {
                    displayValidationErrors('product', data.errors);
                }
                throw new Error(data.message || "Không thể lưu sản phẩm");
            }
            return data;
        })
        .then(res => {
            showToast(res.message, "success");
            productModal.hide();
            fetchProducts();
        })
        .catch(err => {
            showToast(err.message, "danger");
        })
        .finally(() => {
            document.getElementById('btnSaveProduct').disabled = false;
            document.getElementById('btnSaveProduct').textContent = `Lưu Lại`;
        });
    }

    function deleteProduct(id) {
        if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này thông qua API?")) return;

        fetch(`${BASE_API_URL}/product/${id}`, {
            method: 'DELETE'
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || "Lỗi khi xóa sản phẩm");
            return data;
        })
        .then(res => {
            showToast(res.message, "success");
            fetchProducts();
        })
        .catch(err => {
            showToast(err.message, "danger");
        });
    }

    // ==========================================
    // CRUD CATEGORY
    // ==========================================

    function openAddCategoryModal() {
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
        clearValidationErrors();

        document.getElementById('categoryModalLabel').textContent = '➕ Thêm Danh Mục Mới';
        categoryModal.show();
    }

    function editCategory(id) {
        clearValidationErrors();

        fetch(`${BASE_API_URL}/category/${id}`)
            .then(res => {
                if(!res.ok) throw new Error("Không lấy được thông tin danh mục");
                return res.json();
            })
            .then(c => {
                document.getElementById('categoryId').value = c.id;
                document.getElementById('categoryName').value = c.name;
                document.getElementById('categoryDescription').value = c.description || '';

                document.getElementById('categoryModalLabel').textContent = '✏️ Chỉnh Sửa Danh Mục';
                categoryModal.show();
            })
            .catch(err => {
                showToast(err.message, "danger");
            });
    }

    function saveCategory(event) {
        event.preventDefault();
        clearValidationErrors();

        const id = document.getElementById('categoryId').value;
        const name = document.getElementById('categoryName').value.trim();
        const description = document.getElementById('categoryDescription').value.trim();

        const payload = { name, description };

        const isEdit = id && id !== '';
        const url = isEdit ? `${BASE_API_URL}/category/${id}` : `${BASE_API_URL}/category`;
        const method = isEdit ? 'PUT' : 'POST';

        document.getElementById('btnSaveCategory').disabled = true;
        document.getElementById('btnSaveCategory').innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang lưu...`;

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                if (data.errors) {
                    displayValidationErrors('category', data.errors);
                }
                throw new Error(data.message || "Không thể lưu danh mục");
            }
            return data;
        })
        .then(res => {
            showToast(res.message, "success");
            categoryModal.hide();
            fetchCategories();
            fetchProducts(); // Refresh products too, since categories changed
        })
        .catch(err => {
            showToast(err.message, "danger");
        })
        .finally(() => {
            document.getElementById('btnSaveCategory').disabled = false;
            document.getElementById('btnSaveCategory').textContent = `Lưu Lại`;
        });
    }

    function deleteCategory(id) {
        if (!confirm("Bạn có chắc chắn muốn xóa danh mục này? Hãy chắc chắn không còn sản phẩm nào thuộc danh mục này.")) return;

        fetch(`${BASE_API_URL}/category/${id}`, {
            method: 'DELETE'
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || "Lỗi khi xóa danh mục");
            return data;
        })
        .then(res => {
            showToast(res.message, "success");
            fetchCategories();
            fetchProducts(); // Refresh products lists as category labels might change
        })
        .catch(err => {
            showToast(err.message, "danger");
        });
    }

    // ==========================================
    // HELPERS & VALIDATION
    // ==========================================

    function displayValidationErrors(prefix, errors) {
        for (const field in errors) {
            const errorDiv = document.getElementById(`error-${prefix}-${field}`);
            if (errorDiv) {
                errorDiv.textContent = errors[field];
                errorDiv.classList.remove('d-none');
                
                // Add invalid styling class to corresponding input
                const inputId = prefix + field.charAt(0).toUpperCase() + field.slice(1);
                const input = document.getElementById(inputId);
                if (input) input.classList.add('is-invalid');
            }
        }
    }

    function clearValidationErrors() {
        document.querySelectorAll('.error-feedback').forEach(el => {
            el.textContent = '';
            el.classList.add('d-none');
        });
        document.querySelectorAll('.form-control, .form-select').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    function showToast(message, type = "success") {
        const container = document.getElementById('toastContainer');
        const toastId = 'toast_' + Date.now();
        const icon = type === "success" ? "✅" : "⚠️";
        
        const html = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body fs-6 fw-500">
                        ${icon} ${escapeHtml(message)}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        
        const toastEl = document.getElementById(toastId);
        const bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
        bsToast.show();
        
        // Remove from DOM after hidden
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.remove();
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

<?php include __DIR__ . '/../shares/footer.php'; ?>

<?php include __DIR__ . '/../shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="admin-container">
    <div class="admin-header d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="admin-title">🛠️ Trang Quản Trị</h1>
            <p class="admin-subtitle">Quản lý kho sản phẩm và phân loại danh mục cửa hàng</p>
        </div>
        <div>
            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-outline-dark rounded-pill">
                ← Quay lại Cửa Hàng
            </a>
        </div>
    </div>

    <!-- Thông báo thành công/lỗi -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thành công!</strong> <?php echo htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Lỗi!</strong> <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Thống kê nhanh -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="stat-card p-4 d-flex align-items-center">
                <div class="stat-icon bg-primary-light text-primary">📦</div>
                <div class="ms-4">
                    <span class="stat-label text-muted d-block text-uppercase">Tổng Sản Phẩm</span>
                    <strong class="stat-value"><?php echo count($products); ?></strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card p-4 d-flex align-items-center">
                <div class="stat-icon bg-success-light text-success">📁</div>
                <div class="ms-4">
                    <span class="stat-label text-muted d-block text-uppercase">Tổng Danh Mục</span>
                    <strong class="stat-value"><?php echo count($categories); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu tab -->
    <div class="card admin-card border-0 shadow-sm overflow-hidden mb-5">
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-outfit mb-0">Danh Sách Sản Phẩm</h4>
                        <a href="<?php echo BASE_URL; ?>/admin/productCreate" class="btn btn-primary rounded-pill px-4">
                            ➕ Thêm Sản Phẩm Mới
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Danh Mục</th>
                                    <th class="text-end">Giá Bán</th>
                                    <th class="text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $p): ?>
                                        <tr>
                                            <td style="width: 80px;">
                                                <?php if ($p->image): ?>
                                                    <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($p->image); ?>" alt="" class="product-thumb">
                                                <?php else: ?>
                                                    <div class="product-thumb-fallback">📷</div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 font-outfit"><?php echo htmlspecialchars($p->name); ?></h6>
                                                <small class="text-muted d-block text-truncate" style="max-width: 300px;">
                                                    <?php echo htmlspecialchars($p->description); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo htmlspecialchars($p->category_name ?? 'Chưa phân loại'); ?></span>
                                            </td>
                                            <td class="text-end font-monospace fw-bold text-primary">
                                                <?php echo number_format($p->price, 0, ',', '.'); ?> đ
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo BASE_URL; ?>/admin/productEdit/<?php echo $p->id; ?>" class="btn btn-sm btn-outline-warning">
                                                        ✏️ Sửa
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/admin/productDelete/<?php echo $p->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                                        🗑️ Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Chưa có sản phẩm nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Danh Mục -->
                <div class="tab-pane fade" id="categories-panel" role="tabpanel" aria-labelledby="categories-tab">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-outfit mb-0">Danh Sách Danh Mục</h4>
                        <a href="<?php echo BASE_URL; ?>/admin/categoryCreate" class="btn btn-success rounded-pill px-4">
                            ➕ Thêm Danh Mục Mới
                        </a>
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
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $c): ?>
                                        <tr>
                                            <td class="font-monospace text-muted" style="width: 80px;">#<?php echo $c->id; ?></td>
                                            <td>
                                                <h6 class="mb-0 font-outfit"><?php echo htmlspecialchars($c->name); ?></h6>
                                            </td>
                                            <td class="text-muted">
                                                <?php echo htmlspecialchars($c->description ?: 'Không có mô tả'); ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?php echo BASE_URL; ?>/admin/categoryEdit/<?php echo $c->id; ?>" class="btn btn-sm btn-outline-warning">
                                                        ✏️ Sửa
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/admin/categoryDelete/<?php echo $c->id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Hãy chắc chắn không còn sản phẩm nào thuộc danh mục này.');">
                                                        🗑️ Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Chưa có danh mục nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
        border-radius: 20px;
        border: 1px solid rgba(108, 140, 255, 0.1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
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
        background-color: rgba(90, 124, 255, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
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
        border-radius: 20px;
    }
    
    .nav-tabs .nav-link {
        color: #64748b;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link.active {
        color: #0f172a;
        border-color: #5a7cff;
        background: transparent;
    }
    
    .nav-tabs .nav-link:hover {
        color: #0f172a;
        border-color: rgba(90, 124, 255, 0.3);
    }
    
    .product-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .product-thumb-fallback {
        width: 60px;
        height: 60px;
        background: #f1f5f9;
        display: grid;
        place-items: center;
        border-radius: 12px;
        color: #94a3b8;
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
</style>

<?php include __DIR__ . '/../shares/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm - Badminton Store</title>
</head>

<body>
    <?php include_once __DIR__ . '/../shares/header.php'; ?>

    <main class="page">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/product">📦 Danh sách sản phẩm</a>
            <span class="divider">/</span>
            <span class="current">Thêm sản phẩm</span>
        </div>

        <form action="<?php echo BASE_URL; ?>/product/store" method="POST" enctype="multipart/form-data" class="form-card">
            <h1>Thêm Sản Phẩm Mới</h1>
            <p class="form-subtitle">Nhập chi tiết các thông số của sản phẩm</p>

            <?php if (isset($errors) && count($errors) > 0): ?>
                <div class="alert alert-danger" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px; font-weight: 700;">
                        <span>⚠️</span> Vui lòng kiểm tra lại thông tin:
                    </div>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                        <?php foreach ($errors as $field => $message): ?>
                            <li><?php echo htmlspecialchars($message); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Tên sản phẩm -->
            <div class="form-group <?php echo isset($errors['name']) ? 'has-error' : ''; ?>">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm..."
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                <?php if (isset($errors['name'])): ?>
                    <div class="error-feedback"><?php echo htmlspecialchars($errors['name']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Mô tả -->
            <div class="form-group <?php echo isset($errors['description']) ? 'has-error' : ''; ?>">
                <label for="description">Mô Tả Chi Tiết</label>
                <textarea id="description" name="description" class="form-control" placeholder="Mô tả chi tiết sản phẩm..." required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                <?php if (isset($errors['description'])): ?>
                    <div class="error-feedback"><?php echo htmlspecialchars($errors['description']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Giá -->
            <div class="form-group <?php echo isset($errors['price']) ? 'has-error' : ''; ?>">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" id="price" name="price" class="form-control" placeholder="Ví dụ: 1500000" step="1000"
                       value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                <?php if (isset($errors['price'])): ?>
                    <div class="error-feedback"><?php echo htmlspecialchars($errors['price']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Danh mục -->
            <div class="form-group">
                <label for="category_id">Danh Mục</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục sản phẩm --</option>
                    <?php
                    if (isset($categories) && is_array($categories)) {
                        foreach ($categories as $category) {
                            $selected = (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : '';
                            echo '<option value="' . $category->id . '" ' . $selected . '>' . htmlspecialchars($category->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Upload ảnh -->
            <div class="form-group <?php echo isset($errors['image']) ? 'has-error' : ''; ?>">
                <label>Hình Ảnh Sản Phẩm</label>
                <div class="file-upload-container">
                    <span class="file-upload-icon">📸</span>
                    <span class="file-upload-text" id="uploadText">Kéo thả hoặc click để chọn ảnh</span>
                    <span class="file-upload-subtext">Hỗ trợ định dạng JPG, PNG, WEBP</span>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                </div>
                <div id="imagePreviewContainer" style="display: none; align-items: center; gap: 16px; margin-top: 16px;">
                    <div class="image-preview-box">
                        <img id="imagePreview" src="" alt="Preview">
                    </div>
                    <span id="fileName" style="font-size: 13px; color: var(--text-muted); font-weight: 500;"></span>
                </div>
                <?php if (isset($errors['image'])): ?>
                    <div class="error-feedback"><?php echo htmlspecialchars($errors['image']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Nút hành động -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo BASE_URL; ?>/product'">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu Sản Phẩm</button>
            </div>
        </form>
    </main>

    <script>
        function previewImage(input) {
            const fileName = document.getElementById('fileName');
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const uploadText = document.getElementById('uploadText');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                fileName.textContent = file.name;
                uploadText.textContent = 'Đã chọn: ' + file.name;

                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'flex';
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = '';
                imagePreview.src = '';
                previewContainer.style.display = 'none';
                uploadText.textContent = 'Kéo thả hoặc click để chọn ảnh';
            }
        }
    </script>
    <?php include_once __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
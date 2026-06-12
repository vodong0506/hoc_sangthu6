<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sửa Sản Phẩm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.6s ease-out;
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

        h1 {
            color: #0f172a;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message::before {
            content: "⚠";
            font-weight: bold;
        }

        .form-group.has-error input,
        .form-group.has-error textarea,
        .form-group.has-error select {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .current-image {
            margin-top: 10px;
            padding: 10px;
            background: #f1f5f9;
            border-radius: 10px;
            text-align: center;
        }

        .current-image h4 {
            font-size: 12px;
            color: #475569;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .current-image img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }

        .image-preview {
            margin-top: 10px;
            max-width: 150px;
            border-radius: 10px;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }

        button {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .alert-danger {
            background: #fef2f2;
            border: 2px solid #ef4444;
            color: #991b1b;
        }

        .alert-danger ul {
            margin: 10px 0 0 20px;
        }

        .alert-danger li {
            margin: 5px 0;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-input-label {
            display: inline-block;
            padding: 12px 15px;
            background: #f1f5f9;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            color: #3b82f6;
            font-weight: 600;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label:hover {
            background: #e2e8f0;
        }

        .file-name {
            margin-top: 8px;
            font-size: 12px;
            color: #3b82f6;
            font-weight: 500;
        }

        .breadcrumb {
            margin-bottom: 30px;
            font-size: 12px;
        }

        .breadcrumb a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #1d4ed8;
        }

        .breadcrumb span {
            color: #94a3b8;
            margin: 0 5px;
        }

        .hidden-input {
            display: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }

            h1 {
                font-size: 22px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/admin">Danh sách quản trị</a>
            <span>/</span>
            <span>Sửa sản phẩm</span>
        </div>

        <h1>✏️ Sửa Sản Phẩm</h1>
        <p class="subtitle">Cập nhật thông tin chi tiết của sản phẩm</p>

        <?php
        if (isset($errors) && count($errors) > 0) {
            echo '<div class="alert alert-danger">';
            echo '<strong>Có lỗi xảy ra:</strong>';
            echo '<ul>';
            foreach ($errors as $field => $message) {
                echo '<li>' . htmlspecialchars($message) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

        <form action="<?php echo BASE_URL; ?>/admin/productUpdate" method="POST" enctype="multipart/form-data">
            <!-- Hidden ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product->id); ?>" class="hidden-input">

            <!-- Tên sản phẩm -->
            <div class="form-group <?php echo isset($errors['name']) ? 'has-error' : ''; ?>">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên sản phẩm..."
                    value="<?php echo htmlspecialchars($product->name); ?>" required>
                <?php if (isset($errors['name'])) { ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($errors['name']); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Mô tả -->
            <div class="form-group <?php echo isset($errors['description']) ? 'has-error' : ''; ?>">
                <label for="description">Mô Tả</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả sản phẩm..."
                    required><?php echo htmlspecialchars($product->description); ?></textarea>
                <?php if (isset($errors['description'])) { ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($errors['description']); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Giá -->
            <div class="form-group <?php echo isset($errors['price']) ? 'has-error' : ''; ?>">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" id="price" name="price" placeholder="Nhập giá sản phẩm..." step="1000"
                    value="<?php echo htmlspecialchars($product->price); ?>" required>
                <?php if (isset($errors['price'])) { ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($errors['price']); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Danh mục -->
            <div class="form-group">
                <label for="category_id">Danh Mục</label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php
                    if (isset($categories) && is_array($categories)) {
                        foreach ($categories as $category) {
                            $selected = ($product->category_id == $category->id) ? 'selected' : '';
                            echo '<option value="' . $category->id . '" ' . $selected . '>' . htmlspecialchars($category->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Ảnh hiện tại -->
            <?php if ($product->image) { ?>
                <div class="form-group">
                    <div class="current-image">
                        <h4>📷 Ảnh Hiện Tại</h4>
                        <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($product->image); ?>"
                            alt="Current Product Image">
                        <p style="margin-top: 8px; font-size: 12px; color: #64748b;">
                            <?php echo htmlspecialchars($product->image); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>

            <!-- Upload ảnh mới -->
            <div class="form-group <?php echo isset($errors['image']) ? 'has-error' : ''; ?>">
                <label for="image">Thay Đổi Hình Ảnh (Tùy Chọn)</label>
                <p style="font-size: 12px; color: #94a3b8; margin-bottom: 10px;">Bỏ trống nếu không muốn thay đổi ảnh</p>
                <div class="file-input-wrapper">
                    <label for="image" class="file-input-label">
                        📸 Chọn ảnh mới từ máy tính
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                </div>
                <div id="fileName" class="file-name"></div>
                <div id="imagePreview"></div>
                <?php if (isset($errors['image'])) { ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($errors['image']); ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Nút hành động -->
            <div class="button-group">
                <button type="submit" class="btn-submit">💾 Cập Nhật</button>
                <button type="button" class="btn-cancel"
                    onclick="window.location.href='<?php echo BASE_URL; ?>/admin'">Hủy</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const fileName = document.getElementById('fileName');
            const imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                fileName.textContent = '📁 ' + file.name;

                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width: 150px; margin-top: 10px; border-radius: 8px;">';
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = '';
                imagePreview.innerHTML = '';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Xóa thông báo lỗi cũ
                const oldAlert = document.querySelector('.alert-danger');
                if (oldAlert) oldAlert.remove();
                
                const id = document.querySelector('input[name="id"]').value;
                const payload = {
                    name: document.getElementById('name').value.trim(),
                    description: document.getElementById('description').value.trim(),
                    price: document.getElementById('price').value,
                    category_id: document.getElementById('category_id').value
                };
                
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.textContent = 'Đang cập nhật API...';

                fetch('<?php echo BASE_URL; ?>/api/product/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        let errorMsg = data.message || "Lỗi khi cập nhật sản phẩm.";
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).join('<br>');
                        }
                        throw new Error(errorMsg);
                    }
                    return data;
                })
                .then(data => {
                    // Thành công, chuyển hướng về dashboard
                    window.location.href = '<?php echo BASE_URL; ?>/admin';
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.textContent = '💾 Cập Nhật';
                    
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.innerHTML = `<strong>Lỗi gọi API:</strong><br>${err.message}`;
                    form.parentNode.insertBefore(alertDiv, form);
                    window.scrollTo(0, 0);
                });
            });
        });
    </script>
    <?php include __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>

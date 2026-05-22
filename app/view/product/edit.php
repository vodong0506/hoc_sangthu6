<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
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
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        .subtitle {
            text-align: center;
            color: #999;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease-out 0.4s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 25px;
            animation: slideIn 0.6s ease-out backwards;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.5s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.6s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.7s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        label {
            display: block;
            color: #333;
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
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: shake 0.3s ease-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .error-message::before {
            content: "⚠";
            font-weight: bold;
        }

        .form-group.has-error input,
        .form-group.has-error textarea,
        .form-group.has-error select {
            border-color: #e74c3c;
            background: #ffe6e6;
        }

        .current-image {
            margin-top: 10px;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 10px;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
        }

        .current-image h4 {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .current-image img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .image-preview {
            margin-top: 10px;
            max-width: 150px;
            border-radius: 10px;
            overflow: hidden;
            animation: fadeIn 0.4s ease-out;
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
            animation: slideUp 0.6s ease-out 0.9s both;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #333;
        }

        .btn-cancel:hover {
            background: #d0d0d0;
            transform: translateY(-3px);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
            box-shadow: 0 10px 20px rgba(231, 76, 60, 0.3);
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(231, 76, 60, 0.4);
        }

        .alert {
            padding: 15px;
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
            background: #f0f0f0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            color: #667eea;
            font-weight: 600;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label:hover {
            background: #e0e0e0;
            color: #764ba2;
        }

        .file-name {
            margin-top: 8px;
            font-size: 12px;
            color: #667eea;
            font-weight: 500;
        }

        .breadcrumb {
            margin-bottom: 30px;
            font-size: 12px;
            animation: fadeIn 0.8s ease-out;
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #764ba2;
        }

        .breadcrumb span {
            color: #999;
            margin: 0 5px;
        }

        .button-group.full-width {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .button-group.full-width button {
            flex: 1;
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
    <div class="container">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/product">Danh sách sản phẩm</a>
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

        <form action="<?php echo BASE_URL; ?>/product/update" method="POST" enctype="multipart/form-data">
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
                        <p style="margin-top: 8px; font-size: 12px; color: #666;">
                            <?php echo htmlspecialchars($product->image); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>

            <!-- Upload ảnh mới -->
            <div class="form-group <?php echo isset($errors['image']) ? 'has-error' : ''; ?>">
                <label for="image">Thay Đổi Hình Ảnh (Tùy Chọn)</label>
                <p style="font-size: 12px; color: #999; margin-bottom: 10px;">Bỏ trống nếu không muốn thay đổi ảnh</p>
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
            <div class="button-group full-width">
                <button type="submit" class="btn-submit">💾 Cập Nhật</button>
                <button type="button" class="btn-cancel"
                    onclick="window.location.href='<?php echo BASE_URL; ?>/product'">Hủy</button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const fileName = document.getElementById('fileName');
            const imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Hiển thị tên file
                fileName.textContent = '📁 ' + file.name;

                // Hiển thị preview ảnh
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = '';
                imagePreview.innerHTML = '';
            }
        }

        // Validate form trước khi submit
        document.querySelector('form').addEventListener('submit', function (e) {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            const price = document.getElementById('price').value.trim();
            const categoryId = document.getElementById('category_id').value.trim();

            if (!name || !description || !price || !categoryId) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin');
                return false;
            }

            if (isNaN(price) || price <= 0) {
                e.preventDefault();
                alert('Giá phải là số dương');
                return false;
            }
        });
    </script>
</body>

</html>
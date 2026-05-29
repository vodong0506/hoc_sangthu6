<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Thêm Danh Mục</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #2c3e50;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .card {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 36px;
        }

        h1 {
            margin-bottom: 12px;
            font-size: 28px;
            color: #0f172a;
        }

        p {
            color: #64748b;
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #334155;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        input:focus,
        textarea:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .button-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            border: none;
            border-radius: 14px;
            padding: 14px 18px;
            cursor: pointer;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            text-align: center;
            flex: 1;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .errors {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 14px;
            background: #fef2f2;
            border: 2px solid #ef4444;
            color: #991b1b;
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
    </style>
</head>

<body>
    <div class="card">
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>/admin">Danh sách quản trị</a>
            <span>/</span>
            <span>Thêm danh mục</span>
        </div>

        <h1>📁 Thêm Danh Mục Mới</h1>
        <p>Điền tên và mô tả để tạo danh mục phân loại mới.</p>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/admin/categoryStore" method="POST">
            <label for="name">Tên danh mục</label>
            <input type="text" id="name" name="name" placeholder="Ví dụ: Vợt Cầu Lông, Giày Cầu Lông..."
                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>

            <label for="description">Mô tả</label>
            <textarea id="description" name="description" placeholder="Mô tả sơ lược về danh mục này..."
                rows="5"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

            <div class="button-row">
                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</body>

</html>

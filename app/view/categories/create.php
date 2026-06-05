<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            padding: 36px;
        }

        h1 {
            margin-bottom: 12px;
            font-size: 28px;
        }

        p {
            color: #616b7a;
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input,
        textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #dfe3ec;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.25s ease;
        }

        input:focus,
        textarea:focus {
            border-color: #667eea;
        }

        .button-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 14px;
            padding: 14px 18px;
            cursor: pointer;
            font-weight: 700;
            color: white;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-primary {
            background: #667eea;
            box-shadow: 0 14px 30px rgba(102, 126, 234, 0.22);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #d6d8f0;
            color: #2c3e50;
        }

        .errors {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 14px;
            background: #ffe3e3;
            color: #932929;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>
    <div class="card">
        <h1>Thêm Danh Mục</h1>
        <p>Điền tên và mô tả để tạo danh mục mới.</p>

        <?php if (isset($errors) && count($errors) > 0): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo BASE_URL; ?>/category/store" method="POST">
            <label for="name">Tên danh mục</label>
            <input type="text" id="name" name="name"
                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>

            <label for="description">Mô tả</label>
            <textarea id="description" name="description"
                rows="5"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>

            <div class="button-row">
                <button type="submit" class="btn btn-primary">Lưu danh mục</button>
                <a href="<?php echo BASE_URL; ?>/category" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
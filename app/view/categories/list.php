<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Danh Mục</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7ff;
            color: #333;
        }

        .page-wrapper {
            max-width: 1080px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header-box h1 {
            font-size: 28px;
            color: #222;
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 22px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 999px;
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.25);
            transition: all 0.25s ease;
        }

        .btn-create:hover {
            transform: translateY(-2px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            padding: 18px 20px;
            text-align: left;
            border-bottom: 1px solid #f0f2ff;
        }

        th {
            background: #f4f7ff;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .actions a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-right: 14px;
        }

        .actions a.delete {
            color: #e74c3c;
        }

        .no-data {
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>
    <div class="page-wrapper">
        <div class="header-box">
            <h1>Danh Sách Danh Mục</h1>
            <a href="<?php echo BASE_URL; ?>/category/create" class="btn-create">➕ Thêm danh mục</a>
        </div>

        <?php if (isset($categories) && count($categories) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category->id; ?></td>
                            <td><?php echo htmlspecialchars($category->name); ?></td>
                            <td><?php echo htmlspecialchars($category->description); ?></td>
                            <td class="actions">
                                <a href="<?php echo BASE_URL; ?>/category/edit?id=<?php echo $category->id; ?>">Sửa</a>
                                <a href="<?php echo BASE_URL; ?>/category/delete?id=<?php echo $category->id; ?>"
                                    class="delete">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <h2>Chưa có danh mục nào</h2>
                <p>Nhấn nút Thêm danh mục để tạo danh mục đầu tiên.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . '/../shares/footer.php'; ?>
</body>

</html>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Badminton Store</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #eef2ff;
            color: #2b2d42;
        }

        .page {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 34px;
            box-shadow: 0 22px 55px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 16px;
            font-size: 36px;
        }

        p {
            margin-bottom: 24px;
            color: #505050;
            line-height: 1.8;
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
            border: 1px solid #d9e0f0;
            border-radius: 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        input:focus,
        textarea:focus {
            border-color: #667eea;
            outline: none;
        }

        button {
            padding: 14px 24px;
            border: none;
            border-radius: 16px;
            background: #667eea;
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.2);
        }

        .alert {
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 24px;
            background: #def7e3;
            color: #1f5d2b;
        }

        .error {
            background: #ffe3e1;
            color: #a93d38;
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/shares/header.php'; ?>
    <main class="page">
        <div class="card">
            <h1>Liên Hệ</h1>
            <p>Hãy gửi thông tin liên hệ, chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['errors'])): ?>
                <div class="alert error">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>/default/sendContact" method="POST">
                <label for="name">Tên của bạn</label>
                <input id="name" name="name" type="text" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" required>

                <label for="subject">Chủ đề</label>
                <input id="subject" name="subject" type="text" required>

                <label for="message">Nội dung</label>
                <textarea id="message" name="message" rows="7" required></textarea>

                <button type="submit">Gửi liên hệ</button>
            </form>
        </div>
    </main>
    <?php require_once __DIR__ . '/shares/footer.php'; ?>
</body>

</html>
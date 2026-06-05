<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Badminton Store</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7ff;
            color: #222;
        }

        .page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 20px;
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: center;
            margin-top: 40px;
        }

        .hero-text h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 18px;
            line-height: 1.8;
            color: #555;
        }

        .hero-actions {
            margin-top: 30px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 24px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f0f3ff;
            color: #334e7a;
        }

        .stats {
            margin-top: 60px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 22px 50px rgba(50, 55, 87, 0.08);
        }

        .stat-number {
            font-size: 42px;
            font-weight: 700;
            color: #667eea;
        }

        .stat-label {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . '/shares/header.php'; ?>
    <main class="page">
        <section class="hero">
            <div class="hero-text">
                <h1>Badminton Store - Thiết bị cầu lông chuyên nghiệp</h1>
                <p>Khám phá vợt, giày, quần áo cầu lông chất lượng cao cùng dịch vụ nhanh chóng, đáng tin cậy.</p>
                <div class="hero-actions">
                    <a href="<?php echo BASE_URL; ?>/product" class="btn-primary">Xem sản phẩm</a>
                </div>
            </div>
            <div>
                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=900&q=80"
                    alt="Badminton" style="width: 100%; border-radius: 24px; box-shadow: 0 25px 60px rgba(0,0,0,0.12);">
            </div>
        </section>

        <section class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo isset($products) ? count($products) : 0; ?></div>
                <div class="stat-label">Tổng sản phẩm</div>
            </div>
        </section>
    </main>
    <?php require_once __DIR__ . '/shares/footer.php'; ?>
</body>

</html>
<?php if (!defined('BASE_URL')) {
    define('BASE_URL', '/lab03');
} ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Badminton Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>
    <?php include __DIR__ . '/../shares/header.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">🛒 Giỏ Hàng</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (!empty($cart)): ?>
            <div class="table-responsive mb-4">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th style="text-align: right;">Đơn Giá</th>
                            <th style="text-align: center;">Số Lượng</th>
                            <th style="text-align: right;">Tổng Tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grand_total = 0;
                        foreach ($cart as $product_id => $item):
                            $item_total = $item['price'] * $item['quantity'];
                            $grand_total += $item_total;
                            ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <?php if ($item['image']): ?>
                                            <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($item['image']); ?>"
                                                alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                style="max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 8px;">
                                        <?php else: ?>
                                            <div
                                                style="width: 80px; height: 80px; background: #e9ecef; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #999;">
                                                📷
                                            </div>
                                        <?php endif; ?>
                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <strong><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</strong>
                                </td>
                                <td style="text-align: center;">
                                    <form action="<?php echo BASE_URL; ?>/product/updateCart" method="POST"
                                        style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="decreaseQty(this)">−</button>
                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>"
                                                min="1" style="width: 60px; text-align: center;" readonly>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                onclick="increaseQty(this)">+</button>
                                        </div>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <strong><?php echo number_format($item_total, 0, ',', '.'); ?> đ</strong>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo BASE_URL; ?>/product/removeFromCart/<?php echo $product_id; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <a href="<?php echo BASE_URL; ?>/product" class="btn btn-secondary">← Tiếp tục mua sắm</a>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tóm tắt đơn hàng</h5>
                            <hr>
                            <p style="display: flex; justify-content: space-between;">
                                <span>Tổng cộng:</span>
                                <strong style="font-size: 1.25rem; color: #007bff;">
                                    <?php echo number_format($grand_total, 0, ',', '.'); ?> đ
                                </strong>
                            </p>
                            <a href="<?php echo BASE_URL; ?>/product/checkout" class="btn btn-primary w-100">Tiến hành thanh
                                toán →</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading">📭 Giỏ hàng trống</h4>
                <p>Chưa có sản phẩm nào trong giỏ hàng của bạn.</p>
                <hr>
                <a href="<?php echo BASE_URL; ?>/product" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../shares/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQty(btn) {
            const input = btn.parentElement.querySelector('input');
            input.value = parseInt(input.value) + 1;
            input.form.submit();
        }

        function decreaseQty(btn) {
            const input = btn.parentElement.querySelector('input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                input.form.submit();
            }
        }
    </script>
</body>

</html>
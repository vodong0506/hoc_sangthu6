<?php include __DIR__ . '/../shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <h1 class="mb-4">🛒 Giỏ Hàng</h1>

    <?php if (!empty($cart)): ?>
        <ul class="list-group mb-4">
            <?php
            $grand_total = 0;
            foreach ($cart as $id => $item):
                $item_total = $item['price'] * $item['quantity'];
                $grand_total += $item_total;
                ?>
                <li class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-1">
                            <?php if ($item['image']): ?>
                                <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                                    style="max-width: 80px; object-fit: cover; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                        </div>
                        <div class="col-md-2">
                            <p>Giá: <strong><?php echo number_format($item['price'], 0, ',', '.'); ?></strong> đ</p>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-sm" style="width: 140px;">
                                <form action="<?php echo BASE_URL; ?>/product/updateCart" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="decrementQty(this)">−</button>
                                    <input type="number" name="quantity"
                                        value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1"
                                        style="width: 60px; text-align: center; border: 1px solid #ddd;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="incrementQty(this)">+</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <p><strong><?php echo number_format($item_total, 0, ',', '.'); ?></strong> đ</p>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo BASE_URL; ?>/product/removeFromCart/<?php echo $id; ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="row">
            <div class="col-md-8">
                <a href="<?php echo BASE_URL; ?>/product/list" class="btn btn-secondary">← Tiếp tục mua sắm</a>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tóm tắt đơn hàng</h5>
                        <hr>
                        <h3 class="text-primary text-center"><?php echo number_format($grand_total, 0, ',', '.'); ?> đ</h3>
                        <a href="<?php echo BASE_URL; ?>/product/checkout" class="btn btn-primary w-100 mt-3">Tiến hành
                            thanh toán →</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p><strong>Giỏ hàng của bạn đang trống.</strong></p>
            <a href="<?php echo BASE_URL; ?>/product/list" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function incrementQty(btn) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        input.value = parseInt(input.value) + 1;
        btn.parentElement.closest('form').submit();
    }

    function decrementQty(btn) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            btn.parentElement.closest('form').submit();
        }
    }
</script>
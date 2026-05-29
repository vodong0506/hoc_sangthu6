<?php include __DIR__ . '/../shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <h1 class="mb-4">Giỏ hàng</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

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
                        <div class="col-md-2">
                            <?php if ($item['image']): ?>
                                <img src="<?php echo BASE_URL; ?>/common/access/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="Product Image" style="max-width: 100px; object-fit: cover; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p class="text-muted mb-0">Giá: <strong><?php echo number_format($item['price'], 0, ',', '.'); ?>
                                     VND</strong></p>
                        </div>
                        <div class="col-md-3">
                            <form action="<?php echo BASE_URL; ?>/product/updateCart" method="POST" class="d-flex align-items-center">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty(this)">−</button>
                                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control text-center" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQty(this)">+</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <p class="mb-0"><strong><?php echo number_format($item_total, 0, ',', '.'); ?> VND</strong></p>
                        </div>
                        <div class="col-md-1 text-end">
                            <a href="<?php echo BASE_URL; ?>/product/removeFromCart/<?php echo $id; ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="row">
            <div class="col-md-8">
                <a href="<?php echo BASE_URL; ?>/product/list" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tóm tắt</h5>
                        <h3 class="text-primary"><?php echo number_format($grand_total, 0, ',', '.'); ?> VND</h3>
                        <a href="<?php echo BASE_URL; ?>/product/checkout" class="btn btn-primary mt-2 w-100">Thanh Toán</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="<?php echo BASE_URL; ?>/product/list" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function increaseQty(btn) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        input.value = parseInt(input.value) + 1;
        input.form.submit();
    }

    function decreaseQty(btn) {
        const input = btn.parentElement.querySelector('input[name="quantity"]');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            input.form.submit();
        }
    }
</script>
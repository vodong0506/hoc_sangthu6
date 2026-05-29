<?php include 'app/views/shares/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

<div class="container mt-5">
    <h1 class="mb-4">Giỏ hàng</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="list-group">
            <?php
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $id => $item):
                $item_total = $item['price'] * $item['quantity'];
                $grand_total += $item_total;
                ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2">
                            <?php if ($item['image']): ?>
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image"
                                    style="max-width: 100px; object-fit: cover; border-radius: 8px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p class="text-muted">Giá: <?php echo number_format($item['price'], 0, ',', '.'); ?> đ</p>
                        </div>
                        <div class="col-md-3">
                            <form action="<?php echo BASE_URL; ?>/product/updateCart" method="POST"
                                style="display: flex; gap: 0.5rem;">
                                <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="document.querySelector('[name=quantity]').value = Math.max(1, parseInt(document.querySelector('[name=quantity]').value) - 1); this.form.submit();">−</button>
                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>"
                                    min="1" style="width: 60px; text-align: center;">
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="document.querySelector('[name=quantity]').value = parseInt(document.querySelector('[name=quantity]').value) + 1; this.form.submit();">+</button>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <p>
                                <strong><?php echo number_format($item_total, 0, ',', '.'); ?> đ</strong>
                            </p>
                        </div>
                        <div class="col-md-1">
                            <a href="<?php echo BASE_URL; ?>/product/removeFromCart/<?php echo $id; ?>"
                                class="btn btn-sm btn-danger">Xóa</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="row mt-4">
            <div class="col-md-8">
                <a href="<?php echo BASE_URL; ?>/product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng cộng</h5>
                        <h3 class="text-primary"><?php echo number_format($grand_total, 0, ',', '.'); ?> đ</h3>
                        <a href="<?php echo BASE_URL; ?>/product/checkout" class="btn btn-primary mt-2 w-100">Thanh Toán</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="<?php echo BASE_URL; ?>/product" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
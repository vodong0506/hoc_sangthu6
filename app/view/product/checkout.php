<?php include __DIR__ . '/../shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <h1 class="mb-4">Thanh toán</h1>

    <div class="row">
        <!-- Form nhập thông tin -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Thông tin giao hàng</h5>

                    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <p class="mb-1">• <?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['errors']); ?>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo BASE_URL; ?>/product/processCheckout">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Họ tên:</label>
                            <input type="text" id="name" name="name" class="form-control" required
                                value="<?php echo isset($_SESSION['checkout_data']['name']) ? htmlspecialchars($_SESSION['checkout_data']['name']) : ''; ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="text" id="phone" name="phone" class="form-control" required
                                value="<?php echo isset($_SESSION['checkout_data']['phone']) ? htmlspecialchars($_SESSION['checkout_data']['phone']) : ''; ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <textarea id="address" name="address" class="form-control" required
                                rows="4"><?php echo isset($_SESSION['checkout_data']['address']) ? htmlspecialchars($_SESSION['checkout_data']['address']) : ''; ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-2">Thanh toán</button>
                        <a href="<?php echo BASE_URL; ?>/product/cart" class="btn btn-secondary w-100 mt-2">Quay lại giỏ
                            hàng</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tóm tắt đơn hàng</h5>

                    <?php if (!empty($cart)): ?>
                        <ul class="list-group list-group-flush mb-3">
                            <?php
                            $grand_total = 0;
                            foreach ($cart as $id => $item):
                                $item_total = $item['price'] * $item['quantity'];
                                $grand_total += $item_total;
                                ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <?php echo htmlspecialchars($item['name']); ?> <br>
                                        <small class="text-muted">x<?php echo htmlspecialchars($item['quantity']); ?></small>
                                    </span>
                                    <strong><?php echo number_format($item_total, 0, ',', '.'); ?> VND</strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="border-top pt-3">
                            <p class="d-flex justify-content-between mb-0">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-primary" style="font-size: 1.25rem;">
                                    <?php echo number_format($grand_total, 0, ',', '.'); ?> VND
                                </strong>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Giỏ hàng trống. <a href="<?php echo BASE_URL; ?>/product/list">Quay lại mua sắm</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
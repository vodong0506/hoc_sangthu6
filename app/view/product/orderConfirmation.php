<?php include __DIR__ . '/../shares/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Thành công banner -->
            <div class="alert alert-success" role="alert">
                <h1 class="alert-heading">✅ Xác nhận đơn hàng</h1>
                <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
            </div>

            <?php if (isset($order)): ?>
                <!-- Thông tin đơn hàng -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Mã đơn hàng:</strong> <span
                                        class="text-primary">#<?php echo str_pad($order->id, 6, '0', STR_PAD_LEFT); ?></span>
                                </p>
                                <p><strong>Ngày đặt:</strong>
                                    <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                                <p><strong>Trạng thái:</strong> <span class="badge bg-info">Đang xử lý</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tên:</strong> <?php echo htmlspecialchars($order->name); ?></p>
                                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->phone); ?></p>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order->address); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết sản phẩm -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Chi tiết đơn hàng</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($order_details) && !empty($order_details)):
                                    $total = 0;
                                    foreach ($order_details as $detail):
                                        $item_total = $detail->price * $detail->quantity;
                                        $total += $item_total;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($detail->product_name ?? ('Sản phẩm #' . $detail->product_id)); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($detail->quantity); ?></td>
                                            <td><?php echo number_format($detail->price, 0, ',', '.'); ?> VND</td>
                                            <td><strong><?php echo number_format($item_total, 0, ',', '.'); ?> VND</strong></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Tổng cộng:</th>
                                    <th><strong class="text-primary"><?php echo number_format($total ?? 0, 0, ',', '.'); ?>
                                            VND</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Thông báo -->
                <div class="alert alert-info mb-4">
                    <strong>📞 Thông tin liên hệ:</strong>
                    <p class="mb-0">Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận và giao hàng.</p>
                </div>
            <?php endif; ?>

            <!-- Nút hành động -->
            <div class="d-grid gap-2 d-sm-flex justify-content-center">
                <a href="<?php echo BASE_URL; ?>/product/list" class="btn btn-primary">Tiếp tục mua sắm</a>
                <a href="<?php echo BASE_URL; ?>/home" class="btn btn-secondary">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
// Register view
include_once __DIR__ . '/../shares/header.php';
?>

<main class="page">
    <form method="post" action="<?php echo BASE_URL; ?>/account/save" class="form-card">
        <h1>Đăng ký tài khoản</h1>
        <p class="form-subtitle">Tạo tài khoản để tham gia mua sắm tại Badminton Store</p>

        <?php if (!empty($errors) && is_array($errors)): ?>
            <div class="alert alert-danger" style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700;">
                    <span>⚠️</span> Vui lòng kiểm tra lại thông tin:
                </div>
                <ul style="margin: 0; padding-left: 20px; font-size: 13px;">
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Nhập tên đăng nhập..." value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required />
        </div>

        <div class="form-group">
            <label for="fullname">Họ và tên</label>
            <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Nhập họ và tên đầy đủ..." value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>" required />
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required />
        </div>

        <div class="form-group">
            <label for="confirmpassword">Xác nhận mật khẩu</label>
            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Nhập lại mật khẩu..." required />
        </div>

        <input type="hidden" name="role" value="user" />

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </div>
        
        <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
            Đã có tài khoản? <a href="<?php echo BASE_URL; ?>/account/login" style="color: var(--color-primary); font-weight: 700; text-decoration: underline;">Đăng nhập ngay</a>
        </p>
    </form>
</main>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>
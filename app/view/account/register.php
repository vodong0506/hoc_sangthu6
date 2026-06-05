<?php
// Register view
include_once __DIR__ . '/../shares/header.php';
?>
<main class="container">
    <h2>Đăng ký tài khoản</h2>

    <?php if (!empty($errors) && is_array($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/webbanhang/account/save" class="form-card">
        <div class="form-row">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                required />
        </div>

        <div class="form-row">
            <label>Họ và tên</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>"
                required />
        </div>

        <div class="form-row">
            <label>Mật khẩu</label>
            <input type="password" name="password" required />
        </div>

        <div class="form-row">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="confirmpassword" required />
        </div>

        <input type="hidden" name="role" value="user" />

        <div class="form-actions">
            <button type="submit" class="btn">Đăng ký</button>
            <a class="btn btn-link" href="/webbanhang/account/login">Đã có tài khoản? Đăng nhập</a>
        </div>
    </form>
</main>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>
<?php
// Login view
include_once __DIR__ . '/../shares/header.php';
?>
<main class="container">
    <h2>Đăng nhập</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="/webbanhang/account/checkLogin" class="form-card">
        <div class="form-row">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                required />
        </div>

        <div class="form-row">
            <label>Mật khẩu</label>
            <input type="password" name="password" required />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Đăng nhập</button>
            <a class="btn btn-link" href="/webbanhang/account/register">Tạo tài khoản mới</a>
        </div>
    </form>
</main>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>
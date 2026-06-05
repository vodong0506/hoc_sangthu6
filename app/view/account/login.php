<?php
// Login view
include_once __DIR__ . '/../shares/header.php';
?>

<main class="page">
    <form method="post" action="<?php echo BASE_URL; ?>/account/checkLogin" class="form-card">
        <h1>Đăng nhập</h1>
        <p class="form-subtitle">Đăng nhập để tiếp tục mua sắm tại Badminton Store</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <span>⚠️</span> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Nhập tên đăng nhập của bạn..." value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required />
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu..." required />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>
        
        <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted);">
            Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>/account/register" style="color: var(--color-primary); font-weight: 700; text-decoration: underline;">Đăng ký ngay</a>
        </p>
    </form>
</main>

<?php include_once __DIR__ . '/../shares/footer.php'; ?>
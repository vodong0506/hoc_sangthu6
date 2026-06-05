<?php if (!defined('BASE_URL')) {
    define('BASE_URL', '/lab03');
} ?>
<!-- Link global stylesheet -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">

<header class="site-header">
    <div class="header-inner">
        <a href="<?php echo BASE_URL ?: '/'; ?>" class="brand">
            <span class="brand-mark">🏸</span>
            <div>
                <div class="brand-title">Badminton Store</div>
                <div class="brand-subtitle">Thiết bị cầu lông chuyên nghiệp</div>
            </div>
        </a>

        <nav class="site-nav">
            <a href="<?php echo BASE_URL; ?>/">Trang Chủ</a>
            <a href="<?php echo BASE_URL; ?>/product">Sản Phẩm</a>
            <?php if (SessionHelper::isAdmin()): ?>
                <a href="<?php echo BASE_URL; ?>/admin">Quản Trị</a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>/default/about">Giới Thiệu</a>
            <a href="<?php echo BASE_URL; ?>/default/contact">Liên Hệ</a>
        </nav>

        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/product/cart" class="btn btn-accent">
                🛒 Giỏ Hàng
                <?php
                $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
                if ($cart_count > 0) {
                    echo '<span class="cart-badge">' . $cart_count . '</span>';
                }
                ?>
            </a>

            <div class="auth-links">
                <?php if (SessionHelper::isLoggedIn()): ?>
                    <div class="user-profile-wrapper">
                        <button class="btn btn-profile" id="userProfileBtn">
                            <span class="avatar-circle"><?php echo strtoupper(substr(htmlspecialchars(SessionHelper::getUsername()), 0, 1)); ?></span>
                            <span class="username-text"><?php echo htmlspecialchars(SessionHelper::getUsername()); ?></span>
                            <span class="chevron-icon">▼</span>
                        </button>
                        <div class="profile-dropdown" id="profileDropdown">
                            <a href="<?php echo BASE_URL; ?>/account/logout" class="dropdown-item">
                                <span class="dropdown-icon">🚪</span> Đăng xuất
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>/account/login" class="btn btn-login">Đăng nhập</a>
                    <a href="<?php echo BASE_URL; ?>/account/register" class="btn btn-link btn-register">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<style>
    .site-header {
        position: sticky;
        top: 0;
        z-index: 100;
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.05);
        border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        animation: headerFadeIn 0.8s ease-out;
    }

    .header-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 16px 20px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
    }

    .brand-mark {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #84cc16;
        /* Lime neon color */
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15);
        animation: popIn 0.6s ease-out;
    }

    .brand-title {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .brand-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        color: #64748b;
        letter-spacing: 0.3px;
        margin-top: 2px;
    }

    .site-nav {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .site-nav a {
        font-family: 'Outfit', sans-serif;
        color: #475569;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.25s ease;
        position: relative;
        padding: 4px 0;
    }

    .site-nav a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #84cc16;
        transition: all 0.25s ease;
    }

    .site-nav a:hover {
        color: #0f172a;
    }

    .site-nav a:hover::after {
        width: 100%;
    }

    .header-actions {
        display: flex;
        align-items: center;
    }

    @keyframes headerFadeIn {
        from {
            opacity: 0;
            transform: translateY(-14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes popIn {
        from {
            opacity: 0;
            transform: scale(0.7);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @media (max-width: 900px) {
        .header-inner {
            flex-direction: column;
            align-items: stretch;
            padding: 12px 16px;
            gap: 16px;
        }

        .site-nav {
            justify-content: center;
            gap: 16px;
        }
    }

    @media (max-width: 640px) {
        .brand-title {
            font-size: 16px;
        }

        .site-nav {
            gap: 12px;
        }

        .site-nav a {
            font-size: 13px;
        }
    }

    .cart-badge {
        background-color: #ef4444;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 6px;
        display: inline-block;
        line-height: 1;
        min-width: 18px;
        text-align: center;
    }

    /* --- PROFILE BUTTON & DROPDOWN --- */
    .user-profile-wrapper {
        position: relative;
        display: inline-block;
    }

    .btn-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 14px 6px 6px;
        background: rgba(15, 23, 42, 0.04);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 9999px;
        color: var(--color-primary);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Outfit', sans-serif;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-profile:hover {
        background: rgba(15, 23, 42, 0.08);
        border-color: rgba(15, 23, 42, 0.15);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary) 0%, #1e293b 100%);
        color: var(--color-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
    }

    .username-text {
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chevron-icon {
        font-size: 9px;
        color: #64748b;
        transition: transform 0.3s ease;
    }

    .user-profile-wrapper:hover .chevron-icon {
        transform: rotate(180deg);
    }

    .profile-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 160px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        padding: 6px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .user-profile-wrapper:hover .profile-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        font-size: 13px;
        font-weight: 500;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: #f1f5f9;
        color: var(--color-danger);
    }

    .dropdown-icon {
        font-size: 14px;
    }

    .btn-login {
        background-color: var(--color-primary);
        color: var(--text-white) !important;
        padding: 10px 20px;
        border-radius: 9999px;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    .btn-login:hover {
        background-color: var(--color-primary-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-register {
        color: #475569 !important;
        font-weight: 600;
        padding: 10px 16px;
    }

    .btn-register:hover {
        color: var(--color-accent-dark) !important;
    }
</style>
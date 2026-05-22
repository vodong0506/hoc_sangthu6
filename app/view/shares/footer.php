<?php if (!defined('BASE_URL')) {
    define('BASE_URL', '');
} ?>
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="footer-logo">🏸</span>
            <div>
                <p class="footer-title">Badminton Store</p>
                <p class="footer-text">Chuyên cung cấp thiết bị cầu lông chất lượng cao</p>
            </div>
        </div>

        <div class="footer-links">
            <div>
                <p class="footer-heading">Trang</p>
                <a href="<?php echo BASE_URL; ?>/">Trang Chủ</a>
                <a href="<?php echo BASE_URL; ?>/product">Sản Phẩm</a>
                <a href="<?php echo BASE_URL; ?>/category">Danh Mục</a>
            </div>
            <div>
                <p class="footer-heading">Hỗ Trợ</p>
                <a href="<?php echo BASE_URL; ?>/default/about">Giới Thiệu</a>
                <a href="<?php echo BASE_URL; ?>/default/contact">Liên Hệ</a>
            </div>
        </div>

        <div class="footer-contact">
            <p class="footer-heading">Liên Hệ</p>
            <p>Email: support@badmintonstore.vn</p>
            <p>Hotline: 1900 1234</p>
            <div class="socials">
                <a href="#" aria-label="Facebook">facebook</a>
                <a href="#" aria-label="Instagram">instagram</a>
                <a href="#" aria-label="LinkedIn">linkedin</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 Badminton Store. Bản quyền thuộc về Badminton Store.</p>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
        color: #94a3b8;
        padding: 60px 20px 30px;
        overflow: hidden;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        animation: footerFadeIn 0.8s ease-out;
    }

    .footer-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, minmax(200px, 1fr));
        gap: 40px;
        align-items: start;
    }

    .footer-brand {
        display: flex;
        gap: 16px;
        align-items: center;
        animation: popIn 0.7s ease-out;
    }

    .footer-logo {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #84cc16;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .footer-title {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .footer-text {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .footer-links {
        display: grid;
        grid-template-columns: repeat(2, minmax(120px, 1fr));
        gap: 20px;
        animation: popIn 0.7s ease-out 0.1s both;
    }

    .footer-heading {
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 16px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .footer-links a,
    .footer-contact p,
    .socials a {
        display: block;
        color: #94a3b8;
        text-decoration: none;
        margin-bottom: 12px;
        transition: all 0.25s ease;
        font-size: 14px;
    }

    .footer-links a:hover,
    .socials a:hover {
        color: #84cc16;
        transform: translateX(4px);
    }

    .footer-contact {
        animation: popIn 0.7s ease-out 0.2s both;
    }

    .socials {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .socials a {
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
    }

    .socials a:hover {
        background: rgba(132, 204, 22, 0.1);
        border-color: #84cc16;
        transform: translateY(-2px);
    }

    .footer-bottom {
        max-width: 1200px;
        margin: 40px auto 0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 24px;
        text-align: center;
        color: #64748b;
        font-size: 13px;
        animation: fadeIn 0.8s ease-out 0.15s both;
    }

    @keyframes footerFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes popIn {
        from {
            opacity: 0;
            transform: translateY(18px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @media (max-width: 900px) {
        .footer-inner {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    @media (max-width: 640px) {
        .site-footer {
            padding: 40px 16px 20px;
        }

        .footer-links {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
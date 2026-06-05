CREATE DATABASE IF NOT EXISTS badminton_shop;
USE badminton_shop;

-- =========================
-- USER
-- =========================
CREATE TABLE IF NOT EXISTS `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') DEFAULT 'customer',
    status ENUM('active','locked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- CUSTOMER PROFILE
-- =========================
CREATE TABLE IF NOT EXISTS customer_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
    avatar VARCHAR(255) DEFAULT 'default-avatar.png',
    FOREIGN KEY (user_id) REFERENCES `user`(id) ON DELETE CASCADE
);

-- =========================
-- CATEGORY
-- =========================
CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('active','inactive') DEFAULT 'active'
);

-- =========================
-- PRODUCT
-- =========================
CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(150) NOT NULL,
    brand VARCHAR(100),
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id)
    REFERENCES category(id)
    ON DELETE SET NULL
);

-- =========================
-- ORDER
-- =========================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    customer_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,

    total DECIMAL(12,2) DEFAULT 0,

    payment_method ENUM('COD','BANK','MOMO')
    DEFAULT 'COD',

    payment_status ENUM('unpaid','paid')
    DEFAULT 'unpaid',

    status ENUM(
        'pending',
        'confirmed',
        'shipping',
        'delivered',
        'cancelled'
    ) DEFAULT 'pending',

    note TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES `user`(id)
    ON DELETE CASCADE
);

-- =========================
-- ORDER ITEM
-- =========================
CREATE TABLE IF NOT EXISTS order_item (
    id INT AUTO_INCREMENT PRIMARY KEY,

    order_id INT NOT NULL,
    product_id INT,

    quantity INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,

    FOREIGN KEY (order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE,

    FOREIGN KEY (product_id)
    REFERENCES product(id)
    ON DELETE SET NULL
);

-- =========================
-- CATEGORY DATA
-- =========================
INSERT INTO category(name, description) VALUES
('Vợt cầu lông', 'Các loại vợt cầu lông'),
('Giày cầu lông', 'Các loại giày cầu lông'),
('Áo cầu lông', 'Trang phục cầu lông'),
('Phụ kiện', 'Phụ kiện cầu lông');

-- =========================
-- USER DATA
-- =========================
INSERT INTO `user`(name,email,password,role) VALUES
('Admin','admin@gmail.com','123456','admin'),
('Khách hàng','customer@gmail.com','123456','customer');

-- =========================
-- PROFILE DATA
-- =========================
INSERT INTO customer_profile(user_id,phone,address) VALUES
(1,'0900000001','TP.HCM'),
(2,'0900000002','Bình Dương');

-- =========================
-- PRODUCT DATA
-- =========================
INSERT INTO product
(category_id,name,brand,description,price,stock,image)
VALUES
(1,'Yonex Astrox 99','Yonex',
'Vợt thiên công',2500000,20,'astrox99.jpg'),

(1,'Lining Axforce 90','Lining',
'Vợt tấn công mạnh',2300000,15,'axforce90.jpg'),

(2,'Yonex SHB 65Z','Yonex',
'Giày cầu lông cao cấp',1800000,30,'shb65z.jpg'),

(3,'Áo Victor','Victor',
'Áo thi đấu thoáng khí',350000,50,'victor.jpg'),

(4,'Quấn cán Yonex AC102','Yonex',
'Quấn cán chống trơn',65000,80,'ac102.jpg');

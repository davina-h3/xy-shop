-- Create Database
CREATE DATABASE IF NOT EXISTS shop;
USE shop;

-- Shopkeeper Table
CREATE TABLE shopkeepers (
    ShopkeeperId INT PRIMARY KEY AUTO_INCREMENT,
    UserName VARCHAR(50) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Product Table
CREATE TABLE products (
    ProductCode VARCHAR(20) PRIMARY KEY,
    ProductName VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ProductIn Table
CREATE TABLE product_ins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ProductCode VARCHAR(20),
    DateTime DATETIME NOT NULL,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(10,2) NOT NULL,
    TotalPrice DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductCode) REFERENCES products(ProductCode)
);

-- ProductOut Table
CREATE TABLE product_outs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ProductCode VARCHAR(20),
    DateTime DATETIME NOT NULL,
    Quantity INT NOT NULL,
    UnitPrice DECIMAL(10,2) NOT NULL,
    TotalPrice DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductCode) REFERENCES products(ProductCode)
);

-- Insert sample shopkeeper (password: admin123)
INSERT INTO shopkeepers (UserName, Password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample products
INSERT INTO products (ProductCode, ProductName) VALUES 
('SHOE001', 'Nike Air Max'),
('SHOE002', 'Adidas Superstar'),
('CLOTH001', 'Cotton T-Shirt'),
('CLOTH002', 'Denim Jeans');
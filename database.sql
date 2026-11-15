CREATE DATABASE IF NOT EXISTS cool_cafe CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cool_cafe;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL,
  description VARCHAR(255),
  price DECIMAL(10,2) NOT NULL,
  emoji VARCHAR(10) DEFAULT '🍽️',
  available TINYINT(1) DEFAULT 1
);

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  status ENUM('pending','preparing','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name,category,description,price,emoji) VALUES
('Classic Burger','Food','Juicy cafe-style burger with fresh vegetables.',99,'🍔'),
('Veg Sandwich','Food','Toasted sandwich with fresh vegetables.',79,'🥪'),
('French Fries','Snacks','Crispy golden potato fries.',69,'🍟'),
('Cold Coffee','Drinks','Chilled creamy coffee.',89,'🥤'),
('Mango Shake','Drinks','Refreshing mango milkshake.',99,'🥭'),
('Chocolate Brownie','Dessert','Soft chocolate brownie.',69,'🍫');

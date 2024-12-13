#############################################
-- CREATION OF THE DATABASE FOR TECH SHOP  #
#############################################
CREATE DATABASE IF NOT EXISTS dbTechShop
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;

USE dbTechShop;


#############################################
-- ADDING TABLES FOR THE DATABASE TECHSHOP #
#############################################
CREATE TABLE tblUsers (
    idUser INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dateOfBirth DATE,
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP
);


-- Créer la table des marques (brands)
CREATE TABLE IF NOT EXISTS tblBrands (
    idBrand INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Créer la table des catégories (categories)
CREATE TABLE IF NOT EXISTS tblCategory (
    idCategory INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Créer la table des produits (products)
CREATE TABLE IF NOT EXISTS tblProducts (
    idProduct INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    idBrand INT UNSIGNED NOT NULL,
    idCategory INT UNSIGNED NOT NULL,
    image VARCHAR(255),
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT FK_tblProducts_idBrand FOREIGN KEY (idBrand) REFERENCES tblBrands (idBrand),
    CONSTRAINT FK_tblProducts_idCategory FOREIGN KEY (idCategory) REFERENCES tblCategory (idCategory)
) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS tblOrders (
    idOrder INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser INT UNSIGNED NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT FK_tblOrders_idUser FOREIGN KEY (idUser) REFERENCES tblUsers (idUser)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tblOrderItems (
    idOrderItem INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idOrder INT UNSIGNED NOT NULL,
    idProduct INT UNSIGNED NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    CONSTRAINT FK_tblOrderItems_idOrder FOREIGN KEY (idOrder) REFERENCES tblOrders (idOrder),
    CONSTRAINT FK_tblOrderItems_idProduct FOREIGN KEY (idProduct) REFERENCES tblProducts (idProduct)
) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS tblDeals (
    idDeal INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idProduct INT UNSIGNED NOT NULL,
    discountPrice DECIMAL(10, 2) NOT NULL CHECK (discountPrice >= 0),
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    description TEXT,
    CONSTRAINT FK_tblDeals_idProduct FOREIGN KEY (idProduct) REFERENCES tblProducts (idProduct)
) ENGINE=InnoDB;





#############################################
-- ADDING DATA FOR BRANDS, PRODUCTS, ETC.  #
#############################################
INSERT INTO tblCategory (name)
VALUES 
    ('Laptops'),
    ('Phones'),
    ('Tablets'),
    ('TVs'),
    ('Accessories'),
    ('Gaming Consoles');

INSERT INTO tblBrands (name)
VALUES 
    ('Apple'),
    ('Samsung'),
    ('Dell'),
    ('Sony'),
    ('Microsoft'),
    ('Logitech');

INSERT INTO tblProducts (name, idBrand, idCategory, price, stock, image, description)
VALUES
    ('MacBook Air M3', 1, 1, 999.99, 50, 'MacBookAirM3.jpg', 'Apple MacBook Air with M3 chip, 8GB RAM, 256GB SSD.'),
    ('Dell XPS 15', 3, 1, 1399.99, 15, 'DellXPS15.jpg', 'Dell XPS 15 with Intel Core i7, 16GB RAM, 512GB SSD.'),
    ('Microsoft Surface Laptop Studio', 5, 1, 1499.99, 15, 'MicrosoftSurfaceLaptopStudio.jpg', 'Microsoft convertible laptop for creative work.'),
    ('Dell Inspiron 15', 3, 1, 799.99, 30, 'DellInspiron15.jpg', 'Dell Inspiron with Intel Core i5, 8GB RAM, 256GB SSD.'),
    ('MacBook Pro M2', 1, 1, 1999.99, 25, 'MacBookProM2.jpg', 'Apple MacBook Pro with M2 chip, 16GB RAM, 512GB SSD.'),
    ('iPhone 15 Pro Max', 1, 2, 1199.99, 40, 'iPhone15ProMax.jpg', 'Apple iPhone 15 Pro Max with A17 Bionic chip, 256GB storage.'),
    ('Galaxy S23 Ultra', 2, 2, 1199.99, 30, 'GalaxyS23Ultra.jpg', 'Samsung Galaxy S23 Ultra with 12GB RAM, 256GB storage.'),
    ('Sony Bravia 4K TV', 4, 4, 799.99, 15, 'SonyBravia4KTV.jpg', 'Sony 55-inch 4K Ultra HD Smart LED TV.'),
    ('AirPods Pro 2', 1, 5, 249.99, 100, 'AirPodsPro2.jpg', 'Apple AirPods Pro with Active Noise Cancellation and MagSafe case.'),
    ('PlayStation 5', 4, 6, 499.99, 50, 'PlayStation5.jpg', 'Sony gaming console with ray tracing support.');

INSERT INTO tbldeals (idProduct, discountPrice, startDate, endDate, description)
VALUES 
    ( 1, 50.00, "2022-11-25", "2024-12-31", "Black Friday"),
    ( 2, 75.00, "2022-11-25", "2024-12-28", "Black Friday 2");


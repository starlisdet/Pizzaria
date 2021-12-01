CREATE DATABASE Pizzaria;

USE Pizzaria;

CREATE TABLE client (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(50) NOT NULL,
  phone  VARCHAR(19),
  telephone  VARCHAR(18),
  address VARCHAR(150),
  district VARCHAR(50),
  zip_code VARCHAR(10),
  city VARCHAR(50),
  state VARCHAR(50),
  permission VARCHAR(50) NOT NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `permission` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE `product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_product` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `unitary_value` DOUBLE,
  `image` VARCHAR(255),
  `amount` INT,
  `status` BOOLEAN,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  PRIMARY KEY (id)
);
  
CREATE TABLE `sold` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_product` INT NOT NULL,
  `id_client` INT NOT NULL,
  `payment` VARCHAR(50) NOT NULL,
  `amount` INT,
  `sale_value` DOUBLE,
  `created_at` TIMESTAMP,
  `updated_at` TIMESTAMP,
  FOREIGN KEY (`id_product`) REFERENCES `product`(`id`),
  FOREIGN KEY (`id_client`) REFERENCES `client`(`id`),
  PRIMARY KEY (id)
);

INSERT INTO `Pizzaria`.`user` (
  `name`, 
  `email`, 
  `password`, 
  `permission`
) VALUES (
  'Admin', 
  'admin@gmail.com', 
  'admin', 'admin'
);
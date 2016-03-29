ALTER TABLE `product_categories` ADD `order` INT DEFAULT '0';
ALTER TABLE `products` ADD `order` INT DEFAULT '0';
ALTER TABLE `products` ADD COLUMN `price` VARCHAR(255) DEFAULT '';
ALTER TABLE `products_info` ADD COLUMN `full_description` TEXT;
ALTER TABLE `products` ADD COLUMN `image_1` VARCHAR(255) DEFAULT NULL, ADD COLUMN `image_2` VARCHAR(255) DEFAULT NULL;
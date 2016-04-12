ALTER TABLE `product_categories` ADD `order` INT DEFAULT '0';
ALTER TABLE `products` ADD `order` INT DEFAULT '0';
ALTER TABLE `products` ADD COLUMN `price` VARCHAR(255) DEFAULT '';
ALTER TABLE `products_info` ADD COLUMN `full_description` TEXT;
ALTER TABLE `products` ADD COLUMN `image_1` VARCHAR(255) DEFAULT NULL, ADD COLUMN `image_2` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `settings` ADD COLUMN `type` VARCHAR(50) DEFAULT NULL;

INSERT INTO `settings` (`name`,`value`,`lock`,`type`) VALUES ("slideOne","Первый слайд",1,"file");
INSERT INTO `settings` (`name`,`value`,`lock`,`type`) VALUES ("slideTwo","Второй слайд",1,"file");

ALTER TABLE `products` ADD COLUMN `visible` INT(1) NOT NULL DEFAULT '1';

ALTER TABLE `product_categories` ADD COLUMN `description` TEXT
AFTER `order`, ADD COLUMN `description_ru` TEXT
AFTER `description`, ADD COLUMN `description_ua` TEXT AFTER `description_ru`;
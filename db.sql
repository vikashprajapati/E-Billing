CREATE DATABASE billingSystem;
USE billingSystem;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Author','User') DEFAULT 'User',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `products` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `name` varchar(255) NOT NULL UNIQUE,
 `price` int(11) NOT NULL DEFAULT '0',
 `image` varchar(255) NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `discount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `client_name` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `bill_product` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `email`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'snishal', 'sahil.mca18.du@gmail.com', 'Admin', 'e8c8f45019430b6f79862746e96d6e70', '2018-01-08 12:52:58', '2018-01-08 12:52:58');

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'Product1', '100'),
(2, 'Product2', '200'),
(3, 'Product3', '300');

<?php

$config_file = "config.php";

if (file_exists($config_file)) {
  include($config_file);
}

$create = [];

$create[] = "SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO';";

$create[] = 'CREATE TABLE `category` (
  `CategoryId` int(11) NOT NULL,
  `Name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$create[] = 'CREATE TABLE `orders` (
  `OrderId` int(11) NOT NULL,
  `Date_Invoice` datetime NOT NULL,
  `Value` decimal(10,2) NOT NULL,
  `UserId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$create[] = 'CREATE TABLE `orders_details` (
  `Order_detailsId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Amount` int(11) NOT NULL,
  `Unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$create[] = 'CREATE TABLE `products` (
  `ProductId` int(11) NOT NULL,
  `Name` varchar(80) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `CategoryId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$create[] = 'CREATE TABLE `role` (
  `RoleId` int(11) NOT NULL,
  `Role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';

$create[] = 'CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Name` varchar(80) NOT NULL,
  `Surname` varchar(80) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `RoleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';


$create[] = 'ALTER TABLE `category` ADD PRIMARY KEY (`CategoryId`);';
$create[] = 'ALTER TABLE `orders` ADD PRIMARY KEY (`OrderId`);';
$create[] = 'ALTER TABLE `orders_details` ADD PRIMARY KEY (`Order_detailsId`);';
$create[] = 'ALTER TABLE `products` ADD PRIMARY KEY (`ProductId`);';
$create[] = 'ALTER TABLE `role` ADD PRIMARY KEY (`RoleId`);';
$create[] = 'ALTER TABLE `users` ADD PRIMARY KEY (`UserId`);';


$create[] = 'ALTER TABLE `category` MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT;';
$create[] = 'ALTER TABLE `orders` MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT;';
$create[] = 'ALTER TABLE `orders_details` MODIFY `Order_detailsId` int(11) NOT NULL AUTO_INCREMENT;';
$create[] = 'ALTER TABLE `products` MODIFY `ProductId` int(11) NOT NULL AUTO_INCREMENT;';
$create[] = 'ALTER TABLE `role` MODIFY `RoleId` int(11) NOT NULL AUTO_INCREMENT;';
$create[] = 'ALTER TABLE `users` MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT;';


$create[] = 'ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`) ON DELETE CASCADE;';
$create[] = 'ALTER TABLE `orders_details`
  ADD CONSTRAINT `orders_details_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_ibfk_2` FOREIGN KEY (`ProductId`) REFERENCES `products` (`ProductId`) ON DELETE CASCADE;';
$create[] = 'ALTER TABLE `products` ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`CategoryId`);';
$create[] = 'ALTER TABLE `users` ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `role` (`RoleId`);';

$create[] = 'COMMIT;';
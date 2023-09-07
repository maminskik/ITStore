<?php
$config_file = "config.php";

if (file_exists($config_file)) {
    include($config_file);
}

$insert = [];

$insert[] = "SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO';";

$insert[] = "INSERT INTO `category` (`CategoryId`, `Name`) VALUES
(1, 'Podzespoły komputerowe'),
(2, 'Licencje oprogramowania'),
(3, 'Laptopy');";


$insert[] = "INSERT INTO `role` (`RoleId`, `Role`) VALUES
(1, 'Admin'),
(2, 'User');";


$insert[] = "INSERT INTO `users` (`UserId`, `Name`, `Surname`, `Email`, `Password`, `is_active`, `RoleId`) VALUES
(1, 'Marcin', 'Najman', 'mn@interia.pl', '\$2y\$10\$StwnZNnFvuyvYswCc8PopuoHsNWUHVp77RgtvxuzhoYztyMrf5TTu', 1, 2),
(2, 'Tadeusz', 'Nowak', 'tadek@interia.pl', '\$2y\$10\$THogE5WNXj2oHZstZyvP2eQAQkk5joUzOqIsZRXDyZ3iICvo6DnDa', 1, 2),
(3, 'Kuba', 'Mamiński', 'kubamaminski@gmail.com', '\$2y\$10\$RcbgM30wbpWL0mqQcjJVd.ibNLwrLojJPsTxIPfqE8Idl7iuS0bwm', 1, 1),
(4, 'Michał', 'Baron', 'mb@wp.pl', '\$2y\$10\$sciya3woRmn3QERe7PeHd.t53GMqQUZCuAaDhndYHH5catvrGLHuy', 1, 2);";


$insert[] = "INSERT INTO `products` (`ProductId`, `Name`, `Image`, `Price`, `Description`, `CategoryId`) VALUES
(1, 'Intel Core I5 2500K', 'cpu.jpg', 350.00, 'Intel Core i5-2500K to procesor czterordzeniowy z rodziny Sandy Bridge, wprowadzony na rynek w 2011 roku. Jest to jednostka klasy średniej, która zyskała dużą popularność wśród entuzjastów komputerowych, głównie ze względu na możliwość łatwego podkręcania', 1),
(2, 'Zasilacz ASUS 650W', 'psu.jpg', 800.00, 'Zasilacz ASUS 650W to niezawodne i wydajne urządzenie zapewniające stabilne zasilanie dla komputerów stacjonarnych. Oferując moc wyjściową 650 wattów, jest doskonałym wyborem dla średnio zaawansowanych konfiguracji, w tym systemów z kartami graficznymi śr', 1),
(3, 'CorelDraw', 'paint.jpg', 3500.00, 'CorelDRAW to zaawansowane oprogramowanie do grafiki wektorowej, używane przez profesjonalistów w dziedzinach takich jak projektowanie graficzne, ilustracja, edycja zdjęć i wiele innych. Oferuje szeroki zakres narzędzi i funkcji, które pozwalają na tworzen', 2),
(4, 'CREATIVE Blaster', '1.jpg', 335.00, 'Creative Sound Blaster Audigy Fx to karta dźwiękowa przeznaczona dla użytkowników komputerów stacjonarnych, którzy pragną ulepszyć jakość dźwięku w swoim systemie. Wyposażona w technologię 5.1 Surround Sound, ta karta dźwiękowa oferuje bogate i zróżnicowa', 1);";


$insert[] = "INSERT INTO `orders` (`OrderId`, `Date_Invoice`, `Value`, `UserId`) VALUES
(1, '2023-09-03 21:56:00', 14800.00, 1),
(2, '2023-09-03 23:06:13', 2200.00, 2);";


$insert[] = "INSERT INTO `orders_details` (`Order_detailsId`, `OrderId`, `ProductId`, `Amount`, `Unit_price`) VALUES
(1, 1, 1, 20, 350.00),
(2, 1, 2, 1, 800.00),
(3, 1, 3, 2, 3500.00),
(4, 2, 1, 4, 350.00),
(5, 2, 2, 1, 800.00);";

$insert[] = 'COMMIT;';
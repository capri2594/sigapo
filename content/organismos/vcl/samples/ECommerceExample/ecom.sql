CREATE TABLE `admins` (
  `Username` varchar(32) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `LoginID` varchar(32) NOT NULL,
  PRIMARY KEY  (`Username`)
);

INSERT INTO `admins` VALUES ('test', 'test', '');

CREATE TABLE `ads` (
  `Product` int(11) NOT NULL,
  PRIMARY KEY  (`Product`)
);

INSERT INTO `ads` VALUES (1);
INSERT INTO `ads` VALUES (3);

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL auto_increment,
  `User` int(11) NOT NULL,
  `Subtotal` float NOT NULL,
  `Total` float NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `User` (`User`)
) AUTO_INCREMENT=5 ;


CREATE TABLE `orders_products` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Amount` float NOT NULL,
  KEY `OrderID` (`OrderID`,`ProductID`)
) ;


CREATE TABLE `products` (
  `ID` int(11) NOT NULL auto_increment,
  `Name` varchar(32) NOT NULL,
  `Image` varchar(32) NOT NULL,
  `Price` float NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `Name` (`Name`)
) AUTO_INCREMENT=9 ;

INSERT INTO `products` VALUES (1, 'Chemicals', 'CHEMICAL.gif', 45);
INSERT INTO `products` VALUES (2, 'Factory', 'FACTORY.gif', 345);
INSERT INTO `products` VALUES (3, 'Finances', 'FINANCE.gif', 100);
INSERT INTO `products` VALUES (8, 'Handshake', 'HANDSHAK.gif', 123);
INSERT INTO `products` VALUES (5, 'Ships', 'SHIPPING.gif', 222);

CREATE TABLE `users` (
  `ID` int(11) NOT NULL auto_increment,
  `Username` varchar(32) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `LoginID` varchar(32) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Address` varchar(128) NOT NULL,
  `City` varchar(32) NOT NULL,
  `State` varchar(32) NOT NULL,
  `Country` varchar(32) NOT NULL,
  `Postcode` varchar(32) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Username` (`Username`)
) AUTO_INCREMENT=2 ;

INSERT INTO `users` VALUES (1, 'test', 'test', '', 'Jonathan', 'test@test.com', 'Address', 'City', 'State', 'Country', 'Post Code', '1234567890');

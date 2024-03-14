CREATE TABLE `admins` (
  `Username` varchar(32) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `LoginID` varchar(32) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM;

CREATE TABLE `blogs` (
  `ID` int(11) NOT NULL auto_increment,
  `Title` varchar(128) collate latin1_general_ci NOT NULL,
  `Posted` datetime NOT NULL,
  `Content` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 ;

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL auto_increment,
  `BlogID` int(11) NOT NULL,
  `Author` varchar(64) NOT NULL,
  `Posted` datetime NOT NULL,
  `Content` text  NOT NULL,
  PRIMARY KEY  (`ID`),
  KEY `BlogID` (`BlogID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 ;

INSERT INTO admins (Username,Password,LoginID) VALUES('test','test','')

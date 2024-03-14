CREATE TABLE `links` (
  `link_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `link_caption` VARCHAR(80) COLLATE latin1_swedish_ci DEFAULT NULL,
  `link_href` VARCHAR(180) COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM;

/* Data for the `links` table  (Records 1 - 3) */

INSERT INTO `links` (`link_id`, `link_caption`, `link_href`) VALUES 
  (1, 'CodeGear website', 'http://www.codegear.com'),
  (2, 'qadram software', 'http://www.qadram.com'),
  (3, 'qooxdoo', 'http://www.qooxdoo.org');



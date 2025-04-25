DROP TABLE IF EXISTS `#__spreadshop`;

CREATE TABLE `#__spreadshop` (
	`id`          INT(10)         NOT NULL AUTO_INCREMENT,
	`shop_id`     VARCHAR(255)    NOT NULL,
	`platform`    VARCHAR(20)     DEFAULT 'NA',
	`starttoken`  VARCHAR(255)    DEFAULT '',
	`metadata`    INT(11)         DEFAULT '1',
	`mobile_swipe_menu` INT(11)   DEFAULT '0',
	`locale`      VARCHAR(50)     DEFAULT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE=MyISAM
	AUTO_INCREMENT=1
	DEFAULT CHARSET=utf8 ;
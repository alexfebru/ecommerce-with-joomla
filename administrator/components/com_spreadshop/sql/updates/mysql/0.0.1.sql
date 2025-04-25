/*
  First update.sql file is the same as the install.mysql.utf8.sql
  @since version 2.0.1

  Further sql updates should be named numerically regardless from the components version number and
  should only consists of the actual sql-changes
 */
CREATE TABLE IF NOT EXISTS `#__spreadshop` (
	`id`          INT(10)         NOT NULL AUTO_INCREMENT,
	`shop_id`     VARCHAR(255)    NOT NULL,
	`platform`    VARCHAR(20)     DEFAULT 'NA',
	`starttoken`  VARCHAR(255)    DEFAULT '',
	`metadata`    INT(11)         DEFAULT '1',
	`mobile_swipe_menu` INT(11)   DEFAULT '0',
	`locale`      VARCHAR(50)     DEFAULT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =1
	DEFAULT CHARSET =utf8;
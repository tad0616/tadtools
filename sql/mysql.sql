CREATE TABLE `tadtools_setup` (
  `tt_sn` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tt_theme`  varchar(100) NOT NULL default '',
  `tt_use_bootstrap`  varchar(255) NOT NULL default '',
  `tt_bootstrap_color`  varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tt_sn`),
  UNIQUE KEY `tt_theme` (`tt_theme`)
) ENGINE = MYISAM;

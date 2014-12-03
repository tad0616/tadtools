CREATE TABLE `tadtools_setup` (
  `tt_theme`  varchar(100) NOT NULL default '',
  `tt_use_bootstrap`  varchar(255) NOT NULL default '',
  `tt_bootstrap_color`  varchar(255) NOT NULL default '',
  `tt_theme_kind`  varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tt_theme`)
) ENGINE = MYISAM;


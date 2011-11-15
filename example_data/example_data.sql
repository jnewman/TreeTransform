CREATE TABLE IF NOT EXISTS `adjacency_nested_combo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent` int(11) unsigned DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rht` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `adjacency_nested_combo` (`id`, `parent`, `lft`, `rht`) VALUES
(1, NULL, 0, 0),
(2, 1, 0, 0),
(3, 2, 0, 0),
(4, 1, 0, 0),
(5, 2, 0, 0);

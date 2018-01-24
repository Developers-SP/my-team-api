CREATE TABLE `player` (
  `steam_id` varchar(50) NOT NULL,
  `steam_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `active` int(10) unsigned DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`steam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |


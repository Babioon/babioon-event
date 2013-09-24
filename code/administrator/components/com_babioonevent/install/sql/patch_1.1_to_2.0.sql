DROP TABLE IF EXISTS `#__babioonevent_events` ;

CREATE TABLE IF NOT EXISTS `#__babioonevent_events` (
  `babioonevent_event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `organiser` varchar(255) NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sdate` date NOT NULL DEFAULT '0000-00-00',
  `stime` time NOT NULL DEFAULT '00:00:00',
  `stimeset` tinyint(1) NOT NULL,
  `end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edate` date NOT NULL DEFAULT '0000-00-00',
  `etime` time NOT NULL DEFAULT '00:00:00',
  `etimeset` tinyint(1) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `showemail` tinyint(1) unsigned NOT NULL,
  `tel` varchar(100) NOT NULL,
  `website` varchar(255) NOT NULL DEFAULT '',
  `emailchecked` tinyint(1) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `ainfo` varchar(256) NOT NULL,
  `street` varchar(256) NOT NULL,
  `pcode` varchar(50) NOT NULL,
  `city` varchar(256) NOT NULL,
  `state` varchar(256) NOT NULL,
  `country` varchar(256) NOT NULL,
  `geo_b` varchar(256) NOT NULL,
  `geo_l` varchar(256) NOT NULL,
  `teaser` text NOT NULL,
  `text` text NOT NULL,
  `isfreeofcharge` tinyint(1) NOT NULL DEFAULT '0',
  `charge` varchar(255) NOT NULL,
  `picturefile` varchar(255) NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` text NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `control` text NOT NULL,
  `catid` int(11) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`babioonevent_event_id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `#__babioonevent_events`
SELECT * FROM jos_rd_event_data;
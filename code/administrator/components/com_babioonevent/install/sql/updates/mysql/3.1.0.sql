ALTER TABLE `#__babioonevent_events` ADD `customfield1` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  AFTER `hash`;
ALTER TABLE `#__babioonevent_events` ADD `customfield2` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  AFTER `customfield1`;
ALTER TABLE `#__babioonevent_events` ADD `customfield3` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  AFTER `customfield2`;
ALTER TABLE `#__babioonevent_events` ADD `customfield4` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  AFTER `customfield3`;


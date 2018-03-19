UPDATE `statuses` SET `fim`=2 WHERE `fim` IS null;
ALTER TABLE `statuses` CHANGE `fim` `fim` TINYINT(4) NULL DEFAULT NULL;

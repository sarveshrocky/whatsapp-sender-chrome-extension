ALTER TABLE `messages`
  CHANGE `status` `status` ENUM ('new','canceled','sent','pending','rejected')
NOT NULL DEFAULT 'new';

ALTER TABLE `messages` ADD `reason` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;

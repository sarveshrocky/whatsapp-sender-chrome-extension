ALTER TABLE `phone_numbers`
  ADD `name` VARCHAR(100) NULL DEFAULT NULL
  AFTER `phone`,
  ADD `is_visible` TINYINT(1) NOT NULL DEFAULT '1'
  AFTER `name`;

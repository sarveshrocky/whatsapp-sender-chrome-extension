ALTER TABLE `messages` ADD `phone_sender` VARCHAR(14) NULL DEFAULT NULL AFTER `phone`;

CREATE TABLE `phone_numbers` (
  `id`        INT UNSIGNED                  NOT NULL AUTO_INCREMENT,
  `messenger` ENUM ('WhatsApp', 'Telegram') NOT NULL DEFAULT 'WhatsApp',
  `phone`     VARCHAR(20)                   NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

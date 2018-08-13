CREATE TABLE `messages` (
  `id`        INT UNSIGNED                  NOT NULL AUTO_INCREMENT,
  `messenger` ENUM ('WhatsApp', 'Telegram') NOT NULL DEFAULT 'WhatsApp',
  `phone`     VARCHAR(14)                   NOT NULL,
  `media`     VARCHAR(255)                  NULL     DEFAULT NULL,
  `text`      TEXT                          NOT NULL,
  `status`    ENUM ('new', 'canceled', 'sent', 'pending') NOT NULL DEFAULT 'new',
  `time`      INT UNSIGNED                  NOT NULL,
  `time_sent` INT                           NULL     DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;

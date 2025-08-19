/* SUPPRIMER LA BASE DE DONNEES SI ELLE EXISTE */
DROP DATABASE IF EXISTS `squid_game`;

/* CREER ET UTILISER LA BASE DE DONNEES */
CREATE DATABASE IF NOT EXISTS `squid_game`;
USE `squid_game`;

/* CREER LA TABLE users */
CREATE TABLE `users`(
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(100) NOT NULL,
    `user_email` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
    `registration_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`user_id`),
    UNIQUE KEY(`user_email`)
)
ENGINE = InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
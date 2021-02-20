#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `crew` CHARACTER SET 'utf8';
USE `crew`;

#------------------------------------------------------------
# Table: `crew_member`
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `crew_member`(
        `id`        INT (11) AUTO_INCREMENT  NOT NULL,
        `firstname` VARCHAR (25) NOT NULL,
        `firstname` VARCHAR (25) NOT NULL,
        `description`     VARCHAR (25) NOT NULL,
        `gender`     VARCHAR (5) NOT NULL,
        PRIMARY KEY (`id`)
        UNIQUE KEY `firstname` (`firstname`,`lastname`)
)ENGINE=InnoDB;
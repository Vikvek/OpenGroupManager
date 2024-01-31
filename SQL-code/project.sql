CREATE TABLE `clubs` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`admin_username` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;
CREATE TABLE `club_members` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`club_id` INT(11) NULL DEFAULT NULL,
	`customer_name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`email` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`phone_number` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`address` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `club_id` (`club_id`) USING BTREE,
	CONSTRAINT `club_members_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `opengroupmanager`.`clubs` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=8
;
CREATE TABLE `gatherings` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`club_id` INT(11) NULL DEFAULT NULL,
	`status` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`creator` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`attendance` TEXT(65535) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`gathering_date` DATE NULL DEFAULT NULL,
	`gathering_time` TIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `club_id` (`club_id`) USING BTREE,
	CONSTRAINT `gatherings_ibfk_1` FOREIGN KEY (`club_id`) REFERENCES `opengroupmanager`.`clubs` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=5
;
CREATE TABLE `tasks` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`task` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`colleague` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`monetary_value` INT(11) NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;
CREATE TABLE `users` (
	`id` BIGINT(20) NOT NULL,
	`username` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`password` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
	`admin` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT 'If user status=1 admin status is true' COLLATE 'latin1_swedish_ci',
	`companyID` INT(5) NOT NULL COMMENT 'Minkä yrityksen käytössä tämä tili on',
	`userType` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;

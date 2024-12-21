-- TODO: ADD FOREIGN KEYS
-- +
-- + TABLES
-- +

-- + Basic Structure

CREATE DATABASE NordLib CHARACTER SET utf8 COLLATE utf8_polish_ci;

USE NordLib;

CREATE TABLE Users (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(15) CHARACTER SET latin1 NOT NULL,
    `pass` CHAR(128) CHARACTER SET latin1 NOT NULL,
    `email` VARCHAR(20) CHARACTER SET latin1 NOT NULL,
    `role_id` TINYINT NOT NULL,
    `human_id` BIGINT NOT NULL,
    `reset` BOOL NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Stat (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `letter` CHAR(1) NOT NULL,
    PRIMARY KEY (`id`)
); 
-- * public, hidden, deleted, only_friends, spec

-- + Information about user

CREATE TABLE Human (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `personal_id` CHAR(15) CHARACTER SET latin1 NOT NULL,
    `personal_information_id` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Personal_information (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(15) NOT NULL,
    `second_name` VARCHAR(15) DEFAULT NULL,
    `third_name` VARCHAR(15) DEFAULT NULL,
    `surname` VARCHAR(20) NOT NULL,
    `sex_id` TINYINT DEFAULT NULL,
    `telephone` CHAR(12) DEFAULT NULL,
    `country_id` SMALLINT DEFAULT NULL,
    `interested_in` VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Sex (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Countries (
    `id` SMALLINT NOT NULL AUTO_INCREMENT,
    `letters` CHAR(3) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
);

-- + User's settings

CREATE TABLE Settings (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `theme_id` TINYINT DEFAULT NULL,
    `icons_id` TINYINT DEFAULT NULL,
    `font_id` TINYINT DEFAULT NULL,
    `language_id` SMALLINT DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Language (
    `id` SMALLINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `letters` char(3) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Theme (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `primary` CHAR(6) NOT NULL,
    `secondary` CHAR(6) DEFAULT NULL,
    `tertiary` CHAR(6) DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Fonts (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `path` VARCHAR(20) NOT NULL,
    `size` TINYINT DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Icons (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `path` VARCHAR(20) NOT NULL,
    `size` TINYINT DEFAULT NULL,
    PRIMARY KEY (`id`)
);

-- + Privileges of interface

CREATE TABLE Roles (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Interface_privileges (
    `id` INT NOT NULL AUTO_INCREMENT,
    `interface_id` TINYINT NOT NULL,
    `role_id` TINYINT NOT NULL,
    `show` BOOL NOT NULL,
    `show_order` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Interface (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20),
    `id_name` VARCHAR(20),
    PRIMARY KEY (`id`)
);

-- + Friends and other relations

CREATE TABLE Relations (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user0_id` BIGINT NOT NULL,
    `user1_id` BIGINT NOT NULL,
    `relations_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Types_of_relations (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL, 
    `letter` CHAR(1) NOT NULL,
    PRIMARY KEY (`id`)
); -- * friend, block, ignore, invited

-- + Posts

CREATE TABLE Authors (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `author_nick_name` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Posts (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `data` VARCHAR(512) NOT NULL,
    `author_id` BIGINT NOT NULL,
    `add_date` DATETIME NULL,
    `delete_date` DATETIME DEFAULT NULL,
    `last_public_date` DATETIME DEFAULT NULL,
    `last_hide_date` DATETIME DEFAULT NUll,
    `stat_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Post_watcher (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `post_id` BIGINT NOT NULL,
    PRIMARY KEY (`id`)
);

-- + Chats

CREATE TABLE Messages (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `data` VARCHAR(512) NOT NULL,
    `structure_id` BIGINT DEFAULT NULL,
    `group_id` BIGINT DEFAULT NULL,
    `to_id` BIGINT DEFAULT NULL,
    `from_id` BIGINT DEFAULT NULL,
    `add_date` DATETIME NOT NULL,
    `delete_date` DATETIME DEFAULT NULL,
    `stat_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Groups (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `stat_id` TINYINT NOT NULL,
    `type_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Types_of_groups (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Bilongingness (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT NOT NULL,
    `group_id` BIGINT NOT NULL,
    `role_id` BIGINT DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Groups_roles (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `color` CHAR(6) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Groups_privileges (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `read` BOOL NOT NULL,
    `write` BOOL NOT NULL,
    `execute` BOOL NOT NULL,
    `admin` BOOL NOT NULL,
    `role_id` BIGINT NOT NULL,
    `group_id` BIGINT NOT NULL,
    `structure_id` BIGINT DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Structures (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    `group_id` BIGINT NOT NULL,
    `type_id` TINYINT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Types_of_structures (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(15) NOT NULL,
    PRIMARY KEY (`id`)
);

-- + Libraries

CREATE TABLE Books_privileges (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `book_id` BIGINT NOT NULL,
    `owner_id` BIGINT NOT NULL,
    `library_id` BIGINT NOT NULL,
    `user_id` BIGINT NOT NULL,
    `read` BOOL NOT NULL,
    `share` BOOL NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Libraries (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `stat_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Books (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `author_id` BIGINT DEFAULT NULL, 
    `title` VARCHAR(20) NOT NULL,
    `description` VARCHAR(250) DEFAULT NULL,
    `path` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Books_authors (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(15),
    `second_name` VARCHAR(15) DEFAULT NULL,
    `third_name` VARCHAR(15) DEFAULT NULL,
    `surname` VARCHAR(15),
    `sex_id` TINYINT DEFAULT NULL,
    `country_id` SMALLINT DEFAULT NULL,
    PRIMARY KEY (`id`)
);

-- + Logs and Backup Logs

CREATE TABLE Communicates (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `communicate` VARCHAR(100) NOT NULL,
    `code` VARCHAR(5) NOT NULL,
    `type_id` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE Types_of_communicates (
    `id` TINYINT NOT NULL AUTO_INCREMENT,
    `type` CHAR(4) NOT NULL, -- * INFO, WARN, EROR
    PRIMARY KEY (`id`)
);

CREATE TABLE Logs (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `communicate_id` TINYINT NOT NULL,
    `date` TIMESTAMP NOT NULL,
    PRIMARY KEY (`id`)
);


CREATE TABLE Logs_backup (
    `id` BIGINT NOT NULL AUTO_INCREMENT,
    `communicate_id` TINYINT NOT NULL,
    `date` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
);

-- +
-- + CONSTRAINTS
-- +

-- + Basic Structure

ALTER TABLE `Users` ADD CONSTRAINT `FK_Users_of_Human` 
    FOREIGN KEY (`human_id`) REFERENCES `Human` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Users` ADD CONSTRAINT `FK_Role_of_User` 
    FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

-- + Information about user

ALTER TABLE `Human` ADD CONSTRAINT `FK_Personal_information_of_Human` 
    FOREIGN KEY (`personal_information_id`) REFERENCES `Personal_information` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Personal_information` ADD CONSTRAINT `FK_Sex_of_Personal_information` 
    FOREIGN KEY (`sex_id`) REFERENCES `Sex` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Personal_information` ADD CONSTRAINT `FK_Country_of_Human` 
    FOREIGN KEY (`country_id`) REFERENCES `Countries` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

-- + Users's settings

ALTER TABLE `Settings` ADD CONSTRAINT `FK_Settings_of_User` 
    FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Settings` ADD CONSTRAINT `FK_Theme_of_User's_Interface` 
    FOREIGN KEY (`theme_id`) REFERENCES `Theme` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Settings` ADD CONSTRAINT `FK_Font_of_User's_Interface` 
    FOREIGN KEY (`font_id`) REFERENCES `Fonts` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Settings` ADD CONSTRAINT `FK_Icons_of_User's_Interface` 
    FOREIGN KEY (`icons_id`) REFERENCES `Icons` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Settings` ADD CONSTRAINT `FK_Language_of_User's_Interface` 
    FOREIGN KEY (`language_id`) REFERENCES `Language` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

-- + Privileges of interface

ALTER TABLE `Interface_privileges` ADD CONSTRAINT `FK_Privileges_for_Role` 
    FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Interface_privileges` ADD CONSTRAINT `FK_Privileges_for_Interface` 
    FOREIGN KEY (`interface_id`) REFERENCES `Interface` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

-- + Friends and other relations

ALTER TABLE `Relations` ADD CONSTRAINT `FK_Relations_of_User0` 
    FOREIGN KEY (`user0_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Relations` ADD CONSTRAINT `FK_Relations_of_User1` 
    FOREIGN KEY (`user1_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Relations` ADD CONSTRAINT `FK_Type_of_Relation_for_Relation` 
    FOREIGN KEY (`relations_id`) REFERENCES `Types_of_relations` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

-- + Posts

ALTER TABLE `Authors` ADD CONSTRAINT `FK_User_who_is_Authors` 
    FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Posts` ADD CONSTRAINT `FK_Author_of_Post` 
    FOREIGN KEY (`author_id`) REFERENCES `Authors` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Posts` ADD CONSTRAINT `FK_Stat_of_Post` 
    FOREIGN KEY (`stat_id`) REFERENCES `Stat` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

-- + Chats

ALTER TABLE `Messages` ADD CONSTRAINT `FK_Structure_with_Messages` 
    FOREIGN KEY (`structure_id`) REFERENCES `Structures` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Messages` ADD CONSTRAINT `FK_Group_with_Messages` 
    FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Messages` ADD CONSTRAINT `FK_Messages_for_User` 
    FOREIGN KEY (`to_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Messages` ADD CONSTRAINT `FK_Messages_from_User` 
    FOREIGN KEY (`from_id`) REFERENCES `Users` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Messages` ADD CONSTRAINT `FK_Stat_of_Messages` 
    FOREIGN KEY (`stat_id`) REFERENCES `Stat` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Groups` ADD CONSTRAINT `FK_Stat_of_Group` 
    FOREIGN KEY (`stat_id`) REFERENCES `Stat` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Groups` ADD CONSTRAINT `FK_Type_of_Group_for_Groups` 
    FOREIGN KEY (`type_id`) REFERENCES `Types_of_groups` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Bilongingness` ADD CONSTRAINT `FK_Users_Bilongingness` 
    FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Bilongingness` ADD CONSTRAINT `FK_Bilongingness_of_Groups` 
    FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Bilongingness` ADD CONSTRAINT `FK_Role_in_Bilongingness` 
    FOREIGN KEY (`role_id`) REFERENCES `Groups_roles` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Groups_privileges` ADD CONSTRAINT `FK_Privileges_in_Group_for_Role` 
    FOREIGN KEY (`role_id`) REFERENCES `Groups_roles` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Groups_privileges` ADD CONSTRAINT `FK_Privileges_in_Group` 
    FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Groups_privileges` ADD CONSTRAINT `FK_Privileges_in_Group_in_Structure` 
    FOREIGN KEY (`structure_id`) REFERENCES `Structures` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Structures` ADD CONSTRAINT `FK_Structures_in_Group` 
    FOREIGN KEY (`group_id`) REFERENCES `Groups` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Structures` ADD CONSTRAINT `FK_Type_of_structure_for_Structures` 
    FOREIGN KEY (`type_id`) REFERENCES `Types_of_structures` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

-- + Libraries

ALTER TABLE `Books_privileges` ADD CONSTRAINT `FK_Books_privileges_for_Books` 
    FOREIGN KEY (`book_id`) REFERENCES `Books` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Books_privileges` ADD CONSTRAINT `FK_Owner_of_Book` 
    FOREIGN KEY (`owner_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Books_privileges` ADD CONSTRAINT `FK_Library_with_Book` 
    FOREIGN KEY (`library_id`) REFERENCES `Libraries` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Books_privileges` ADD CONSTRAINT `FK_User_of_Book` 
    FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) 
        ON DELETE CASCADE
        ON UPDATE RESTRICT;

ALTER TABLE `Libraries` ADD CONSTRAINT `FK_Stat_of_Libraries` 
    FOREIGN KEY (`stat_id`) REFERENCES `Stat` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Books_authors` ADD CONSTRAINT `FK_Sex_of_Books_authors` 
    FOREIGN KEY (`sex_id`) REFERENCES `Sex` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

ALTER TABLE `Books_authors` ADD CONSTRAINT `FK_Country_of_Books_authors` 
    FOREIGN KEY (`country_id`) REFERENCES `Countries` (`id`) 
        ON DELETE SET NULL
        ON UPDATE RESTRICT;

-- + Logs and Backup Logs

ALTER TABLE `Communicates` ADD CONSTRAINT `FK_Type_of_communicates_for_Communicates` 
    FOREIGN KEY (`type_id`) REFERENCES `Types_of_communicates` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Logs` ADD CONSTRAINT `FK_Communicates_in_Log` 
    FOREIGN KEY (`communicate_id`) REFERENCES `Communicates` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

ALTER TABLE `Logs_backup` ADD CONSTRAINT `FK_Communicates_in_Backup` 
    FOREIGN KEY (`communicate_id`) REFERENCES `Communicates` (`id`) 
        ON DELETE RESTRICT
        ON UPDATE RESTRICT;

-- +
-- + USERS
-- +

-- + Create users

CREATE USER 'anonymous_librarian'@'!localhost!' IDENTIFIED BY '!password0!';
CREATE USER 'user_librarian'@'!localhost!' IDENTIFIED BY '!password1!';
CREATE USER 'admin_librarian'@'!localhost!' IDENTIFIED BY '!password2!';
CREATE USER 'mr_register'@'!localhost!' IDENTIFIED BY '!password3!';
CREATE USER 'mr_statistic'@'!localhost!' IDENTIFIED BY '!password4!';

-- + User Privileges

GRANT SELECT ON `Interface` TO 'anonymous_librarian'@'!localhost!';
GRANT SELECT ON `Interface_privileges` TO 'anonymous_librarian'@'!localhost!';
GRANT SELECT ON `Roles` TO 'anonymous_librarian'@'!localhost!';
GRANT SELECT ON `Sex` TO 'anonymous_librarian'@'!localhost!';
GRANT SELECT ON `Countries` TO 'anonymous_librarian'@'!localhost!';

GRANT SELECT, INSERT ON `Users` TO 'mr_register'@'!localhost!';
GRANT SELECT, INSERT ON `Human` TO 'mr_register'@'!localhost!';
GRANT INSERT ON `Personal_information` TO 'mr_register'@'!localhost!';
GRANT SELECT ON `Interface` TO 'mr_register'@'!localhost!';
GRANT SELECT ON `Interface_privileges` TO 'mr_register'@'!localhost!';
GRANT SELECT ON `Roles` TO 'mr_register'@'!localhost!';

-- +
-- + BASIC DATA
-- +

-- + Interfaces

INSERT INTO Roles (`name`)
    VALUES 
        ('anonymous'),
        ('user'),
        ('administrator');

INSERT INTO Interface (`name`, `id_name`) 
    VALUES 
        ('Witaj', 'welcome'), 
        ('Posty', 'posts_an'), 
        ('Zarejestracja', 'register'), 
        ('Zaloguj', 'login'), 
        ('Główna', 'main'), 
        ('Wiadomości', 'messages'), 
        ('Biblioteka', 'library'), 
        ('Konto', 'account'), 
        ('Ustawienia', 'settings'), 
        ('Profil', 'profile'), 
        ('Statystyki', 'statistics'), 
        ('Logi', 'logs'), 
        ('Posty', 'posts_adm'), 
        ('Użytkownicy', 'users_adm');

INSERT INTO Interface_privileges (`interface_id`, `role_id`, `show`, `show_order`)
    VALUES
        (1, 1, TRUE, 1),
        (1, 2, FALSE, 0),
        (1, 3, FALSE, 0),
        (2, 1, TRUE, 2),
        (2, 2, FALSE, 0),
        (2, 3, FALSE, 0),
        (3, 1, TRUE, 3),
        (3, 2, FALSE, 0),
        (3, 3, FALSE, 0),
        (4, 1, TRUE, 4),
        (4, 2, FALSE, 0),
        (4, 3, FALSE, 0),
        (5, 1, FALSE, 0),
        (5, 2, TRUE, 1),
        (5, 3, FALSE, 0),
        (6, 1, FALSE, 0),
        (6, 2, TRUE, 2),
        (6, 3, FALSE, 0),
        (7, 1, FALSE, 0),
        (7, 2, TRUE, 3),
        (7, 3, FALSE, 0),
        (8, 1, FALSE, 0),
        (8, 2, TRUE, 4),
        (8, 3, TRUE, 5),
        (9, 1, FALSE, 0),
        (9, 2, TRUE, 41),
        (9, 3, TRUE, 51),
        (10, 1, FALSE, 0),
        (10, 2, TRUE, 42),
        (10, 3, TRUE, 52),
        (11, 1, FALSE, 0),
        (11, 2, FALSE, 0),
        (11, 3, TRUE, 1),
        (12, 1, FALSE, 0),
        (12, 2, FALSE, 0),
        (12, 3, TRUE, 2),
        (13, 1, FALSE, 0),
        (13, 2, FALSE, 0),
        (13, 3, TRUE, 3),
        (14, 1, FALSE, 0),
        (14, 2, FALSE, 0),
        (14, 3, TRUE, 4);

INSERT INTO Sex (`name`)
    VALUES
        ('mężczyzna'),
        ('kobieta');

INSERT INTO Countries (`letters`, `name`)
    VALUES
        ('PL', 'Polska'),
        ('UA','Ukraina'),
        ('USA','Stany Zjednoczone');

INSERT INTO Personal_information (`first_name`, `second_name`, `third_name`, `surname`, `sex_id`, `telephone`, `country_id`, `interested_in`)
    VALUES
        ('!admin_first_name!', '!admin_second_name!', '!admin_third_name!', '!admin_surname!', '!admin_sex_id!', '!admin_telephone!', '!admin_country_id!', '!admin_interested_in!');

INSERT INTO Human (`personal_id`, `personal_information_id`)
    VALUES
        ('000000000000000', 1);

INSERT INTO Users (`username`, `pass`, `email`, `role_id`, `human_id`, `reset`)
    VALUES
        ('!admin_nick!', '!admin_pass!', '!admin_email!', 3, 1, FALSE);
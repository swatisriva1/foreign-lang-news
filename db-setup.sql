CREATE DATABASE ss3ck_foreign_lang_news_db;

USE ss3ck_foreign_lang_news_db;
CREATE TABLE user_info 
    (login_count INT, username VARCHAR(255), password VARCHAR(255), 
    profile_pic VARCHAR(255), f_name VARCHAR(255), l_name VARCHAR(255), email VARCHAR(255), PRIMARY KEY(username));

INSERT INTO user_info 
(login_count, username, password, profile_pic, f_name, l_name, email) values 
(1, "jdoe27", "Hello!23", "1", "Jane", "Doe", "jdoe@gmail.com");

CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_lang` 
( `username` VARCHAR(255) NOT NULL , `lang_id` VARCHAR(10) NOT NULL , PRIMARY KEY (`username`, `lang_id`)) 
ENGINE = InnoDB;


CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_topic` 
( `username` VARCHAR(255) NOT NULL , `topic_id` VARCHAR(8) NOT NULL , PRIMARY KEY (`username`, `topic_id`)) 
ENGINE = InnoDB;


CREATE TABLE `ss3ck_foreign_lang_news_db`.`langs` 
( `language` VARCHAR(255) NOT NULL , `lang_id` VARCHAR(10) NOT NULL , PRIMARY KEY (`lang_id`)) 
ENGINE = InnoDB;


CREATE TABLE `ss3ck_foreign_lang_news_db`.`topics` 
( `topic` VARCHAR(255) NOT NULL , `topic_id` VARCHAR(10) NOT NULL , PRIMARY KEY(`topic_id`));
ENGINE = InnoDB;


CREATE TABLE `ss3ck_foreign_lang_news_db`.`avatars` 
(`image_path` VARCHAR(255) NOT NULL, `image_id` VARCHAR(10) NOT NULL , PRIMARY KEY(`image_id`));
ENGINE = InnoDB;


CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_history`
(`username` VARCHAR(255) NOT NULL , `article_1` VARCHAR(255) NOT NULL, `article_2` VARCHAR(255) NOT NULL , `article_3` VARCHAR(255) NOT NULL , PRIMARY KEY(`username`));
ENGINE = InnoDB;
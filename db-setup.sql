-- Database tables and values
-- Megan Reddy (mr8vn) and Swati Srivastava (ss3ck)

CREATE DATABASE ss3ck_foreign_lang_news_db;

USE ss3ck_foreign_lang_news_db;
CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_info`
    (login_count INT, username VARCHAR(255), password VARCHAR(255), 
    profile_pic VARCHAR(255), f_name VARCHAR(255), l_name VARCHAR(255), email VARCHAR(255), PRIMARY KEY(`username`));

CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_lang`
(`username` VARCHAR(255) NOT NULL , `lang_1` VARCHAR(255) NOT NULL, `lang_2` VARCHAR(255) NOT NULL , `lang_3` VARCHAR(255) NOT NULL , PRIMARY KEY(`username`));
-- ENGINE = InnoDB;

CREATE TABLE `ss3ck_foreign_lang_news_db`.`user_topic`
(`username` VARCHAR(255) NOT NULL , `topic_1` VARCHAR(255) NOT NULL, `topic_2` VARCHAR(255) NOT NULL , `topic_3` VARCHAR(255) NOT NULL , PRIMARY KEY(`username`));
-- ENGINE = InnoDB;

CREATE TABLE `ss3ck_foreign_lang_news_db`.`langs` 
( `language` VARCHAR(255) NOT NULL , `lang_id` VARCHAR(10) NOT NULL , PRIMARY KEY (`lang_id`)); 
-- ENGINE = InnoDB;

INSERT INTO `langs` (`language`, `lang_id`) VALUES
('Chinese', 'cn'),
('German', 'de'),
('French', 'fr'),
('Italian', 'it'),
('Japanese', 'jp'),
('Korean', 'kr'),
('Dutch', 'nl'),
('Norwegian', 'no'),
('Portuguese', 'pt'),
('Russian', 'ru');

CREATE TABLE `ss3ck_foreign_lang_news_db`.`topics` 
( `topic` VARCHAR(255) NOT NULL , `topic_id` VARCHAR(255) NOT NULL , PRIMARY KEY(`topic_id`));
-- ENGINE = InnoDB;

INSERT INTO `topics` (`topic`, `topic_id`) VALUES
('Business', 'business'),
('Entertainment', 'entertainment'),
('General', 'general'),
('Health', 'health'),
('Science', 'science'),
('Sports', 'sports'),
('Technology', 'technology');

CREATE TABLE `ss3ck_foreign_lang_news_db`.`questions` 
( `question_id` int(4) NOT NULL AUTO_INCREMENT , `fname` VARCHAR(255) NOT NULL , `lname` VARCHAR(255) NOT NULL , 
`email` VARCHAR(255) NOT NULL , `type` VARCHAR(255) NOT NULL , `qText` VARCHAR(255) NOT NULL , 
PRIMARY KEY (`question_id`)); 
-- ENGINE = InnoDB;

CREATE TABLE `lang_info` (
  `lang_id` varchar(255) NOT NULL,
  `fact1` varchar(255) NOT NULL,
  `fact2` varchar(255) NOT NULL,
  `fact3` varchar(255) NOT NULL,
  `fact4` varchar(255) NOT NULL
);

INSERT INTO `lang_info` (`lang_id`, `fact1`, `fact2`, `fact3`, `fact4`) VALUES
('cn', 'Chinese is the most used mother tongue. In 2010, the number of Chinese native speakers totaled 955 million people.', 'Typically, you must learn 3,000 characters in order to be considered fluent enough to read the morning newspaper.', 'Written Chinese is over 3,000 years old.', 'The English word \"brainwash\" comes from Chinese.'),
('de', 'The German language has three genders.', 'All nouns in German are capitalized.', 'German has a unique letter -- an additional consonant called \"Eszett\".', 'The German word \"fremdschämen\" refers to shame felt on another person’s behalf.'),
('fr', 'About 30% of modern English words are of French origin.', 'French counting can get interesting -- for example, \"eighty\" is \"quatre-vingts\", or \"four twenties\".', 'French has a lot of homophones.', 'If you find a French word with “w” in it, it’s only because it’s a borrowed word from a different language.'),
('it', 'The Italian alphabet only has 21 letters.', 'Italian uses a lot of double consonants.', 'The word \"America\" comes from Italian.', 'Italian is the universal language of music, especially classical music.'),
('jp', 'One study showed that Japanese has a spoken syllable rate of nearly 8 syllables per second.', 'There are several ways to say \"I\" in Japanese.', 'Considered to be one of the most unique languages in the world, Japanese is said to have no direct relation to other languages.', 'Japanese has 3 writing systems: kanji, hiragana, and katakana.'),
('kr', 'Many Korean words are of Chinese origin.', 'Korean has two different counting systems -- one of Korean origin and the other of Chinese origin, and each is used in different ways.', 'Koreans often say \"our\" or \"we\" instead of \"my\" or \"me.\"', 'Korean used Chinese characters until 1446 when King Sejong made hangul the official alphabet to increase literacy.'),
('nl', 'Several words in English have Dutch origins, including \"apartheid\", \"bamboo\", \"bazooka\", and \"blink\".', 'Dutch is known for its long compound words.', 'Dutch words often have several consonants in a row.', 'Some Dutch slang words are derived from Hebrew.'),
('no', 'Norwegian is a \"pitch accent\" language, which is similar to tonal languages but tones do not vary per syllable like in tonal languages.', 'Norwegian has a specific word to refer to binge drinking on weekends: \"Helgefylla\".', 'Norwegian has two official forms of written language.', 'There is no word for \"please\" in Norwegian.'),
('pt', 'Portuguese is the official language of nine countries.', 'Portuguese is the fastest-growing European language in the world behind English.', 'Portuguese is heavily influenced by Arabic.', 'Several English words have Portuguese origins, including \"embarrass\", \"cobra,\" and \"fetish\".'),
('ru', 'Russian is the 6th most natively spoken language in the world.', 'In Russian, where the emphasis falls on a word is important in determining its meaning. ', 'Russian names include a patronymic name, which is the father’s name plus the ending -ovich for a son and -ovna for a daughter.', 'The Russian language splits the color blue into two words for dark and light shades. As a result, it’s been found that Russian speakers can distinguish and categorize different shades of blue more accurately than English speakers.');

CREATE TABLE `flags` (
  `image_id` varchar(10) NOT NULL,
  `image_path` varchar(255) NOT NULL
);

INSERT INTO `flags` (`image_id`, `image_path`) VALUES
('cn', 'china-flag.jpg'),
('de', 'germany-flag.jpg'),
('fr', 'france-flag.jpg'),
('it', 'italy-flag.jpg'),
('jp', 'japan-flag.jpg'),
('kr', 'korea-flag.jpg'),
('nl', 'netherlands-flag.jpg'),
('no', 'norway-flag.jpg'),
('pt', 'portugal-flag.jpg'),
('ru', 'russia-flag.jpg');
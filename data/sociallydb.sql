DROP DATABASE IF EXISTS sociallydb;
CREATE DATABASE sociallydb;
USE sociallydb; 


/* Tables creation */

CREATE TABLE company(
  company_name VARCHAR(100) NOT NULL PRIMARY KEY,
  header_title VARCHAR(255) NOT NULL,
  header_desc VARCHAR(255) NOT NULL,
  rights VARCHAR(100) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  phone VARCHAR(100) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE company_developer(
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR (100) NOT NULL,
  `name` VARCHAR (100) NOT NULL,
  surname VARCHAR (100) NOT NULL,
  profession VARCHAR (100) NOT NULL,
  FOREIGN KEY (company_name) REFERENCES company (company_name)
)ENGINE = InnoDB;

CREATE TABLE web_insight(
  field_title VARCHAR (100) NOT NULL PRIMARY KEY,
  company_name VARCHAR (100) NOT NULL,
  field_icon VARCHAR (100) NOT NULL,
  field_desc VARCHAR (255) NOT NULL,
  FOREIGN KEY (company_name) REFERENCES company (company_name)
)ENGINE = InnoDB;

CREATE TABLE `role` (
    role_name VARCHAR (100) NOT NULL PRIMARY KEY
)ENGINE = InnoDB;

CREATE TABLE `user` (
	`user_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  avatar VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  registration_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  email VARCHAR(255) NOT NULL,
  banned BOOLEAN DEFAULT FALSE,
  `rank` VARCHAR (255),
  role_name VARCHAR (100) NOT NULL,
  FOREIGN KEY (role_name) REFERENCES `role` (role_name) ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE `category` (
  category_name VARCHAR (100) NOT NULL PRIMARY KEY,
  `description` TEXT,
  `rules` VARCHAR (255),
  `icon` VARCHAR (50) NOT NULL
)ENGINE = InnoDB;

CREATE TABLE `user_category` (
  `user_id` INT NOT NULL,
  category_name VARCHAR (100) NOT NULL,
  CONSTRAINT PK_UserCategory PRIMARY KEY (`user_id`,category_name),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (category_name) REFERENCES category (category_name) ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE `post` (
	post_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL,
  `user_id` INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  up_votes INT DEFAULT 0,
  down_votes INT DEFAULT 0,
  media_url VARCHAR(2030) DEFAULT null,
  `description` TEXT,
  `datetime` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `total_comments` INT NOT NULL DEFAULT 0,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (category_name) REFERENCES category (category_name) ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE `user_votes_post`(
  `user_id` INT NOT NULL,
  post_id INT NOT NULL,
  is_positive BOOLEAN NOT NULL,
  CONSTRAINT PK_UserVotesPost PRIMARY KEY (`user_id`,post_id),
  FOREIGN KEY (post_id) REFERENCES post (post_id) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE `comment` (
  comment_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  media_url VARCHAR(2030),
  post_id INT,
  `description` TEXT NOT NULL,
  up_votes INT DEFAULT 0,
  down_votes INT DEFAULT 0,
  `datetime` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (post_id) REFERENCES post (post_id) ON DELETE CASCADE
)ENGINE = InnoDB;



/* Data insertion */

/* Company */
INSERT INTO company(company_name,header_title,header_desc,rights,`address`,phone) VALUES (
  "socially",
  "Hi, we are Socially!",
  "Socially is a place to discover and to achieve authentic human connection. Whether you're into music, art, or a never-ending stream of the internet's cutest animals, there's a place here for you.",
  "All rights reserved 2021-2022",
  "30 Milwaukee Drive, 5400. Ohio, United States",
  "807-139-6554"
);
/* Company developer */
INSERT INTO company_developer(`id`,company_name,`name`, surname, profession) VALUES(
  NULL,
  "socially",
  "Anna",
  "Lopez Ribo",
  "Web developer"
);
INSERT INTO company_developer(`id`,company_name,`name`, surname, profession) VALUES(
  NULL,
  "socially",
  "Andres",
  "Dominguez Martinez",
  "Web developer"
);
/* Web insight*/
INSERT INTO web_insight (field_title,company_name,field_icon,field_desc) VALUES(
  "Post",
  "socially",
  "fas fa-edit",
  "The community can share content by posting links and images."
);
INSERT INTO web_insight (field_title,company_name,field_icon,field_desc) VALUES(
  "Comment",
  "socially",
  "fas fa-comments",
  "The community comments on posts. Comments provide discussion and often humor."
);
INSERT INTO web_insight (field_title,company_name,field_icon,field_desc) VALUES(
  "Vote",
  "socially",
  "fas fa-thumbs-up",
  "Posts can be upvoted or downvoted. The latest posts rise to the top."
);

/* Role */
INSERT INTO `role` (role_name) VALUES ('User');
INSERT INTO `role` (role_name) VALUES ('Moderator');
INSERT INTO `role` (role_name) VALUES ('Admin') ;

/* Category */
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('News', 'Curabitur accumsan hendrerit mauris, id dapibus lectus lobortis quis. Cras leo mauris, cursus eget justo at, egestas molestie felis. Pellentesque nec dignissim dui. Maecenas porttitor lectus nunc, id auctor magna laoreet id.', null, 'fas fa-newspaper');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Sports', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sodales ut risus in auctor. Quisque ultricies diam felis, id congue odio mollis at. ', null, 'fas fa-running');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Videos', 'Phasellus luctus, enim dictum eleifend eleifend, lacus orci vulputate turpis, id accumsan nisi neque eget justo. Morbi mattis elementum enim, vitae dictum libero fringilla eu.', null, 'fas fa-video');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Music', 'Mauris urna nulla, placerat sed nisi nec, iaculis consectetur ex. Morbi sagittis imperdiet ante id imperdiet. Etiam egestas fringilla ante sed ultrices. Curabitur fermentum suscipit volutpat.', null, 'fas fa-music');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Photography', 'Donec ornare sit amet odio at semper. Donec pharetra velit massa, quis consequat justo tempor a. Nullam rhoncus lorem ex, a faucibus nibh cursus sed. Suspendisse bibendum odio eros.', null, 'fas fa-photo-video');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Films', 'Phasellus aliquam tortor sit amet nunc pellentesque, et lacinia metus commodo. Curabitur id faucibus sapien.', null, 'fas fa-film');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Animals', 'Pellentesque convallis bibendum diam, quis dignissim neque efficitur at. Sed laoreet at purus placerat imperdiet. In at pellentesque felis.', null, 'fas fa-paw');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Finance', 'In euismod erat ac urna sollicitudin interdum. Pellentesque posuere ultrices nisl eget pretium. Donec libero est, venenatis eget suscipit ut, rutrum sit amet augue. Aliquam non ultrices diam.', null, 'fas fa-landmark');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Gaming', 'Accumsan hendrerit mauris, id dapibus lectus lobortis quis. Cras leo mauris, cursus eget justo at, egestas molestie felis. Pellentesque nec dignissim dui.', null, 'fas fa-gamepad');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Health', 'Maecenas porttitor lectus nunc, id auctor magna laoreet id. Aenean porta erat eu lacus egestas, consectetur pretium ante tempus. Suspendisse eu ultrices metus, vel congue enim.', null, 'fas fa-heartbeat');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Fitness', 'Aliquam suscipit nibh lorem. Etiam ullamcorper maximus porttitor. Nullam et dolor a lorem gravida dignissim. Cras laoreet nunc id lectus blandit, et aliquet neque tempus.', null, 'fas fa-dumbbell');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Science', 'Nam aliquam dolor dolor, semper iaculis lorem dignissim quis. Curabitur nec maximus libero, eget pretium turpis. Maecenas ut lobortis eros. Nullam odio justo, tempus sed tortor laoreet, lobortis dictum urna.', null, 'fas fa-flask');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Art', 'Suspendisse in semper lectus, sit amet laoreet massa. Quisque arcu odio, egestas in nulla sit amet, porttitor cursus justo. Vestibulum porttitor maximus nibh, eu iaculis ante accumsan ac.', null, 'fas fa-palette');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Food', 'Aliquam vulputate tellus et lacus dictum iaculis ac at massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam magna nisl, interdum in vestibulum eget, auctor non velit.', null, 'fas fa-hamburger');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Humor', 'Suspendisse bibendum, lacus quis laoreet sollicitudin, ex libero semper dui, ut posuere erat neque eget diam. Duis nisi tortor, porttitor id ornare non, blandit sit amet lorem.', null, 'fas fa-grin-squint');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Shows', 'Phasellus et augue ligula. Sed eu condimentum leo, sit amet consectetur dolor. Nulla eu ligula congue sapien imperdiet pretium. Nunc vitae feugiat libero. Nulla nec facilisis magna, eget eleifend est.', null, 'fab fa-youtube');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Tech', 'Quisque orci odio, volutpat sit amet ipsum sed, elementum auctor lorem. Vivamus laoreet ultrices lectus eget rhoncus. Suspendisse blandit lacus dapibus nibh ornare rhoncus.', null, 'fas fa-mobile-alt');
INSERT INTO `category` (category_name, `description`, rules, `icon`) 
VALUES ('Books', 'Praesent scelerisque justo felis, ac tempus erat imperdiet et. Maecenas convallis erat eu augue varius mattis. Proin congue eros non diam fermentum congue.', null, 'fas fa-book-open');

/* User (16 users) */

/* Easy to remember Users (4) */
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name)  
VALUES (null, 'user1', 'avatar_1.png', '$2y$12$elcRFvbdETWXC.D5nB.w7.0Wia.qPcVVoVg6x8bTzlQU2Wg11H.fm', 'user1@gmail.com', FALSE, 'Beginner', 'User');
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name)  
VALUES (null, 'user2', 'avatar_2.png', '$2y$12$BUYBjyRI57kNxe2S4fN1uOO.chVp7jZx9s3qcUhd5Wyl8JblFuK1.', 'user2@gmail.com', FALSE, 'Beginner', 'User');
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name)  
VALUES (null, 'user3', 'avatar_3.png', '$2y$12$Ndnd0CK0Z4UNs0HXGMUQ2uP06zuWY/c3G3QDLDE0q1msxeLnjZwle', 'user3@gmail.com', TRUE, 'Beginner', 'User');
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name)  
VALUES (null, 'user4', 'avatar_4.png', '$2y$12$hY/VmSHAkOqdHqkHCmNDi.j4.kEfNHoUDUCceI2XTOPz6/cB6XEeK', 'user4@gmail.com', FALSE, 'Beginner', 'User');

/* Administrators (2) */
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'socially1', 'avatar_9.png', '$2y$12$Srh.tnnElrD3hlmOM3OWMuh1jEm9crJ6kX5ckvhHP8md4.sA5XC7G', 'socially1@gmail.com',FALSE, 'Administration', 'Admin');
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'socially2', 'avatar_10.png', '$2y$12$nMXAotb2F3Q/JOcsXgwjtei4EQVhBPF7uZQgEcIQQiebPQ9o1VIZm', 'socially2@gmail.com',FALSE, 'Administration', 'Admin');

/* Users (10)*/
INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'osijmons0','avatar_1.png', '$2y$12$jmnrqZdyvAdgQ0BULDJzHeBlj.1ju/LJLXtG3LlpmssQevKhZyZFa', 'schippendale0@gmail.com',TRUE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'jjeannesson1', 'avatar_2.png','$2y$12$.b9a22OcoM9uzB2BauOPNeA.u4kjAhpXTmxmxgeDWC0Jy0GqOW.fq', 'radrien1@springer.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'cgrubey2', 'avatar_3.png', '$2y$12$R2WCLf12aROSNWmH3o2rjedADSHSnmOl6nyccjDOqAJdORej2HO/.', 'gmacaree2@icq.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'tcaulwell3', 'avatar_4.png', '$2y$12$Ze85pTGQSotxGMJEQM4rROJQvcVMKmzRD60e1FyuSttpnyB0m7evG', 'anott3@stumbleupon.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'tscantlebury4', 'avatar_5.png', '$2y$12$g2XxY2gxuaz2xeQlheKDNuMBqg4kQm3YawlpF.dIqE0oewv.j44S6', 'sbroxis4@jiathis.com',TRUE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'crigbye5', 'avatar_6.png', '$2y$12$WgYSN6fQUfrdE7jsQTPiV.5pbx0P2haTyfQ9itudBFwRadI2PtesW', 'sdalwood5@omniture.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'jtruran6', 'avatar_7.png', '$2y$12$GJa/NaDWiNobjmqirtnGuegV66ZdXuOHZVvIKYuMysjc79WKmN2Z6', 'agourley6@wunderground.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'vbullimore7', 'avatar_8.png', '$2y$12$/T8DPkIEOUvgM3eBhnuzZOT45Nv50ZSHarJCx6K8/z4veP4hPwKQ.', 'cwhaymand7@scientificamerican.com',FALSE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'tmatkin8', 'avatar_4.png','$2y$12$25t9Wi9z.42Rrl0rLc4NmuXkSyvUZ21VSl1ufkjDAEjvX5dSERhnK', 'nellum8@tiny.cc',TRUE, 'Beginner', 'User');

INSERT INTO `user` (`user_id`, username, avatar, `password`, email, banned, `rank`, role_name) 
values (null, 'wbeany9', 'avatar_6.png', '$2y$12$RBnvmeyNZxWjIK7OkKPoiucLzNDD5Chws8WDCdJzp5ocZBsnCktEu', 'korrick9@statcounter.com',FALSE, 'Beginner', 'User');




/* User_Category ( users) */

-- User 1
INSERT INTO `user_category` (`user_id`, category_name) VALUES (1, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (1, 'Books');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (1, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (1, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (1, 'Fitness');
-- User 2
INSERT INTO `user_category` (`user_id`, category_name) VALUES (2, 'Art');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (2, 'Food');
-- User 3
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'Gaming');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'Music');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'News');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (3, 'Photography');
-- User 4
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Art');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Books');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Fitness');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Gaming');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Music');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'News');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Photography');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Science');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Shows');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Sports');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Tech');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (4, 'Videos');
-- User 5 
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Art');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Books');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Fitness');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Gaming');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Music');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'News');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Photography');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Science');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Shows');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Sports');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Tech');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (5, 'Videos');
-- User 6
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Art');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Books');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Fitness');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Gaming');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Music');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'News');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Photography');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Science');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Shows');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Sports');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Tech');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (6, 'Videos');
-- User 7
INSERT INTO `user_category` (`user_id`, category_name) VALUES (7, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (7, 'Finance');
-- User 8
INSERT INTO `user_category` (`user_id`, category_name) VALUES (8, 'Fitness');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (8, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (8, 'Music');
-- User 9
INSERT INTO `user_category` (`user_id`, category_name) VALUES (9, 'Photography');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (9, 'Sports');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (9, 'Tech');
-- User 10
INSERT INTO `user_category` (`user_id`, category_name) VALUES (10, 'Books');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (10, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (10, 'News');
-- User 11
INSERT INTO `user_category` (`user_id`, category_name) VALUES (11, 'Sports');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (11, 'Tech');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (11, 'Videos');
-- User 12
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Art');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Gaming');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (12, 'Health');
-- User 13
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Finance');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Fitness');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Humor');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (13, 'Photography');
-- User 14
INSERT INTO `user_category` (`user_id`, category_name) VALUES (14, 'Food');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (14, 'Health');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (14, 'Photography');
-- User 15
INSERT INTO `user_category` (`user_id`, category_name) VALUES (15, 'Animals');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (15, 'Videos');
-- User 16
INSERT INTO `user_category` (`user_id`, category_name) VALUES (16, 'Films');
INSERT INTO `user_category` (`user_id`, category_name) VALUES (16, 'Fitness');

/* Posts */

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Animals', 1, 'Innovate interactive communities', 0, 0, '61bb9d4d0cda4_halloween.png', '<p>Amet consectetuer adipiscing elit proin interdum mauris non ligula pellentesque ultrices phasellus id sapien in sapien iaculis congue vivamus metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus<br data-mce-bogus="1"></p>', '2021-10-19 13:06:43', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Animals', 4, 'Seamless composite hierarchy', 0, 0, '61bba804981da_animals2.jpeg', null, '2021-11-01 16:00:01', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Gaming', 8, 'Drive wireless paradigms', 0, 0, '61bba8c07448b_nameagame.jpg', null, '2021-12-01 18:25:16', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Art', 8, 'Benchmark seamless users', 0, 0, '61bbaa15e9eaf_summertime.jpg', null, '2021-11-22 00:21:48', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Films', 9, 'Implement efficient architectures', 0, 0, '61bbab5bb481b_spencermovie.png', '<p>Nam aliquam dolor dolor, semper iaculis lorem dignissim quis. Curabitur nec maximus libero, eget pretium turpis. Maecenas ut lobortis eros. Nullam odio justo, tempus sed tortor laoreet, lobortis dictum urna. <em>Suspendisse in semper lectus</em>, sit amet laoreet massa. Quisque arcu odio, egestas in nulla sit amet, porttitor cursus justo. </p><p>Vestibulum porttitor <span style="text-decoration: underline;" data-mce-style="text-decoration: underline;">maximus nibh</span>, eu iaculis ante accumsan ac. Aliquam vulputate tellus et lacus dictum iaculis ac at massa. Interdum et malesuada fames ac ante ipsum primis in faucibus.<br data-mce-bogus="1"></p>', '2021-11-03 01:16:01', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'News', 9, 'Maximize cross-platform functionalities', 0, 0, null, '<p>Phasellus et augue ligula. Sed eu condimentum leo, sit amet consectetur dolor. Nulla eu ligula congue sapien imperdiet pretium. Nunc vitae feugiat libero. Nulla nec facilisis magna, eget eleifend est. Quisque orci odio, volutpat sit amet ipsum sed, elementum auctor lorem. Vivamus laoreet ultrices lectus eget rhoncus. Suspendisse blandit lacus dapibus nibh ornare rhoncus. Praesent scelerisque justo felis, ac tempus erat imperdiet et. Maecenas convallis erat eu augue varius mattis. Proin congue eros non diam fermentum congue. Sed rutrum justo viverra, cursus ante non, venenatis mi. Morbi vel malesuada eros. Mauris pellentesque non justo ut fringilla. Nullam id leo pulvinar, commodo lorem a, pellentesque velit. In varius, turpis placerat faucibus efficitur, leo turpis tempor ligula, id consectetur orci leo non mi.</p><p>Phasellus sit amet diam et nibh tincidunt sodales. Aliquam pellentesque volutpat nisl, at tristique sapien. Quisque molestie, leo a egestas lobortis, nisi eros tincidunt lectus, in scelerisque velit mi in quam. In hac habitasse platea dictumst. </p><p>Fusce at augue ac nisi ullamcorper elementum maximus vel ipsum. Duis ornare turpis a purus feugiat tincidunt. Sed vel erat elementum, euismod tellus sit amet, dictum eros.</p>', '2021-10-19 19:16:01', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Shows', 10, 'Incentivize viral convergence', 0, 0, '61bbae9135c77_thewitcher.png', '<p>Cras gravida, est ut dignissim pulvinar, risus purus sodales justo, quis finibus velit arcu vel metus. Proin nec egestas purus, a interdum urna. Sed ut egestas neque.&nbsp;<br data-mce-bogus="1"></p>', '2021-10-31 09:30:38', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Music', 10, 'Deliver granular relationships', 0, 0, '61bbafb1dd0da_orangutan-music.png', '<p>Faucibus orci luctus et ultrices posuere <span style="text-decoration: underline;" data-mce-style="text-decoration: underline;">cubilia curae </span>duis faucibus<br data-mce-bogus="1"></p>', '2021-10-30 04:08:43', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Humor', 10, 'Maximize open-source networks', 0, 0, '61bbb04770302_meme2.jpeg', 'Mattis pulvinar nulla pede ullamcorper augue a suscipit nulla elit ac nulla sed vel enim sit amet nunc', '2021-10-24 18:37:43', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Humor', 12, 'Digitized radical strategy', 0, 0, '61bbb0f24f9f1_mlordmlady.jpg', null, '2021-10-24 14:17:03', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Sports', 12, 'Reintermediate proactive applications', 0, 0, '61bbb1d764f08_miamigame.png', '<p>Phasellus et augue ligula. Sed eu condimentum leo, sit amet consectetur dolor. Nulla eu ligula congue sapien imperdiet pretium. Nunc vitae feugiat libero. </p><p>Nulla nec facilisis magna, eget eleifend est. Quisque orci odio, volutpat sit amet ipsum sed, elementum auctor lorem. Vivamus laoreet ultrices lectus eget rhoncus. Suspendisse blandit lacus dapibus nibh ornare rhoncus. </p><p>Praesent scelerisque justo felis, ac tempus erat imperdiet et. Maecenas convallis erat eu augue varius mattis. Proin congue eros non diam fermentum congue. Sed rutrum justo viverra, cursus ante non, venenatis mi. Morbi vel malesuada eros. Mauris pellentesque non justo ut fringilla. Nullam id leo pulvinar, commodo lorem a, pellentesque velit. In varius, turpis placerat faucibus efficitur, leo turpis tempor ligula, id consectetur orci leo non mi.<br data-mce-bogus="1"></p>', '2021-10-18 17:56:33', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Fitness', 2, 'Innovate sexy architectures', 0, 0, '61bb9ef1db641_emotionaldoggo.jpg', null, '2021-10-17 11:58:13', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Books', 13, 'Aggregate distributed synergies', 0, 0, '61bbb35a7a0d4_annefrank.png', '<p><em>Cras gravida, est ut dignissim pulvinar, risus purus sodales justo, quis finibus velit arcu vel metus. Proin nec egestas purus, a interdum urna. Sed ut egestas neque. Duis et lacinia nisi. Nulla pellentesque leo justo, nec rhoncus ante vestibulum et. Duis eget blandit nunc. Pellentesque tincidunt odio vitae mi pellentesque vulputate. Phasellus vulputate in tellus in tristique. Aenean viverra nisl nec lectus egestas semper. Fusce purus sem, ullamcorper a vestibulum ut, sodales a neque. In sit amet sagittis mi, eu fringilla diam. Fusce diam quam, ullamcorper eget fringilla et, varius sit amet leo. Aliquam erat volutpat. Etiam libero eros, vestibulum et augue quis, facilisis condimentum nisi. Curabitur mi est, porttitor quis ornare convallis, sollicitudin in libero. Sed aliquet orci enim, vel scelerisque metus hendrerit ac.</em></p><p><br></p><p><em>Suspendisse dictum hendrerit mattis. Donec lacinia nunc a dictum eleifend. Pellentesque non libero non metus vestibulum maximus. Nulla ut metus sollicitudin, feugiat tellus rutrum, consequat augue. Praesent ut ultricies diam, ut consequat libero. Donec a enim mattis, suscipit nisi at, efficitur neque. Mauris justo nibh, aliquam sed convallis vitae, iaculis id dolor. Aliquam erat volutpat. Donec vehicula maximus euismod.</em></p>', '2021-10-02 16:42:09', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
values (null, 'Finance', 13, 'Embrace collaborative applications', 0, 0, '61bbb44904277_financestats.png', '<p>Proin a feugiat ipsum. Nulla placerat semper nunc eget congue. Vivamus commodo nibh ornare, eleifend purus vitae, vestibulum augue. Sed porttitor viverra aliquet. </p><ul><li>Aliquam rhoncus libero eget ipsum molestie hendrerit. Vestibulum vel maximus sem. Donec a condimentum eros. Cras a fermentum mi. Nullam a fermentum est. </li><li>Curabitur commodo efficitur neque, accumsan aliquet ante dictum ut. </li></ul><p>Nulla non purus in lectus maximus volutpat et sit amet nibh. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>', '2021-10-24 05:15:19', 0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
VALUES (null, 'Food', 14, 'Fundamental discrete moderator', 0, 0,'61bbb597eff08_orangutan-food.png', null, '2021-12-15',0);

INSERT INTO `post` (post_id, category_name, `user_id`, title, up_votes, down_votes, media_url, `description`, `datetime`,`total_comments`)
VALUES (null, 'Sports', 14, 'Fully-configurable 4th generation support', 0, 0,'61bbb6ba3d3bd_2021-12-02 18_41_09-animalia - my life by rambo - part 2 - youtube.png', '<p>Suspendisse fringilla auctor turpis, vitae iaculis nisi semper sed. In orci justo, pulvinar eu sollicitudin nec, dignissim et erat. Mauris suscipit mauris in diam malesuada, semper pretium est lobortis.<br data-mce-bogus="1"></p>', '2021-10-03',0);

/* Triggers */
DELIMITER //
CREATE TRIGGER add_post_total_comments
AFTER INSERT 
ON `comment` FOR EACH ROW 
BEGIN
    UPDATE `post` 
    SET total_comments = (total_comments +1)
    WHERE post_id = new.post_id;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER substract_post_total_comments
AFTER DELETE 
ON `comment` FOR EACH ROW 
BEGIN
    UPDATE `post` 
    SET total_comments = (total_comments -1)
    WHERE post_id = old.post_id;
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER add_post_votes
AFTER INSERT 
ON user_votes_post FOR EACH ROW 
BEGIN
	 DECLARE isPositive BOOLEAN;
  	 SET isPositive = NEW.is_positive;
  	 IF (isPositive) THEN
  		UPDATE `post` 
     	SET up_votes = up_votes +1
   	WHERE post_id = new.post_id;
  	 ELSE
  	 	UPDATE `post` 
     	SET down_votes = down_votes +1
   	WHERE post_id = new.post_id;
  	 END IF;
   
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER substract_post_votes
AFTER DELETE 
ON user_votes_post FOR EACH ROW 
BEGIN
	 DECLARE isPositive BOOLEAN;
  	 SET isPositive = old.is_positive;
  	 IF (isPositive) THEN
  		UPDATE `post` 
     	SET up_votes = up_votes -1
   	WHERE post_id = old.post_id;
  	 ELSE
  	 	UPDATE `post` 
     	SET down_votes = down_votes -1
   	WHERE post_id = old.post_id;
  	 END IF;
   
END//
DELIMITER ;

DELIMITER //
CREATE TRIGGER modify_post_votes
AFTER UPDATE 
ON user_votes_post FOR EACH ROW 
BEGIN
	 DECLARE isPositive BOOLEAN;
  	 SET isPositive = new.is_positive;
  	 IF (isPositive) THEN
  		UPDATE `post` 
     	SET up_votes = (up_votes +1 ), down_votes = (down_votes -1 )
   	WHERE post_id = new.post_id;
  	 ELSE	 
  	 	UPDATE `post` 
     	SET up_votes = (up_votes -1 ), down_votes = (down_votes +1 )
   	WHERE post_id = new.post_id;
  	 END IF;
   
END//
DELIMITER ;

/* Views */

CREATE VIEW V_AboutUs_company AS
SELECT * FROM company;

CREATE VIEW V_AboutUs_developers AS
SELECT * FROM company_developer WHERE company_name='socially';
 
CREATE VIEW V_AboutUs_web AS
SELECT * FROM web_insight WHERE company_name='socially';

CREATE VIEW V_AdminDashboard_stats AS
SELECT COUNT(*) AS admin_stats FROM user 
UNION
SELECT COUNT(*) AS total_posts FROM post
UNION
SELECT COUNT(*) AS total_comments FROM comment
UNION
SELECT COUNT(*) AS total_upvotes FROM user_votes_post WHERE is_positive=1
UNION 
SELECT COUNT(*) AS total_downvotes FROM user_votes_post WHERE is_positive=0;


/* Comment */
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 1 , null, 1, 'Where banana', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 7 , null, 2, 'So cute!!', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 4 , null, 3, 'The witch dog is in town', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 3 , null, 4, 'Doggo ipsum long bois tungg woofer boof he made many woofs, floofs extremely cuuuuuute wow very biscit. What a nice floof shibe super chub ruff, what a nice floof. Bork the neighborhood pupper big ol mlem, big ol. Very jealous pupper wow such tempt big ol sub woofer heckin good boys and girls wow such tempt, pupper super chub snoot long bois vvv, shibe stop it fren extremely cuuuuuute boof. Adorable doggo vvv h*ck wow very biscit h*ck, bork blop stop it fren. Long water shoob blop the neighborhood pupper doing me a frighten floofs doge heck, you are doin me a concern floofs porgo heckin good boys and girls shoob, you are doing me a frighten ruff floofs most angery pupper I have ever seen sub woofer. Woofer tungg fat boi you are doing me a frighten pats fluffer, borkf length boy heckin.', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 5 , null, 5, 'Doggo ipsum long bois tungg woofer boof he made many woofs, floofs extremely cuuuuuute wow very biscit. What a nice floof shibe super chub ruff, what a nice floof. Bork the neighborhood pupper big ol mlem, big ol. Very jealous pupper wow such tempt big ol sub woofer heckin good boys and girls wow such tempt, pupper super chub snoot long bois vvv', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 6 , null, 1, 'Doggo ipsum long bois tungg woofer boof he made many woofs, floofs extremely cuuuuuute wow very biscit. What a nice floof shibe super chub ruff, what a nice floof. Bork the neighborhood pupper big ol mlem, big ol. Very jealous pupper wow such tempt big ol sub woofer heckin good boys and girls wow such tempt, pupper super chub snoot long bois vvv', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 7 , null, 6, 'Doggo ipsum long bois tungg woofer boof he made many woofs, floofs extremely cuuuuuute wow very biscit. What a nice floof shibe super chub ruff, what a nice floof. Bork the neighborhood pupper big ol mlem, big ol. Very jealous pupper wow such tempt big ol sub woofer heckin good boys and girls wow such tempt, pupper super chub snoot long bois vvv', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 8 , null, 6, 'My first comment!', 0, 0);
INSERT INTO `comment` (comment_id, `user_id`, media_url, post_id, `description`, up_votes, down_votes) 
VALUES (null, 9 , null, 7, 'This is the wrong category for this!', 0, 0);


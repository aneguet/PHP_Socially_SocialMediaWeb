
DROP TABLE web_insight;
DROP TABLE company_developer;
DROP TABLE company;
DROP TABLE user_votes_post; 
DROP TABLE user_category;  


-- FKs

ALTER TABLE `user` DROP FOREIGN KEY user_ibfk_1;
ALTER TABLE `post` DROP FOREIGN KEY post_ibfk_2;
ALTER TABLE `comment` DROP FOREIGN KEY comment_ibfk_1;

DROP TABLE `role`; 
DROP TABLE category; 
DROP TABLE comment;
DROP TABLE post;
DROP TABLE `user`;

-- Views
Drop VIEW V_AdminDashboard_stats;
Drop VIEW V_AboutUs_company;
Drop VIEW V_AboutUs_developers;
Drop VIEW V_AboutUs_web;

-- Triggers

DROP TRIGGER add_post_total_comments;
DROP TRIGGER substract_post_total_comments;
DROP TRIGGER add_post_votes;
DROP TRIGGER substract_post_votes;
DROP TRIGGER modify_post_votes;
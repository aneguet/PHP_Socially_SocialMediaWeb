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
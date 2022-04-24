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
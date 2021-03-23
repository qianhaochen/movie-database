SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

USE movie_lens;
CREATE TABLE IF NOT EXISTS `movies` (
  `mov_id` INT UNSIGNED,
  `mov_title` VARCHAR(100) NOT NULL,
  `gen_name` VARCHAR(200) NOT NULL,
   PRIMARY KEY ( `mov_id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/movies.csv' INTO TABLE movies
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


CREATE TABLE IF NOT EXISTS`genres` (
  `gen_id` INT UNSIGNED,
  `gen_name` VARCHAR(45) NOT NULL,
   PRIMARY KEY ( `gen_id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/genres.csv' INTO TABLE genres
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


CREATE TABLE IF NOT EXISTS `moviesGenresRelation` (
  `mov_id` INT UNSIGNED,
  `genre_id` INT UNSIGNED,
  FOREIGN KEY (mov_id) REFERENCES movies(mov_id),
  FOREIGN KEY (genre_id) REFERENCES genres(gen_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/mgrelation.csv' INTO TABLE moviesGenresRelation
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `userCorrelation` (
  `user_1` INT UNSIGNED 
  `user_2` INT UNSIGNED 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `noRatingUserMovie` (
  `user_id` INT UNSIGNED 
  `mov_id` INT UNSIGNED 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/users.csv' INTO TABLE users
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


CREATE TABLE IF NOT EXISTS `ratings` (
  `user_id` INT UNSIGNED,
  `mov_id` INT UNSIGNED,
  `rating` DECIMAL(2,1),
  `timestamp` TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),FOREIGN KEY (mov_id) REFERENCES movies(mov_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/ratings.csv' INTO TABLE ratings
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
(@user_id, @mov_id, @rating, @timestamp)
SET
user_id = @user_id,
mov_id = @mov_id,
rating = @rating,
`timestamp` = FROM_UNIXTIME(@timestamp);


CREATE TABLE IF NOT EXISTS `tags` (
  `user_id` INT UNSIGNED,
  `mov_id` INT UNSIGNED,
  `tag` VARCHAR(255) NOT NULL,
  `time` TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (mov_id) REFERENCES movies(mov_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/tags.csv' INTO TABLE tags
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
(@user_id, @mov_id, @tag, @timestamp)
SET
user_id = @user_id,
mov_id = @mov_id,
tag = @tag,
`time` = FROM_UNIXTIME(@timestamp);


CREATE TABLE IF NOT EXISTS `links` (
`mov_id` INT UNSIGNED,
`imdb_id` INT UNSIGNED,
`tmdb_id` INT UNSIGNED,
FOREIGN KEY (mov_id) REFERENCES movies(mov_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/links.csv' INTO TABLE links
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';

CREATE TABLE IF NOT EXISTS `ugrelation` (
`user_id` INT UNSIGNED,
`gen_id` INT UNSIGNED,
`count` INT UNSIGNED,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (gen_id) REFERENCES genres(gen_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOAD DATA LOCAL INFILE '/var/lib/mysql/movie_lens/ml-latest-small/ugrelation.csv' INTO TABLE ugrelation
CHARACTER SET 'utf8'
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';

alter table users 
add n_rating INT UNSIGNED default 0,
add avg_rating DECIMAL(3,2),
add n_tag INT UNSIGNED default 0;

with table1(id,n) as (SELECT user_id, COUNT(rating)
                FROM ratings
                GROUP BY user_id)
update users,table1
set users.n_rating = table1.n
where users.id = table1.id;

with table1(id,n) as (SELECT user_id, round(AVG(rating),2)
                FROM ratings
                GROUP BY user_id)
update users,table1
set users.avg_rating = table1.n
where users.id = table1.id;

with table1(id,n) as (SELECT user_id, COUNT(tag)
                FROM tags
                GROUP BY user_id)
update users,table1
set users.n_tag = table1.n
where users.id = table1.id;

INSERT INTO users
  (id, n_rating, avg_rating, n_tag)
VALUES
  (0, 0, 0, 0);


INSERT INTO `userCorrelation` (user_1,user_2)
SELECT user_covariance_1.user_1, user_covariance_1.user_2, user_covariance_1.pd/SQRT(user_covariance_2.pd*user_covariance_3.pd) AS corr FROM
(SELECT user_1, user_2, sum(product) AS pd
FROM
(SELECT ratings_.user_id AS user_1, ratings_1.user_id AS user_2, ratings_.rating*ratings_1.rating as product
FROM (SELECT mov_id,user_id,rating FROM ratings) AS ratings_
INNER JOIN
(SELECT mov_id,user_id,rating FROM ratings) AS ratings_1
ON ratings_.mov_id=ratings_1.mov_id) as rr
GROUP BY user_1, user_2
 ) AS user_covariance_1
INNER JOIN (SELECT user_1, user_2, sum(product) AS pd
FROM
(SELECT ratings_.user_id AS user_1, ratings_1.user_id AS user_2, ratings_.rating*ratings_1.rating as product
FROM (SELECT mov_id,user_id,rating FROM ratings) AS ratings_
INNER JOIN
(SELECT mov_id,user_id,rating FROM ratings) AS ratings_1
ON ratings_.mov_id=ratings_1.mov_id) as rr
GROUP BY user_1, user_2
 ) AS user_covariance_2
ON user_covariance_1.user_1=user_covariance_2.user_1 AND user_covariance_1.user_1=user_covariance_2.user_2
INNER JOIN (SELECT user_1, user_2, sum(product) AS pd
FROM
(SELECT ratings_.user_id AS user_1, ratings_1.user_id AS user_2, ratings_.rating*ratings_1.rating as product
FROM (SELECT mov_id,user_id,rating FROM ratings) AS ratings_
INNER JOIN
(SELECT mov_id,user_id,rating FROM ratings) AS ratings_1
ON ratings_.mov_id=ratings_1.mov_id) as rr
GROUP BY user_1, user_2
 ) AS user_covariance_3
ON user_covariance_1.user_2=user_covariance_3.user_1 AND user_covariance_1.user_2=user_covariance_3.user_2;




CREATE TABLE IF NOT EXISTS `releaseSoonMovies`(
SELECT mov_id, mov_title from movies ORDER by rand() limit 50
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `userMovieNotRated` (user_id,mov_id)
SELECT users.user_id, movs.mov_id 
FROM (SELECT DISTINCT user_id, 1 AS joiner FROM ratings) users 
INNER JOIN (SELECT mov_id, 1 AS joiner FROM releaseSoonMovies) movs 
ON users.joiner=movs.joiner 
LEFT JOIN (SELECT user_id,mov_id,rating from ratings ) AS all_ratings 
ON users.user_id=all_ratings.user_id AND movs.mov_id=all_ratings.mov_id 
WHERE all_ratings.user_id is NULL AND all_ratings.mov_id is NULL;

CREATE TABLE IF NOT EXISTS `predictedRatings`(
SELECT userMovieNotRated.user_id,userMovieNotRated.mov_id, 
aves_target.avg_rating + SUM((ratings.rating-aves.avg_rating)*userCorrelation.corr)/ SUM(corr) 
AS prediction 
FROM ratings, userCorrelation, userMovieNotRated,
(SELECT user_id, AVG(rating) AS avg_rating FROM ratings GROUP BY user_id) 
AS aves, 
(SELECT user_id, AVG(rating) AS avg_rating FROM ratings GROUP BY user_id) 
AS aves_target
WHERE ratings.mov_id =userMovieNotRated.mov_id 
AND userMovieNotRated.mov_id IN (SELECT mov_id FROM releaseSoonMovies) 
AND ratings.user_id = aves.user_id 
AND userCorrelation.user_1 = ratings.user_id 
AND userCorrelation.user_2 = userMovieNotRated.user_id 
AND aves_target.user_id = userMovieNotRated.user_id 
GROUP BY userMovieNotRated.user_id, userMovieNotRated.mov_id
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `shrekTestPred` (
SELECT userMovieNotRated.user_id,userMovieNotRated.mov_id, 
aves_target.avg_rating + SUM((ratings.rating-aves.avg_rating)*userCorrelation.corr)/ SUM(corr) 
AS prediction 
FROM ratings, userCorrelation, (SELECT user_id,mov_id FROM
ratings 
WHERE mov_id = 4306 AND user_id < 150) AS userMovieNotRated,
(SELECT user_id, AVG(rating) AS avg_rating FROM ratings  WHERE NOT (mov_id = 4306 AND user_id < 150)
GROUP BY user_id) AS aves, 
(SELECT user_id, AVG(rating) AS avg_rating FROM ratings  WHERE NOT (mov_id = 4306 AND user_id < 150)
GROUP BY user_id) 
AS aves_target
WHERE ratings.mov_id =userMovieNotRated.mov_id 
AND userMovieNotRated.mov_id IN (SELECT mov_id FROM releaseSoonMovies WHERE mov_id = 4306) 
AND ratings.user_id = aves.user_id 
AND userCorrelation.user_1 = ratings.user_id 
AND userCorrelation.user_2 = userMovieNotRated.user_id 
AND aves_target.user_id = userMovieNotRated.user_id 
GROUP BY userMovieNotRated.user_id, userMovieNotRated.mov_id
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

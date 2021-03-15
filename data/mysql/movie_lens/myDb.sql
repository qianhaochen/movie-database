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

with table1(id,n) as (SELECT user_id, AVG(rating)
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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

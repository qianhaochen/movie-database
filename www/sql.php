<?php

// most popular top 10
include('fn_display.php');
$sql_query = 'SELECT movies.mov_id, movies.mov_title, COUNT(ratings.rating)
FROM ratings, movies
WHERE movies.mov_id = ratings.mov_id
GROUP BY movies.mov_id
ORDER BY COUNT(ratings.rating) DESC LIMIT 10';
$col_arr = array('ID', 'Movie Title', 'Views');
display_sql($sql_query, $col_arr);

// top rated top 10
$sql_query = 'SELECT movies.mov_id, movies.mov_title, AVG(ratings.rating)
FROM ratings, movies
WHERE movies.mov_id = ratings.mov_id
GROUP BY movies.mov_id
ORDER BY AVG(ratings.rating) DESC LIMIT 10';
$col_arr = array('ID', 'Movie Title', 'Average Ratings');
display_sql($sql_query, $col_arr);
<?php

include('fn_display.php');
$sql_query = 'SELECT mov_id, AVG(rating)
FROM ratings
GROUP BY mov_id
ORDER BY AVG(rating) DESC';
$col_arr = array('ID', 'Average Ratings');
display_sql($sql_query, $col_arr);

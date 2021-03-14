<?php

include('fn_display.php');
$sql_query = 'SELECT mov_id, COUNT(rating)
FROM ratings
GROUP BY mov_id
ORDER BY COUNT(rating) DESC';
$col_arr = array('ID', 'Views');
display_sql($sql_query, $col_arr);

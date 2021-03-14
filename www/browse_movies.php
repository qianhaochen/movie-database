<?php

include('fn_display.php');
$sql_query='SELECT * From movies';
$col_arr = array('ID', 'Movie Title', 'Genres');
display_sql($sql_query, $col_arr);
echo '</table>';
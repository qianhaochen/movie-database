<?php

include('fn_display.php');

function ratings_count_sql($mov_id) {
    $sql_query_ratings_count = "SELECT rating, COUNT(DISTINCT user_id) AS number FROM ratings WHERE mov_id = ".$mov_id." GROUP BY rating ORDER BY rating DESC";
    return $sql_query_ratings_count;
}

function tags_count_sql($mov_id) {
    $sql_query_tags_count = "SELECT tag, COUNT(DISTINCT user_id) AS number FROM tags WHERE mov_id = ".$mov_id." GROUP BY tag ORDER BY number DESC";
    return $sql_query_tags_count;
}

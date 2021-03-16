<?php
function search_sql($sql_query) {

    if (!isset($_GET['query'])) {
        $query = "";
    } else {
        $query = $_GET["query"];
        echo $query;
    }
    
    
    $min_length = 0;
    
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
        $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
        $query = htmlspecialchars($query); // changes characters used in html to their equivalents, for example: < to &gt;
        $query = mysqli_real_escape_string($conn, $query); // makes sure nobody uses SQL injection
        mysqli_close($conn);
    
        $sql_query = "SELECT * FROM movies 
                    WHERE (movies.mov_title LIKE '%".$query."%')
                    OR (movies.gen_name LIKE '%".$query."%')";
        
        return $sql_query;

    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }

}
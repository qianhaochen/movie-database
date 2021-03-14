<form action="search.php" method="GET">
    <input type="text" name="query" />
    <input type="submit" value="Search" />
</form>

<?php
function search_sql($sql_query, $col_arr) {
    include('fn_display.php');

    if (!isset($_GET['query'])) {
        $query = "";
        echo "Search keywords"; //Your code here
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

        display_sql($sql_query, $col_arr);
    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }

}
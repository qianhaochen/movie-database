<form action="home.php" method="GET">
    <div class="input-group">
        <input type="text" name="query" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
            <datalist id="datalistOptions">
                <option value="Drama">
                <option value="Comedy">
                <option value="Family">
                <option value="Sci-Fi">
                <option value="Romance">
            </datalist>
        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
        <input type="submit" value="Search" class="btn btn-outline-secondary" />
    </div>
</form>

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

        //display_sql($sql_query, $col_arr);
    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }

}

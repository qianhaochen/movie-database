<?php 

function menu_dropdown($sql_query) {
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
    $result = mysqli_fetch_array(mysqli_query($conn, $sql_query));

    while ($rows = mysql_fetch_array($result)) {
        echo "<a class='dropdown-item' href='#'>" .$rows['gen_name']. "</a>";
    }
}


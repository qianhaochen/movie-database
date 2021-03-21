<head>
        <meta charset="utf-8">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<?php
function display_sql($sql_query, $col_arr) {
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

    echo '<table class="table table-hover" table-striped">';

    echo '<thead><tr><th></th>';
    foreach ($col_arr as &$value) {
        echo '<th>' . $value . '</th>';
    }
    unset($value);
    echo '</tr></thead>';
    
    while($value = $result->fetch_array(MYSQLI_NUM)){
        echo '<tr>';
        echo '<td><a href="/details.php?mov='.$value[0].'"><span class="glyphicon glyphicon-search">';
        echo '<i class="bi bi-info-circle"></i>'; // search icon of Bootstrap Icons
        echo '</span></a></td>';
        for($i=1; $i<count($value); $i++){
            echo '<td>' . $value[$i] . '</td>';
        }
        

        echo '</tr>';
    }
    echo '</table>';
    
    $result->close();
    mysqli_close($conn);
}

function display_sql_stbr($sql_query, $col_arr) {
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

    echo '<table class="table table-hover" table-striped">';

    echo '<thead><tr><th></th>';
    foreach ($col_arr as &$value) {
        echo '<th>' . $value . '</th>';
    }
    unset($value);
    echo '</tr></thead>';
    
    while($value = $result->fetch_array(MYSQLI_NUM)){
        echo '<tr>';
        echo '<td><a href="/pred_detail.php?mov='.$value[0].'"><span class="glyphicon glyphicon-search">';
        echo '<i class="bi bi-eye"></i>'; // search icon of Bootstrap Icons
        echo '</span></a></td>';
        for($i=1; $i<count($value); $i++){
            echo '<td>' . $value[$i] . '</td>';
        }

        

        echo '</tr>';
    }
    echo '</table>';
    
    $result->close();
    mysqli_close($conn);
}
?>

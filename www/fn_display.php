<head>
        <meta charset="utf-8">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
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

    /*$table_head = "SELECT COLUMN_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'my_database' AND TABLE_NAME = 'my_table'";*/

    echo '<table class="table table-striped">';

    $table_header = '<thead><tr><th></th>';
    foreach ($col_arr as &$value) {
        $table_header = $table_header.('<th>').($value).('</th>');
    }
    $table_header = $table_header.('</tr></thead>');
    //echo '<thead><tr><th></th><th>2</th><th>3</th><th>4</th></tr></thead>';
    echo $table_header;
    unset($value);

    
    while($value = $result->fetch_assoc()){
        echo '<tr>';
        echo '<td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>';
        foreach($value as $element){
            echo '<td>' . $element . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    
    $result->close();
    mysqli_close($conn);
}
?>
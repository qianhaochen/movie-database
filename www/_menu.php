<?php 

function menu_dropdown($sql_query) {
    $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
    $result = mysqli_fetch_array(mysqli_query($conn, $sql_query));

    while ($rows = mysql_fetch_array($result)) {
        echo "<a class='dropdown-item' href='#'>" .$rows['gen_name']. "</a>";
    }
}
?>

<?php
$sql_query = "SELECT gen_name FROM genres ORDER BY gen_id";
$conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
$result = mysqli_fetch_array(mysqli_query($conn, $sql_query));

foreach($result as $element){
    echo '<td>' . $element . '</td>';
}
echo '</tr>';

?>
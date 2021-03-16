<?php
// movie genres
$conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
$dropdown_query = "SELECT gen_name FROM genres ORDER BY gen_id ASC";
$dropdown_result = mysqli_query($conn, $dropdown_query);
$dropdown_menu = '';
$dropdown_content = '';
$count = 0;
while($row = mysqli_fetch_array($dropdown_result)){
    if($count == 0){
        $dropdown_menu .= '
        <li class="active"><a href="#'.$row["gen_id"].'" data-toggle="tab">'.$row["gen_name"].'</a></li>
        ';
        $dropdown_content .= '
        <div id="'.$row["gen_id"].'" class="tab-pane fade in active">
        ';
    }
    else{
        $dropdown_menu .= '
        <li><a href="#'.$row["gen_id"].'" data-toggle="tab">'.$row["gen_name"].'</a></li>
        ';
        $dropdown_content .= '
        <div id="'.$row["gen_id"].'" class="tab-pane fade">
        ';
    }
    $genres_query = "SELECT * FROM genres WHERE gen_id LIKE '".$row["gen_id"]."'";
    $genres_result = mysqli_query($conn, $genres_query);
    while($sub_row = mysqli_fetch_array($genres_result)){

    }
    $dropdown_content .= '<div style="clear:both"></div></div>';

    $count++;
}
echo $dropdown_menu;
?>
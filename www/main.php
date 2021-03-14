<html>
 <head>
  <title>Homepage</title>

  <meta charset="utf-8"> 

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  

</head>
<form action="search.php" method="GET">
    <input type="text" name="query" />
    <input type="submit" value="Search" />
</form>
<body>

    <?php
    // drop-down menus of movie genres
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
    ?>



    <div class="container">
    <?php echo "<h1>Movie Database</h1>"; ?>


        <br />
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="genres-tab" data-toggle="tab" href="#genres" role="tab" aria-controls="genres" aria-selected="false">Genres</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tags-tab" data-toggle="tab" href="#search" role="tab" aria-controls="search" aria-selected="false">Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="popular-tab" data-toggle="tab" href="#popular" role="tab" aria-controls="popular" aria-selected="false">Popular</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="container">
                <?php
                $conn = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
                $sql_query = 'SELECT * From movies';
                /*$sql_query = "SELECT * FROM movies
                WHERE movies.gen_name = $tab_content";*/
                $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));
        
                echo '<table class="table table-striped">';
                echo '<thead><tr><th></th><th>id</th><th>title</th><th>genres</th></tr></thead>';
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
                ?>
                </div>
            </div>
            <div class="tab-pane fade" id="genres" role="tabpanel" aria-labelledby="genres-tab">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">All</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Genres
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php echo $dropdown_menu?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">
                No search history.
            </div>
            <div class="tab-pane fade" id="popular" role="tabpanel" aria-labelledby="popular-tab">
                Sort by popularity.
            </div>
        </div>

        
    </div>
    
</body>
</html>

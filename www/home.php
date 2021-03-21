<html>
<head>
    <title>Movies</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');



    $con = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$sql_genres ="SELECT gen_id,  gen_name FROM genres";
$result_genres = mysqli_query($con, $sql_genres) or die(mysqli_error($con));
$genres=mysqli_fetch_all($result_genres);

$genre_size = sizeof($genres);


  ?>

  <div class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-secondary rounded shadow-sm">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">All movies</h1>
    </div>
  </div>



<form action = "home.php" method="GET" >

  <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h1 class="h6 mb-0 lh-1">Genres:</h1>
    <div class="d-flex text-muted pt-3">

      <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
      
        <div class="d-flex justify-content-between align-items-stretch">

          <?php
              $checked = [];
              if(isset($_GET["genres"])){
                $checked = $_GET["genres"];
              }
              $i= 0;
              foreach ($result_genres as $gen){
                $i++;
                ?> 
                <input type='checkbox' name='genres[]' class='checkbox' value = '<?=$gen['gen_id'];?>'
                    <?php
                      if(in_array($gen['gen_id'],$checked)){echo "checked";}
                    ?>
                /> <?=$gen['gen_name'];?>


      
                


                <?php


                if($i == 10) break;
              }
          ?>          
        </div>

        <div class="d-flex justify-content-between align-items-stretch" style = 'margin-top:5px'>
          <?php
              $i= 0;
              foreach ($result_genres as $gen){
                $i++;
                if($i > 10){
                echo "<input type='checkbox' name='genres[]' class='checkbox' value = '".$gen['gen_id']."' />".$gen['gen_name'];
                }
                if($i == 20) break;
              }
          ?>          
        </div>

        
        <small class="d-block text-center mt-3">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        </small>
      </div>
    </div>
    </form>

  
  
  




  


  <?php 
    $query = search_sql();
    $sql_query = "SELECT m_id, title,gens,ave_rating,rating_count FROM
    (SELECT moviesGenresRelation.mov_id AS m_id, movies.mov_title AS title, GROUP_CONCAT(DISTINCT gen_name SEPARATOR ', ') AS gens
        FROM moviesGenresRelation, genres,movies
        WHERE moviesGenresRelation.genre_id = genres.gen_id AND movies.mov_id = moviesGenresRelation.mov_id AND movies.mov_title LIKE '%".$query."%'
        GROUP BY moviesGenresRelation.mov_id) as gennames,
    (SELECT mov_id,
            ROUND(AVG(rating),1) AS ave_rating, 
               COUNT(user_id) AS rating_count 
            FROM ratings 
            GROUP BY mov_id 
           ) AS avgratingbymovies
    WHERE avgratingbymovies.mov_id = gennames.m_id";
    $col_arr = array( 'Title','Genres','Rating', 'views');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
 
  <?php 
    include('footer.php');

  ?>
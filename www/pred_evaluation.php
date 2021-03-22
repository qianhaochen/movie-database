<?php 
    $con = mysqli_connect("database", "user", "user", "movie_lens");
    if (!$con) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $mov_id = 4306;
    $sql_rate_distribution = "select count(*) as y,label
from
(
 select case when prediction between 0  and 1 then '0-1'
             when prediction between 1 and 2 then '1-2'
    		 when prediction between 2 and 3 then '2-3'
    		 when prediction between 3 and 4 then '3-4'
             when prediction >= 4 then '4-5' end as label
 from predictedRatings
 WHERE mov_id = $mov_id
) AS pd
group by label
ORDER BY label ASC";
$result_rate = mysqli_query($con, $sql_rate_distribution) or die(mysqli_error($con));
$rates_distribition=mysqli_fetch_all($result_rate);

$range_count  = sizeof($rates_distribition);


$stack = array();


for ($i = 0; $i < $range_count; ++$i) {
    $x = array("y" => $rates_distribition[$i][0],"label" => $rates_distribition[$i][1] );
    array_push($stack, $x);
}

$sql_mov = "SELECT mov_title FROM movies WHERE mov_id=$mov_id";
$result_mov = mysqli_query($con, $sql_mov) or die(mysqli_error($con));
$mov=mysqli_fetch_assoc($result_mov);


$sql_rating_info = "SELECT stbr_id, raters, ave_rating, unraters, ave_prediction 
    FROM
    (SELECT mov_id AS stbr_id, COUNT(user_id) AS unraters, ROUND(AVG(prediction),2) AS ave_prediction
    FROM predictedRatings 
    GROUP BY stbr_id
    ) AS predictions,
    (SELECT mov_id AS m_id, COUNT(user_id) AS raters, ROUND(AVG(rating),2) AS ave_rating
    FROM ratings 
    GROUP BY m_id
    )AS rating_existed
    WHERE rating_existed.m_id = predictions.stbr_id
    AND predictions.stbr_id = $mov_id
    ORDER BY ave_prediction DESC";
$result_rating_info = mysqli_query($con, $sql_rating_info) or die(mysqli_error($con));
$rating_info=mysqli_fetch_assoc($result_rating_info);



$sql_genres ="SELECT releaseSoonMovies.mov_id AS m_id, releaseSoonMovies.mov_title AS title, 
GROUP_CONCAT(DISTINCT gen_name SEPARATOR ', ') AS gens
        FROM moviesGenresRelation, genres,releaseSoonMovies
        WHERE moviesGenresRelation.genre_id = genres.gen_id 
        AND releaseSoonMovies.mov_id = moviesGenresRelation.mov_id 
        AND releaseSoonMovies.mov_id =$mov_id
        GROUP BY moviesGenresRelation.mov_id";
$result_genres = mysqli_query($con, $sql_genres) or die(mysqli_error($con));
$genres=mysqli_fetch_assoc($result_genres);


$sql_test_evaluate = "SELECT shrekTestPred.mov_id, ROUND(AVG(shrekTestPred.prediction),4) as ave_test_prediction, ROUND(AVG(testSet.rating),4)as ave_test_rating, ROUND(SQRT(Avg( POWER(testSet.rating - shrekTestPred.prediction , 2) ) ),4) as pred_rmse  FROM `shrekTestPred`,
(SELECT user_id,mov_id, rating FROM
ratings 
WHERE mov_id = 4306 AND user_id < 150) as testSet
WHERE shrekTestPred.user_id = testSet.user_id
GROUP BY shrekTestPred.mov_id
ORDER BY pred_rmse ASC";
$result_test_evaluate = mysqli_query($con, $sql_test_evaluate) or die(mysqli_error($con));
$test_evaluate=mysqli_fetch_assoc($result_test_evaluate);

    


?>

<html>
<head>
<link href="assets/css/jumbotron.css" rel="stylesheet">
<link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/jumbotron/">
</head>
<body>
  <?php 
    include('_stbr_navbar.php');
    include('_display.php');
  ?>
<main role="main">

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron" style="height: 200px; width: 100%;margin-top: 15px;">
  <div class="container">

  <?php
                echo "<h1 class='display-3''>".$mov["mov_title"]."</h1>";

                echo "<p style = ' font-size:150%; margin-top: 15px; color:grey;'>".$genres["gens"]."</p>";
          ?>
  </div>
</div>

<div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-3">
          <?php
                echo "<h2 style = 'text-align: center;'>".$rating_info["raters"]."</h2>";

          ?>
            
            <p style = 'text-align: center; font-size:90%;'>users has already rated</p>
          </div>
          <div class="col-md-3">

          <?php
                echo "<h2 style = 'text-align: center;'>".$rating_info["ave_rating"]."/5</h2>";

          ?>
            <p style = 'text-align: center; font-size:90%;'>is the average of existing ratings</p>
          </div>
          <div class="col-md-3">
         
          <?php
                echo "<h2 style = 'text-align: center;'>".$rating_info["unraters"]."</h2>";

          ?>
            <p style = 'text-align: center; font-size:90%;'>user hasn't rated yet</p>
          </div>
          
          <div class="col-md-3">
          
          <?php
                echo "<h2 style = 'text-align: center;'>".$rating_info["ave_prediction"]."/5</h2>";

          ?>
            <p style = 'text-align: center; font-size:90%;'>is the average of rating predictions</p>
          </div>
        </div>

        <hr>

      </div> <!-- /container -->

</main>
  <div class="container">
 <div class="my-3 p-3 bg-body rounded shadow-sm">

 <h2 style = 'text-align: left;'>Evaluation Method</h2>
 <p> From the 170 users that has rated the movie, we make the users with user ID smaller than 150 a test dataset (42 users), 
 and make the users with user ID larger or equal than 150 a train dataset (128 users). We let collaborative filtering method train on the ratings dataset that excludes the testset then we use the method to predict rating for users in test set.
 By comparing the results of prediction and the actual rating from users in test set, we can roughly understand how well the algorithm perform in predicting rating.
  </p>
 <h2 style = 'text-align: left;'>Results</h2>


 <table class="table">
 <thead ><tr>
 <th>Average of actual ratings on test set</th>
 <th>Average of predicted ratings on test set</th>
 <th>RMSE</th>
 </tr></thead>
 <tr>
 <?php
 echo '<td>' . $test_evaluate["ave_test_rating"] . '</td>';
 echo '<td>' . $test_evaluate["ave_test_prediction"] . '</td>';
 echo '<td>' . $test_evaluate["pred_rmse"]. '</td>';
 ?>
 </tr>
 </table>

 <h3> All Predictions on test set
  </h3>

  <?php 
  
    $sql_query = "SELECT shrekTestPred.user_id,testSet.rating , ROUND(shrekTestPred.prediction,4), ROUND(ABS(testSet.rating - shrekTestPred.prediction) ,4) as pred_dif  FROM `shrekTestPred`,
    (SELECT user_id,mov_id, rating FROM
    ratings 
    WHERE mov_id = 4306 AND user_id < 150) as testSet
    WHERE shrekTestPred.user_id = testSet.user_id
    ORDER BY pred_dif ASC";
    $col_arr = array( 'User ID','Rating','Prediction', 'Difference');
    display_nolink_sql($sql_query, $col_arr);
  ?>  
  </div>
  </div>
  <?php 
    include('footer.php');

  ?>
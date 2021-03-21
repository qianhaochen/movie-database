
<?php

$mov_id = $_GET['mov'];


 
$con = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "movie_lens");
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

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



?>

<html>
<head>
<link href="assets/css/jumbotron.css" rel="stylesheet">
<link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/jumbotron/">
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Distribution of rating predictions from users that hasn't rated the movie"
	},
    axisX: {
		title: "Prediced rating range",
		includeZero: true,
		prefix: "",
		suffix:  ""
	},
    
	axisY: {
		title: "Number of users",
		includeZero: true,
		prefix: "",
		suffix:  ""
	},
    
	data: [{
		type: "bar",
		yValueFormatString: "#,##0",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontWeight: "bolder",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($stack, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
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
                echo "<h4 class='display-3''>".$mov["mov_title"]."</h4>";

          ?>

    <p style = ' font-size:150%;'>Genres:asdhcal</p>
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


<div id="chartContainer" style="height: 370px; width: 80%;margin-top: 12px; margin-left: auto;margin-right: auto;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php 
    include('footer.php');

  ?>
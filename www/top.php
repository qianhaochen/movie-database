<html>
<head>
    <title>Top Rated</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
  ?>

  <div class="container">
  <?php echo "<h1>Top Rated</h1>"; ?>

  <?php 
    $sql_query = 'SELECT movies.mov_id, mov_title, ave_rating, rating_count
    FROM movies,
       (SELECT mov_id,
        ROUND(AVG(rating),1) AS ave_rating, 
           COUNT(user_id) AS rating_count 
        FROM ratings 
        GROUP BY mov_id 
       ) AS avgratingbymovies
    WHERE movies.mov_id = avgratingbymovies.mov_id
    ORDER BY ave_rating DESC, rating_count DESC';
    $col_arr = array('Title', 'Ratings', 'Views');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
</body>
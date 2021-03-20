<html>
<head>
    <title>Most Polarising</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
  ?>

  <div class="container">
  <?php echo "<h4>Most Polarising</h4>"; ?>

  <?php
    $sql_query = 'SELECT movies.mov_id, mov_title,ave_rating ,rating_count, rating_dif
    FROM movies,
      (SELECT mov_id,
        ROUND(AVG(rating),1) AS ave_rating, 
          COUNT(user_id) AS rating_count 
        FROM ratings 
        GROUP BY mov_id 
      ) AS avgratingbymovies,
      (SELECT MAX(rating) - MIN(rating) AS rating_dif, 
        
      mov_id FROM ratings GROUP BY mov_id) AS ratingPolarise
    WHERE movies.mov_id = avgratingbymovies.mov_id AND movies.mov_id = ratingPolarise.mov_id
    ORDER BY rating_dif DESC, rating_count DESC';
    $col_arr = array('Title','Ratings','Views','Rating Difference');
    display_sql($sql_query, $col_arr);
  ?>
  </div>
</body>
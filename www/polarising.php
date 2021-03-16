<html>
<head>
    <title>Most Polarising</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
    include('_search.php');
  ?>

  <div class="container">
  <?php echo "<h1>Most Polarising</h1>"; ?>

  <?php
    $sql_query = 'SELECT mov_id, mov_title,rating_count, rating_dif
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
    $col_arr = array('ID', 'Title','Rating Count','Rating Difference');
    display_sql($sql_query, $col_arr);
  ?>
  </div>
</body>
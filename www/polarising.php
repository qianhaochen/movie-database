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

  <div class="d-flex align-items-center p-3 my-3 text-white bg-secondary rounded shadow-sm">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Most polarising</h1>
      <small>Find the movies with the most polarising ratings. </small>
    </div>
  </div>

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
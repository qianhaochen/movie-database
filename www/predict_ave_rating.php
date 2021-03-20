<html>
<head>

</head>
<body>
  <?php 
    include('_stbr_navbar.php');
    include('_display.php');
  ?>
  <div class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-secondary rounded shadow-sm">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Most popular</h1>
      <small>Find the movies that has been rated the most. </small>
    </div>
  </div>

  <?php 
    $query = search_sql();
    $sql_query = "SELECT stbr_id, mov_title, raters, ave_rating, unraters, ave_prediction 
    FROM
    (SELECT mov_id AS stbr_id, COUNT(user_id) AS unraters, ROUND(AVG(prediction),2) AS ave_prediction
    FROM predictedRatings 
    GROUP BY stbr_id
    ) AS predictions,
    (SELECT mov_id AS m_id, COUNT(user_id) AS raters, ROUND(AVG(rating),2) AS ave_rating
    FROM ratings 
    GROUP BY m_id
    )AS rating_existed, movies
    WHERE rating_existed.m_id = predictions.stbr_id
    AND movies.mov_id = predictions.stbr_id
    ORDER BY ave_prediction DESC";
    $col_arr = array( 'Title','Users rated','Average rating(from rated)', 'users to predict','Average prediction');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
</body>
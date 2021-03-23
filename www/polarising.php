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
    <div class="my-3 p-3 bg-body rounded shadow-sm">
      <?php
    $sql_query = 'SELECT movies.mov_id, movies.mov_title,ave_rating , rating_dif, ROUND(CVrating,3) FROM movies,
    (SELECT mov_id,ROUND(AVG(rating),1) AS ave_rating, COUNT(user_id) AS rating_count 
    FROM ratings GROUP BY mov_id ) AS avgratingbymovies,
    (SELECT ratings.mov_id,mov_title,MAX(rating) - MIN(rating) AS rating_dif,
     STDDEV(1.0*rating) / AVG(1.0*rating) AS CVrating
    FROM ratings,movies
    WHERE ratings.mov_id = movies.mov_id
    GROUP BY ratings.mov_id) AS ratingPolarise WHERE 
    movies.mov_id = avgratingbymovies.mov_id AND 
    movies.mov_id = ratingPolarise.mov_id ORDER BY rating_dif DESC, CVrating DESC';
    $col_arr = array('Title','Average Rating','Rating Difference','Coefficient of Variation');
    display_sql($sql_query, $col_arr);
  ?>
    </div>
  </div>
  <?php 
    include('footer.php');

  ?>
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
  <div class="d-flex align-items-center p-3 my-3 text-white bg-secondary rounded shadow-sm">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">Top rated</h1>
      <small>Find the movies with the best average rating. </small>
    </div>
  </div>

  <?php 
    $sql_query = 'SELECT m_id, title,gens,ave_rating,rating_count FROM
    (SELECT moviesGenresRelation.mov_id AS m_id, 
     movies.mov_title AS title, 
     GROUP_CONCAT(DISTINCT gen_name SEPARATOR ", ") AS gens
    FROM moviesGenresRelation, genres,movies
    WHERE moviesGenresRelation.genre_id = genres.gen_id 
    AND movies.mov_id = moviesGenresRelation.mov_id
    GROUP BY moviesGenresRelation.mov_id) as gennames,
    (SELECT mov_id,
    ROUND(AVG(rating),1) AS ave_rating, 
    COUNT(user_id) AS rating_count 
    FROM ratings 
    GROUP BY mov_id 
    ) AS avgratingbymovies
    WHERE avgratingbymovies.mov_id = gennames.m_id
    ORDER BY ave_rating DESC,rating_count DESC';
    $col_arr = array('Title','Genres', 'Ratings', 'Views');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
  <?php 
    include('footer.php');

  ?>
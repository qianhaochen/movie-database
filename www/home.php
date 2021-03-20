<html>
<head>
    <title>Movies</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
  ?>

  <div class="container">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-secondary rounded shadow-sm">
    <div class="lh-1">
      <h1 class="h6 mb-0 text-white lh-1">All movies</h1>
      <small>9742 results</small>
    </div>
  </div>

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
</body>
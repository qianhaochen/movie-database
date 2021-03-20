<html>
<head>
    <title>Movies</title>
</head>
<body>
  <?php 
    include('_stbr_navbar.php');
    include('_display.php');
  ?>

  <div class="container">

  <?php 
    $query = search_sql();
    $sql_query = "SELECT m_id, title,gens,ave_rating,rating_count FROM
    (SELECT releaseSoonMovies.mov_id AS m_id, releaseSoonMovies.mov_title AS title, GROUP_CONCAT(DISTINCT gen_name SEPARATOR ', ') AS gens
        FROM moviesGenresRelation, genres,releaseSoonMovies
        WHERE moviesGenresRelation.genre_id = genres.gen_id AND releaseSoonMovies.mov_id = moviesGenresRelation.mov_id AND releaseSoonMovies.mov_title LIKE '%".$query."%'
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
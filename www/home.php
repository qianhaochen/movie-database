<html>
<head>
    <title>Homepage</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
  ?>

  <div class="container">
  <?php echo "<h1>All movies</h1>"; ?>

  <?php 
    $query = search_sql();
    $sql_query = "SELECT mov_title, gen_name, ave_rating, rating_count
        FROM movies,
           (SELECT mov_id,
            ROUND(AVG(rating),1) AS ave_rating, 
               COUNT(user_id) AS rating_count 
            FROM ratings 
            GROUP BY mov_id 
           ) AS avgratingbymovies
        WHERE (movies.mov_id = avgratingbymovies.mov_id)
        AND (movies.mov_title LIKE '%".$query."%')";
    $col_arr = array('Title', 'genres', 'Ratings', 'Views');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
</body>
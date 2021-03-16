<html>
<head>
    <title>Most Popular</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
    include('_search.php');
  ?>
  <div class="container">
  <?php echo "<h1>Most Popular</h1>"; ?>

  <?php 
    $sql_query = 'SELECT movies.mov_id, mov_title,rating_count, ave_rating
    FROM movies,
        (SELECT mov_id,
        ROUND(AVG(rating),1) AS ave_rating, 
            COUNT(user_id) AS rating_count 
        FROM ratings 
        GROUP BY mov_id 
        ) AS avgratingbymovies
    WHERE movies.mov_id = avgratingbymovies.mov_id
    ORDER BY rating_count DESC';
    $col_arr = array('ID', 'Title','Views','Average Ratings');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
</body>
<html>
<head>
    <title>Homepage</title>
</head>
<body>
  <?php 
    include('_navbar.php');
    include('_display.php');
    include('_search.php');
  ?>

  <div class="container">
  <?php echo "<h1>All movies</h1>"; ?>

  <?php
    $sql_query = 'SELECT mov_id, AVG(rating)
    FROM ratings
    GROUP BY mov_id
    ORDER BY AVG(rating) DESC';
    $col_arr = array('ID', 'Movie Title', 'Genres');
    display_sql(search_sql($sql_query), $col_arr);
  ?>
  </div>
</body>
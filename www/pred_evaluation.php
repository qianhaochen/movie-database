

<html>
<head>

</head>
<body>
  <?php 
    include('_stbr_navbar.php');
    include('_display.php');
  ?>
 

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
    $col_arr = array( 'Title','Users rated','Average rating', 'users to predict','Average prediction');
    display_sql($sql_query, $col_arr);
  ?>  
  </div>
  <?php 
    include('footer.php');

  ?>
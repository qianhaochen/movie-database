<html>
<head>
    <title>Homepage</title>

    <meta charset="utf-8"> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
    <?php include('fn_darkmode.php'); ?>
    <?php echo "<h1>Movie Database</h1>"; ?>
    <?php 
    include('fn_display.php'); 
    include('fn_search.php');
    ?>
    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
        Home
        </button>
        <button class="nav-link" id="nav-popular-tab" data-bs-toggle="tab" data-bs-target="#nav-popular" type="button" role="tab" aria-controls="nav-popular" aria-selected="false">
        Most Popular
        </button>
        <button class="nav-link" id="nav-ratings-tab" data-bs-toggle="tab" data-bs-target="#nav-ratings" type="button" role="tab" aria-controls="nav-ratings" aria-selected="false">
        Top Rated
        </button>
        <button class="nav-link" id="nav-polarising-tab" data-bs-toggle="tab" data-bs-target="#nav-polarising" type="button" role="tab" aria-controls="nav-polarising" aria-selected="false">
        Most Polarising
        </button>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="container">
            <?php
                $sql_query = 'SELECT mov_id, AVG(rating)
                FROM ratings
                GROUP BY mov_id
                ORDER BY AVG(rating) DESC';
                $col_arr = array('ID', 'Movie Title', 'Genres');
                display_sql(search_sql($sql_query), $col_arr);
            ?>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-popular" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="container">
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
                $col_arr = array('ID', 'Title','Rating Count','Average Ratings');
                display_sql($sql_query, $col_arr);
            ?>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-ratings" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="container">
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
                ORDER BY ave_rating DESC, rating_count DESC';
                $col_arr = array('ID', 'Title','Rating Count','Average Ratings');
                display_sql($sql_query, $col_arr);
            ?>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-polarising" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="container">
            <?php
                $sql_query = 'SELECT movies.mov_id, mov_title,rating_count, rating_dif
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
                $col_arr = array('ID', 'Title','Rating Count','Rating Difference');
                display_sql($sql_query, $col_arr);
            ?>
            </div>
        </div>

    </div>
    
</body>
</html>

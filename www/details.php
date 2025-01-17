<?php
$mov_id = $_GET['mov'];

function star_n($number){
    $number = round($number/0.5);
    $half = $number%2;
    $full = ($number-$half)/2;
    $result = array($full,$half,(5-$full-$half));
    return $result;
}

function print_star($num){
    $p = 4;
    for ($i=1; $i<=$num[0]; $i++)
    {
        echo "<i class='bi bi-star-fill' style='color:#FFCC33; position: absolute; right:".($p*5)."%; padding: 5px;'></i>";
        $p-=1;
    }
    for ($i=1; $i<=$num[1]; $i++)
    {
        echo "<i class='bi bi-star-half' style='color:#FFCC33; position: absolute; right:".($p*5)."%; padding: 5px;'></i>";
        $p-=1;
    }
    for ($i=1; $i<=$num[2]; $i++)
    {
        echo "<i class='bi bi-star' style='color:#FFCC33; position: absolute; right:".($p*5)."%; padding: 5px;'></i>";
        $p-=1;
    }
}

$con = mysqli_connect("database", "user", "user", "movie_lens");
if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$sql_mov = "SELECT mov_title FROM movies WHERE mov_id=$mov_id";
$result_mov = mysqli_query($con, $sql_mov) or die(mysqli_error($con));
$mov=mysqli_fetch_assoc($result_mov);

$sql_avg_rate = "SELECT round(AVG(rating),2) as rate, COUNT(rating) as num, MAX(timestamp) as t
            FROM ratings
            WHERE mov_id=$mov_id";
$result_avg_rate = mysqli_query($con, $sql_avg_rate) or die(mysqli_error($con));
$avg_rate=mysqli_fetch_assoc($result_avg_rate);

function rate($number){
    global $mov_id, $con, $avg_rate;
    $sql_5_rate = "SELECT COUNT(rating) as num
                    FROM ratings
                    WHERE mov_id=$mov_id AND rating >= $number AND rating < $number+1";
    $result_5_rate = mysqli_query($con, $sql_5_rate) or die(mysqli_error($con));
    $_5_rate=mysqli_fetch_assoc($result_5_rate);

    echo "<li class='list-group-item'>".round($_5_rate["num"]/$avg_rate["num"]*100,1)."%";
    print_star(array($number,0,0));
    echo "</li>";
}

$sql_tag = "SELECT tag, COUNT(user_id) as id, MAX(time) as t
            FROM tags
            WHERE mov_id=$mov_id
            GROUP BY tag
            ORDER BY id DESC";
$result_tag = mysqli_query($con, $sql_tag) or die(mysqli_error($con));
$tag=mysqli_fetch_all($result_tag,MYSQLI_ASSOC);

$sql_user_mov_max = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.n_rating>=200";
$result_user_mov_max = mysqli_query($con, $sql_user_mov_max) or die(mysqli_error($con));
$user_mov_max=mysqli_fetch_assoc($result_user_mov_max);

$sql_user_mov_mid = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.n_rating<200 AND users.n_rating>=100";
$result_user_mov_mid = mysqli_query($con, $sql_user_mov_mid) or die(mysqli_error($con));
$user_mov_mid=mysqli_fetch_assoc($result_user_mov_mid);

$sql_user_mov_min = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.n_rating<100";
$result_user_mov_min = mysqli_query($con, $sql_user_mov_min) or die(mysqli_error($con));
$user_mov_min=mysqli_fetch_assoc($result_user_mov_min);

$sql_user_rate_max = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.avg_rating>=3.75";
$result_user_rate_max = mysqli_query($con, $sql_user_rate_max) or die(mysqli_error($con));
$user_rate_max=mysqli_fetch_assoc($result_user_rate_max);

$sql_user_rate_mid = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.avg_rating<3.75 AND users.n_rating>=3.25";
$result_user_rate_mid = mysqli_query($con, $sql_user_rate_mid) or die(mysqli_error($con));
$user_rate_mid=mysqli_fetch_assoc($result_user_rate_mid);

$sql_user_rate_min = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.avg_rating<3.25";
$result_user_rate_min = mysqli_query($con, $sql_user_rate_min) or die(mysqli_error($con));
$user_rate_min=mysqli_fetch_assoc($result_user_rate_min);

$sql_user_tag = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.n_tag<>0";
$result_user_tag = mysqli_query($con, $sql_user_tag) or die(mysqli_error($con));
$user_tag=mysqli_fetch_assoc($result_user_tag);

$sql_user_no_tag = "with rating(id) as (SELECT user_id
                FROM ratings
                WHERE mov_id=$mov_id
            )SELECT COUNT(users.id) as num
            FROM users,rating
            WHERE users.id=rating.id AND users.n_tag=0";
$result_user_no_tag = mysqli_query($con, $sql_user_no_tag) or die(mysqli_error($con));
$user_no_tag=mysqli_fetch_assoc($result_user_no_tag);

$sql_user_gen = "with name(id) as (
            with gen(id) as (
                with rating(id) as (SELECT user_id
                    FROM ratings
                    WHERE mov_id=$mov_id
                    )SELECT gen_id
                FROM ugrelation,rating
                WHERE ugrelation.user_id=rating.id)
            SELECT id
            FROM gen
            GROUP BY id
            ORDER BY COUNT(id) DESC)
        SELECT gen_name
        FROM genres,name
        WHERE genres.gen_id=name.id LIMIT 5";
$result_user_gen = mysqli_query($con, $sql_user_gen) or die(mysqli_error($con));
$user_gen=mysqli_fetch_all($result_user_gen,MYSQLI_ASSOC);

$sql_link = "SELECT imdb_id,tmdb_id
            FROM links
            WHERE mov_id=$mov_id";
$result_link = mysqli_query($con, $sql_link) or die(mysqli_error($con));
$link=mysqli_fetch_assoc($result_link);

?>

<html>

<head>

    <?php echo "<title>".$mov["mov_title"]."</title>"; ?>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

</head>

<body>
    <?php include('_navbar.php');?>
    <div class="container">
        <div class="card">
            <?php echo "<h2 class='card-header'>".$mov["mov_title"]."</h2>"; ?>
            <div class="card-body">
                <div class="card-group">
                    <div class="card border-light mb-3">
                        <h5 class="card-header bg-transparent">Rating</h5>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <?php 
                $avg_star = star_n($avg_rate["rate"]);
                echo "<li class='list-group-item'>Average rating: ".$avg_rate["rate"];
                print_star($avg_star);
                echo "</li>";
                echo "<li class='list-group-item'>Number of ratings: ".$avg_rate["num"]."</li>";
                rate(5);
                rate(4);
                rate(3);
                rate(2);
                rate(1);
                ?>
                            </ul>
                        </div>
                        <?php
            echo "<div class='card-footer bg-transparent'><small class='text-muted'>Last rated ".$avg_rate["t"]."</small></div>";
            ?>
                    </div>
                    <div class="card border-light mb-3">
                        <h5 class="card-header bg-transparent">Tags</h5>
                        <div class="card-body" style="height:400px;overflow-y:auto">
                            <?php echo "<form class='d-flex' name='tag_form' action='".$_SERVER["PHP_SELF"]."?mov=".$mov_id."' method='post'>"?>
                            <input class="form-control" placeholder="Add New Tags" name="tag">
                            <button class="btn btn-outline-dark" type="submit">Add</button>
                            </form>
                            <?php
            function add_tag(){
                global $con,$mov_id;
                $tag = rtrim(ltrim($_POST["tag"]));
                if(empty($tag)){
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Empty!</strong> Please enter a tag.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    return;
                } else if (!preg_match("/^[\w\(\)\-\s\|\:]{1,50}$/", $tag, $matches)){
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Invalid format!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                  return;
                }
                $sql = sprintf("INSERT INTO tags (user_id, mov_id, tag, time)
                VALUES (0,'%s', '%s',TIMESTAMP(NOW()));
                UPDATE users SET n_tag=n_tag+1
                WHERE id=0",mysqli_real_escape_string($con,$mov_id), mysqli_real_escape_string($con,$tag));
                if ($con->multi_query($sql) === TRUE) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> You add tag '.$_POST['tag'].'. <a href="/details.php?mov='.$mov_id.'" class="alert-link">Referesh</a> to view changes.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                } else {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Connection Error!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            }
            if($_SERVER["REQUEST_METHOD"]==="POST"){
                add_tag();
            }
            ?>
                            <div class="row gx-3 gy-2 row-cols-auto">
                                <?php
            $time = array();
            foreach($tag as $element){
                echo "<div class='btn-group' role='group'>
                <button type='button' class='col btn btn-outline-dark'><i class='bi bi-tag'></i> ".$element["tag"]."</button>
                <button type='button' class='col btn btn-outline-dark'>".$element["id"]."</button>
                </div>";
                $time[]=$element["t"];
            }
            ?>
                            </div>
                            <?php
            if(count($time)==0){
                echo "<p class='card-text'>No Tags.</p>";
            }
            ?>
                        </div>
                        <?php
            if(count($time)!=0){
                echo "<div class='card-footer bg-transparent'><small class='text-muted'>Last modified ".max($time)."</small></div>";
            }
            ?>
                    </div>
                    <div class="card border-light mb-3">
                        <h5 class="card-header bg-transparent">Viewers Info</h5>
                        <div class="card-body" style="height:400px;overflow-y:auto">
                            <h8 class="card-text">Viewers with different watching experience</h8>
                            <!-- <div class="chart-container" style="position: relative; height:387px; width:300px">
                <canvas id="myChart"></canvas>
            </div> -->
                            <canvas id="user_watch_chart" width="774" height="386"></canvas>
                            <p id="user_watch" style="visibility: hidden; margin-bottom:0">
                                <span id="user_watch_1">
                                    <?php echo round($user_mov_max["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_watch_2">
                                    <?php echo round($user_mov_mid["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_watch_3">
                                    <?php echo round($user_mov_min["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_watch_4">
                                    200
                                </span>
                                <span id="user_watch_5">
                                    100
                                </span>
                            </p>
                            <h8 class="card-text">Viewers who tends to rate higher</h8>
                            <canvas id="user_rate_chart" width="774" height="386"></canvas>
                            <p id="user_rate" style="visibility: hidden; margin-bottom:0">
                                <span id="user_rate_1">
                                    <?php echo round($user_rate_max["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_rate_2">
                                    <?php echo round($user_rate_mid["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_rate_3">
                                    <?php echo round($user_rate_min["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_rate_4">
                                    3.75
                                </span>
                                <span id="user_rate_5">
                                    3.25
                                </span>
                            </p>
                            <h8 class="card-text">Viewers who tags or not</h8>
                            <canvas id="user_tag_chart" width="774" height="386"></canvas>
                            <p id="user_tag" style="visibility: hidden; margin-bottom:0">
                                <span id="user_tag_1">
                                    <?php echo round($user_tag["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_tag_2">
                                    <?php echo round($user_no_tag["num"]/$avg_rate["num"]*100,1);?>
                                </span>
                                <span id="user_tag_4">
                                    have tagged
                                </span>
                                <span id="user_tag_5">
                                    never tagged
                                </span>
                            </p>

                            <h8 class="card-text">Most liked genres</h8>
                            <ul class="list-group list-group-flush">
                                <?php
            foreach($user_gen as $element){
                echo "<li class='list-group-item'>".$element["gen_name"]."</li>";
            }
            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    echo "<div class='card-footer'>Links: <a href='http://www.imdb.com/title/tt0".$link["imdb_id"]."/'>imdb</a>, 
        <a href='https://www.themoviedb.org/movie/".$link["tmdb_id"]."/'>tmdb</a>";
        // <a href='test.php'>test</a></div>";
    ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="chart.js"></script>

</body>

</html>
<?php
$result_mov->close();
mysqli_close($con);
?>
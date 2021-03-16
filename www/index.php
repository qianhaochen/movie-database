<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Movie Database</title>

        <link rel="stylesheet" href="/assets/css/bulma.min.css">

    </head>
    <body>
        <section class="hero is-medium is-info is-bold">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">
                    Movie Database
                    </h1>
                    <h2 class="subtitle">
                        Browse all kinds of movies
                    </h2>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column">
                        <h3 class="title is-3 has-text-centered">Environment</h3>
                        <hr>
                        <div class="content">
                            <ul>
                                <li><a href="http://localhost:<? print $_ENV['PMA_PORT']; ?>">phpMyAdmin</a></li>
                                <li><?= apache_get_version(); ?></li>
                                <li><a href="/phpinfo.php">PHP <?= phpversion(); ?></a></li>
                                <li>
                                    <?php
                                    $link = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], null);

/* check connection */
                                    if (mysqli_connect_errno()) {
                                        printf("MySQL connecttion failed: %s", mysqli_connect_error());
                                    } else {
                                        /* print server version */
                                        printf("MySQL Server %s", mysqli_get_server_info($link));
                                    }
                                    /* close connection */
                                    mysqli_close($link);
                                    ?>
                                </li>
                                <li><a href="https://getbootstrap.com/docs/5.0/">Bootstrap v5.0.0-beta2</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="column">
                        <h3 class="title is-3 has-text-centered">Quick Links</h3>
                        <hr>
                        <div class="content">
                            <ul>
                                <li><a href="/home.php">Home page</a></li>
                                <li><a href="/_navbar.php">Navbar Test</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>

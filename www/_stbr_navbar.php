<head>
  <meta charset="utf-8">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link href="assets/css/offcanvas.css" rel="stylesheet">
  <style type="text/css">
    body {
      background-color: white;
    }

    .darkmode {
      background-color: black;
    }
  </style>
  </style>

</head>


<body>

  <?php 
  include('_search.php');
  ?>

  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
      <a class="navbar-brand" href="/index.php">
        <i class="bi bi-film"></i>
        Movie Database
      </a>
      <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link " href="/home.php">Movielens</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/stbr_movies.php">Soon-to-be-released</a>
          </li>
        </ul>
      </div>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button onclick="darkmode()" class="btn btn-dark me-md-2" type="button">
        <i class="bi bi-moon-stars"></i>
        </button>
      </div>
    </div>
  </nav>
  

  <div class="nav-scroller bg--body shadow-sm">
    <nav class="nav nav-underline" aria-label="Secondary navigation">

      <a class="nav-link active" aria-current="page" href="/stbr_movies.php">All</a>
      <a class="nav-link" href="/predict_ave_rating.php">Predict average ratings</a>
      <a class="nav-link" href="/pred_evaluation.php">Evaluate prediction for Shrek</a>



      <form action="stbr_movies.php" method="GET" class="d-flex justify-content-end"
        style=' margin-left: 155px; margin-top: 4px; margin-right: 10px; width:1200px'>
        <div class="input-group">
          <input type="search" name="query" class="form-control" list="datalistOptions" id="exampleDataList"
            placeholder="Search for movies..." aria-label="Search">
          <datalist id="datalistOptions">
            <option value="Forrest Gump">
            <option value="Shawshank Redemption">
            <option value="Pulp Fiction">
            <option value="Silence of the Lambs">
            <option value="Matrix">
            <option value="Star Wars">
          </datalist>

          <input type="submit" value="Search" class="btn btn-outline-success" />
        </div>
      </form>

    </nav>
  </div>

  <script>
    function darkmode() {
      document.body.classList.toggle("darkmode");
    }
  </script>

</body>
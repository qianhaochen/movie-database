<head>
  <meta charset="utf-8">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <style type="text/css">
  @media (prefers-color-scheme: dark) {
    body {
      background-color: white;
      color: black;
    }

    .darkmode {
      background-color: black;
      color: white;
    }

  }
  </style>
  
</head>


<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/index.php">
      <i class="bi bi-film"></i>
      Movie Database
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="navbar-nav">

        <a class="nav-link active" aria-current="page" href="/home.php">Home</a>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Genres
            <span class="caret"></span>
          </a>

          <ul class="dropdown-menu">
              <?php 
              include('_genres.php');
              ?>
          </ul>
          
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>

                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <?php 
                      include('_genres.php');
                      echo $dropdown_menu;
                      ?>
                  </ul>

            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>

        <a class="nav-link" href="/popular.php">Most Popular</a>
        <a class="nav-link" href="/top.php">Top Rated</a>
        <a class="nav-link" href="/polarising.php">Most Polarising</a>
        <button onclick="darkmode()" type="button" class="btn btn-outline-dark" data-bs-toggle="button" autocomplete="off" aria-pressed="true"><i class="bi bi-moon-stars"></i></button>

      </div>
    </div>
        
      
      
    <form action="home.php" method="GET" class="d-flex">
      <div class="input-group">
        <input type="search" name="query" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search..." aria-label="Search">
          <datalist id="datalistOptions">
            <option value="Drama">
            <option value="Comedy">
            <option value="Family">
            <option value="Sci-Fi">
            <option value="Romance">
          </datalist>
        
        <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Action</a></li>
          <li><a class="dropdown-item" href="#">Another action</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
        
        <input type="submit" value="Search" class="btn btn-outline-success"/>
      </div>
    </form>

  </div>
</nav>

<script>
function darkmode() {
   var element = document.body;
   element.classList.toggle("darkmode");
}
</script>

</body>
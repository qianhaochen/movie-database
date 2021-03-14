<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>


    <style>
    body {
    background-color: white;
    color: black;
    }

    .dark-mode {
    background-color: black;
    color: white;
    }

    </style>
</head>
<body>

<div class="btn-group" role="group" aria-label="Basic example" style="float: right;">
  <button onclick="location.href='home.php'" type="button" class="btn btn-outline-dark">Home</button>
  <button onclick="location.href='index.php'" type="button" class="btn btn-outline-dark">Index</button>
  <button onclick="darkmode()" type="button" class="btn btn-outline-dark" data-bs-toggle="button" autocomplete="off" aria-pressed="true">Dark mode</button>
</div>

<script>
function darkmode() {
   var element = document.body;
   element.classList.toggle("dark-mode");
}
</script>

</body>
</html>



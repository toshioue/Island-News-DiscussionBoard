


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Oceania News-Forum</title>
    <!-- Bootstrap core CSS -->
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <script src="ajax.js"></script>
 <style>
 .form-inline{
   margin-left: 8px;
 }
</style>

  </head>
  <body>
    <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="#">Oceania News & Forum</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse"
data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expa
nded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Discussion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Majoriem</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gloriam</a>
          </li>
        </ul>

        <form class="form-inline align-right border-right-0 mr-n1">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>

      </div>
    </div>
  </nav>
  <!--END OF Navigation -->

  <!--RSS NEWS FEED-->
  <div class="container-fluid">
  <div class="row">
    <div id="feed" class="col-10 border border-primary" >
      <!--<div class="spinner-border">
        <span class="sr-only">Loading...</span>
      </div>
    </div>-->
    <div  class="col border border-primary" >

    </div>
  </div>
</div>



  </div>
<script>
  function setFeed(xmlObject){
    document.getElementById("feed").innerHTML = xmlObject;
  }

  //call towards server to get xml feeds;
  AJAX_GET('next.php', {'feed': 'getRSS'}, setFeed, '')
</script>


  <!-- Bootstrap core JavaScript -->

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Bootstrap core JavaScript
 ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script>window.jQuery || document.write('<script src="bootstrap/js/jquery-slim.min.js"><\/script>')</script>
 <script src="bootstrap/js/popper.min.js"></script>
 <script src="bootstrap/js/bootstrap.min.js"></script>


  </body>
</html>

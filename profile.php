<?php
session_start();
?>

<!--HTML file displays user's name, last, username-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Aboutm Micronesia News</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/icon/font/css/open-iconic-bootstrap.css" rel="stylesheet">

    <script src="ajax.js"></script>

    <!-- Extra-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
   <!--custom CSS-->
   <link href="main.css" rel="stylesheet">

   <style>

   .container{
     margin: 0 auto;

   }

   .form-group {
     padding-left: 10%;
     padding-right: 10%;
   }

   #box {
     margin-top: 20px;
   }
    body {
      margin: 0;
      width: 100%;
      background-image: url('img/sokehs.jpg');
      background-size: cover;
    }
   </style>
  </head>

  <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Micronesia News & Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

      <ul class="navbar-nav ml-auto">


        <li id="home" class="nav-item">
          <a class="nav-link" href="main.php">News
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="discussion.php">Discussion</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
      </ul>



      <div id="drop" class="dropdown align-right">
          <button class="btn btn-primary btn-circle btn-sm  " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <span class="oi oi-person"></span>
            <span class="caret"></span>
          </button>
          <?php
          if(isset($_SESSION['user'])){
              echo"<ul class='dropdown-menu text-center' aria-labelledby='dropdownMenu1'>";
              echo "<label>" . $_SESSION['user'] . "</label>";
              echo "<li><a id='prof' href='#'>Profile</a></li>
                <li role='separator' class='divider'></li>
                <li><a href='#'>Settings</a></li>
                <li role='separator' class='divider'></li>
                <li><a href='login.php?logout=yes'>Sign out</a></li>
                <li role='separator' class='divider'></li></ul>";

              }
              ?>

        </div>
    </div>
  </div>
</nav>
<!--END OF Navigation -->

  <body>
    <div class="container row justify-content-center">
      <div class="col-md-12 col-md-offset-3  text-center ">
      <div id= "box" class=" flex jumbotron jumbotron-fluid rounded border border-dark">
        <h1 class="Display-4">Profile</h1>
        <span class="oi oi-person float-left border border-warning" style="font-size:150px;"></span>
        <div class="text-left lead" style="margin-left: 20%;">
        <p>UserName: <?php echo $_SESSION['user']; ?> </p>
        <label>First Name: <?php echo $_SESSION['firstName']; ?></label><br/>
        <label>Last Name: <?php echo $_SESSION['lastName']; ?></label><br/>

        </div>







    </div>
  </div>

  </div>
</body>



</html>

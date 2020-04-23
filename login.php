<?php
session_start();
if(isset($_GET['logout'])){
  session_destroy();

}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login Oceania News</title>
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
    <a class="navbar-brand" href="#">Oceania News & Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

      <ul class="navbar-nav ml-auto">

        <form id="searchBar" class="form-inline">
          <input class="form-control mr-sm-2" type="search" placeholder="Search News or Users.." aria-label="Search">
          <button class="btn btn-outline-primary my-1 my-sm-0" type="submit">Search</button>
        </form>

        <li id="home" class="nav-item">
          <a class="nav-link" href="main.php">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Discussion</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="signup.php">Sign up</a>
        </li>
      </ul>



      <div id="drop" class="dropdown align-right">
          <button class="btn btn-primary btn-circle btn-sm  " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <span class="oi oi-person"></span>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenu1">
            <li><a href="#">Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Sign out</a></li>
            <li role="separator" class="divider"></li>

          </ul>
        </div>
    </div>
  </div>
</nav>
<!--END OF Navigation -->

  <body>
    <div class="container row justify-content-center">
      <div class="col-md-6 col-md-offset-3 ">
      <div id= "box" class=" flex jumbotron jumbotron-fluid rounded border border-dark">

        <div class="form-group  justify-content-center">
          <div class="col-xs-4">
            <p id="logOutMessage" class="text-center" style="font-size:20px; color:purple;"></p>
          <form method="POST" action="login.php" >
            <h3 class="display-5 text-center">Login </h3>
            <p class="text-center">Dont have an account? <a href="signup.php">Sign up!</a> </p><br/>
            <span id="newmistake" style="color: red;"> </span>
            <label class="lead" for="form-control ">Username:</label>
            <input  type="text" onchange="checkUserName(this.value)" class="form-control " name="enteredUser" required><br>
            <label class="lead" for="form-control">Password:</label> <!--<sub>-must be at least 5 characers long.</sub>-->
            <input  type="password" onkeydown="checkLength(this.value)" class="form-control" name="enteredPswd" required><br />
            <div class="text-center">
            <button type="submit" id="newsubmit" name="newsubmit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary ">Reset</button>
            </div>
          </form>
        </div>
        </div>


          <!--<div class="form-group col-md-4">
            <form method="post">
              <span id="mistake" style="color: red;"> </span>
            <h3 >Login </h3>
            <label for="form-control">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Sawyer" required>
            <label for="form-control">Password</label>
            <input type="password" class="form-control" id="pswd" name="pswd" required><br />
            <button type="submit" name="submitt" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
          </form>
        </div>-->

        <!--  <div class="col-md-1">
          </div>
          <div align="center" class="vl">
          </div>
          <div class="col-md-1">
          </div>-->



    </div>
  </div>

  </div>
  <script>
  <?php
      if(isset($_GET['logout'])){
          echo "document.getElementById('logOutMessage').innerHTML = 'You have signed out!';";

      }
    ?>
  </script>
  </body>
</html>

<?php
session_start();

?>

<!--All About Page-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>About Micronesia News</title>
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
          <a class="nav-link" href="main.php">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="discussion.php">Discussion</a>
        </li>
        <?php
        if(!isset($_SESSION['user'])){
           echo "<li class='nav-item'>
                      <a class='nav-link' href='signup.php'>Sign Up</a>
                      </li>
                  <li class='nav-item'>
                      <a class='nav-link' href='login.php'>Log in</a>
                      </li>";
          }
         ?>

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
              echo "<label><b>" . $_SESSION['user'] . "</b></label>";
              echo "<li><a id='prof' href='profile.php'>Profile</a></li>
                <li role='separator' class='divider'></li>
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
      <div class="col-lg-10 col-md-offset-5 text-center ">
      <div id= "box" class=" flex jumbotron jumbotron-fluid rounded border border-dark">
        <h1 class="Display-4">Welcome to Micronesia News and Forum</h1>
        <p class="lead" >
          This website features an RSS aggregator/API that pulls recent news from Pacific Islands News Websites (mainly Micronesian related sites).
          Additionally, the website feature a Discussion forum where users can view posts made by users who choose
          to make a profile. Users can also comment on post and have a friendly conversation about a topic. The motivation behind this website was that Pacific news sources are very hard to find
          online and congregating it into one website would satisfy anyone looking to find whats happening in the
          Pacific.
        </p>
        <label><u> Current News Sources for Pacific Island News: Micronesia, Melanesia, Polynesia:</u></label><br/>
        <ul class="text-left border border-dark bg-white">
          <li>Federated States of Micronesia</li>
          <li>Marshall Islands</li>
          <li>Palau</li>
          <li>Guam</li>
          <li>Nauru</li>
          <li>Kiribati</li>
          <li>Fiji</li>
          <li>Vanuatu</li>
          <li>Cook Islands</li>
          <li>Samoa</li>
          <li>Tonga</li>
        </ul>


        <p class="footer">Website features RSS calls using AJAX, JavaScript, JQuery, and PHP for all calls to one
          server that stores/retrieves all related info on an SQL Database on the google cloud.</p>



    </div>
  </div>

  </div>
</body>



</html>

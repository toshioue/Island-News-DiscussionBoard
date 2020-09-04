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
        <p class="lead text-left ml-4" >
          This website features an RSS aggregator/API that pulls recent news from Pacific Islands
          News Websites (mainly Micronesian related sites).<br>
          Additionally, the website feature a Discussion forum where users can create posts about Micronesian - related issues.
         Users can also comment on post and have a friendly conversation about a topic.
          The motivation behind this website was that Pacific news sources are very hard to find
          online and congregating it into one website would satisfy anyone looking to find whats happening in the
          Pacific.
        </p>
        <label><u> Current News Sources for Pacific Island News: Micronesia, Melanesia, Polynesia:</u></label><br/>
        <ul class="text-left border border-dark bg-white">
          <li>Federated States of Micronesia - <a target="_blank" href="https://gov.fm/">gov.fm</a></li>
          <li>Marshall Islands - <a target="_blank" href="https://marshallislandsjournal.com/">marshalislandsjournal.com</a></li>
          <li>Palau - <a target="_blank" href="#">Tia Belau news - Facebook</a></li>
          <li>Guam - <a target="_blank" href="#">PNC News</a></li>
          <li>Nauru - <a target="_blank" href="https://nauru-news.com">Nauru News</a></li>
          <li>Kiribati - <a target="_blank" href="https://kiribatiupdates.com">Belau news - Facebook</a></li>
          <li>Fiji - <a target="_blank" href="https://fbcnews.com.fj">Fiji Broadcasting Corp.</a></li>
          <li>Vanuatu - <a target="_blank" href="https://dailypost.vu">Vanuautu Daily Posts</a></li>
          <li>Cook Islands - <a target="_blank" href="https://cookislandnews.com">Cook Island News</a></li>
          <li>Samoa - <a target="_blank" href="https://samoannews.com">Samoan News</a></li>
          <li>Tonga - <a target="_blank" href="https://nukualofatimes.tbu">NukuAlofa News</a></li>
        </ul>


        <p class="footer">Website features RSS calls using AJAX, JavaScript, JQuery, and PHP for all calls to one
          server that stores/retrieves all related info on an SQL Database on the google cloud.</p>



    </div>
  </div>

  </div>
</body>



</html>

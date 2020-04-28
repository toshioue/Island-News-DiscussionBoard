<?php
session_start();
//check if user is logged in or not



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=IE8" charset="utf-8" />
    <title>Oceania News-Forum</title>
    <!-- Bootstrap core CSS -->
 <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link href="bootstrap/icon/font/css/open-iconic-bootstrap.css" rel="stylesheet">
 <script src="ajax.js"></script>
 <!-- Extra-->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link href="main.css" rel="stylesheet">
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->


<!--<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>-->



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

          <li id="home" class="nav-item active">
            <a class="nav-link" href="#" >Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Discussion</a>
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
            <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenu1">
              <?php
                if(isset($_SESSION['user'])){
                  echo "<label>" . $_SESSION['user'] . "</label>";
                }
               ?>
              <li><a href="#">Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Settings</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="login.php?logout=yes">Sign out</a></li>
              <li role="separator" class="divider"></li>

            </ul>
          </div>







      </div>
    </div>
  </nav>
  <!--END OF Navigation -->






  <!--RSS NEWS FEED-->
  <body style="background-image: url('img/sokehs.jpg');">
  <div class="container-fluid">
  <div class="row">

    <div class="col-lg-9" >
      <!--main RSS news feed display -->
      <div class="text-center text-light"><h1>Oceania News Headlines</h1></div>
        <div  id=feed></div>
        <div class="d-flex justify-content-center">
          <div id='spinner' class=" spinner-border spinner-border-lg text-light" role="status">
            <span class="sr-only text-light h2">Loading...</span>
          </div>
        <span id="load" class="text-light" style="font-size: 30px; display: none;">Loading...</span>
        </div>
    </div>
    <!--Side Bar with toggles and side Features-->
    <div id="sideBar" class="col-md-3 border border-dark bg-dark" >
         <div class="sticky-top"><h3>Side bars in the works</h3>

         </div>
    </div>
</div>

  </div>

  <!-- Modal -->
  <?php if(isset($_SESSION['created'])){
  echo file_get_contents('modal.html');
  unset($_SESSION['created']);
  }?>

<!--/***********START OF JAVASCRIPT PORTION*****************************/ -->
<script>

  function setFeed(xmlObject){
    console.log("setFeed() called");
    //determine if spinner loader exists, remove it from webpage
    if(xmlObject == 0 ){
      console.log('stopped');
      $('#load').css('display', 'none');
      return;
    }



    //demterines if news needs to be appended or shown when webpages loads
    if(globalNewsCount != 0){
      console.log("got appended");
      $(xmlObject).hide().appendTo("#feed").fadeIn(1000);

     $('html, body').animate({scrollTop: '+=300px'}, 300);

    /////////////////////////////////////////////////////////////////////////
    }else{
      $('#feed').html(xmlObject).hide();
      $('#feed').fadeIn(1000);
    }

    if($('#load').css('display') == 'flex'){
      console.log("set to none");
      $('#load').css('display', 'none');
    }

    if ($("#spinner").length > 0){
      console.log("spinner removed");
      $('#spinner').remove();
    }
  }

  //call towards server to get xml feeds;
  var globalNewsCount = 0; //gloal variable that keep tracks of # of news sources loaded to page.
  //ajax call to server to get news
  AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');

  //Jquery reaction to run Ajax call when user scrolls to bottom of page to load more news
  $(window).scroll(function() {
    //console.log($(window).scrollTop());
      if($(window).scrollTop() == $(document).height() - $(window).height() && globalNewsCount < 7 ) {
          //$('html, body').animate({scrollTop: '-=5px'}, 200);

            console.log("bottom of page hit");


            $('#load').css('display', 'flex');
            globalNewsCount++; //increment news sources to load

             // ajax call get data from server and append to the #feed div
            AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');
      }
  });

  $(window).resize(function() {
    var windowsize = $(window).width();
    if (windowsize < 800) {
      console.log(windowsize + " collapse");

      //if the window is greater than 440px wide then turn on jScrollPane..
      //$('#sideBar').remove();
    }
  });


  $(window).on('load',function(){
       $('#Modal').modal('show');
   });
</script>



  </body>
</html>

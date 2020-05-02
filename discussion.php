<?php
session_start();
require_once('mysql.inc.php');    # MySQL Connection Library
include 'functions.php';
//check if user is logged in or not

if(isset($_POST['submitPost']) && isset($_SESSION['user'])){
//function for inserting posts
$db = new myConnectDB();          # Connect to MySQL
//check if connecting to DB draws error
if (mysqli_connect_errno()) {
  echo "<h5>ERROR: " . mysqli_connect_errno() . ": " . mysqli_connect_error() . " </h5><br>";
}
//this function is from function.php that will run a insert sql statement
insertPost($db, $_POST['title_post'],  $_POST['body_post'], $_SESSION['user'], $_POST['cat_post']);
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=IE8" charset="utf-8" />
    <link rel="icon" type="image/jpg" href="#">
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

  <style>

    button:hover {
      background-color: red;
    }
    .jumbotron {
      height: auto;

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
            <input class="form-control" type="search" placeholder="Search News or Users.." aria-label="Search">
            <button class="btn btn-sm btn-outline-primary " type="submit">Search</button>
          </form>

          <li id="home" class="nav-item">
            <a class="nav-link" href="main.php" >Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item active">
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






  <!--RSS NEWS FEED-->
  <body style="background-image: url('img/sokehs.jpg');">
  <div class="container-fluid">
  <div class="row">

    <div class="col-lg-9" >
      <!--main RSS news feed display -->
      <div class="text-center text-light mt-2"><h1>Discussion Board</h1></div>
        <div class='jumbotron jumbotron-fluid rounded-top ' id='feed'>
        <div id='spinnerDiv' class="d-flex justify-content-center mt-3">
          <div id='spinner' class="spinner-border spinner-border-lg text-dark" role="status">
            <span class="sr-only text-light h2">Loading...</span>
          </div>
        <span id="load" class="text-light" style="font-size: 30px; display: none;">Loading...</span>
        </div>
      </div>
    </div>
    <!--Side Bar with toggles and side Features-->
    <div id="sidenav" class="col-lg-3 border-left border-primary bg-dark bg-transparent" >
         <div class="sticky-top">
           <div class="container bg-light rounded py-4 text-center"><button id="postButton" type="button" class="btn btn-lg py-3 px-10  btn-danger">Create a Post</button></div>
           <div class="h2 text-center">Filters</div>
        </div>
    </div>

  </div>

  <!-- Modal -->
  <?php
  //THIS ONLY RUNS WHEN USERS SIGNS UP FOR FIRST TIME
  if(!isset($_SESSION['user'])){
    echo file_get_contents('modal.html');
  }?>

<!--/***********START OF JAVASCRIPT PORTION*****************************/ -->
<script>
  $('#Modal').modal('hide');

  //this if statement prevents sendning POST values when pages is refreshed
  if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
  function setFeed(xmlObject){
    console.log("setFeed() called");
    //determine if spinner loader exists, remove it from webpage
    if(xmlObject == 0 ){
    //  done = true;
      console.log('no more posts');
      $('#load').css('display', 'none');

      //will enter loop if server return no posts; removes spinner and adds message
      if ($("#spinner").length > 0){
        console.log("spinner removed");
        spinner = $('#spinner').detach();
        document.getElementById('feed').innerHTML = "<h2 class='text-center'>No Posts have been made yet :(</h2>";

      }
      return;
    }



    //demterines if news needs to be appended or shown when webpages loads
    if(globalPostCount != 0){
      console.log("got appended");
      $(xmlObject).hide().appendTo("#feed").fadeIn(1000);

     $('html, body').animate({scrollTop: '+=300px'}, 300);


    /////////////////////////////////////////////////////////////////////////
    }else{
      $('#feed').html(xmlObject).hide();
      $('#feed').fadeIn(1000);
      console.log("spinner removed");
      spinner = $('#spinner').detach();
    }

    if($('#load').css('display') == 'flex'){
      console.log("set to none");
      $('#load').css('display', 'none');
    }

  /*  if ($("#spinner").length > 0){
      console.log("spinner removed");
      spinner = $('#spinner').detach();
    }*/
    wait = false;
  }




  //call towards server to get xml feeds;
  var globalPostCount = 0; //gloal variable that keep tracks of # of news sources loaded to page.
  var done = false; // global variable to determine when all news have loadede-attached spinner
  var wait = false; //global variable boolean for disabling bottom loading
  var spinner; //global variable to store spinner for map/scroll switch
  //ajax call to server to get news
  AJAX_GET('next.php', {'postCount': globalPostCount}, setFeed, '');
  //call('https://api.weather.gov/points/6.892113,158.214691', check);

  //Jquery reaction to run Ajax call when user scrolls to bottom of page to load more news
/*  $(window).scroll(function() {
    //console.log($(window).scrollTop());
      if($(window).scrollTop() == $(document).height() - $(window).height() && done == false && wait == false) {
          //$('html, body').animate({scrollTop: '-=5px'}, 200);

            console.log("bottom of page hit");


            $('#load').css('display', 'flex');
            globalPostCount++; //increment news sources to load
            wait = true;
             // ajax call get data from server and append to the #feed div
            AJAX_GET('next.php', {'newsCount': globalPostCount}, setFeed, '');
      }
  });*/

  //only for printing out window size when window is resized. no other use.
  $(window).resize(function() {
    var windowsize = $(window).width();
    if (windowsize < 800) {
      console.log(windowsize + " collapse");
    }
  });


  //////////////////////////////////////

   //used for button group when switching news layout
   /*$(".btn-group > .btn").click(function(){
     $(this).addClass("active").siblings().removeClass("active");
   });*/
   //////////////////////////////////////

   //when button group gets click
   $(".btn-secondary").click(function(){
       console.log($(this).html());
       if($(this).html() == 'scroll'){
          document.getElementById('feed').innerHTML = "";
          spinner.appendTo('#spinnerDiv');
          spinner = null;
          globalPostCount = 0;
          done = false;
          AJAX_GET('next.php', {'postCount': globalPostCount}, setFeed, '');
        }else{
          //JS scetion reserved for three.js
        }

     });


  function postRequest(){
    //AJAX call for making post
    console.log("make post");
    document.getElementById('feed').innerHTML = "";
    spinner.appendTo('#spinnerDiv');
    spinner = null;
    document.getElementById('postButton').innerHTML = "<a class='btn text-light' href='discussion.php'>back to Board</a>";
    //document.getElementById('postButton').disabled = true;
    $('#postButton').removeAttr('onClick');
    AJAX_GET('next.php', {'getEdit': 1}, setFeed, '');

  }

  function modalSign(){
    console.log("must create account");
    $('#modalTitle').html('Oceania News & Forum');
    $('#modalBody').html('To participate in the Forum you must create an account or log on.');
    $('#modalFooter').html("<a href='signup.php' class='btn btn-danger '  role='button'>Sign up</a><a href='login.php' class='btn btn-warning'   role='button'>Log in</a>");
    $('#Modal').modal('show');

  }

     <?php
        if(isset($_SESSION['user'])){
            echo "$('#postButton').attr('onClick', 'postRequest();');";
        }else{
          echo "$('#postButton').attr('onClick', 'modalSign();');";
        }


     ?>




</script>



  </body>
</html>

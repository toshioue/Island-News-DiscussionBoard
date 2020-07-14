<?php
session_start();
require_once('mysql.inc.php');    # MySQL Connection Library
include 'functions.php'; //inlcuded to run insertPost() function

//check if user is logged in or not
if(isset($_POST['submitPost']) && isset($_SESSION['user'])){
$db = new myConnectDB();    # Connect to MySQL
//check if connecting to DB draws error
if (mysqli_connect_errno()) {
  echo "<h5>ERROR: " . mysqli_connect_errno() . ": " . mysqli_connect_error() . " </h5><br>";
}
//function for inserting posts
//this function is from function.php that will run a insert sql statement
insertPost($db, $_POST['title_post'],  $_POST['body_post'], $_SESSION['user'], $_POST['cat_post']);
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=IE8" charset="utf-8" />
    <link rel="icon" type="image/jpg" href="#">
    <title>Micronesia News-Forum</title>
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

  <style>
    button:hover {
      background-color: #DC143C;
    }
    .jumbotron {
      height: auto;
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

        <!--  <form id="searchBar" class="form-inline">
            <input class="form-control" type="search" placeholder="Search News or Users.." aria-label="Search">
            <button class="btn btn-sm btn-outline-primary " type="submit">Search</button>
          </form>-->

          <li id="home" class="nav-item">
            <a class="nav-link" href="main.php" >News
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="discussion.php">Discussion</a>
          </li>
          <!--extra tags if user is logged in or not-->
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
            <a class="nav-link" href="about.php">About</a>
          </li>
        </ul>


        <!--profile dropdown -->
        <div id="drop" class="dropdown align-right">
            <button class="btn btn-primary btn-circle btn-sm  " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <span class="oi oi-person"></span>
              <span class="caret"></span>
            </button>
              <?php
                if(isset($_SESSION['user'])){
              echo"<ul class='dropdown-menu text-center' aria-labelledby='dropdownMenu1'>";
              echo "<label><b>" . $_SESSION['user'] . "</b></label>";
              echo "<li><a id='prof' href='#'>Profile</a></li>
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


  <!--Disucssion Posts-->
  <body style="background-image: url('img/sokehs.jpg');  background-attachment: fixed; background-position: center bottom; ">
  <div class="container-fluid">
  <div class="row">

    <div class="col-lg-9" >
      <!--main Discussion Post display -->
      <div class="text-center text-light mt-1"><h1>Discussion Board</h1></div>
        <div class='jumbotron rounded-top' id='feed'>
        <div id='spinnerDiv' class="d-flex justify-content-center mt-3">
          <div id='spinner' class="spinner-border spinner-border-lg text-dark" role="status">
            <span class="sr-only text-light h2">Loading...</span>
          </div>
        <span id="load" class="text-light" style="font-size: 30px; display: none;">Loading...</span>
        </div>
      </div>
    </div>
    <!--Side Bar with toggles and side Features-->
    <div id="sidenav" class="col-lg-3 border-left border-primary bg-dark " ><!--bg-transparent-->
         <div class="sticky-top">
           <div class="container bg-light rounded py-4 text-center"><button id="postButton" type="button" class="btn btn-lg py-3 px-10  btn-danger">Create a Post</button></div><br/>
           <div class="h2 text-center container ">
             <!--Filter for Discussion psts-->
             <p><u>Filters</u></p>
             <div class="btn-group btn-group-sm mr-2 text-center" role="group" aria-label="First group" style="border-radius: 45px;">
               <button type="button" class="btn btn-secondary active">Newest</button>
               <button type="button" class="btn btn-secondary">most Views</button>
               <button type="button" class="btn btn-secondary">most Comments</button>
             </div>

           </div>
        </div>
    </div>

  </div>

  <!-- Modal -->
  <?php
  //THIS ONLY RUNS WHEN USERS HAS NOT signed up yet
  if(!isset($_SESSION['user'])){
    echo file_get_contents('modal.html');
  }?>

<!--/***********START OF JAVASCRIPT PORTION*****************************/ -->
<script>
  $('#Modal').modal('hide'); // hide modal jus in case

  //this if statement prevents sendning POST values when pages is refreshed
  if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }

  //generic function that will load dicsussion posts in container
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



    //demterines if posts needs to be appended or shown when webpages loads
    if(globalPostCount != 0){
      console.log("got appended");
      $(xmlObject).hide().appendTo("#feed").fadeIn(1000);

     $('html, body').animate({scrollTop: '+=300px'}, 300);


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

    if ($("#spinner").length > 0){
      console.log("spinner removed");
      spinner = $('#spinner').detach();
    }
    wait = false;
  }




  //call towards server to get xml feeds;
  var globalPostCount = 0; //gloal variable that keep tracks of # of news sources loaded to page.
  var done = false; // global variable to determine when all news have loadede-attached spinner
  var wait = false; //global variable boolean for disabling bottom loading
  var spinner; //global variable to store spinner for map/scroll switch

  //ajax call to server to get discussion posts.
  AJAX_GET('next.php', {'postCount': globalPostCount}, setFeed, '');


  //only for printing out window size when window is resized. no other use.
  $(window).resize(function() {
    var windowsize = $(window).width();
    if (windowsize < 800) {
      console.log(windowsize + " collapse");
    }
  });


  //////////////////////////////////////

   //used for button group when switching posts layout
   $(".btn-group > .btn").click(function(){
     $(this).addClass("active").siblings().removeClass("active");
   });
   //////////////////////////////////////

   //Filter for Newest, mostViews, most comments
   $(".btn-secondary").click(function(){
       console.log($(this).html());
       document.getElementById('feed').innerHTML = "";
       $("#load").css('display', 'block');
       $("#load").append("<p>Loading....</p>");
       spinner.appendTo('#load');
       spinner = null;
       globalPostCount = 0;
       done = false;
       if($(this).html() == 'Newest'){
          AJAX_GET('next.php', {'postCount': globalPostCount, 'filter' : 0}, setFeed, '');
        }else if ($(this).html() == 'most Views'){
          AJAX_GET('next.php', {'postCount': globalPostCount, 'filter' : 1 }, setFeed, '');
        }else if ($(this).html() == 'most Comments'){
          AJAX_GET('next.php', {'postCount': globalPostCount, 'filter' : 2}, setFeed, '');
        }else{ }

     });

  //function for when user wants to see an indvidual post
  function showPost(obj){
    //console.log(obj.value);
    //clear div
    document.getElementById('postButton').innerHTML = "<a  class='btn text-light' href='discussion.php'>back to Board</button>";
    document.getElementById('feed').innerHTML = "<h3 class='text-center'>Loading....</h3>";

    spinner.appendTo('#spinnerDiv');
    spinner = null;
    $('#postButton').removeAttr('onClick');
    //ajax call for getting specific post ID
    AJAX_GET('next.php', {'onePost': obj.value}, setFeed, '');

  }
  //function called when user is logged in and wants to insert a comment
  function insertComment(postID){
      var comment = document.getElementById('insertComment').value;
    //  console.log(postID + " " + com );
      console.log('inserting a comment');
      if(comment != ""){
        AJAX_GET('next.php', {'insertComment': postID, 'comment' : comment}, reloadPost, '');
      }
  }
  //chain function call when comment is successfully inserted
  function reloadPost(id){
    console.log('comment added, reloading.. ' + id);
    AJAX_GET('next.php', {'onePost': id}, setFeed, ''); // reloads the specific discussion post
  }

  //loads the post template
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

  //show modal if user is not logged in
  function modalSign(){
    console.log("must create account");
    $('#modalTitle').html('Micronesia News & Forum');
    $('#modalBody').html('To participate in the Forum you must create an account or log on.');
    $('#modalFooter').html("<a href='signup.php' class='btn btn-danger '  role='button'>Sign up</a><a href='login.php' class='btn btn-warning'   role='button'>Log in</a>");
    $('#Modal').modal('show');

  }

     <?php
      //changes button event based on if user is logged in or not
        if(isset($_SESSION['user'])){
            echo "$('#postButton').attr('onClick', 'postRequest();');";
        }else{
          echo "$('#postButton').attr('onClick', 'modalSign();');";
        }


     ?>
   </script>

</body>
</html>

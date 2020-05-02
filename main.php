<?php
session_start();
//check if user is logged in or not

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=IE8" charset="utf-8" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <!--  <form id="searchBar" class="form-inline">
            <input class="form-control" type="search" placeholder="Search News or Users.." aria-label="Search">
            <button class="btn btn-sm btn-outline-primary " type="submit">Search</button>
          </form>-->

          <!--navbar Tabs-->
          <li id="home" class="nav-item active">
            <a class="nav-link" href="#" >Home
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
            <a class="nav-link" href="about.php">About</a>
          </li>
        </ul>



        <div id="drop" class="dropdown align-right">
            <button class="btn btn-primary btn-circle btn-sm  " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <span class="oi oi-person"></span>
              <span class="caret"></span>
            </button>
            <!--Below is for profile dropdown-->
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






  <!--RSS NEWS FEED-->
  <body style="background-image: url('img/sokehs.jpg');">
  <div class="container-fluid">
  <div class="row">

    <div class="col-lg-9" >
      <!--main RSS news feed display -->
      <div class="text-center text-light"><h1>Oceania News Headlines</h1></div>
        <div  id='feed'></div>
        <div id='spinnerDiv' class="d-flex justify-content-center mt-3">
          <div id='spinner' class="spinner-border spinner-border-lg text-light" role="status">
            <span class="sr-only text-light h2">Loading...</span>
          </div>
        <span id="load" class="text-light" style="font-size: 30px; display: none;">Loading...</span>
        </div>
    </div>
    <!--Side Bar with toggles and side Features-->
    <div id="sidenav"  class="col-lg-3 border-left border-primary bg-dark" >
         <div class="sticky-top">

           <p class=" h4 text-center underline"><u>News Layout</u><p>
            <div class="btn-toolbar justify-content-center " role="toolbar" aria-label="Toolbar with button groups">
              <div class="btn-group btn-group-lg mr-2 border border-light" role="group" aria-label="First group" style="border-radius: 45px;">
                <button type="button" class="btn btn-secondary active">scroll</button>
                <button type="button" class="btn btn-secondary">map</button>
              </div>

            </div>
            <!-- Radio buttons for filtering News -->
      <div id="radios" class="container text-center">
          <br/><br/><p class="h3 text-center underline"><u>Filters</u><p>

            <!-- Micronesia - option 1 -->
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios" value='1'>
              <label class="custom-control-label" for="defaultGroupExample1" value='1'>Micronesia</label>
            </div>

            <!-- Melanesia - option 2 -->
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="groupOfDefaultRadios" value='2' >
              <label class="custom-control-label" for="defaultGroupExample2" >Melanesia</label>
            </div>

            <!-- Polynesia - option 3 -->
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="defaultGroupExample3" name="groupOfDefaultRadios" value='3'>
              <label class="custom-control-label" for="defaultGroupExample3" >Polynesia</label>
            </div>
          </div>
        </div>
</div>

  </div>

  <!-- Modal -->
  <?php
  //THIS ONLY RUNS WHEN USERS SIGNS UP FOR FIRST TIME
  if(isset($_SESSION['created'])){
    echo file_get_contents('modal.html');
    unset($_SESSION['created']);
  }?>

<!--/***********START OF JAVASCRIPT PORTION*****************************/ -->
<script>

  //function is used for seting News feed when server responds with news
  function setFeed(xmlObject){
    console.log("setFeed() called");
    //determine if spinner loader exists, remove it from webpage
    if(xmlObject == 0 ){
      done = true;
      console.log('stopped');
      $('#load').css('display', 'none');
      return;
    }

    //demterines if news needs to be appended or shown when webpages loads
    if(globalNewsCount != 0){
      console.log("got appended");
      $(xmlObject).hide().appendTo("#feed").fadeIn(1000);

     $('html, body').animate({scrollTop: '+=300px'}, 600);

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
      spinner = $('#spinner').detach();
    }
    wait = false;
  }

//function used for checking what AJAX gets called ; debugging purposes
function check(response){
  console.log('check got called');
  //console.log(response);
}

  //call towards server to get xml feeds;
  var globalNewsCount = 0; //gloal variable that keep tracks of # of news sources loaded to page.
  var done = false; // global variable to determine when all news have loadede-attached spinner
  var wait = false; //global variable boolean for disabling bottom loading
  var spinner; //global variable to store spinner for map/scroll switch
  var fil = 0

  //ajax call to server to get news
  AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');
  //call('https://api.weather.gov/points/6.892113,158.214691', check);

  //Jquery reaction to run Ajax call when user scrolls to bottom of page to load more news
  $(window).scroll(function() {
    //console.log($(window).scrollTop());
      if($(window).scrollTop() == $(document).height() - $(window).height() && done == false && wait == false) {
            console.log("bottom of page hit");

            $('#load').css('display', 'flex');
            globalNewsCount++; //increment news sources to load
            wait = true;
             // ajax call get data from server and append to the #feed div
            AJAX_GET('next.php', {'newsCount': globalNewsCount, 'filterNews' : fil}, setFeed, '');
      }
  });

  //only for printing out window size when window is resized. no other use. debugging
  $(window).resize(function() {
    var windowsize = $(window).width();
    if (windowsize < 800) {
      console.log(windowsize + " collapse");
    }
  });

  //used for js modal pop up when page finish loading when there is a sign up/new user
  $(window).on('load',function(){
       $('#Modal').modal('show');
   });
  //////////////////////////////////////

   //used for button group when switching active news layout map or scroll
   $(".btn-group > .btn").click(function(){
     $(this).addClass("active").siblings().removeClass("active");
   });
   //////////////////////////////////////

   //when button group gets click for map or scroll layout
   $(".btn-secondary").click(function(){
       console.log($(this).html());
       if($(this).html() == 'scroll'){
          document.getElementById('feed').innerHTML = "";
          spinner.appendTo('#spinnerDiv');
          spinner = null;
          globalNewsCount = 0;
          done = false;
          AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');
        }else if($(this).html() == 'map'){
          done = true;
          document.getElementById('feed').innerHTML = "<iframe class='border border-dark' width='100%' height='450' src='https://embed.windy.com/embed2.html?lat=-2.285&lon=168.047&zoom=3&level=surface&overlay=wind&menu=&message=true&marker=true&calendar=&pressure=&type=map&location=coordinates&detail=&detailLat=33.816&detailLon=-117.969&metricWind=kt&metricTemp=%C2%B0F&radarRange=-1' frameborder='0'></iframe>"
        }else{}

     });

     //function runs when radio buttons gets toggle so specific news can be loaded
     $('#radios input:radio').click(function() {
        //console.log('radio clicked ' + $(this).val());
        document.getElementById('feed').innerHTML = "";
        spinner.appendTo('#spinnerDiv');
        spinner = null;
        fil = $(this).val();
        done = false;
        globalNewsCount = 0;
        AJAX_GET('next.php', {'newsCount': globalNewsCount, 'filterNews' : fil }, setFeed, '');

   });

</script>

  </body>
</html>

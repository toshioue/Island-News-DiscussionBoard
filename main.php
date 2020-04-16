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
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->


<!--<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>-->



 <style>
  #searchBar {
    margin-left: 10px;
  }

  body{
    padding-top: 65px;
    /*margin-bottom: 30px;*/

  }
  .btn-circle {
    margin-left: 12px;
    width: 50px;
    height: 50px;
    padding: 6px 0px;
    border-radius: 20px;
    font-size: 20px; //controls personicon
    text-align: center;
  }

  .sticky-top {
    padding-top: 100px;
  }

  @media screen and (min-width: 800px) { /*The following CSS runs only for displays with a width (in pixels) of more than 800px*/
    body {
        font-size: 100%;
    }
}

@media screen and (max-width: 800px) { /*The following CSS runs only for displays with a width (in pixels) of less than 800px*/
    body {
        font-size: 12px;
    }
}

.post-content{
  font-size: 20px;
}

/*img:hover {
  width: 80%;
  height:80%;
}*/





#spinner{
  height: 10rem;
  width: 10rem;
  font-weight: bold;
  visibility: visible;
  margin-bottom: 20px;
}

#reveal {
  visibility: hidden;
}

.col-lg-9 {
  background-color: #eeeeff
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
                        <a class='nav-link' href='#'>Sign Up</a>
                        </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#''>Log in</a>
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

  <!--RSS NEWS FEED-->
  <body>
  <div class="container-fluid">
  <div class="row">

    <div class="col-lg-9" >
      <div class="text-center"><h1>Oceania News Headlines</h1></div>
        <div  id=feed></div>
        <div class="d-flex justify-content-center">
          <div id='spinner' class=" spinner-border spinner-border-lg" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      <!--  <div class="text-center">
          <button id='reveal' style="opacity: 0.6;" type="button" class="btn btn-secondary btn-lg btn-block oi oi-expand-down"></button>
      </div>-->

    </div>
    <div id="sideBar" class="col-sm-3 border border-dark " >
         <div class="sticky-top"><h1>Hello World</h1>

    </div>
  </div>
</div>




  </div>
<script>
  function setFeed(xmlObject){
    console.log("set");
  //  document.getElementById("feed").innerHTML = xmlObject;
    document.getElementById('spinner').style.visibility = 'collapse';
    document.getElementById('spinner').style.height = '2px';
    $('#spinner').removeClass('spinner-border');
    //make reveal button visible
    //document.getElementById('reveal').style.visibility = 'visible';
    if(globalNewsCount != 0){
      console.log("got appended");
      $(xmlObject).hide().appendTo("#feed").fadeIn(1000);

    }else{
      $('#feed').html(xmlObject).hide();
      $('#feed').fadeIn();
    }
  }
  //call towards server to get xml feeds;
  var globalNewsCount = 0;
  AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');

  //Jquery to run Ajax call when wuser scrolls to bottom of page to load more news
  $(window).scroll(function() {
      if($(window).scrollTop() == $(document).height() - $(window).height()) {
            console.log("bottom of page hit");
            //this makes spinner viewable or button
            //document.getElementById('spinner').style.visibility = 'visible';
            //document.getElementById('spinner').style.height = '10rem';
            //$('#spinner').addClass('spinner-border');
            //increment globalNewsCount var to load new news
            globalNewsCount++;
             // ajax call get data from server and append to the div
            AJAX_GET('next.php', {'newsCount': globalNewsCount}, setFeed, '');
      }
  });

</script>


  </body>
</html>

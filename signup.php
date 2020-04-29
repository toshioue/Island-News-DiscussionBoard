<?php
session_start();

include 'functions.php';

if(isset($_POST['createUser'])){

//grab all the provided fields in signup dialog
$username = $_POST['enteredUser'];
$first = $_POST['enteredFirst'];
$last = $_POST['enteredLast'];
$pswd = password_hash($_POST["enteredPswd"], PASSWORD_DEFAULT);

require_once('mysql.inc.php');    # MySQL Connection Library
$db = new myConnectDB();          # Connect to MySQL

//check if connecting to DB draws error
if (mysqli_connect_errno()) {
  echo "<h5>ERROR: " . mysqli_connect_errno() . ": " . mysqli_connect_error() . " </h5><br>";
}


//insert values from post to the Database
if(isset($_POST["enteredUser"])){
  $insert = "INSERT INTO Users (Username, FirstName, LastName, Password) VALUES (?, ?, ?, ?)";
  $stmt = $db->stmt_init();
  $stmt->prepare($insert);
  //bind
  $stmt->bind_param('ssss', $username, $first, $last, $pswd);
  $sucess = $stmt->execute();


  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    //echo "<h2>ERROR: " . $db->error . "for query</h2>"; // error statement
    $insertion = false;
  }else{
    //echo "<h2>Signup Success!</h2>"; //print if entry is sucess!
    $stmt->close();

    $_SESSION['user'] = $username;
    $_SESSION['created'] = true;
    insertSessionID($db, $username, session_id());
    header("Location: main.php");
  }
}


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
          <a class="nav-link" href="login.php">Login</a>
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
      <div class="col-md-6 col-md-offset-3 ">
      <div id= "box" class=" flex jumbotron jumbotron-fluid rounded border border-dark">

        <div class="form-group  justify-content-center">
          <div class="col-xs-4">
          <form method="POST" action="signup.php" >
            <h3 class="display-5 text-center">Sign up</h3>
            <p>Create an account to participate in forum and specialize news to your preference!</p>
            <label id="username"  class="lead" for="form-control">Username:</label>
            <span id="usermistake" style="color: red;"> </span>
            <input  type="text" onkeydown="wipe()"  class="form-control " name="enteredUser" placeholder="Rice21.." required><br>
            <label  class="lead" for="form-control">First Name:</label> <!--<sub>-must be at least 5 characers long.</sub>-->
            <input  type="text" class="form-control" name="enteredFirst" required><br />

            <label class="lead" for="form-control">Last Name:</label> <!--<sub>-must be at least 5 characers long.</sub>-->
            <input  type="text" class="form-control" name="enteredLast" required><br />

            <label class="lead" for="form-control">Password:</label> <!--<sub>-must be at least 5 characers long.</sub>-->
            <input  type="password" onkeydown="checkLength(this.value)" class="form-control" name="enteredPswd" required><br />
            <span id="pswdmistake" style="color: red;"> </span>
            <div class="text-center">
            <button type="submit" id="newsubmit"  name="createUser" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary ">Reset</button>
            </div>
          </form>
        </div>
        </div>


    </div>
  </div>

  </div>
  </body>

  <script>
  function checkLength(word){
    if(word.length < 5 ){
      document.getElementById('pswdmistake').innerHTML = "* password needs to be greater length of 5."
      document.getElementById('newsubmit').disabled = true;

    }else{
      document.getElementById('pswdmistake').innerHTML = "";
      document.getElementById('newsubmit').disabled = false;

    }
  }

  function wipe(){
    if(!$('#usermistake').is(':empty')){
      console.log('its not empy')
      $('#usermistake').empty();
    }
  }

  <?php
    if($insertion == false && isset($_POST['enteredUser'])){
      echo "document.getElementById('usermistake').innerHTML = '* username has already been used';";
    }
    ?>


  </script>
</html>

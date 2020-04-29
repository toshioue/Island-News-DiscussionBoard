<?php

  session_start();                  # Start the Session
  include 'functions.php';
  
  require_once('mysql.inc.php');    # MySQL Connection Library
  $db = new myConnectDB();          # Connect to MySQL


  //check if connecting to DB draws error
  if (mysqli_connect_errno()) {
    echo "<h5>ERROR: " . mysqli_connect_errno() . ": " . mysqli_connect_error() . " </h5><br>";
  }


  $sessionid = session_id();        # Retrieve the session id

  // LOGON THE USER (if requested)  # Check to see if user/password were sent
  if (isset($_POST['username']) && isset($_POST['password'])) {
                                    # Validate the user/password combination
    if (!logon($db, $_POST['username'], $_POST['password'], $sessionid)) {
      header('Location: login.php');# Redirect the user to the login page
      die;                          # End the script (just in case)
    }
  }

  // VERIFY THE USER IS LOGGED ON
  $user = verify($db, $sessionid);  # Verify the user, return username or ''
  if ($user == '') {                # User was not successfully verified!
    header('Location: login.php');  # Redirect the user to the login page
    die;                            # End the script (just in case)
  }

  // LOGOFF THE USER
  if (isset($_REQUEST['logoff'])) { # Did the user request to logoff?
    logoff($db, $sessionid);        # Remove the row with this sessionid
    header('Location: login.php');  # Redirect the user to the login page
    die;                            # End the script (just in case)
  }

?>

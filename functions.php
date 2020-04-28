<?php

session_start();
function logon($db, $username, $password, $sessionid) {
  $query = "SELECT Password FROM Users WHERE Username =?";
  $query3 = "INSERT INTO Sessions (User, SessionID) VALUES (?, ?)";
  $hash = '';


  $stmt = $db->stmt_init();
  $stmt->prepare($query);

  //bind
  $stmt->bind_param('s', $username);
  $sucess = $stmt->execute();

  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    //echo "ERROR: " . $db->error . " for query"; // error statement
    //echo "username does not exists in DB";
    return False;
  }else{
      //check if returned hash is correct;
      $stmt->bind_result($hash);
  while($stmt->fetch()){
    //echo $hash . "\n";
    //echo password_hash($password, PASSWORD_DEFAULT);
        //check if passwords match
  if(password_verify($password, $hash)){

    $stmt->close();
    $stmt = $db->stmt_init();
    $stmt->prepare($query3);
    $stmt->bind_param('ss', $username, $sessionid);
    $sucess = $stmt->execute();
      if(!$sucess || $db->affected_rows == 0){
      //  echo "ERROR: " . $db->error . " for query*"; // error statement
        return False;
      }
   //echo "It worked, looged in";
   return True;
  }else
  //  echo "password did not match";
    return False;
  }
    }
}

function getSession($db, $username){
  $query = "SELECT Session from Users where Username=?";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('s', $username);
  $sucess = $stmt->execute();


  //check for query error
  if(!$sucess || $db->affected_rows == 0){
    //  echo "ERROR: " . $db->error . "for query"; // error statement

  }else{
    $session = "";
    $stmt->bind_result($session);
    while($stmt->fetch()){
      return $session;
    }
  }

    $stmt->close(); //close stmt
}



function update($db, $username, $session_string){
  $query = "UPDATE Users set Session =? where Username=?";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('ss', $session_string, $username);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
      return;
  }

    $stmt->close(); //close stmt
    //echo "it worked, session stored!";

}


/*function verify($db, $sessionid){
  //$user ='';

  $query = "SELECT s.Alpha, a.session
              FROM  Midshipmen a join auth_session s ON a.Alpha = s.Alpha
              WHERE (NOW() < (DATE_ADD(s.lastvisit, INTERVAL 1 HOUR)))
              AND (NOW() < (DATE_ADD(a.lastlogin, INTERVAL 12 MONTH)))
              AND s.id=?";
  $query2 = "UPDATE Midshipmen set lastlogin = NOW() WHERE Alpha=?";

    $stmt = $db->stmt_init();
    $stmt->prepare($query);


    //bind
    $stmt->bind_param('s', $sessionid);
    $sucess = $stmt->execute();
    if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . " for query"; // error statement
      echo "<h3>username does not exists in DB</h3>";
      return '';
    }
    //bind the user to $user variable
    $stmt->bind_result($user, $storedsession);
    //fetch data to the last row --not sure if neccessary--
   while($stmt->fetch()) {}

     //restore the session to the logged in user
    session_decode($storedsession);
      //close the first query
     $stmt->close();

     //start query to update lastvisit
     $stmt = $db->stmt_init();
     $stmt->prepare($query2);


     //bind
     $stmt->bind_param('i', $user);
     $sucess = $stmt->execute();

     if(!$sucess || $db->affected_rows == 0){
       echo "ERROR: " . $db->error . " for query*"; // error statement
       return ;
     }
     $stmt->close();

     return $user;
  }
*/
function logoff($db, $sessionid){
  $query = "DELETE FROM Sessions where SessionID=?";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('s', $sessionid);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
    //  return ;
    return false;
  }
  $stmt->close(); //close stmt
//  echo "It Worked!"; // just for testing purposes
    return true;
}




 ?>

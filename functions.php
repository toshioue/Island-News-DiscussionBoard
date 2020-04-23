<?php

session_start();
function logon($db, $username, $password, $sessionid) {
  $query = "SELECT Hash FROM Midshipmen WHERE Alpha =?";
  $query3 = "INSERT INTO auth_session (Alpha, id) VALUES (?, ?)";
  $hash = '';


  $stmt = $db->stmt_init();
  $stmt->prepare($query);

  //bind
  $stmt->bind_param('i', $username);
  $sucess = $stmt->execute();

  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    echo "ERROR: " . $db->error . " for query"; // error statement
    echo "username does not exists in DB";
    return False;
  }else{
      //check if returned hash is correct;
      $stmt->bind_result($hash);
  while($stmt->fetch()){
        //check if passwords match
  if(password_verify($password, $hash)){

    $stmt->close();
    $stmt = $db->stmt_init();
    $stmt->prepare($query3);
    $stmt->bind_param('is', $username, $sessionid);
    $sucess = $stmt->execute();
      if(!$sucess || $db->affected_rows == 0){
        echo "ERROR: " . $db->error . " for query*"; // error statement
        return False;
      }

   return True;
  }else
    return False;
  }
    }
}

function verify($db, $sessionid){
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

function logoff($db, $sessionid){
  $query = "DELETE FROM auth_session where id=?";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('s', $sessionid);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
      return "no";
  }
  $stmt->close(); //close stmt
  echo "It Worked!"; // just for testing purposes

}


function update($db, $username, $session_string){
  $query = "UPDATE Midshipmen set session =? where Alpha=?";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('si', $session_string, $username);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
      return;
  }

    $stmt->close(); //close stmt
    echo "it worked!";

}


 ?>

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
   $stmt->close();
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



function update($db, $session, $username){
  $query = "UPDATE Users SET Session = ? WHERE Username = ? ";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('ss', $session, $username);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      //echo "ERROR: " . $db->error . "for query"; // error statement

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
  }*/

function insertSessionID($db, $user, $sessionid){
  $insert = "INSERT INTO Sessions (User, SessionID) VALUES (?, ?)";
  $stmt = $db->stmt_init();
  $stmt->prepare($insert);
  //bind
  $stmt->bind_param('ss', $user, $sessionid);
  $sucess = $stmt->execute();


  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    echo "<h2>ERROR: " . $db->error . "for query</h2>"; // error statement
  }else{
    //echo "<h2>Signup Success!</h2>"; //print if entry is sucess!
  }
  $stmt->close();
}


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


function insertPost($db, $title, $body, $author, $cat){
  /////////////////////////////////////////////

  $insert = "INSERT INTO Discussions (Title, Body, Author, Category) VALUES (?, ?, ?, ?)";
  $stmt = $db->stmt_init();
  $stmt->prepare($insert);
  //bind
  $stmt->bind_param('ssss', $title, $body, $author, $cat);
  $sucess = $stmt->execute();


  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    echo "<h2>ERROR: " . $db->error . "for query</h2>"; // error statement
  }else{
    //echo "<h2>Signup Success!</h2>"; //print if entry is sucess!

    $stmt->close();
  }
}


function loadDiscussions($db){

  $query = "SELECT * FROM Discussions";
  $stmt = $db->stmt_init();
  $stmt->prepare($query);

  //bind
  //$stmt->bind_param('s', $username);
  $sucess = $stmt->execute();

  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    //echo "ERROR: " . $db->error . " for query"; // error statement
    //echo "username does not exists in DB";
    echo 0;
  }else{
      $stmt->bind_result($id, $date, $T, $B, $A, $C, $V, $com);
      $count =  0;
      $array= [];
      while($stmt->fetch()){
        //  $array[$count] = array("id"=>$id, "date"=>$date, "title"=>$T, "body"=>$B, "auth"=>$A, "cat"=>$C, "views"=>$V, "com"=>$com);
        //  $count++;
        echo "<button class='flex container rounded border border-secondary m-0' style='width:98%'>
              <h3 class='display-5 text-left'>" . $T . "</h3><hr class='my-1'><div class='lead' style='display: flex; justify-content:space-between;'> <div>By: <kbd> " . $A . "</kbd></div><kbd> Posted: " . $date . "</kbd><div>Views: <kbd> ". $V . "</div><div>Comments: <kbd> ". $com . "</div></button><br/>";

      }
      //return $array;
}
}

function getBody($db){
  
}

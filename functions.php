<?php
session_start();

//verifies if user can log on
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
//return session string
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


//updates user's saved session when logged out
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
//updates # of views on post when it gets viewed
function updateViews($db, $postID){
  $query = "UPDATE Discussions SET Views = Views + 1 WHERE PostID = ? ";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $postID);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
      return;
  }

    $stmt->close(); //close stmt
    //echo "it worked, session stored!";

}

//function to update comment numbers when comment is inserted
function updateCommentTotal($db, $postID){
  $query = "UPDATE Discussions SET numComment= numComment + 1 WHERE PostID = ? ";

  //prepare and bind database $query
  $stmt = $db->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('i', $postID);
  $sucess = $stmt->execute();

  //check for query error
  if(!$sucess || $db->affected_rows == 0){
      echo "ERROR: " . $db->error . "for query"; // error statement
      return;
  }

    $stmt->close(); //close stmt
    //echo "it worked, session stored!";
}


//function for when user logs on, sessionID stores
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

//function for when user logs off save their sessionss
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

//function to insert a post from user
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
//function to insert a comment from a user
function insertComment($db, $postID, $comment, $author){
  $insert = "INSERT INTO Comments (PostID, Comment, Author) Values (?, ?, ?)";
  $stmt = $db->stmt_init();
  $stmt->prepare($insert);
  //bind
  $stmt->bind_param('iss', $postID, $comment, $author);
  $sucess = $stmt->execute();


  //check to see if DB insert was successful if not print DB error
  if(!$sucess || $db->affected_rows == 0){
    echo "<h2>ERROR: " . $db->error . "for query</h2>"; // error statement
  }else{
    //if comment updates succesfully, increment comment total
    updateCommentTotal($db, $postID);
    echo $postID; //print if entry is sucess!

    $stmt->close();
  }
}

//function to load all discusison posts for discussion.php
function loadDiscussions($db, $filter){

  if($filter == 0){
      $query = "SELECT * FROM Discussions ORDER BY PostID DESC;";
  }else if($filter == 1){
      $query = "SELECT * FROM Discussions ORDER BY Views DESC;";
  }else {
    $query = "SELECT * FROM Discussions ORDER BY numComment DESC;";}

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
        $date = date("F j, Y, g:i a", strtotime($date));
        echo "<div class='text-wrap text-break'><button value='$id' onclick='showPost(this)' type='button' class='btn rounded border border-primary m-0' style='width:98%; white-space: normal;'>
              <h3 class=' text-left '>" . $T . "</h3><hr class='my-1'><div class='lead' style='display: flex; justify-content:space-between;'> <div>By: <kbd> " . $A . "</kbd></div><div>Posted: <kbd> " . $date . "</kbd></div><div>Views: <kbd> ". $V . "</div><div>Comments: <kbd> ". $com . "</div></button></div><br/>";

      }
      //return $array;
}
}

//function to get specific post and comments
function getPost($db, $postID){


    $query = "SELECT * FROM Discussions where PostID = ?";
    $query2 = "SELECT Comment, Author, Stamp FROM Comments where PostID = ?";
    $stmt = $db->stmt_init();
    $stmt->prepare($query);
    //bind
    $stmt->bind_param('i', $postID);
    $sucess = $stmt->execute();
    //check to see if DB insert was successful if not print DB error
    if(!$sucess || $db->affected_rows == 0){
      //echo "ERROR: " . $db->error . " for query"; // error statement
      //echo "username does not exists in DB";
    //  echo 0;
    }else{
        $stmt->bind_result($id, $date, $T, $B, $A, $C, $V, $com);

        while($stmt->fetch()){
          $date = date("F j, Y, g:i a", strtotime($date));
          $post = "<div id='onePost' class='text-wrap text-break container'>
          <h1 class='display-4 text-dark' id='title'><u>" . $T . "</u><h1><hr>
          <h4 class='lead' id='by'> written by <kbd>" . $A . "</kbd> on " . $date . "<kbd style='background-color: orange; font-size:12px; margin-left: 5px;'> "  . $C . "</kbd></h4>
          <p class='border border-secondary rounded' style='font-size:18px; white-space: pre-line'>" . $B . "<p></div>
          <div id='comments' style='width:100%'></div><hr><h6>Comments:</h6>";
        }
        $stmt->close();
        $stmt = $db->stmt_init();
        $stmt->prepare($query2);
        //bind
        $stmt->bind_param('i', $postID);
        $sucess = $stmt->execute();
        //check to see if DB insert was successful if not print DB error
        if(!$sucess || $db->affected_rows == 0){
          echo "ERROR: " . $db->error . " for query"; // error statement
          //echo "username does not exists in DB";
          //echo "$";
        }else{

        $stmt->bind_result($comment, $author, $stamp);
        $i = 0;
        while($stmt->fetch()){
          $stamp = date("F j, Y, g:i a", strtotime($stamp));
          if($i & 1){  $align = 'text-right';}else{$align = 'text-left';}
          $post .= "<div class='border border-secondary rounded $align' style='width:80%;'>
          <div class='bg-secondary'><label class=;text-light' style='font-size:13px;' id='by'>: <kbd>" . $author . "</kbd> on " . $stamp . "</label></div></hr>
          <p class='text-dark' style='font-size:20px; white-space: pre-line'>" . $comment . "</p>
          </div><br/>";
          $i++;
        }


      }
      if(isset($_SESSION['user'])){$disable = "onclick='insertComment($postID)'";}else{$disable = "disabled";}
      $post .= "<label>[" . $com . "] Add Comment</label><br/><div style= 'margin-left: 5px;'>
      <textarea id='insertComment' name='insertComment' minlength='2' cols='20' rows='4' style='resize:none; width:60%;'></textarea><br/>
      <button class='btn btn-xs btn-secondary' $disable  type='button' name='insertComment'>submit</button>
      </div></div>";
      updateViews($db, $postID);
      echo $post;

    }
  }

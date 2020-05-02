<?php
/*THIS FILE IS DEDICATED AS THE SERVER THAT PERFORMS ALL SQL ACTION AND SENDS RESULT TO CLIENT(MAIN.PHP AND DISCUSSION.PHP)*/
session_start();
include 'functions.php';
require_once('mysql.inc.php');    # MySQL Connection Library

//tis gets call when SQL access is neeeded
if(isset($_GET['onePost']) || isset($_GET['postCount']) || isset($_GET['insertComment'])){
$db = new myConnectDB();          # Connect to MySQL
//check if connecting to DB draws error
if (mysqli_connect_errno()) {
    echo "<h5>ERROR: " . mysqli_connect_errno() . ": " . mysqli_connect_error() . " </h5><br>";
  }
}


//global variables containing news sources
 $urlTemp = "https://www.rnz.co.nz/rss/pacific.xml";
 $urlArray = array('FSM' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e87aadd8a93f8e3188b4567.xml", 'RMI' => "https://marshallislandsjournal.com/feed/", 'ROP' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e94eef18a93f8c1478b4567.xml",
                    'GUM' => "https://www.pncguam.com/feed/", 'NAU' => "http://nauru-news.com/feed/", "KRI" => "https://kiribatiupdates.com.ki/feed/", 'FIJ' => "https://www.fbcnews.com.fj/feed/", "VAN" => "https://dailypost.vu/search/?f=rss&t=article&c=news",
                    "TGA" => "https://nukualofatimes.tbu.to/feed/", "CKI" => "http://www.cookislandsnews.com/?format=feed&type=rss",
                    'SAM' => "https://www.samoanews.com/taxonomy/term/1/all/feed");

//filters news if client sends filter request
if(isset($_GET['filterNews'])){
  $fil = $_GET['filterNews'];
  if($fil == 1){ $urlArray = array_slice($urlArray, 0, 6);
  }else if($fil == 2){$urlArray = array_slice($urlArray, 6, 2, true);
  }else if ($fil == 3){$urlArray = array_slice($urlArray, 8, 3);}

}
//used for keys
$urlKeys = array_keys($urlArray);

/* this function loads the desire url xml feed and parses it out to the client side*/
/* portion of code taken from https://makitweb.com/how-to-read-rss-feeds-using-php  */
function loadNews($url, $code){
 $invalidurl = false;
 if(@simplexml_load_file($url)){
  $feeds = simplexml_load_file($url);

 }else{
  $invalidurl = true;
  echo "<h2>Invalid RSS feed URL.</h2>";
 }

 $i=0; //counter
 if(!empty($feeds)){
   //grab news feed website title
  $site = $feeds->channel->title;
//  echo strpos($site, "on Facebook");
  if(strpos($site, "on Facebook") != false){
    //echo "hello world";
    $site = str_replace("on Facebook", "", $site);
  }
  $sitelink = $feeds->channel->link;
  echo "<h2 class='text-light'>".$site."</h2>";

  //iterate through the xml object and grab title, description, and date
  foreach ($feeds->channel->item as $item) {

   $title = $item->title;
   //this resets title if too long; meant for some new rss feeds misformatting
   if(strlen($title) > 30){
     $short = explode("--", $title, 2); // for FSM news formatting
     $title = $short[0];
   }
   $link = $item->link;
   $description = $item->description;
   $postDate = $item->pubDate;
   $pubDate = date('D, d M Y',strtotime($postDate));
   $media = (string)$item->children("media", true)->attributes();


   if($i >= 5) break; //allows for only 4 news articles
  ?>
   <div class="jumbotron animated fadeInUp border border-dark">
     <div class="post-content">
       <h2><a class="display-7" target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
       <span><?php echo $pubDate; ?></span>
     </div>
     <div class="lead">
      <?php
      //echo $code;
       if( (strcmp($media, null) != 0) && (strcmp($code, "ROP") != 0) ){
         //echo $media;
         echo "<div class='text-center'><img class='rounded border border-dark fit-pic' src='" . $media . "' height='auto' width='70%' /></div>";
       }
       ;
       echo implode(' ', array_slice(explode(' ', $description), 0, 49)) . "..."; ?> <a target="_blank" href="<?php echo $link; ?>">Read more</a></br></br>
     </div>
   </div>

   <?php
    $i++;
   }
 }else{
   if(!$invalidurl){
     echo "<h2>No item found</h2>";
   }
 }
}


//start of SERVER CONTROL code
//below are several if/else statements which determines what action needs to be done
if(isset($_GET['newsCount'])){
  $num = $_GET['newsCount'];
  if($num < sizeof($urlKeys)){
    loadNews($urlArray[$urlKeys[$num]], $urlKeys[$num]);
  }else{
    echo 0;//means no more news left to load
  }
}else if(isset($_GET['getEdit'])){
    //if user is signed in and once to make a post
    echo file_get_contents('post.html');
}else if(isset($_GET['postCount'])){

    //loads discussion board to discussion.pp
    $result = loadDiscussions($db, $_GET['filter']);
    echo $result;

}else if(isset($_GET['onePost'])){
    //if user is requesting to view a specific post
    getPost($db, $_GET['onePost']);
}else if(isset($_GET['insertComment'])){
  //if a comment once to be inserted
    insertComment($db, $_GET['insertComment'], $_GET['comment'], $_SESSION['user']);
}else{
  echo 0;
}






 ?>

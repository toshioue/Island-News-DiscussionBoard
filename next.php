<?php
session_start();
//global variables containing news sources
 $urlTemp = "https://www.rnz.co.nz/rss/pacific.xml";
 $urlArray = array('FSM' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e87aadd8a93f8e3188b4567.xml", 'RMI' => "https://marshallislandsjournal.com/feed/", 'ROP' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e94eef18a93f8c1478b4567.xml",
                    'GUM' => "https://www.pncguam.com/feed/", 'NAU' => "http://nauru-news.com/feed/");
$urlKeys = array_keys($urlArray);
/////////////////////////////////////////////

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


   //print_r(date('D, d M Y',strtotime('-1 week')));
  // date('D, d M Y',strtotime('yesterday');
  //print_r((string)$description);
  //if(strtotime($postDate) < strtotime('-2 days')) break;

   if($i >= 5) break; //allows for only 4 news articles
  ?>
   <div class="jumbotron animated fadeInUp">
     <div class="post-content">
       <h2><a class="display-7" target="_blank" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
       <span><?php echo $pubDate; ?></span>
     </div>
     <div class="lead">
      <?php
      //echo $code;
       if( (strcmp($media, null) != 0) && (strcmp($code, "ROP") != 0) ){
         //echo $media;
         echo "<div class='text-center'><img class='rounded border border-dark' src='" . $media . "' height='400' width='auto' /></div>";
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
if(isset($_GET['newsCount'])){
  $num = $_GET['newsCount'];
  if($num < sizeof($urlKeys)){
    loadNews($urlArray[$urlKeys[$num]], $urlKeys[$num]);
  }else{
    echo 0;
  }

}




 ?>

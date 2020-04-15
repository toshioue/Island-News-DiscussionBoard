<?php
session_start();
//global variables containing news sources
 $urlTemp = "https://www.rnz.co.nz/rss/pacific.xml";
 $urlArray = array('FSM' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e87aadd8a93f8e3188b4567.xml", 'RMI' => "https://marshallislandsjournal.com/feed/", 'ROP' => "http://fetchrss.com/rss/5e87aaf08a93f886198b45685e94eef18a93f8c1478b4567.xml",
                    'GUM' => "https://www.pncguam.com/feed/");

$urlKeys = array_keys($urlArray);

function loadNews($url){
 $invalidurl = false;
 if(@simplexml_load_file($url)){
  $feeds = simplexml_load_file($url);
  //print_r($feeds);

 }else{
  $invalidurl = true;
  echo "<h2>Invalid RSS feed URL.</h2>";
 }


 $i=0;
 if(!empty($feeds)){

  $site = $feeds->channel->title;
  $sitelink = $feeds->channel->link;

  echo "<h1>".$site."</h1>";
  foreach ($feeds->channel->item as $item) {

   $title = $item->title;
   if(strlen($title) > 30){
     $short = explode("--", $title, 2); // for FSM news formatting
     $title = $short[0];
   }
   $link = $item->link;
   $description = $item->description;
   $postDate = $item->pubDate;
   $pubDate = date('D, d M Y',strtotime($postDate));

   //print_r(date('D, d M Y',strtotime('-1 week')));
  // date('D, d M Y',strtotime('yesterday');
  //print_r((string)$description);

  //if(strtotime($postDate) < strtotime('-2 days')) break;
   if($i >= 4) break;
  ?>
   <div class="post">
     <div class="post-header">
       <h2><a class="feed_title" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
       <span><?php echo $pubDate; ?></span>
     </div>
     <div class="post-content">
       <?php echo implode(' ', array_slice(explode(' ', $description), 0, 50)) . "..."; ?> <a target="_blank" href="<?php echo $link; ?>">Read more</a>
       <?php //echo (string) $description; ?>
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
if(isset($_GET['feed'])){
  echo loadNews($urlArray['FSM']);


}




 ?>

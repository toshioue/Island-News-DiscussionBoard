// Generic Ajax GET Function, will call callFunction
// upon receipt of results. ajaxVars will be converted from JSON string to URL?key=value&key1=value1 sequence
function AJAX_GET(ajaxBaseUrl, ajaxVars, callFunction, callArgs) {
  var xhttp;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xhttp =new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      callFunction(xhttp.responseText);
    }
  };
  let counter = 0;
  for (let key in ajaxVars) {
    if (counter == 0) {
      ajaxBaseUrl += '?';
    } else {
      ajaxBaseUrl += '&';
    }
    ajaxBaseUrl += encodeURIComponent(key) + '=' + encodeURIComponent(ajaxVars[key]);
    counter++;
  }
  console.log("Ajax GET URL:", ajaxBaseUrl);
  xhttp.open("GET", ajaxBaseUrl, true);
  xhttp.send();
}

//AJAX_GET('server.php', {'action':'getVotes'}, getVotes, '')

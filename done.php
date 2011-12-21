<?php
require('/var/www/html/tools/facebook-api/facebook.php');
include("/var/www/html/tools/dBug.php");

$facebook = new Facebook(array(
  'app_id'  => '291784860853137',
  'app_secret' => '193c9cc6133ca27bf85417f47fb0cf61',
  'redirect_uri' => 'http://apps.facebook.com/myfriendspace/index.php'
));
?>


<html xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<style type="text/css">
body {background-color:#000;
	/*font-family: 'Convergence', sans-serif;*/
	font-family: 'Times Roman', serif;	
	position:relative;
	margin:40px;
	

	}
h2 {
	color:white;
	font-family:"Times Roman",serif;
	margin:20px;
	font-weight:none;
}
#header {
	width:100%;
	height:32px;
	margin:10px;
	padding:10px;
	
}
#title {
	color:red;
	font-size:32px;
	display:inline;}
</style>
</script>

<script type="text/javascript" src="jquery.min.js"></script>

</head>
<body>
<center>
<h2>Thanks For Using Our Holiday Card!</h2>

<br />
<div style="margin-bottom:50px;" class="fb-like" data-href="http://www.facebook.com/pages/Momentus-Apps/173947455968845" data-send="true" data-width="450" data-show-faces="true"></div>
	<br/>
	<br/>
	<div>
	<center>
<iframe width='728' height='90' frameborder='no' framespacing='0' scrolling='no'  src='//ads.lfstmedia.com/fbslot/slot5050?ad_size=728x90&adkey=94c'></iframe>
	</div>

	<br/>
	<br/>



</center>

<div id="fb-root"></div>
<script src="all.js"></script>
<script> 
  window.fbAsyncInit = function() {
    FB.init({appId: '<?php echo 291784860853137;?>', status: true, cookie: true,
             xfbml: true})
    window.setTimeout(function() {
      FB.Canvas.setAutoResize();
    }, 250);
    FB.Event.subscribe('edge.create', function(response) {
		  getResult();
    });  
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = 'all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>
</body>
</html>
<?php 

require('/var/www/html/tools/facebook-api/facebook.php');
include("/var/www/html/tools/dBug.php");

$facebook = new Facebook(array(
  'app_id'  => '291784860853137',
  'app_secret' => '193c9cc6133ca27bf85417f47fb0cf61',
  'redirect_uri' => 'http://apps.facebook.com/myfriendspace/index.php'
));

$facebook->checkRequest();

if(!$facebook->signed_request["user_id"]){
	$auth_uri = $facebook->getAuthUri("publish_stream");
}
try{
	$friends = $facebook->api("me/friends",array('limit'=>500));
} catch (Exception $e){
	echo $e;	
}
?>
<html xmlns:og="http://opengraphprotocol.org/schema/"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<meta property="og:title" content="My Friends' Space Facewall"/>
    <meta property="og:type" content="site"/>
    <meta property="og:url" content="http://apps.facebook.com/myfriendspace"/>
    <meta property="og:image" content="http://apps.facebook.com/myfriendspace/appicon.png"/>
    <meta property="og:site_name" content="My Friends' Space"/>
    <meta property="fb:admins" content="561731908"/>
    <meta property="og:description"
          content="Create a wall of your friends"/>
    <meta property="fb:app_id" content="291784860853137" />
</head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	var at = '<?php if ($facebook->access_token) { echo $facebook->access_token; } ?>';
	if(at != ''){
		$.post('build.php', {'access_token':at});		
		var t = setTimeout("publish()",1000);
	} else {
		$("#save-button").html("Start");
	}
	$("#save-button").click(function() {
			auth();
	});
});

function auth(){
	top.location.href = '<?php if(isset($auth_uri)){ echo $auth_uri; }?>';

}

function publish(){
	FB.ui(
  {
    method: 'feed',
    name: 'Friendwall',
    link: 'http://apps.facebook.com/myfriendspace',
    picture: 'http://friendwall-803401267.us-east-1.elb.amazonaws.com/dev/appicon.png',
    caption: 'Make a friend poster',
    description: 'I just made a big image of all my friends. Yep.'
  });
}
</script>
<link href='http://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
<style type="text/css">
body {background-color:#000;font-family: 'Convergence', sans-serif;}
a {color:#fff;}
#friendwall_url {
	cursor:pointer;
	display:none;
	color:#fff;
	margin:5 15 5 5;
	float:right;}
img { margin:5; }
.button {
font-family: 'Convergence', sans-serif;
	border-radius: 10px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
	-moz-border-radius: 10px;
	-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
	-webkit-border-radius: 10px;
	-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
	color: #fff;
	cursor: pointer;
	float: left;
	font-size: 18px;
	font-weight: bold;
	margin-right: 20px;
	padding: 5px 20px;
	text-decoration: none;
}

.button:hover {
	color: #fff;
	text-decoration: none;
}

.green {
	background:-moz-linear-gradient(center top , #78f000, #66cc00);
	background: -webkit-gradient(linear, center top, center bottom, from(#78f000), to(#66cc00));
}
#header {
	width:100%;
	height:32px;
	margin:10px;
	padding:10px;
	
}
#title {
	color:#fff;
	font-size:32px;
	display:inline;}
</style>
<body>
	<div id="header">
		<span id="title">FriendWall</span>
		<div class="button green" id="save-button" style="cursor:pointer;float:right;">Share</div>
		<img src="loading.gif" style="display:none;float:right;" id="loading" />
	</div>
	<?php

	$i=0;
	if(isset($friends->data)){
		foreach($friends->data as $friend){
			echo "<img src=\"https://graph.facebook.com/".$friend->id."/picture?type=square\" />";		
		}
	}		
?>

<div id="fb-root"></div>
<script src="all.js"></script>
<script>   
	FB.init({appId: '291784860853137', status: true, cookie: true,
					 xfbml: true});

</script>


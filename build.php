<?php 

require('/var/www/html/tools/facebook-api/facebook.php');
include("/var/www/html/tools/dBug.php");
require('/var/www/html/AWSSDKforPHP/sdk.class.php');

$facebook = new Facebook(array(
  'app_id'  => '291784860853137',
  'app_secret' => '193c9cc6133ca27bf85417f47fb0cf61',
  'redirect_uri' => 'http://apps.facebook.com/myfriendspace'
));


$facebook->access_token = $_REQUEST["access_token"];
$facebook->getSignedRequest();
$uid = $facebook->signed_request["user_id"];
try{
	$friends = $facebook->api("me/friends",array('limit'=>500));
} catch (Exception $e){
	echo $e;	
}
if($uid && $facebook->access_token){
	$response = makeRubyFriends($friends);
	
	// upload to amz
	$s3 = new AmazonS3();
	$bucket = 'friendwall';
	$response = $s3->if_bucket_exists($bucket);

	$filename = $uid.'_friendwall.jpeg';
	$path = "/var/www/html/dev/user_images/".$filename;
	$aws_path = uploadS3($path, $filename);
	upload($path);
} else {
	echo "No uid or access token.";
}

function upload($path){
	global $facebook;
	$args["message"] = "my friendwall";
	$args["method"] = "post";
	$args["image"] = "@".realpath($path);
	try {
		$result = $facebook->api('me/photos', $args);
	} catch (Exception $e){			
		echo $e;
	}
}

function makeRubyFriends($friends){
	global $uid;
	$ruby_cmd = "./build.rb ".$uid." ";
	$i=0;
	foreach($friends->data as $friend){
		$ruby_cmd .= " ".$friend->id;		
		$i++;
	}
	exec($ruby_cmd,$output, $response);	
}

function uploadS3($tmpPath, $fname){
	global $s3, $bucket;
	
	if($tmpPath){
		try{
			$response = $s3->batch()->create_object($bucket, $fname, array( 'fileUpload' => $tmpPath, 'acl' => AmazonS3::ACL_PUBLIC));
		} catch (Exception $e){
			$msg= "<br>amz s3 exception: $e";
		}
		$file_upload_response = $s3->batch()->send();
		$path_s3 = $s3->get_object_url($bucket, $fname);
		return $path_s3;
	} else {
		$msg= "could not get file size";
	}
}






?>

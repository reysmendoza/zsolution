<?php
	
	require 'config.php';
	require 'class/class.php';
		 
	$config["zingitmobile"]["user_guid"] 	= $_REQUEST['userguid']; 	
	$config["zingitmobile"]["keyword"] 		= $_REQUEST['keyword'];
	$config["zingitmobile"]["shortcode"] 	= $_REQUEST['shortcode'];
	
	$config["local"]["receiver_email"] 		= $_REQUEST['email'];
	$config["local"]["from_email"] 			= 'info@'.$_SERVER['HTTP_HOST'];
	
	//if ( !isset($_POST['email']) ) die('Direct hit is not allowed!');	
 
	$a = new zmobile( array('config' => $config, 'data' => $_REQUEST) );	 
	$a->mailHandler();	
	$a->httpCurlSms();
	$a->pushRedirect();   
	
?>
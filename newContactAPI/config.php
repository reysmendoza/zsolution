<?php
$config = array ("zingitmobile" => array( "url" => "http://client.zingitmobile.com/gateway/contactmanager_keyword.asp", 
										  //"url" => "http://localhost/virginia/newContactAPI/test.post.php", 	
										  "user_guid"  => "",
										  "keyword"    => "",
										  "shortcode"  => ""),
							
				 "local" 		=> array( "from_name"  		=> "Web Inquiry",				 
										  "from_email"  	=> "",
										  "receiver_email"  => "",
										  "mailSubject"  	=> "Received from web enquiry",
										  "mailTemplate"    => "message.template.html",
										  "mailFormField"   => array("firstname","lastname","email","mobile","phone","request")  )	  				
						);



?>
<?php
ob_start();

/*
	Class zmobile
	Author: Rey S. Mendoza
	Email:	reysmendoza@gmail.com
	Homepage: reysmendoza.me
			  workwith.reysmendoza.me
	Created 11-03-2007	
	Update Version: ( N/A )				
*/

class zmobile {
	
	private $curl_url;
	private $curl_post_data = array();
	private $redirectURL;
	
	protected $mailFrom;
	protected $mailFromName;
	protected $mailReceiver;
	protected $mailTemplate;
	protected $mailContent;
	protected $mailFormField;
	
	function __construct(array $data){				
	
		$this->curl_sms_url 	= 'http://client.zingitmobile.com/gateway/sendmt.asp?';
		$this->curl_url 		= $data['config']['zingitmobile']['url'];	
		$this->mailFrom	 		= $data['config']['local']['from_email'];
		$this->mailFromName	 	= $data['config']['local']['from_name'];
		
		$this->mailReceiver 	= $data['config']['local']['receiver_email'];
		$this->mailSubject 		= $data['config']['local']['mailSubject'];
		$this->mailTemplate 	= $data['config']['local']['mailTemplate'];
		$this->mailFormField 	= $data['config']['local']['mailFormField'];					
		$this->curl_post_data 	= $data['data'];		
		
		$this->redirectURL      = !empty($data['data']['redirectURL']) ? $data['data']['redirectURL'] : '';				$this->httpCurl();				
	}
		
	function pushRedirect(){
		 
		if ( !empty( $this->redirectURL ) ){
			header("location: $this->redirectURL");			
		} else {
			if ( !empty($_SERVER['HTTP_REFERER']) )	{
							
				header("location: ".$_SERVER['HTTP_REFERER']."?zmobileApi=success");
										
			}		
		}		
	}
	
	
	function cleanData($data) {
		
		
		$cData = array('user_guid','keyword','shortcode','email','firstname','lastname','mobile','request');
		
		foreach($data as $f => $v ){
			
			if ( in_array($f,$cData) ) {}
			else unset($this->curl_post_data[$f]);
			
			
		}
		
	}
	
	function httpCurlSms(){
		
		$smsData = $this->curl_post_data;
		unset( $smsData['request'] );
		unset( $smsData['redirectURL'] );
		unset( $smsData['email'] );
		unset( $smsData['firstname'] );
		unset( $smsData['lastname'] );
			 	
		$smsData = http_build_query($smsData).'&sendmode=1';		
		
		$ch = curl_init(); 		
		curl_setopt( $ch, CURLOPT_URL, $this->curl_sms_url."?".$smsData ); 	
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );		
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $smsData );
		
		$content = curl_exec( $ch );
		
		//echo $this->curl_sms_url."?".$smsData;
		//echo $content;
		
	}
	
	function httpCurl(){		
					
		$this->cleanData( $this->curl_post_data);
		$cdata = http_build_query( $this->curl_post_data );			
					
		$ch = curl_init(); 					
		curl_setopt( $ch, CURLOPT_URL, $this->curl_url."?".$cdata );	
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );		
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $cdata );	
		$content = curl_exec( $ch );			
		$response = curl_getinfo( $ch );	 			
		curl_close ( $ch );		
			
		//echo $content;
		
	}	
	function mailHandler(){
				
		$content = $mailContent = $this->dataParser ( $this->fetchMailTemplate() ); 
 
		$to      = $this->mailReceiver;
		$subject = $this->mailSubject;
		$message = $content;
		$headers = 'From: '.$this->mailFromName.' <'.$this->mailFrom.">\r\n" .
				   'Reply-To: '.$this->mailFrom. "\r\n" .
				   'X-Mailer: PHP/' . phpversion();
			
		
		try {
			
			mail($to, $subject, $message, $headers);
		
		} catch (Exception $e) {
			
		} finally {			
		   
		   //print_r( TRUE );
		   
		}				
		
	}
	
	function dataParser($content){
		
		$retContent=$content;
		
		 
		
		foreach($this->mailFormField as $f => $field) {
			if ( isset($this->curl_post_data[$field])) {
				
				$retContent = str_replace("{".$field."}", !empty($this->curl_post_data[$field]) ? $this->curl_post_data[$field] : '<strong>---empty string---</strong>',$retContent);				
			
			}
		}
		
		$retContent = str_replace('{phone}','---no-entry---',$retContent);
		$retContent = str_replace('{request}','---no--entry---',$retContent);
		
		return $retContent;
		
	}
	
	function fetchMailTemplate(){
 
		//if ( is_file( __DIR__ .$this->mailTemplate) == TRUE ) {
			return $this->mailContent = file_get_contents( __DIR__ .'../../'.$this->mailTemplate);
		//}
		
	}
	
}
?>
<?php
/**
 * @package zSolutions Integration and Mailer
 * @version 1
 */
/*
Plugin Name: zSolutions Integration and Mailer 
Plugin URI: http://reysmendoza.me
Description: Integration to Zingit Solutions and Mailer.
Author: Rey S. Mendoza
Version: 1
Author URI: http://workwith.reysmendoza.me
*/
 
function zsolutions_plugin_menu() {
	
	add_options_page( 'Zingit Integration & Mailer Settings', 'zSolutions Integration', 'manage_options', 'zsolutions-integration-mailer', 'zsolution_options' );
	add_action( 'admin_init', 'zsolution_activate' );
	
}

function zsolution_options() {	

	include __DIR__.'/form.inc.php';	

} 

function zsolution_activate() {

	$content = file_get_contents( __DIR__ .'/templates/message.inc.txt');

    register_setting( 'zsolution-settings-group', 'zsolution-userguid',array('default' => '{xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx}') );
	register_setting( 'zsolution-settings-group', 'zsolution-keyword' ,array('default' => 'your keyword'));
	register_setting( 'zsolution-settings-group', 'zsolution-shortcode' ,array('default' => 'your shortcode'));
	register_setting( 'zsolution-settings-group', 'zsolution-email' ,array('default' => 'youremail@domain.com'));
	register_setting( 'zsolution-settings-group', 'zsolution-content' ,array('default' => $content ));
	register_setting( 'zsolution-settings-group', 'zsolution-redirecturl' ,array('default' => "http://yourdomain.com/" ));
 
}

function render_form( $atts, $content = null ){

	
	$iscaptcha = @in_array('captcha', $atts ) ? true : false;	
		
	$form = file_get_contents( __DIR__.'/templates/form.template.html' );
	$form = str_replace('{plugin_location}',plugins_url( '', __FILE__ ),$form);
	$form = str_replace('{redirectURL}',get_option('zsolution-redirecturl'),$form);
	
	
	if ( empty( get_option('zsolution-userguid')) ||		 empty( get_option('zsolution-keyword')) || 		 empty( get_option('zsolution-shortcode')) ||		 empty( get_option('zsolution-email')) ) {			 return "<strong>Error: Please complete the settings.</strong>";	}
	$form = str_replace('{user_guid}',get_option('zsolution-userguid'),$form);
	$form = str_replace('{keyword}',get_option('zsolution-keyword'),$form);
	$form = str_replace('{shortcode}',get_option('zsolution-shortcode'),$form);
	$form = str_replace('{email}',get_option('zsolution-email'),$form);
	
	if ( $iscaptcha ) {
		$captach_div    	 = file_get_contents( __DIR__.'/templates/captcha.render-div.template.html' );
		$captach_script		 = file_get_contents( __DIR__.'/templates/captcha.template.html' );
		$captach_script		 = str_replace('{key}',$atts['key'],$captach_script);
		$captach_script_call = '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';		
		$captchaOnSubmit     = 'onSubmit="javascript: if (grecaptcha.getResponse(widgetId1).length==0) return false;"';						if ( empty($atts['key']) ) return "<strong><i>Plugin Error: Captcha Key Please find from <a href='https://www.google.com/recaptcha/admin#list' target='_BLANK'>recapcha</a></i></strong>";				
	}
	
	$form 		   = str_replace('{captcha_script}',$captach_script,$form);
	$form          = str_replace('{captcha_script_call}',$captach_script_call,$form);	
	$form 		   = str_replace('{onSubmit}',$captchaOnSubmit,$form);		
	$form 		   = str_replace('{captcha_render_div}',$captach_div,$form);
	$form 		   = str_replace('{SubmitButton}',!empty(@$atts['button']) ? $atts['button'] : 'Submit',$form);
	
	return $form;
		 	
}

register_activation_hook( __FILE__, 'zsolutions_plugin_menu' );
add_action( 'admin_menu', 'zsolutions_plugin_menu' );
add_shortcode( 'zsolutionsContactForm', 'render_form' );



 
?>
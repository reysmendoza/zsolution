
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" />
<style>
	.control-label {  padding-top: 5px; margin-right: 10px; width: 120px;  border: 0px solid red; }
	.control-row { margin-bottom: 8px; }	
	.rFormControl { width: 60%; margin: 0px 20px 20px 20px; }
</style>
<div class="rFormControl">
<h3>Zingit Integration & Mailer Settings </h3> <div style="padding: 10px; margin: 5px; background: #cccc"><p>How to: </p>
<p>1. Place short code <strong>[zsolutionsContactForm][/zsolutionsContactForm]</strong> in any page or post content.<br/><p>2. Use parameter captcha & key for recaptcha <br/><p><strong>[zsolutionsContactForm <strong><i>captcha key={yourkey}</i> ][/zsolutionsContactForm]</strong> <br/><br/>Register and get your recaptcha key <a href='https://www.google.com/recaptcha/admin#list' target='_BLANK'>recapcha key</a></i></strong><br/><br/>Please filled necessary parameter value below.</p></div>
<form action="options.php" method="POST" >	
<?php settings_fields( 'zsolution-settings-group' ); ?>
<?php do_settings_sections( 'zsolution-settings-group' ); ?>
	
<input name="redirectURL1" type="hidden" id="redirectURL" value="http://www.zingitsolutions.com" />
<div class="form-group">
	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>User GUID</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<input type="text" class="form-control" name="zsolution-userguid" id="zsolution-userguid" value="<?php echo esc_attr( get_option('zsolution-userguid') ); ?>" required />    	 
		</div>
	</div>
	
	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>Keyword</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<input type="text" class="form-control" name="zsolution-keyword" id="zsolution-keyword" value="<?php echo esc_attr( get_option('zsolution-keyword') ); ?>" required />    	 
		</div>
	</div>

	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>Shortcode</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<input type="text" class="form-control" name="zsolution-shortcode" id="zsolution-keyword" value="<?php echo esc_attr( get_option('zsolution-shortcode') ); ?>" required />    	 
		</div>
	</div>

	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>Receiver Email</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<input type="text" class="form-control" name="zsolution-email" id="zsolution-email" value="<?php echo esc_attr( get_option('zsolution-email') ); ?>"   required />    	 
		</div>
	</div>
	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>Redirect URL</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<input type="text" class="form-control" name="zsolution-redirecturl" id="zsolution-redirecturl" value="<?php echo esc_attr( get_option('zsolution-redirecturl') ); ?>"   required />    	 
		</div>
	</div>
	
	<!--
	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label"><strong>Email Content</strong></label>		 	
		</div>
		<div class="col-xs-12">
			<textarea class="form-control" rows="9" cols="100%" name="zsolution-content" id="zsolution-content"><?php echo esc_attr( get_option('zsolution-content') ); ?></textarea>	
		</div>
	</div>
	-->
	
	<div class="col control-row"> 
		<div class="col-xs-12">
			<label class="control-label">  </label>		 	
		</div>
		<div class="col-xs-12">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</div>	
</div>
</form>
</div>
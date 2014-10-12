<?php

/********** Enter Your Plugin Functions Here */

Config::set('site.header', 'login_signup_modal');



function login_signup_modal(){

	$login_signup_modal_custom_css = PluginData::where('plugin_slug', '=', 'login_signup_modal')->where('key', '=', 'css')->first();
	if(empty($login_signup_modal_custom_css->value)){
	    $login_signup_modal_custom_css = '';
	} else{
		 //$login_signup_modal_custom_css = '';
	   $login_signup_modal_custom_css = trim($login_signup_modal_custom_css->value);
	}

	?>
	<style type="text/css">
		.form-signin{ padding-bottom:40px; margin-top:20px; }#loginSignupModal{ border:0; outline:none; } #loginSignupModal .modal-dialog{ margin-top:100px; } #loginSignupModal .close{ padding:20px; position:absolute; right:0px; z-index:99; border:0; outline:none; } #loginSignupModal .close:active{ border:0; outline:none; } #loginSignupModal .close:focus{ border:0; outline:none; } .dark #loginSignupModal .form-signin h2, a, a.reset_password{ color:#fff; } #loginSignupModal .form-signin h2, a, a.reset_password{ color:#777; } 
		<?php echo $login_signup_modal_custom_css; ?>
	</style>
	<script src="/content/plugins/login_signup_modal/functions.js"></script>
	<?php
}
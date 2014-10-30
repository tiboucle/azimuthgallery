<?php
/**
 * Colabs Custom Form
 * Function outputs the login form
 * Function outputs the registration form
 *
 */

function colabs_login_form( $action = '', $redirect = '' ) {

	global $posted;
	
	if (!$action) $action = site_url('wp-login.php');
	if (!$redirect) $redirect = get_permalink(get_option('colabs_dashboard_page_id'));
	?>

	<h5><?php _e('Login', 'colabsthemes'); ?></h5>

	<form id="frmcontact" action="<?php echo $action; ?>" method="post" class="account_form">
		
            <p>
				<label id="login_username" for="login_username"><?php _e('Username', 'colabsthemes'); ?></label>
                <input type="text" class="text" name="log" id="login_username" value="<?php if (isset($posted['login_username'])) echo $posted['login_username']; ?>" />
            </p>

            <p>
				<label id="login_password" for="login_password"><?php _e('Password', 'colabsthemes'); ?></label>
                <input type="password" class="text" name="pwd" id="login_password"  value="" />
            </p>

            <p>
                <input type="hidden" name="redirect_to" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="rememberme" value="forever" />
                <input type="submit" class="submit" name="wp-submit" value="<?php _e('Login', 'colabsthemes'); ?>" />
                <a class="lostpass" href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php _e('Forgot Password?', 'colabsthemes'); ?>"><?php _e('Forgot Password?', 'colabsthemes'); ?></a>
            </p>

	</form>

<?php
}

function colabs_register_form( $action = '', $role = '' ) {
	
    global $posted;

    if ( get_option('users_can_register') ) :

        if (!$action) $action = site_url('wp-login.php?action=register');
    ?>

            <h5><?php _e('Register', 'colabsthemes'); ?></h5>

            <form id="frmcontact" action="<?php echo $action; ?>" method="post" class="account_form">
				
				
				
                <p>
					<label id="your_username" for="your_username"><?php _e('Username', 'colabsthemes'); ?></label>
                    <input type="text" class="text" tabindex="1" name="your_username" id="your_username"  value="<?php if (isset($posted['your_username'])) echo $posted['your_username']; ?>" />
                </p>

                <p>
					<label id="your_email" for="your_email"><?php _e('Email', 'colabsthemes'); ?></label>
                    <input type="text" class="text" tabindex="2" name="your_email" id="your_email"  value="<?php if (isset($posted['your_email'])) echo $posted['your_email']; ?>" />
                </p>
				
				<?php if (get_option('colabs_allow_registration_password')) : ?>
                <p>
					<label id="your_password" for="your_password"><?php _e('Enter a password', 'colabsthemes'); ?></label>
                    <input type="password" class="text" tabindex="3" name="your_password" id="your_password"  value="" />
                </p>

                <p>
					<label id="your_password_2" for="your_password_2"><?php _e('Enter password again', 'colabsthemes'); ?></label>
                    <input type="password" class="text" tabindex="4" name="your_password_2" id="your_password_2" value="" />
                </p>
                <?php endif; ?>       
                
                <?php
                // include the spam checker if enabled
                colabsthemes_recaptcha();
                ?>

				
                <p>
                    <input type="submit" class="submit" tabindex="7" name="register" value="<?php _e('Register', 'colabsthemes'); ?>" />
                </p>

                <!-- autofocus the field -->
                <script type="text/javascript">try{document.getElementById('your_username').focus();}catch(e){}</script>

            </form>
<?php else : ?>
    <p><?php _e('Registration is disabled on this site','colabsthemes'); ?></p>
<?php endif; ?>

<?php } 

function colabs_forgot_password_form() {
	?>
    <p><?php _e('Please enter your username or email address. A new password will be emailed to you.', 'colabsthemes') ?></p>
    <form id="frmcontact" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post" class="login-form main_form">

        <p>
		<label id="login_username" for="login_username"><?php _e('Username/Email', 'colabsthemes'); ?></label>
		<input type="text" class="text placeholder" name="user_login" id="login_username" rel="<?php _e('Username/Email', 'colabsthemes'); ?>" />
		</p>

        <p><?php do_action('lostpassword_form'); ?><input type="submit" class="submit" name="login" value="<?php _e('Get New Password','colabsthemes'); ?>" /></p>

    </form>
	<?php
}
?>
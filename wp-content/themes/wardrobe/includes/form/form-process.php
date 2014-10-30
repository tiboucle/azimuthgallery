<?php
/**
 * Colabs Form Process
 * Processes the login forms and returns errors/redirects to a page
 * Processes the registration forms and returns errors/redirects to a page
 *
 */

if (!function_exists('user_can')) :
	function user_can( $user, $capability ) {
		if ( ! is_object( $user ) )
			$user = new WP_User( (int) $user );
		
		if ( ! $user || ! $user->ID )
			return false;
	
		$args = array_slice( func_get_args(), 2 );
		$args = array_merge( array( $capability ), $args );
	
		return call_user_func_array( array( &$user, 'has_cap' ), $args );
	}
endif;

function colabs_process_login_form() {

	global $posted;
	
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	else
		$redirect_to = admin_url();
	
	if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;
	else
		$secure_cookie = '';

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
	
		if (user_can($user, 'manage_options')) :
			$redirect_to = admin_url();
		endif;
			
		wp_safe_redirect($redirect_to);
		exit;
	}

	$errors = $user;

	return $errors;

}
function colabs_process_register_form( $success_redirect = '' ) {

        // if there's no redirect posted, send them to their job dashboard
	if (!$success_redirect)
            $success_redirect = get_permalink(get_option('colabs_dashboard_page_id'));

	
	if ( get_option('users_can_register') ) :
		
		global $posted, $app_abbr;
		
		$posted = array();
		$errors = new WP_Error();
		$user_pass = wp_generate_password();
		
		if (isset($_POST['register']) && $_POST['register']) {

                        // include the WP registration core
			require_once( ABSPATH . WPINC . '/registration.php');

			                     // process the reCaptcha request if it's been enabled
			if (get_option('colabs_captcha_enable') == 'true') {
                            require_once (TEMPLATEPATH . '/includes/lib/recaptchalib.php');
                            $resp = null;
                            $error = null;

                            // check and make sure the reCaptcha values match
                            $resp = recaptcha_check_answer(
                                get_option('colabs_captcha_private_key'),
                                $_SERVER['REMOTE_ADDR'],
                                $_POST['recaptcha_challenge_field'],
                                $_POST['recaptcha_response_field']
                            );
			}
			// Get (and clean) data
			$fields = array(
				'your_username',
				'your_email',
				'your_password',
				'your_password_2'
			);
			foreach ($fields as $field) {
				if (isset($_POST[$field])) $posted[$field] = stripslashes(trim($_POST[$field])); else $posted[$field] = '';
			}
		
			$user_login = sanitize_user( $posted['your_username'] );
			$user_email = apply_filters( 'user_registration_email', $posted['your_email'] );
		
			
			// Check terms acceptance
			if (get_option('colabs_terms_page_id')>0) :
				if (!isset($_POST['terms'])) $errors->add('empty_terms', __('<strong>Notice</strong>: You must accept our terms and conditions in order to register.', 'appthemes'));
			endif;
			
			
			// Check the username
			if ( $posted['your_username'] == '' )
				$errors->add('empty_username', __('<strong>ERROR</strong>: Please enter a username.', 'appthemes'));
			elseif ( !validate_username( $posted['your_username'] ) ) {
				$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.', 'appthemes'));
				$posted['your_username'] = '';
			} elseif ( username_exists( $posted['your_username'] ) )
				$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.', 'appthemes'));
		
			// Check the e-mail address
			if ($posted['your_email'] == '') {
				$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.', 'appthemes'));
			} elseif ( !is_email( $posted['your_email'] ) ) {
				$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'appthemes'));
				$posted['your_email'] = '';
			} elseif ( email_exists( $posted['your_email'] ) )
				$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.', 'appthemes'));
			
			if (get_option('colabs_allow_registration_password')) :
				// Check Passwords match
				if ($posted['your_password'] == '')	
					$errors->add('empty_password', __('<strong>ERROR</strong>: Please enter a password.', 'appthemes'));
				elseif ($posted['your_password_2'] == '')
					$errors->add('empty_password', __('<strong>ERROR</strong>: Please enter password twice.', 'appthemes'));
				elseif ($posted['your_password'] !== $posted['your_password_2'])
					$errors->add('wrong_password', __('<strong>ERROR</strong>: Passwords do not match.', 'appthemes'));
				
				$user_pass = $posted['your_password'];
			endif;
			
			// display the reCaptcha error msg if it's been enabled
			if (get_option('colabs_captcha_enable') == 'true') {
                            // Check reCaptcha  match
                            if (!$resp->is_valid)
                                $errors->add('invalid_captcha', __('<strong>ERROR</strong>: The reCaptcha anti-spam response was incorrect.', 'appthemes'));
                                //$error = $resp->error;
			}
			
			do_action('register_post', $posted['your_username'], $posted['your_email'], $errors);
			$errors = apply_filters( 'registration_errors', $errors, $posted['your_username'], $posted['your_email'] );
		
                        // if there are no errors, let's create the user account
			if ( !$errors->get_error_code() ) {

                           
                            $user_id = wp_create_user(  $posted['your_username'], $user_pass, $posted['your_email'] );
                            if ( !$user_id ) {
                                    $errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'appthemes'), get_option('admin_email')));
                                    return array( 'errors' => $errors, 'posted' => $posted);
                            }


                            // send the user a confirmation and their login details
                            colabs_sent_email($user_id, $user_pass);

							if (get_option('colabs_allow_registration_password')=='yes') :
							
								// set the WP login cookie
								$secure_cookie = is_ssl() ? true : false;
								wp_set_auth_cookie($user_id, true, $secure_cookie);

								// redirect
								wp_redirect($success_redirect);
								exit;
							
							else :
							
								//create own password option is turned off so show a message that it's been emailed instead
								$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : '?checkemail=newpass';
								wp_safe_redirect( $redirect_to );
								exit();
							
							endif;

			} else {

                            // there were errors so go back and display them without creating new user
                            return array( 'errors' => $errors, 'posted' => $posted);

			}
		}
		
	endif;

}

// email that gets sent out to new users once they register
function colabs_sent_email($user_id, $plaintext_pass = '') {

    $user = new WP_User($user_id);

    $user_login = stripslashes($user->user_login);
    $user_email = stripslashes($user->user_email);

    // variables that can be used by admin to dynamically fill in email content
    $find = array('/%username%/i', '/%password%/i', '/%blogname%/i', '/%siteurl%/i', '/%loginurl%/i', '/%useremail%/i');
    $replace = array($user_login, $plaintext_pass, get_option('blogname'), get_option('siteurl'), get_option('siteurl').'/wp-login.php', $user_email);

    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    // send the site admin an email everytime a new user registers
        $message  = sprintf(__('New user registration on your site %s:'), $blogname) . PHP_EOL . PHP_EOL;
        $message .= sprintf(__('Username: %s'), $user_login) . PHP_EOL . PHP_EOL;
        $message .= sprintf(__('E-mail: %s'), $user_email) . PHP_EOL;

        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

    if ( empty($plaintext_pass) )
        return;



        $message  = sprintf(__('Username: %s', 'colabsthemes'), $user_login) . PHP_EOL;
        $message .= sprintf(__('Password: %s', 'colabsthemes'), $plaintext_pass) . PHP_EOL;
        $message .= wp_login_url() . PHP_EOL;

        wp_mail($user_email, sprintf(__('[%s] Your username and password', 'colabsthemes'), $blogname), $message);

  

}
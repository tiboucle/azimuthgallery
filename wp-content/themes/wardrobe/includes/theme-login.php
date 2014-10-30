<?php
/**
 *
 * This controls how the login, logout,
 * registration, and forgot your password pages look.
 * It overrides the default WP pages by intercepting the request.
 *
 */

global $pagenow;

// check to prevent php "notice: undefined index" msg
if(isset($_GET['action'])) $theaction = $_GET['action']; else $theaction ='';

// if the user is on the login page, then let the games begin
if ($pagenow == 'wp-login.php' && $theaction != 'logout' && !isset($_GET['key'])) :
	add_action('init', 'colabs_login_init', 98);
	add_filter('wp_title', 'colabs_login_title');
endif;

// main function that routes the request
function colabs_login_init() {

	nocache_headers();
	
    if (isset($_REQUEST['action'])) :
        $action = $_REQUEST['action'];
    else :
       $action = 'login';
    endif;
    switch($action) :
        case 'lostpassword' :
        case 'retrievepassword' :
            colabs_show_password();
        break;
        
        case 'login':
        
            colabs_show_login();
        break;
		
		case 'register':
        
            colabs_show_register();
        break;
    endswitch;
    exit;
}

// display the meta page title based on the current page
function colabs_login_title($title) {
    global $pagenow;
    if ($pagenow == "wp-login.php") :
    	if (isset($_GET['action'])) $action = $_GET['action']; else $action='';
        switch($action) :
            case 'lostpassword':
                $title = __('Retrieve your lost password for ','colabsthemes');
            break;
            case 'login':
           
            default:
                $title = __('Login/Register at ','colabsthemes');
            break;
        endswitch;

    elseif ($pagenow == "profile.php") :
        $title = __('Your Profile at ','colabsthemes');
    endif;
    return $title;
}

// Show login and registation forms
function colabs_show_login() {

	global $posted;
	
	if (isset($_POST['wp-submit']) && $_POST['wp-submit']) {

		$errors = colabs_process_login_form();
	}

	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) ) $errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
			$errors->add('test_cookie', __('Cookies are blocked or not supported by your browser. You must enable cookies to continue.','colabsthemes'));
	
	if ( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
			$message = __('You are now logged out.','colabsthemes');

	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	
			$errors->add('registerdisabled', __('User registration is currently not allowed.','colabsthemes'));

	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	
			$message = __('Check your email for the confirmation link.','colabsthemes');

	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	
			$message = __('Check your email for your new password.','colabsthemes');

	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
			$message = __('Registration complete. Please check your e-mail.','colabsthemes');

	get_template_part('header');
	?>
	<div class="page-section row">
						
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>

			<div class="post">
			

				<div class="entry-content">
					<?php 
    				if (isset($message) && !empty($message)) {
    					echo '<p class="success">'.$message.'</p>';
    				}
					?>
					<?php 
					if ($errors && sizeof($errors)>0 && $errors->get_error_code()) :
						echo '<ul class="errors">';
						foreach ($errors->errors as $error) {
							echo '<li>'.$error[0].'</li>';
						}
						echo '</ul>';
					endif; 
					?>
					<?php colabs_login_form(); ?>
				</div><!-- .entry-content -->
		
			</div>

		</div><!-- .page-section -->

<?php 

	get_template_part('footer');

}

// Show login and registation forms
function colabs_show_register() {

	global $posted;
	
	if (isset($_POST['register']) && $_POST['register']) {
		
		$result = colabs_process_register_form();
		
		$errors = $result['errors'];
		$posted = $result['posted'];
		
	} 

	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) ) $errors = new WP_Error();

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
			$errors->add('test_cookie', __('Cookies are blocked or not supported by your browser. You must enable cookies to continue.','colabsthemes'));
	
	if ( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
			$message = __('You are now logged out.','colabsthemes');

	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	
			$errors->add('registerdisabled', __('User registration is currently not allowed.','colabsthemes'));

	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	
			$message = __('Check your email for the confirmation link.','colabsthemes');

	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	
			$message = __('Check your email for your new password.','colabsthemes');

	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
			$message = __('Registration complete. Please check your e-mail.','colabsthemes');

	get_template_part('header');
	?>
	<div class="page-section row">
						
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>

			<div class="post">
			

				<div class="entry-content">
					<?php 
    				if (isset($message) && !empty($message)) {
    					echo '<p class="success">'.$message.'</p>';
    				}
					?>
					<?php 
					if (isset($errors) && sizeof($errors)>0 && $errors->get_error_code()) :
						echo '<ul class="errors">';
						foreach ($errors->errors as $error) {
							echo '<li>'.$error[0].'</li>';
						}
						echo '</ul>';
					endif; 
					?>
					<?php colabs_register_form(); ?>
				</div><!-- .entry-content -->
		
			</div>

		</div><!-- .page-section -->

<?php 

	get_template_part('footer');

}

// show the forgot your password page
function colabs_show_password() {
    $errors = new WP_Error();

    if ( isset($_POST['user_login']) && $_POST['user_login'] ) {
        $errors = retrieve_password();

        if ( !is_wp_error($errors) ) {
            wp_redirect('wp-login.php?checkemail=confirm');
            exit();
        }

    }

    if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.','colabsthemes'));

    do_action('lost_password');
    do_action('lostpassword_post');

    get_template_part('header');
	?>
<div class="page-section row">
						
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>

			<div class="post">
			

				<div class="entry-content">
					<?php 
    				if (isset($message) && !empty($message)) {
    					echo '<p class="success">'.$message.'</p>';
    				}
					?>
					<?php 
					if (isset($errors) && sizeof($errors)>0 && $errors->get_error_code()) :
						echo '<ul class="errors">';
						foreach ($errors->errors as $error) {
							echo '<li>'.$error[0].'</li>';
						}
						echo '</ul>';
					endif; 
					?>
					<?php colabs_forgot_password_form(); ?>
				</div><!-- .entry-content -->
		
			</div>

		</div><!-- .page-section -->

<?php 
	
	get_template_part('footer');
}

?>
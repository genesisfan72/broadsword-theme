<?php
/**
 * Template Name: Contact Page
 *
 * @package Broadsword
 */

//response generation function
$response = "";

//function to generate response
function woc_broadsword_contact_form_generate_response( $type, $message ) {

	global $response;

	if ( $type === "success" ) $response = "<div class='alert alert-success'>{$message}</div>";
	else $response = "<div class='alert alert-danger'>{$message}</div>";

}

//response messages
$not_human       = __( 'Human verification incorrect.', 'woc_broadsword' );
$missing_content = __( 'Please supply all information.', 'woc_broadsword' );
$email_invalid   = __( 'Email Address Invalid.', 'woc_broadsword' );
$message_unsent  = __( 'Message was not sent. Try Again.', 'woc_broadsword' );
$message_sent    = __( 'Thanks! Your message has been sent.', 'woc_broadsword' );

//post variables
$name = $email = $message = $human = "";

//user posted variables
if ( isset( $_POST['author'] ) ) $name = sanitize_text_field( $_POST['author'] );
if ( isset( $_POST['email'] ) ) $email = sanitize_email( $_POST['email'] );
if ( isset( $_POST['contactmessage'] ) ) $message = esc_textarea( $_POST['contactmessage'] );
if ( isset( $_POST['human'] ) ) $human = sanitize_text_field( $_POST['human'] );

//php mailer variables
$to = get_option('admin_email');
$subject = __( 'Someone sent a message from ', 'woc_broadsword' ) .get_bloginfo('name');
$headers = 'From: '. $email . "rn" .
  'Reply-To: ' . $email . "rn";

if(!$human == 0){
	if($human != 2) woc_broadsword_contact_form_generate_response("error", $not_human); //not human!
  	else {
    	//validate email
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			woc_broadsword_contact_form_generate_response("error", $email_invalid);
		}
		else { //email is valid
	  		//validate presence of name and message
			if(empty($name) || empty($message)){
			  	woc_broadsword_contact_form_generate_response("error", $missing_content);
			}
			else { //ready to go!
			  	$sent = wp_mail($to, $subject, strip_tags($message), $headers);
				if($sent) woc_broadsword_contact_form_generate_response("success", $message_sent); //message sent!
				else woc_broadsword_contact_form_generate_response("error", $message_unsent); //message wasn't sent

				$name = '';
				$message = '';
			}
		}
	}
}
else {
	if ( isset( $_POST['submitted'] ) ) {
		if ($_POST['submitted']) woc_broadsword_contact_form_generate_response("error", $missing_content);
	}
}

get_header(); ?>

	<?php
		/**
		 * Get the page title.
		 */
		$page_title = get_the_title($post->id);
	?>

	<section id="primary" class="hideme content-area single">

		<div class="page-image-container header-image">
			<div class="page-details title-details single">
		        <div class="entry-header">
		            <h1><?php echo $page_title; ?></h1>
		        </div><!-- .entry-header -->
		    </div>
	    </div>

		<main id="main" class="site-main" role="main">

			<div class="container-fluid">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'contact' ); ?>

				<?php endwhile; // end of the loop. ?>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>

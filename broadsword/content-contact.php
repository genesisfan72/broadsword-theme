<?php
/**
 * @package Broadsword
 */
?>

<div <?php post_class( "container" ); ?>>
	<div class="contact-icons row ">
		<div class="col-sm-12">
			<div class="icons-list">
				<?php
					// Phone and email first
					if ( get_theme_mod( 'woc_phone' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="tel:+' . get_theme_mod( 'woc_phone' ) . '"><i class="fa fa-phone"></i></a><div class="icon-details">' . get_theme_mod( 'woc_phone' ) . '</div></div>';
					}

					if ( get_theme_mod( 'admin_email' ) ) {
						echo '<div class="contact-icon-container"><a href="mailto:' . esc_url( get_theme_mod( 'admin_email' ) ) . '"><i class="fa fa-envelope"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'admin_email' ) ) . '</div></div>';
					}

					// Social media icons
					if ( get_theme_mod( 'woc_facebook' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="' . esc_url( get_theme_mod( 'woc_facebook' ) ) . '"><i class="fa fa-facebook"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'woc_facebook' ) ) . '</div></div>';
					}

					if ( get_theme_mod( 'woc_twitter' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="' . esc_url( get_theme_mod( 'woc_twitter' ) ) . '"><i class="fa fa-twitter"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'woc_twitter' ) ) . '</div></div>';
					}

					if ( get_theme_mod( 'woc_googleplus' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="' . esc_url( get_theme_mod( 'woc_googleplus' ) ) . '"><i class="fa fa-google-plus"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'woc_googleplus' ) ) . '</div></div>';
					}

					if ( get_theme_mod( 'woc_linkedin' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="' . esc_url( get_theme_mod( 'woc_linkedin' ) ) . '"><i class="fa fa-linkedin"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'woc_linkedin' ) ) . '</div></div>';
					}

					if ( get_theme_mod( 'woc_pinterest' ) != "" ) {
						echo '<div class="contact-icon-container"><a href="' . esc_url( get_theme_mod( 'woc_pinterest' ) ) . '"><i class="fa fa-pinterest"></i></a><div class="icon-details">' . esc_url( get_theme_mod( 'woc_pinterest' ) ) . '</div></div>';
					}
				?>
			</div>
		</div>
	</div>

	<div class="border-bottom"></div>

	<div class="contact-form row">
		<div class="col-sm-12">
			<?php global $response; ?>
			<?php echo $response; ?>
			<form action="<?php esc_url( the_permalink() ); ?>" method="post" id="contactform" novalidate="">

				<div class="form-group contact-form-author">
					<label for="author"><?php echo __( 'Your name:' , 'woc_broadsword' ); ?></label>
					<input id="author" name="author" minlength="3" maxlength="30" required type="text" class="form-control" value="">
				</div>

				<div class="form-group contact-form-email">
					<label for="email"><?php echo __( 'Your email:' , 'woc_broadsword' ); ?></label>
					<input id="email" name="email" type="email" required class="form-control" value="">
				</div>

				<div class="form-group contact-form-comment">
					<label for="contactmessage"><?php echo __( 'Your message' , 'woc_broadsword' ); ?></label>
					<textarea id="contactmessage" class="form-control" required name="contactmessage" rows="4"></textarea>
				</div>

				<div class="form-group contact-form-human">
					<label for="human"><?php echo __( 'Human verification:' , 'woc_broadsword' ); ?></label>
					<input id="human" name="human" type="text" class="form-control" required value=""><span> + 3 = 5</span>
				</div>

				<p class="form-submit">
					<input name="form_submit" type="submit" id="form_submit" value="<?php echo __( 'Submit' , 'woc_broadsword' ); ?>">
				</p>
			</form>
		</div>
	</div>
</div>

<div class="container-fluid">
	<?php
		if ( get_theme_mod( 'woc_google_map' ) != '' ) {
	?>
		<div class="contact-map">
			<?php echo get_theme_mod( 'woc_google_map' ); ?>
		</div>
	<?php } ?>
</div>

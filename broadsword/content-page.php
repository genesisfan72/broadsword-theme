<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Broadsword
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="page-content row">
			<div class="col-sm-12">
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'woc_broadsword' ),
						'after'  => '</div>',
					) );
				?>
			</div>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->

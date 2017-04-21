<?php
/**
 * The template for displaying all single posts.
 *
 * @package Broadsword
 */

get_header(); ?>

	<?php
	/**
	 * Get the post author info and title.
	 */
	$post_title = get_the_title($post->id);
    $name_choice = get_theme_mod( 'woc_display_name', 'user_nicename' );
	$author_name = get_the_author_meta( $name_choice , $post->post_author );
	$author_id = get_the_author_meta( 'ID', $post->post_author );
	?>

	<section id="primary" class="hideme content-area single">
		<div class="single-image-container header-image">
			<div class="arrow-container arrow-container-bottom">
            	<i id="arrow_down" class="fa fa-angle-down fa-4x direction-arrow"></i>
            </div>

			<div class="post-details title-details single">
	        	<div class="entry-header">
	            	<h1><?php echo $post_title; ?></h1>
	        	</div><!-- .entry-header -->

                <?php if ( get_theme_mod( 'woc_post_byline', 'show' ) == 'show' ) { ?>
		        <div class="entry-summary">
		        	<div class="dimmed-06">
			            <div class="uppercase"><?php woc_broadsword_posted_on_in_category($post->id); ?></div>
			            <?php
			            $byline = sprintf(
							_x( 'by %s', 'post author', 'woc_broadsword' ),
							'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( $author_name ) . '</a></span>'
						);
			            ?>
			            <div><?php echo '<span class="byline"> ' . $byline . '</span>'; ?></div>
		            </div>
		        </div><!-- .entry-summary -->
                <?php } ?>
		    </div>
		</div>

		<main id="main" class="site-main" role="main">

			<div class="container-fluid">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

					<?php woc_broadsword_post_nav(); ?>

				<?php endwhile; // end of the loop. ?>

			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
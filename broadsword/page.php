<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Broadsword
 */

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

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>

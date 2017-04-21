<?php
/**
 * The template for displaying search results pages.
 *
 * @package Broadsword
 */

get_header(); ?>

	<section id="primary" class="hideme content-area single">
		<div class="page-image-container header-image">
			<div class="page-details title-details single">
	        	<div class="entry-header">
	        		<?php
	        		$mySearch = new WP_Query("s=$s & showposts=-1");
					$num = $mySearch->post_count;
					?>
	            	<h1 class="page-title"><?php printf( __( '(%d) Search Results Found', 'woc_broadsword' ), $num ); ?></h1>
	        	</div><!-- .entry-header -->

		    </div>
		</div>

		<main id="main" class="site-main" role="main">

			<div class="post-content">

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'content', 'search' );
						?>

					<?php endwhile; ?>

					<?php woc_broadsword_paging_nav(); ?>

				<?php else : ?>

					<?php get_template_part( 'content', 'none' ); ?>

				<?php endif; ?>

			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>

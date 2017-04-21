<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Broadsword
 */

get_header(); ?>

	<section id="primary" class="hideme content-area single">
		<div class="page-image-container header-image">
			<div class="page-details title-details single">
		        <div class="entry-header">
		            <h1><?php _e( '404 - Oops! You must be lost', 'woc_broadsword' ); ?></h1>
		        </div><!-- .entry-header -->
		    </div>
		</div>

		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<div class="container">
					<div class="page-content row">
						<div class="col-sm-12">
							<p><?php _e( 'Sorry about that but the page you are looking for is not here. Perhaps you should go to the homepage or try to search using the search field below.', 'woc_broadsword' ); ?></p>

							<?php get_search_form(); ?>
						</div>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>

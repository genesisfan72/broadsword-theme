<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Broadsword
 */

if ( ! function_exists( 'woc_broadsword_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function woc_broadsword_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'woc_broadsword' ); ?></h1>
		<div class="container">
			<div class="nav-links">

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'woc_broadsword' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'woc_broadsword' ) ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</div>
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'woc_broadsword_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function woc_broadsword_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation container-fluid" role="navigation">
		<div class="nav-links">
			<?php
				$prev_post = get_previous_post();
				$prev_bg_style = "";
				$args = array( 'order' => 'ASC', 'post_type' => 'post', 'post_status' => 'publish', 'orderby' => 'post_date', 'posts_per_page' => -1 );
				$posts_array = get_posts( $args );
				$first_post = count( $posts_array ) > 0 ? $posts_array[0] : NULL;
				$last_post = count( $posts_array ) > 0 ? $posts_array[count($posts_array) - 1] : NULL;

				if ( empty( $prev_post ) ) {
					$prev_post = $last_post;
				}

				if ( has_post_thumbnail( $prev_post->ID) ) {
					$prev_feat_image = wp_get_attachment_url( get_post_thumbnail_id($prev_post->ID) );
					$prev_bg_style = 'style="background: url(' . $prev_feat_image . ') 100% / cover"';
				}

				$next_post = get_next_post();
				$next_bg_style = "";
				if ( empty( $next_post ) ) {
					$next_post = $first_post;
				}
				if ( has_post_thumbnail( $next_post->ID) ) {
					$next_feat_image = wp_get_attachment_url( get_post_thumbnail_id($next_post->ID) );
					$next_bg_style = 'style="background: url(' . $next_feat_image . ') 100% / cover"';
				}
			?>

            <?php
            // Check to see if we have a previous post to show
            if ( $prev_post != "" ) {
            ?>
			<div class="footer-nav <?php if ( !empty( $prev_post ) ) echo 'border-right'; ?> col-sm-6">
				<div class="nav-image-container" <?php echo $prev_bg_style; ?>></div>
                <div class="post-details title-details">
                    <div class="entry-header">
                        <h1>
                        	<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>"><?php echo $prev_post->post_title; ?></a>
                        </h1>
                    </div><!-- .entry-header -->

                <?php if ( get_theme_mod( 'woc_post_byline', 'show' ) == 'show' ) { ?>
                    <div class="entry-summary">
                        <div class="dimmed-06">
                            <?php woc_broadsword_posted_on_in_category( $prev_post->ID ); ?>
                        </div>
                    </div><!-- .entry-summary -->
                <?php } ?>
                </div>

                <div class="overlay"></div>
			</div>
            <?php
            }
            ?>

            <?php
            // Check to see if we have a next post to show
            if ( !empty( $next_post) ) {
            ?>
			<div class="footer-nav <?php if ( empty( $prev_post ) ) echo 'border-left col-sm-offset-6'; ?> col-sm-6">
				<div class="nav-image-container" <?php echo $next_bg_style; ?>></div>
                <div class="post-details title-details">
                    <div class="entry-header">
                        <h1>
                        	<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>"><?php echo $next_post->post_title; ?></a>
                        </h1>
                    </div><!-- .entry-header -->

                    <?php if ( get_theme_mod( 'woc_post_byline', 'show' ) == 'show' ) { ?>
                    <div class="entry-summary">
                        <div class="dimmed-06">
                            <?php woc_broadsword_posted_on_in_category( $next_post->ID ); ?>
                        </div>
                    </div><!-- .entry-summary -->
                    <?php } ?>
                </div>

                <div class="overlay"></div>
			</div>
            <?php
            }
            ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'woc_broadsword_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function woc_broadsword_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )

    // Uncomment the following if you would like to show the date the post was modified
//		,esc_attr( get_the_modified_date( 'c' ) ),
//		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( 'Posted on %s', 'post date', 'woc_broadsword' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'woc_broadsword' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'woc_broadsword_posted_on_in_category' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and category.
 */
function woc_broadsword_posted_on_in_category($id) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c', $id ) ),
		esc_html( get_the_date( 'F j, Y', $id) ),
		esc_attr( get_the_modified_date( 'c', $id ) ),
		esc_html( get_the_modified_date( 'F j, Y', $id) )
	);

	$posted_on = sprintf( _x( '%s', 'post date', 'woc_broadsword' ), $time_string );

	$categories = get_the_category($id);
	$separator = ', ';
	$category_output = '';
	$byline = '';

	if ($categories) {
		foreach($categories as $category) {
			$category_output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "woc_broadsword" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}

		$category_output = trim($category_output, $separator);
		$byline = sprintf(_x( 'in %s', 'post category', 'woc_broadsword' ), $category_output);
	}

	echo '<h3>' . $posted_on . ' ' . $byline . '</h3>';

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function woc_broadsword_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'woc_broadsword_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'woc_broadsword_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so woc_broadsword_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so woc_broadsword_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in woc_broadsword_categorized_blog.
 */
function woc_broadsword_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'woc_broadsword_categories' );
}
add_action( 'edit_category', 'woc_broadsword_category_transient_flusher' );
add_action( 'save_post',     'woc_broadsword_category_transient_flusher' );

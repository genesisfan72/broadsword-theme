<?php
/**
 * @package Broadsword
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
		<div class="comments-tags-social row">
			<div class="comments-tags col-sm-8">
				<div class="comments-row row">
					<div class="col-sm-12">
						<?php
						comments_number(
							__( 'No comments', 'woc_broadsword' ),
							__( 'One comment', 'woc_broadsword' ),
							'% ' . __( 'comments', 'woc_broadsword' )
						);
						?>
					</div>
				</div>
				<div class="tags-row row">
					<div class="col-sm-12">
						<?php echo get_the_tag_list(__( 'Tags: ', 'woc_broadsword' ), ', '); ?>
					</div>
				</div>
			</div>
			<div class="social-links col-sm-4">
				<div class="row share-this">
					<div class="col-sm-12">
					<?php
					echo __( 'Share article:', 'woc_broadsword' );
					?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<a href=<?php echo esc_url( 'http://www.facebook.com/sharer.php?u=' . get_permalink() ); ?>><i class="fa fa-facebook fa-lg"></i></a>
						<a href='http://www.twitter.com/share?text=<?php echo the_title(); ?>&url=<?php echo esc_url( get_permalink() ); ?>'><i class="fa fa-twitter fa-lg"></i></a>
						<a href=<?php echo esc_url( 'https://plus.google.com/share?url=' . get_permalink() ); ?>><i class="fa fa-google-plus fa-lg"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="border-bottom"></div>
		<div class="entry-content row">
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

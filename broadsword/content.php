<?php
/**
 * @package Broadsword
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container">
        <div class="post-thumb col-xs-12 col-sm-3">
            <?php
            if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                the_post_thumbnail( 'broadsword_thumbnail' );
            }
            ?>
        </div>

        <div class="col-sm-9">
            <header class="entry-header">
                <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

                <?php if ( 'post' == get_post_type() ) : ?>
                <div class="entry-meta">
                    <?php woc_broadsword_posted_on_in_category( get_the_ID() ); ?>
                </div><!-- .entry-meta -->
                <?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_excerpt(); ?>
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'woc_broadsword' ),
                        'after'  => '</div>',
                    ) );
                ?>
            </div><!-- .entry-content -->
        </div>
    </div>
</article><!-- #post-## -->
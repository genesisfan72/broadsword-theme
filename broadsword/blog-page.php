<?php
/**
 * Template Name: Blog
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
            </div>
            <!-- .entry-header -->
        </div>
    </div>

    <main id="main" class="site-main" role="main">

        <div class="post-content">

            <?php
            $myposts = get_posts( array( 'posts_per_page' => -1 ) );
            if (count($myposts) > 0) {
                foreach ($myposts as $post) : setup_postdata($post);
                    get_template_part('content', get_post_format());
                endforeach;
                wp_reset_postdata();
            }
            else {
                get_template_part('content', 'none');
            }
            ?>
        </div>

    </main>
    <!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>

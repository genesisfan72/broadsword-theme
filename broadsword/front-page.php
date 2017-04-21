<?php
/**
 * Front Page template file.
 *
 * @package Broadsword
 */

get_header(); ?>

<?php

$fp_style      = get_theme_mod('woc_front_page_style');
$is_horizontal = ($fp_style == 'horizontal' || $fp_style == 'horizontal-bg');

if (isset($_GET['fp_style'])) {
    $fp_post_style = $_GET['fp_style'];
    $is_horizontal = ($fp_post_style == 'horizontal' || $fp_post_style == 'horizontal-bg');
    $fp_style      = $fp_post_style;
} else {
    $is_horizontal = ($fp_style == 'horizontal' || $fp_style == 'horizontal-bg');
}

?>

    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="hideme viewport <?php if ($is_horizontal) {
                echo 'horizontal';
            } ?>">
                <nav id="posts" class="<?php echo $is_horizontal
                    ? ""
                    : "swiper-container"; ?>">
                    <?php
                    $class_string = "";
                    ?>
                    <?php if (!$is_horizontal) {
                        $class_string .= "swiper-wrapper";
                    } ?>
                    <ul class="<?php echo $class_string; ?>">

                        <?php if (get_theme_mod('woc_loop_source') == 'pages') {
                            query_posts(array('post_type' => 'page'));
                        }
                        ?>

                        <?php if (have_posts()) : ?>

                            <?php while (have_posts()) : the_post(); ?>

                                <?php
                                get_template_part('content', 'excerpt');
                                ?>

                            <?php endwhile; ?>

                        <?php else : ?>

                            <?php get_template_part('content', 'none'); ?>

                        <?php endif; ?>

                        <?php if ($fp_style == 'default' || $fp_style == 'imaged') { ?>
                    </ul>
                <?php } ?>
                </nav>
            </div>

            <?php if ($fp_style != 'horizontal' && $fp_style != 'horizontal-bg') { ?>
                <div class="arrow-container arrow-container-right">
                    <i id="arrow_next" class="fa fa-angle-right fa-3x direction-arrow"></i>
                </div>

                <div class="arrow-container arrow-container-left">
                    <i id="arrow_prev" class="fa fa-angle-left fa-3x direction-arrow"></i>
                </div>
            <?php } else {
                ?>
                <div class="arrow-container arrow-container-top">
                    <i id="arrow_up" class="fa fa-angle-up fa-3x direction-arrow"></i>
                </div>

                <div class="arrow-container arrow-container-bottom">
                    <i id="arrow_down" class="fa fa-angle-down fa-3x direction-arrow"></i>
                </div>
            <?php } ?>

            <div class="view-more-container">
                <button class="view-more"><?php echo __('View More', 'woc_broadsword'); ?></button>
            </div>


        </main>
        <!-- #main -->

    </section><!-- #primary -->

<?php get_footer(); ?>
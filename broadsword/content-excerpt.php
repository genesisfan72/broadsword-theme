<?php
/**
 * The template part for displaying post excerpts on the front page.
 *
 * @package Broadsword
 */
?>

<?php
$class_string = "post-column ";
global $fp_style;

if ($fp_style == 'horizontal' || $fp_style == 'horizontal-bg') {
    $class_string .= "horizontal";
} else $class_string .= "swiper-slide"
?>

<li id="post-<?php the_ID(); ?>" <?php post_class($class_string); ?>>
    <div class="post-details hideme offscreen <?php if ($fp_style == 'horizontal' || $fp_style == 'horizontal-bg') {
        echo 'horizontal';
    } ?>">
        <div class="entry-header">
            <h1><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h1>
        </div>
        <!-- .entry-header -->

        <?php if (get_theme_mod( 'woc_show_date_line', 1 ) == 1) { ?>
            <div class="entry-summary <?php if ($fp_style == 'horizontal' || $fp_style == 'horizontal-bg') {
                echo 'horizontal';
            } ?>">
                <?php woc_broadsword_posted_on_in_category($post->id); ?>
            </div><!-- .entry-summary -->
        <?php } ?>
    </div>

    <?php if ($fp_style !== 'default' && $fp_style !== 'horizontal-bg') {
        $thumbnail = get_post_thumbnail_id($post->ID);
        $bg_img    = '';
        if ($thumbnail != '') {
            $bg_img = wp_get_attachment_image_src($thumbnail, 'single-post-thumbnail'); // returns an array
            $bg_img = esc_url($bg_img[0]);  // the url
        }
        ?>
        <div class="post-column-image" <?php if ($bg_img != '') { ?>style="background:url(<?php echo $bg_img; ?>) 100% / cover;"<?php } ?>></div>
    <?php } ?>

    <div class="hover"></div>
</li><!-- #post-## -->
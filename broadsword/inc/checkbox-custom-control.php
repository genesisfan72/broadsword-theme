<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom layout control
 */
class Checkbox_Custom_Control extends WP_Customize_Control
{
    public function __construct( $manager, $id, $args = array() )
    {
        $this->args = $args;

        parent::__construct( $manager, $id, $args );
    }

    public function render_content()
     {
          ?>
              <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
              <label>
                <input type="checkbox" data-customize-setting-link="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" <?php checked( $this->value() ); ?> /><?php echo esc_html( $this->args[ 'checkbox_label' ] ); ?>
              </label>
          <?php
     }
}
?>
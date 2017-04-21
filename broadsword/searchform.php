<?php
/**
 * Search Form
 *
 * @package Broadsword
 */
?>

<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
	<div class="input-group">
		<input type="search" class="search-field form-control"  value="<?php echo get_search_query() ?>" name="s"placeholder="<?php echo __( 'Search here', 'woc_broadsword' ); ?>">
		<span class="input-group-btn">
			<input type="submit" class="btn btn-default"><?php echo __( 'Submit', 'woc_broadsword' ); ?></button>
		</span>
	</div>
</form>

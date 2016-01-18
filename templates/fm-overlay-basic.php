<?php
/**
 * fm-overlay-basic.php
 *
 * @created     1/15/16 5:45 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Basic template for displaying fm-overlay
 * @TODO Finish building content once the fields are finally established.
 */
if ( empty( $overlay ) ) {
	return;
}
?>

<div class="fm-overlay-wrapper">
	<div class="fm-overlay-content">
		<div class="fm-overlay-title">
			<?php echo esc_html( $overlay->post_title ); ?>
		</div>
	</div>
</div>

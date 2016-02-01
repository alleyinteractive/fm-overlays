<?php
/**
 * fm-overlay-basic.php
 *
 * @created     1/15/16 5:45 PM
 * @author      Alley Interactive
 * @package     fm-overlays
 * @description Basic template for displaying fm-overlay
 */
if ( empty( $overlay ) ) {
	return;
}
?>

<div id="fm-overlay" class="fm-overlay">
	<div class="fm-overlay-wrapper">
		<a class="fm-overlay-close" href="javascript:void(0)"><?php esc_html_e( 'Close', 'fm-overlays' ); ?></a>
		<div class="fm-overlay-title">
			<h1><?php echo esc_html( $overlay->post_title ); ?></h1>
		</div>
		<?php if ( '' != ( $overlay_content = get_post_meta( $overlay->ID, 'fm_overlays_content', true ) ) ) : ?>
			<div class="fm-overlay-content">
				<?php echo wp_kses_post( $overlay_content ); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="fm-overlay-fade"></div>
</div>

<?php
/**
 * FM Overlays Image Template
 * implements the srcset attribute in the <img> tag
 *
 * @package fm-overlays
 *
 * phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
 */

if ( empty( $overlay ) ) {
	return;
}

$image_sizes   = Fm_Overlays_Helpers()->get_overlay_image_sizes( $overlay->overlay_content['image_id'] );
$classes       = 'entry-thumbnail fm-image';
$alt_text      = the_title_attribute( array( 'echo' => false ) );
$attachment_id = 'attachment_' . $overlay->overlay_content['image_id'];

?>

<?php if ( ! empty( $image_sizes ) ) : ?>
	<div <?php if ( ! empty( $attachment_id ) ) : ?>
		id="<?php echo esc_attr( $attachment_id ); ?>"<?php endif; ?>
		<?php if ( ! empty( $classes ) ) : ?>
			class="<?php echo esc_attr( $classes ); ?>"
		<?php endif; ?>>
		<img srcset="<?php echo( ! empty( $image_sizes['desktop_src'] ) ? esc_url( $image_sizes['desktop_src']['src'] ) . ' ' . esc_attr( $image_sizes['desktop_src']['width'] ) . 'w, ' : '' ); ?>
					<?php echo( ! empty( $image_sizes['tablet_src'] ) ? esc_url( $image_sizes['tablet_src']['src'] ) . ' ' . esc_attr( $image_sizes['tablet_src']['width'] ) . 'w, ' : '' ); ?>
					<?php echo( ! empty( $image_sizes['mobile_src'] ) ? esc_url( $image_sizes['mobile_src']['src'] ) . ' ' . esc_attr( $image_sizes['mobile_src']['width'] ) . 'w, ' : '' ); ?>"
			alt="<?php echo esc_attr( $alt_text ); ?>"
			sizes="(min-width: 36em) calc(.666 * (100vw - 8em)), 100vw"
			src="<?php echo esc_url( $image_sizes['mobile_src']['src'] ); ?>"
		/>
	</div>
<?php endif;

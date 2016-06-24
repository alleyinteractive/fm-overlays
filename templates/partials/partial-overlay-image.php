<?php
/**
 * FM Overlays Image Template
 * used to create responsive picture element
 */




$image_sizes = Fm_Overlays_Helpers::instance()->get_overlay_image_sizes( $overlay->overlay_content['image_id'] );


$classes = 'entry-thumbnail fm-image';
$alt_text = the_title_attribute( array( 'echo' => false ) );

?>


<?php if ( ! empty( $image_sizes ) ) : ?>
	<picture <?php if ( ! empty( $id ) ) : ?>
		id="<?php echo esc_attr( $id ); ?>"<?php endif; ?>
		<?php if ( ! empty( $classes ) ) : ?>
			class="<?php echo esc_attr( $classes ); ?>"
		<?php endif; ?>>
		<?php if ( ! empty( $image_sizes['desktop_src'] ) ) : ?>
			<source
				srcset="<?php echo esc_url( $image_sizes['desktop_src']['src'] ); ?>"
				media="(min-width: 768px)">
		<?php endif; ?>
		<?php if ( ! empty( $image_sizes['tablet_src'] ) ) : ?>
			<source
				srcset="<?php echo esc_url( $image_sizes['tablet_src']['src'] ); ?>"
				media="(min-width: 640px)">
		<?php endif; ?>
		<?php if ( ! empty( $image_sizes['mobile_src'] ) ) : ?>
			<source
				srcset="<?php echo esc_url( $image_sizes['mobile_src']['src'] ); ?>"
				media="(max-width: 639px)">
			<img
				srcset="<?php echo esc_url( $image_sizes['mobile_src']['src'] ); ?>"
				<?php if ( ! empty( $alt_text ) ) : ?>
					alt="<?php echo esc_attr( $alt_text ); ?>"
				<?php endif; ?>
			>
		<?php endif; ?>
	</picture>
<?php endif; ?>

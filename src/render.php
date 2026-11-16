<?php
/**
 * Server render. Shows the featured image (default) or `imageUrl`; the `faf_imageviewer_tile_source`
 * filter can swap in a Deep Zoom (.dzi) source for an attachment.
 *
 * @var array $attributes
 */

$height = isset( $attributes['height'] ) ? $attributes['height'] : '500px';

if ( ! empty( $attributes['useFeatured'] ) ) {
	$attachment_id = (int) get_post_thumbnail_id();
	// The full-resolution original, not WordPress' 2560 px "-scaled" copy.
	$image_url = $attachment_id ? ( wp_get_original_image_url( $attachment_id ) ?: wp_get_attachment_url( $attachment_id ) ) : '';
} else {
	$attachment_id = (int) ( $attributes['attachmentId'] ?? 0 );
	$image_url     = $attributes['imageUrl'] ?? '';
}
if ( ! $image_url ) {
	return;
}
$tile_source = apply_filters( 'faf_imageviewer_tile_source', $image_url, $attachment_id );

// Once per page, however many viewers there are.
if ( ! defined( 'FAF_IMAGEVIEWER_ICONS_PRINTED' ) ) {
	define( 'FAF_IMAGEVIEWER_ICONS_PRINTED', true );
	wp_add_inline_script(
		'sag-sas-faf-imageviewer-block-view-script',
		'window.OSDBlock = ' . wp_json_encode( array( 'iconsUrl' => plugins_url( '../src/osd-icons/', __FILE__ ) ) ) . ';',
		'before'
	);
}
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput ?>>
	<div class="osd-container" style="width: 100%; height: <?php echo esc_attr( $height ); ?>" data-image-url="<?php echo esc_url( $image_url ); ?>" data-tile-source="<?php echo esc_url( $tile_source ); ?>"></div>
</div>

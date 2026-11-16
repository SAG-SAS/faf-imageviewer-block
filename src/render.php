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
	$image_url     = $attributes['imageUrl'] ?? '';
	$attachment_id = (int) ( $attributes['attachmentId'] ?? 0 ) ?: attachment_url_to_postid( $image_url );
}
if ( ! $image_url ) {
	return;
}
$tile_source = apply_filters( 'faf_imageviewer_tile_source', $image_url, $attachment_id );

// The viewer takes the image's own proportions (the "-scaled" copy keeps them); a fixed height only
// when the size is unknown. The theme can cap it with max-height/min-height on .osd-container.
$meta  = $attachment_id ? wp_get_attachment_metadata( $attachment_id ) : array();
$style = ! empty( $meta['width'] ) && ! empty( $meta['height'] )
	? sprintf( 'width: 100%%; aspect-ratio: %d / %d', $meta['width'], $meta['height'] )
	: 'width: 100%; height: ' . $height;

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
	<div class="osd-container" style="<?php echo esc_attr( $style ); ?>" data-image-url="<?php echo esc_url( $image_url ); ?>" data-tile-source="<?php echo esc_url( $tile_source ); ?>"></div>
</div>

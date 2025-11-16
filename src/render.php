<?php


$iconsUrl = plugins_url( '../src/osd-icons/', __FILE__ );
$height = isset( $attributes['height'] ) ? esc_attr( $attributes['height'] ) : '400px';

$post_id = get_the_ID() ?: 0;

	if ( ! empty( $attributes['useFeatured'] ) && $attributes['useFeatured'] ) {
		$image_url = get_the_post_thumbnail_url( null, 'full' );
	} else {
		$image_url = $attributes['imageUrl'] ?? '';
	}

?>
<script>
	const OSDBlock = { iconsUrl: "<?php echo esc_url($iconsUrl) ?>" };
</script>
<div <?php echo wp_kses_data(get_block_wrapper_attributes()) ?>>
	<div class="osd-container" style="width: 100%; height: <?php echo esc_attr($height) ?>" data-image-url="<?php echo esc_url($image_url) ?>"></div>
</div>



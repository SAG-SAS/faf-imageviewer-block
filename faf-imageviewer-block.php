<?php
/**
 * Plugin Name:       SAG/FAF Imageviewer
 * Description:       A zoomable image viewer using the open source Openseadragon viewer, with support for tiling images
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       faf-imageviewer-block
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_faf_imageviewer__block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_faf_imageviewer__block_block_init' );

function faf_imageviewer_enqueue_view_assets() {
    // Pass PHP values into JS
    // wp_localize_script( 'faf-imageviewer-view', 'OSDBlock', array(
    //     'iconsUrl' => plugins_url( 'src/osd-icons/', __FILE__ ),
    //     'defaultImageUrl' => get_the_post_thumbnail_url( null, 'full' ), // Featured image fallback
    // ) );
}
add_action( 'enqueue_block_assets', 'faf_imageviewer_enqueue_view_assets' );

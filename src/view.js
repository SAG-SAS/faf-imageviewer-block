/**
 * Front-end: one OpenSeadragon viewer per block. Uses Deep Zoom tiles when `data-tile-source`
 * is a .dzi, otherwise the single image. Viewers inside a closed <details> start when it opens.
 */
import OpenSeadragon from 'openseadragon';
import metadata from './block.json';

const blockClass = 'wp-block-' + metadata.name.replace( '/', '-' );

function init( el ) {
	if ( el.osdViewer ) {
		el.osdViewer.forceResize();
		return;
	}
	const source = el.dataset.tileSource || el.dataset.imageUrl;
	if ( ! source || ! el.offsetHeight ) {
		return; // not visible yet
	}
	el.osdViewer = OpenSeadragon( {
		element: el,
		autoHideControls: false,
		imageSmoothingEnabled: false,
		showNavigator: false,
		defaultZoomLevel: 0,
		prefixUrl: window.OSDBlock?.iconsUrl,
		visibilityRatio: 0.9,
		tileSources: /\.dzi(\?|$)/.test( source )
			? source
			: { type: 'image', url: source },
	} );
}

document.addEventListener( 'DOMContentLoaded', () => {
	document
		.querySelectorAll( `.${ blockClass } .osd-container` )
		.forEach( init );
	document.querySelectorAll( 'details' ).forEach( ( details ) =>
		details.addEventListener( 'toggle', () => {
			if ( details.open ) {
				details
					.querySelectorAll( `.${ blockClass } .osd-container` )
					.forEach( init );
			}
		} )
	);
} );

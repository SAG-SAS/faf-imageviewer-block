import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	MediaPlaceholder,
	InspectorControls
} from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { imageUrl, useFeatured, height } = attributes;
	const blockProps = useBlockProps();

	const onSelectImage = (media) => {
		if (media?.url) {
			setAttributes({ imageUrl: media.url });
		}
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Viewer Settings', 'faf-imageviewer-block')}>
					<ToggleControl
						label={__('Use Featured Image', 'faf-imageviewer-block')}
						checked={useFeatured}
						onChange={(value) => setAttributes({ useFeatured: value })}
					/>
					<TextControl
						label={__('Height', 'faf-imageviewer-block')}
						value={height}
						onChange={(value) => setAttributes({ height: value })}
						help={__('Any valid CSS height value (e.g., 400px, 50vh, 100%).', 'faf-imageviewer-block')}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div
					style={{
						height: height || '400px',
						background: '#eee',
						display: 'flex',
						alignItems: 'center',
						justifyContent: 'center',
					}}
				>
					{useFeatured ? (
						<p style={{ color: '#666' }}>
							{__('Featured image will be shown here', 'faf-imageviewer-block')}
						</p>
					) : imageUrl ? (
						<img
							src={imageUrl}
							alt={__('Selected image', 'faf-imageviewer-block')}
							style={{ maxWidth: '100%', maxHeight: '100%', objectFit: 'contain' }}
						/>
					) : (
						<MediaPlaceholder
							icon="format-image"
							labels={{
								title: __('Openseadragon Image', 'faf-imageviewer-block'),
								instructions: __('Select an image.', 'openseadragon-block'),
							}}
							onSelect={onSelectImage}
							accept="image/*"
							allowedTypes={['image']}
						/>
					)}
				</div>
			</div>
		</>
	);
}

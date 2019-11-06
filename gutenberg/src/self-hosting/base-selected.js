import icon from './icon';

const { __ } = wp.i18n;
const { Icon } = wp.components;

const BaseSelected = ({ children }) => {
	return (
		<div className="components-placeholder editor-media-placeholder block-editor-media-placeholder wp-block-video">
			<div className="components-placeholder__label">
				<span className="editor-block-icon block-editor-block-icon">
					{ icon }
					<Icon icon="lock" />
				</span>{ __( 'Private Video - self hosting', 'simple-private-video' )}
			</div>
			<div className="components-placeholder__fieldset">
				<div className="components-form-file-upload">
					{ children }
				</div>
			</div>
		</div>
	);
}

export default BaseSelected;

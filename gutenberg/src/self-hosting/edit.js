import BaseSelected from './base-selected';
import classnames from 'classnames';
import helpers from './helpers';

const { __ } = wp.i18n;
const { Component } = wp.element;
const { MediaUpload, MediaUploadCheck } = wp.editor;
const { Button, Icon } = wp.components;
const baseCurrentUrl = window.location.href;
const pluginName = $plugin_options.pluginName;

export default class Edit extends Component {

    constructor() {
        super( ...arguments );
    }

    render() {
        const { attributes, className, setAttributes } = this.props;
		const { videoID } = attributes;
		return (
			<div className={ className }>
				{ ! videoID ? (
					<BaseSelected>
						<MediaUploadCheck>
							<MediaUpload
								title={ __( 'Select or Upload Private Video', pluginName ) }
								onSelect={ video => setAttributes({ videoID: video.id }) }
								value={ videoID }
								render={ ( { open } ) => (
									<Button
										className={ classnames( 'components-icon-button has-text')}
										isLarge
										onClick={ () => {
											helpers.setUrlPrivate( baseCurrentUrl );
											open();
										} }
									>
										<Icon icon="upload" />
										{ __( 'Select or Upload Private Video ', pluginName ) }
									</Button>
								) }
								onClose={ () => helpers.unsetUrlPrivate( baseCurrentUrl ) }
							>
							</MediaUpload>
						</MediaUploadCheck>
					</BaseSelected>
				) : (
					<BaseSelected>
						<Button
							className={ classnames( 'components-icon-button has-text')}
							isDefault
							onClick={ () => setAttributes({ videoID: null }) }
						>
							<Icon icon="no-alt" />
							{ __( ' Deselect Video', pluginName ) }
						</Button>
						<a className="spv-more-info center" href={ `/wp-admin/post.php?post=${videoID}&action=edit`} target="_blank">{ __( 'Show video info', pluginName ) }</a>
					</BaseSelected>
				)}
			</div>
        );
    }
}

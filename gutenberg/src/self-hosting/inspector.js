import classnames from 'classnames';

const { __ } = wp.i18n;
const { MediaUpload, MediaUploadCheck } = wp.editor;
const { Component, Fragment } = wp.element;
const { ColorPalette, InspectorControls } = wp.editor;
const { ColorIndicator, Button, PanelBody, PanelRow, ToggleControl, Icon } = wp.components;
const pluginName = $plugin_options.pluginName;

export default class Inspector extends Component {

    constructor() {
        super( ...arguments );
    }

    render() {
        const { attributes: { color, imageID, imageUrl, content }, setAttributes } = this.props;
		const onSelectImageUpload = img => {
			setAttributes( {
				imageID: img.id,
				imageUrl: img.url
			} );
		};
		const unsetImage = () => {
			setAttributes({
				imageID: null,
				imageUrl: null
			});
		}
        return (
            <InspectorControls>
				<PanelBody
                    title={ __( 'Main color', pluginName ) }
                    initialOpen={ true }
                >
					<PanelRow>
						<p className="color-indicator"><ColorIndicator colorValue={ color } /><strong>{ color }</strong></p>
                    </PanelRow>
					<ColorPalette
                        value={ color }
                        onChange={ color => setAttributes( { color } ) }
                    />
				</PanelBody>
                <PanelBody
                    title={ __( 'Preload image', pluginName ) }
                    initialOpen={ true }
                >
					<MediaUploadCheck>
						<MediaUpload
							title={ __( 'Select or Upload Image', pluginName ) }
							onSelect={ onSelectImageUpload }
							value={ imageID }
							render={ ( { open } ) =>
								<Fragment>
									{ ! imageID ? (
										<Button
											className={ classnames( 'components-icon-button has-text')}
											isLarge
											onClick={ open }
										>
											<Icon icon="upload" />
											{ __( 'Select or Upload Image', pluginName ) }
										</Button>
									) : (
										<Fragment>
											<Button
												className={ classnames( 'components-icon-button has-text')}
												isDefault
												onClick={ unsetImage }
											>
												<Icon icon="no-alt" />
												{ __( ' Deselect Image', pluginName ) }
											</Button>
											<a className="spv-more-info margin-bottom" href={ `/wp-admin/post.php?post=${imageID}&action=edit`} target="_blank">{ __( 'Show image info', pluginName ) }</a>
											<img src={ imageUrl } />
										</Fragment>
									)
									}
								</Fragment>
							}
						>
						</MediaUpload>
					</MediaUploadCheck>
                </PanelBody>
				<PanelBody
                    title={ __( 'Alternative content', pluginName ) }
                    initialOpen={ false }
                >
					<PanelRow>
                        <p>{ __( 'Add custom content to show when video it is not allowed.', pluginName ) }</p>
                    </PanelRow>
					<ToggleControl
                        label={ __( 'Add alternative content', pluginName ) }
                        checked={ content }
                        onChange={ content => setAttributes( { content } ) }
                    />
				</PanelBody>
				<PanelBody
                    title={ __( 'Custom restrictions', pluginName ) }
                    initialOpen={ false }
                >
					<PanelRow>
                        <p>{ __( 'By default the video is show only to logged user, but you can set more restriction with custom configuration by the filter: ', pluginName ) }<strong>spv-show-private-video</strong></p>
					</PanelRow>
					<PanelRow>
						<p>{ __( 'Example with Restric Content Pro:', pluginName ) }</p>
					</PanelRow>
					<PanelRow>
						<p><code className={ classnames( 'spv-example-code')} >
							{ `if ( function_exists( 'rcp_user_has_active_membership' ) ) {
								add_filter( 'spv-show-private-video', function( $show_private_video, $attributes ){
									return rcp_user_has_active_membership();
								}, 10, 2 );
							}`}
						</code></p>
					</PanelRow>
				</PanelBody>
            </InspectorControls>
        );
    }
}

import Edit from './edit';
import Inspector from './inspector';
import Controls from './controls';
import './style.scss';
import './editor.scss';
import classnames from 'classnames';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.editor;
const { Fragment } = wp.element;
const pluginName = $plugin_options.pluginName;

export default registerBlockType(
    pluginName + '/self-hosting',
    {
        title: __( 'Private Video - self hosting', pluginName ),
        description: __( 'Upload and show private videos with self hosting.', pluginName ),
		category: 'sumapress',
		icon: 'format-video',
		supports : {
			html: false,
		},
        keywords: [
			__( 'Video player', pluginName ),
            __( 'Private Video', pluginName ),
            __( 'Vimeo Amazon S3', pluginName ),
        ],
		getEditWrapperProps( { blockAlignment } ) {
            if ( 'left' === blockAlignment || 'right' === blockAlignment || 'full' === blockAlignment ) {
                return { 'data-align': blockAlignment };
            }
        },
        edit: props => {
			const { setAttributes, className, attributes : { content } } = props;
            return (
				<Fragment>
					<Inspector { ...{ setAttributes, ...props } } />
					<Controls { ...{ setAttributes, ...props } }/>
					<Edit { ...{ setAttributes, ...props } } />
					{ content && (
						<div className={ classnames( className, 'spv-border-allow' ) }>
							<InnerBlocks />
						</div>
					)}
				</Fragment>
			);
		},
		save() {
            return <InnerBlocks.Content />;
        }
    },
);

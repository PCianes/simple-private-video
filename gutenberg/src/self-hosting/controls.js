const { Component } = wp.element;
const { BlockControls, BlockAlignmentToolbar } = wp.editor;

export default class Inspector extends Component {

    constructor() {
        super( ...arguments );
    }
    render() {
        const { attributes: { blockAlignment }, setAttributes } = this.props;
        return (
            <BlockControls>
                <BlockAlignmentToolbar
                    value={ blockAlignment }
					onChange={ blockAlignment => setAttributes( { blockAlignment } ) }
                />
            </BlockControls>
        );
    }
}

import {assign} from 'lodash';
// import {PanelBody, SelectControl, Toolbar, IconButton} from '@wordpress/components';
// import {Fragment} from '@wordpress/element';
// import {__} from '@wordpress/i18n';
// import {addFilter} from '@wordpress/hooks';
// import {createHigherOrderComponent} from '@wordpress/compose';
// import {InspectorControls, BlockControls} from '@wordpress/editor';

const {__} = wp.i18n;
const {addFilter} = wp.hooks;
const {createHigherOrderComponent} = wp.compose;
const {Fragment} = wp.element;
const {InspectorControls, BlockControls} = wp.editor;
const {PanelBody, SelectControl} = wp.components;

const availableLanguages = [
    {value: '', label: __('Other', 'fvch')},
    {value: 'bash', label: __('Bash', 'fvch')},
    {value: 'css', label: __('CSS', 'fvch')},
    {value: 'javascript', label: __('Javascript', 'fvch')},
    {value: 'html', label: __('HTML', 'fvch')},
    {value: 'php', label: __('PHP', 'fvch')},
    {value: 'xml', label: __('XML', 'fvch')},
];

const addCodeLanguageAttribute = (settings, name) => {
    if ('core/code' !== name) {
        return settings;
    }

    settings.attributes = assign(settings.attributes, {
        language: {
            type: 'string',
            default: '',
        },
    });

    return settings;
};

addFilter('blocks.registerBlockType', 'fv-code-highlighter/attribute/language', addCodeLanguageAttribute);


const codeLanguageSelect = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        // Do nothing if it's another block than our defined ones.
        if ('core/code' !== props.name) {
            return <BlockEdit {...props} />;
        }

        const {setAttributes} = props;
        const {language} = props.attributes;

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody
                        title="FV Code Highlighter"
                        initialOpen={true}
                    >
                        <SelectControl
                            label={'Language'}
                            value={language}
                            options={availableLanguages}
                            onChange={value => setAttributes({language: value})}
                        />
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };
}, 'codeLanguageSelect');

addFilter('editor.BlockEdit', 'efv-code-highlighter/code-language-select', codeLanguageSelect);

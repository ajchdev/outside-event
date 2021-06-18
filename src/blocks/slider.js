import { registerBlockType } from "@wordpress/blocks";

const { __ } = wp.i18n; // Import __() from wp.i18n
const {
    RichText,
    InspectorControls,
    MediaUpload,
    InnerBlocks,
    MediaPlaceholder
} = wp.blockEditor;

const {
    TextControl,
    ToggleControl,
    SelectControl,
    QueryControls,
    Panel,
    PanelBody,
    PanelRow,
    Button,
    IconButton,
    TextareaControl,
    FormFileUpload ,
} = wp.components;

const {
    Component,
    Fragment,
} = wp.element;

import Slider from "react-slick";

registerBlockType( 'outside-event-block/slider-block', {
    title: __( 'Outside Slider' ),
    icon: 'admin-post',
    category: 'common',
    attributes: {
        blog_id: {
            type: 'string',
        },
        slidercontents: {
            type: 'array',
            default: [],
        },
    },
    edit: function( props ) {

        props.setAttributes({
            blog_id: props.clientId,
        });

        
        const settings = {
          dots: false,
          infinite: true,
          speed: 500,
          slidesToShow: 1,
          slidesToScroll: 1
        };


        const handleAddSliderContent = () => {

            const slidercontents = [ ...props.attributes.slidercontents ];

            slidercontents.push( {
                slidertitle: '',
                slidercaption: '',
                sliderimage: '',
                sliderbuttontext: '',
                sliderbuttonlink: '',
            } );

            props.setAttributes( { slidercontents } );

        };

        const handleRemoveSliderContent = ( index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents.splice( index, 1 );
            props.setAttributes( { slidercontents } );
        };

        const handleSliderTitleChange = ( slidertitle, index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].slidertitle = slidertitle;
            props.setAttributes( { slidercontents } );
        };

        const handleSliderDescChange = ( slidercaption, index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].slidercaption = slidercaption;
            props.setAttributes( { slidercontents } );
        };

        const handleSliderImageChange = ( sliderimage, index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].sliderimage = sliderimage.sizes;
            props.setAttributes( { slidercontents } );
        };

        const handleRemoveSliderImage = ( index ) => {

            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].sliderimage = '';
            props.setAttributes( { slidercontents } );
        };

        const handleSliderButtonTextChange = ( sliderbuttontext, index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].sliderbuttontext = sliderbuttontext;
            props.setAttributes( { slidercontents } );
        };

        const handleSliderButtonLinkChange = ( sliderbuttonlink, index ) => {
            const slidercontents = [ ...props.attributes.slidercontents ];
            slidercontents[ index ].sliderbuttonlink = sliderbuttonlink;
            props.setAttributes( { slidercontents } );
        };

        let slidercontentFields,slidercontentDisplay;

        if ( props.attributes.slidercontents.length ) {

            var fieldcount = props.attributes.slidercontents.length;
            var active = false;

            console.log( props.attributes.slidercontents );
            slidercontentFields = props.attributes.slidercontents.map( ( slidercontent, index ) => {

            if( typeof( props.attributes.slidercontents[ index ].sliderimage.medium ) === 'undefined' ){
                var imgthumbsrc = '';
            }else{
                var imgthumbsrc = <div class="image-thumb"><img src={props.attributes.slidercontents[ index ].sliderimage.medium.url} /></div>;
            }

                var count = index;
                count++;
                if( count == fieldcount ){ active = true; }

                return <div class="custom-slider-option-field"><PanelBody title={'Slider '+count} initialOpen={ active }>
                    <Fragment key={ index }>

                        <div class="outside-event-slider-colorols">

                            <TextControl
                                placeholder="Slider Title"
                                value={ props.attributes.slidercontents[ index ].slidertitle }
                                onChange={ ( slidertitle ) => handleSliderTitleChange( slidertitle, index ) }
                            />

                            <TextareaControl
                                placeholder="Slider Caption"
                                value={ props.attributes.slidercontents[ index ].slidercaption }
                                onChange={ ( slidercaption ) => handleSliderDescChange( slidercaption, index ) }
                            />

                            <div class="media-uploader">

                                <MediaUpload
                                    onSelect={ ( sliderimage ) => handleSliderImageChange( sliderimage, index ) }
                                    render={ ({open}) => {
                                        return (
                                            <div class="outside-event-image-uploader">

                                                {imgthumbsrc}

                                            <button onClick={open} type="button" class="outside-event-img-upload-button">
                                                <span class="dashicons dashicons-upload"></span>
                                            </button>
                                            </div>
                                        );
                                    }}
                                />

                                <IconButton
                                    className="grf__remove-sliderimage"
                                    icon="no-alt"
                                    label="Remoce Image"
                                    onClick={ () => handleRemoveSliderImage( index ) }
                                />

                            </div>

                            <TextControl
                                placeholder="Button Label"
                                value={ props.attributes.slidercontents[ index ].sliderbuttontext }
                                onChange={ ( sliderbuttontext ) => handleSliderButtonTextChange( sliderbuttontext, index ) }
                            />

                            <TextControl
                                placeholder="Button Link"
                                value={ props.attributes.slidercontents[ index ].sliderbuttonlink }
                                onChange={ ( sliderbuttonlink ) => handleSliderButtonLinkChange( sliderbuttonlink, index ) }
                            />

                        </div>

                        <IconButton
                            className="grf__remove-slidercontent"
                            icon="no-alt"
                            label="Delete Slider"
                            onClick={ () => handleRemoveSliderContent( index ) }
                        />

                    </Fragment>
                </PanelBody></div>;

            } );

            slidercontentDisplay = props.attributes.slidercontents.map( ( slidercontent, index ) => {

                if( typeof( slidercontent.sliderimage.full ) === 'undefined' ){
                    var imagesrc = '';
                }else{
                    var imagesrc = <div class="slider-image"><img src={slidercontent.sliderimage.full.url} /></div>;
                }

                var slidertitle = <h2>{ slidercontent.slidertitle }</h2>
                var sliderdesc = <p>{ slidercontent.slidercaption }</p>
                var sliderbutton = <a target="_blank" href={slidercontent.sliderbuttonlink}>{ slidercontent.sliderbuttontext }</a>



                return (
                    <div class="outside-event-slider-content" key={ index }>

                        {imagesrc}
                        {slidertitle}
                        {sliderdesc}
                        {sliderbutton}
                    </div>
                );
            } );
        }

        function SliderOptions(){
            return(

                <div class="outside-event-slider-add">
                    <Button
                        isDefault
                        onClick={ handleAddSliderContent.bind( this ) }
                    >
                        { __( 'Add Slider' ) }
                    </Button>
                </div>

            );

        }

        return [

            <div class="outside-event-slider">

                <Slider {...settings}>
                {slidercontentDisplay}
                </Slider>

            </div>,
            <InspectorControls>

                <PanelBody title="General Settings" initialOpen={ true }>

                    <div class="custom-slider-options">
                        <div class="custom-slider-option-fields">
                            { slidercontentFields }
                        </div>
                        <SliderOptions />
                    </div>

                </PanelBody>

            </InspectorControls>
        ];

    },

    save: ( { attributes } ) => {


        let slidercontentDisplay;

        slidercontentDisplay = attributes.slidercontents.map( ( slidercontent, index ) => {

            if( typeof( slidercontent.sliderimage.full ) === 'undefined' ){
                var imagesrc = '';
            }else{
                var imagesrc = <div class="slider-image"><img src={slidercontent.sliderimage.full.url} /></div>;
            }

            var slidertitle = <h2>{ slidercontent.slidertitle }</h2>
            var sliderdesc = <p>{ slidercontent.slidercaption }</p>
            var sliderbutton = <a target="_blank" href={slidercontent.sliderbuttonlink}>{ slidercontent.sliderbuttontext }</a>



            return (
                <div class="outside-event-slider-content" key={ index }>

                    {imagesrc}
                    {slidertitle}
                    {sliderdesc}
                    {sliderbutton}
                </div>
            );

        } );

        return(
            <>
                <div class="outside-event-slider">

                    {slidercontentDisplay}

                </div>
            </>
        )
    }
} );
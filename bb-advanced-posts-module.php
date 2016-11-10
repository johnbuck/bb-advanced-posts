<?php
/**
 * @class FLAdvancedPostsModule
 */
class FLAdvancedPostsModule extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct()
    {
        parent::__construct(array(
            'name'          	=> __('Advanced Posts', 'fl-builder'),
            'description'   	=> __('Display a grid of your WordPress posts.', 'fl-builder'),
            'category'      	=> __('Advanced Modules', 'fl-builder'),
            'dir'             => BBAP_MODULES_DIR,
            'url'             => BBAP_MODULES_URL,
            'editor_export' 	=> false,
            'partial_refresh'	=> true
        ));
    }

    /**
     * @method enqueue_scripts
     */
    public function enqueue_scripts()
    {
        if(FLBuilderModel::is_builder_active() || $this->settings->layout == 'grid') {
            $this->add_js('jquery-masonry');
        }
        if(FLBuilderModel::is_builder_active() || $this->settings->layout == 'gallery') {
            $this->add_js('fl-gallery-grid');
        }
        if(FLBuilderModel::is_builder_active() || $this->settings->pagination == 'scroll') {
            $this->add_js('jquery-infinitescroll');
        }
    }

    /**
     * @method get_classname
     */
    public function get_classname()
    {
        $classname = 'fl-button-wrap';

        if(!empty($this->settings->width)) {
            $classname .= ' fl-button-width-' . $this->settings->width;
        }
        if(!empty($this->settings->align)) {
            $classname .= ' fl-button-' . $this->settings->align;
        }
        if(!empty($this->settings->icon)) {
            $classname .= ' fl-button-has-icon';
        }

        return $classname;
    }
}

function bbap_get_acf_fields() {
    $groups = $fields = array();
    $groups = apply_filters('acf/get_field_groups', $groups);

    if (!empty($groups)) {
        foreach( $groups as $group ) {
            $group_fields = apply_filters( 'acf/field_group/get_fields', array(), $group['id'] );
            if ( !empty($group_fields) ) {
                foreach( $group_fields as $group_field ) {
                    $fields[ $group_field['name'] ] = $group_field['label'] . ' [ ACF ]';
                }
            }
        }
    }

	global $wpdb;

	$custom_keys = $wpdb->get_results("SELECT DISTINCT meta_key FROM {$wpdb->postmeta} ORDER BY meta_key", ARRAY_A);

	if ( !empty($custom_keys) ) {
		foreach( $custom_keys as $key ) {
			$key = $key['meta_key'];
			if ($key[0] == '_') continue;
			$fields[ $key ] = ucwords( str_replace('_', ' ', $key) );
		}
	}

    return $fields;
}



/**
 * Register the module and its form settings.
 */

FLBuilder::register_module('FLAdvancedPostsModule', array(
    'layout' => array(
        'title' => __('Layout', 'fl-builder'),
        'sections' => array(
            'general' => array(
                'title' => '',
                'fields' => array(
                    'layout' => array(
                        'type' => 'select',
                        'label' => __('Layout Style', 'fl-builder'),
                        'default' => 'grid',
                        'options' => array(
                            'grid' => __('Grid', 'fl-builder'),
                            'gallery' => __('Gallery', 'fl-builder'),
                            'feed' => __('Feed', 'fl-builder'),
                        ),
                        'toggle' => array(
                            'grid' => array(
                                'sections' => array('grid', 'image', 'content'),
                                'fields' => array('show_author', 'match_height')
                            ),
                            'feed' => array(
                                'sections' => array('image', 'content'),
                                'fields' => array('image_position', 'show_author', 'show_comments', 'content_type')
                            ),
                            'gallery' => array(
                                'tabs' => array('style')
                            )
                        )
                    ),
                    'match_height' => array(
                        'type' => 'select',
                        'label' => __('Equal Heights', 'fl-builder'),
                        'default' => '0',
                        'options' => array(
                            '1' => __('Yes', 'fl-builder'),
                            '0' => __('No', 'fl-builder')
                        )
                    ),
                    'pagination' => array(
                        'type' => 'select',
                        'label' => __('Pagination Style', 'fl-builder'),
                        'default' => 'numbers',
                        'options' => array(
                            'numbers' => __('Numbers', 'fl-builder'),
                            'scroll' => __('Scroll', 'fl-builder'),
                            'none' => _x('None', 'Pagination style.', 'fl-builder'),
                        )
                    ),
                    'posts_per_page' => array(
                        'type' => 'text',
                        'label' => __('Posts Per Page', 'fl-builder'),
                        'default' => '10',
                        'size' => '4'
                    ),
                )
            ),
            'grid' => array(
                'title' => __('Grid', 'fl-builder'),
                'fields' => array(
                    'post_width' => array(
                        'type' => 'text',
                        'label' => __('Post Width', 'fl-builder'),
                        'default' => '300',
                        'maxlength' => '3',
                        'size' => '4',
                        'description' => 'px'
                    ),
                    'post_spacing' => array(
                        'type' => 'text',
                        'label' => __('Post Spacing', 'fl-builder'),
                        'default' => '60',
                        'maxlength' => '3',
                        'size' => '4',
                        'description' => 'px'
                    ),
                )
            ),
            'image' => array(
                'title' => __('Featured Image', 'fl-builder'),
                'fields' => array(
                    'show_image' => array(
                        'type' => 'select',
                        'label' => __('Image', 'fl-builder'),
                        'default' => '1',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        ),
                        'toggle' => array(
                            '1' => array(
                                'fields' => array('image_size')
                            )
                        )
                    ),
                    'image_position' => array(
                        'type' => 'select',
                        'label' => __('Position', 'fl-builder'),
                        'default' => 'above',
                        'options' => array(
                            'above' => __('Above Text', 'fl-builder'),
                            'beside' => __('Beside Text', 'fl-builder')
                        )
                    ),
                    'image_size' => array(
                        'type' => 'photo-sizes',
                        'label' => __('Size', 'fl-builder'),
                        'default' => 'medium'
                    ),
                )
            ),
            'info' => array(
                'title' => __('Post Info', 'fl-builder'),
                'fields' => array(
                    'show_author' => array(
                        'type' => 'select',
                        'label' => __('Author', 'fl-builder'),
                        'default' => '1',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        )
                    ),
                    'show_date' => array(
                        'type' => 'select',
                        'label' => __('Date', 'fl-builder'),
                        'default' => '1',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        ),
                        'toggle' => array(
                            '1' => array(
                                'fields' => array('date_format')
                            )
                        )
                    ),
                    'date_format' => array(
                        'type' => 'select',
                        'label' => __('Date Format', 'fl-builder'),
                        'default' => 'default',
                        'options' => array(
                            'default' => __('Default', 'fl-builder'),
                            'Y' => date('Y'),
                            'M j, Y' => date('M j, Y'),
                            'F j, Y' => date('F j, Y'),
                            'm/d/Y' => date('m/d/Y'),
                            'm-d-Y' => date('m-d-Y'),
                            'd M Y' => date('d M Y'),
                            'd F Y' => date('d F Y'),
                            'Y-m-d' => date('Y-m-d'),
                            'Y/m/d' => date('Y/m/d'),
                        )
                    ),
                    'show_comments' => array(
                        'type' => 'select',
                        'label' => __('Comments', 'fl-builder'),
                        'default' => '1',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        )
                    ),
                    'meta_fields_position' => array(
                        'type' => 'select',
                        'label' => __('Meta Fields Position', 'fl-builder'),
                        'default' => 'before',
                        'options' => array(
                            'before' => __('Before Content', 'fl-builder'),
                            'after' => __('After Content', 'fl-builder'),
                        )
                    )
                )
            ),
            'content' => array(
                'title' => __('Content', 'fl-builder'),
                'fields' => array(
                    'show_content' => array(
                        'type' => 'select',
                        'label' => __('Content', 'fl-builder'),
                        'default' => '1',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        )
                    ),
                    'content_type' => array(
                        'type' => 'select',
                        'label' => __('Content Type', 'fl-builder'),
                        'default' => 'excerpt',
                        'options' => array(
                            'excerpt' => __('Excerpt', 'fl-builder'),
                            'full' => __('Full Text', 'fl-builder')
                        )
                    ),
                    'show_more_link' => array(
                        'type' => 'select',
                        'label' => __('More Link', 'fl-builder'),
                        'default' => '0',
                        'options' => array(
                            '1' => __('Show', 'fl-builder'),
                            '0' => __('Hide', 'fl-builder')
                        )
                    ),
                    'more_link_text' => array(
                        'type' => 'text',
                        'label' => __('More Link Text', 'fl-builder'),
                        'default' => __('Read More', 'fl-builder'),
                    ),
                    'more_link_url' => array(
                        'type' => 'text',
                        'label' => __('More Link URL', 'fl-builder'),
                        'default' => __('', 'fl-builder'),
                    )
                )
            )
        )
    ),
    'cta' => array( // Tab
        'title' => __('CTA', 'fl-builder'), // Tab title,
        'sections' => array(
            'sections_general' => array(
                'title' => '',
                'fields' => array(
                    'cta_show' => array(
                        'type' => 'select',
                        'label' => __( 'Button', 'fl-builder' ),
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __( 'Hide', 'fl-builder' ),
                            'show' => __( 'Show', 'fl-builder' ),
                        )
                    ),
                    'cta_caption' => array(
                        'type' => 'text',
                        'label' => __( 'Button Caption', 'fl-builder' ),
                        'default' => __( 'Button', 'fl-builder' )
                    ),
                    'cta_type' => array(
                        'type' => 'select',
                        'default' => 'url',
                        'label' => __( 'Target', 'fl-builder' ),
                        'options' => array(
                            'url' => __( 'URL', 'fl-builder' ),
                            'custom' => __( 'Custom Field', 'fl-builder' ),
                        ),
                        'toggle' => array(
                            'url' => array(
                                'fields' => array('cta_url')
                            ),
                            'custom' => array(
                                'fields' => array('cta_custom_field')
                            )
                        )
                    ),
                    'cta_custom_field' => array(
                        'type' => 'select',
                        'label' => __( 'CTA Custom Field', 'fl-builder' ),
                        'default' => '',
                        'options' => bbap_get_acf_fields()
                    ),
                    'cta_url' => array(
                        'type' => 'text',
                        'label' => __( 'CTA url', 'fl-builder' ),
                        'default' => '',
                    )
                )
            )
        )
    ),
    'cta_style'         => array(
        'title'         => __('CTA Button Style', 'fl-builder'),
        'sections'      => array(
            'colors'        => array(
                'title'         => __('Colors', 'fl-builder'),
                'fields'        => array(
                    'cta_bg_color'      => array(
                        'type'          => 'color',
                        'label'         => __('Background Color', 'fl-builder'),
                        'default'       => '',
                        'show_reset'    => true
                    ),
                    'cta_bg_hover_color' => array(
                        'type'          => 'color',
                        'label'         => __('Background Hover Color', 'fl-builder'),
                        'default'       => '',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'none'
                        )
                    ),
                    'cta_text_color'    => array(
                        'type'          => 'color',
                        'label'         => __('Text Color', 'fl-builder'),
                        'default'       => '',
                        'show_reset'    => true
                    ),
                    'cta_text_hover_color' => array(
                        'type'          => 'color',
                        'label'         => __('Text Hover Color', 'fl-builder'),
                        'default'       => '',
                        'show_reset'    => true,
                        'preview'       => array(
                            'type'          => 'none'
                        )
                    )
                )
            ),
            'style'         => array(
                'title'         => __('Style', 'fl-builder'),
                'fields'        => array(
                    'cta_style'         => array(
                        'type'          => 'select',
                        'label'         => __('Style', 'fl-builder'),
                        'default'       => 'flat',
                        'options'       => array(
                            'flat'          => __('Flat', 'fl-builder'),
                            'gradient'      => __('Gradient', 'fl-builder'),
                            'transparent'   => __('Transparent', 'fl-builder')
                        ),
                        'toggle'        => array(
                            'transparent'   => array(
                                'fields'        => array('bg_opacity', 'border_size')
                            )
                        )
                    ),
                    'cta_border_size'   => array(
                        'type'          => 'text',
                        'label'         => __('Border Size', 'fl-builder'),
                        'default'       => '2',
                        'description'   => 'px',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'placeholder'   => '0'
                    ),
                    'cta_bg_opacity'    => array(
                        'type'          => 'text',
                        'label'         => __('Background Opacity', 'fl-builder'),
                        'default'       => '0',
                        'description'   => '%',
                        'maxlength'     => '3',
                        'size'          => '5',
                        'placeholder'   => '0'
                    )
                )
            ),
            'formatting'    => array(
                'title'         => __('Structure', 'fl-builder'),
                'fields'        => array(
                    'cta_width'         => array(
                        'type'          => 'select',
                        'label'         => __('Width', 'fl-builder'),
                        'default'       => 'auto',
                        'options'       => array(
                            'auto'          => _x( 'Auto', 'Width.', 'fl-builder' ),
                            'full'          => __('Full Width', 'fl-builder'),
                            'custom'        => __('Custom', 'fl-builder')
                        ),
                        'toggle'        => array(
                            'auto'          => array(
                                'fields'        => array('align')
                            ),
                            'full'          => array(),
                            'custom'        => array(
                                'fields'        => array('align', 'custom_width')
                            )
                        )
                    ),
                    'cta_custom_width'  => array(
                        'type'          => 'text',
                        'label'         => __('Custom Width', 'fl-builder'),
                        'default'       => '200',
                        'maxlength'     => '3',
                        'size'          => '4',
                        'description'   => 'px'
                    ),
                    'cta_align'         => array(
                        'type'          => 'select',
                        'label'         => __('Alignment', 'fl-builder'),
                        'default'       => 'left',
                        'options'       => array(
                            'center'        => __('Center', 'fl-builder'),
                            'left'          => __('Left', 'fl-builder'),
                            'right'         => __('Right', 'fl-builder')
                        )
                    ),
                    'cta_font_size'     => array(
                        'type'          => 'text',
                        'label'         => __('Font Size', 'fl-builder'),
                        'default'       => '16',
                        'maxlength'     => '3',
                        'size'          => '4',
                        'description'   => 'px'
                    ),
                    'cta_padding'       => array(
                        'type'          => 'text',
                        'label'         => __('Padding', 'fl-builder'),
                        'default'       => '12',
                        'maxlength'     => '3',
                        'size'          => '4',
                        'description'   => 'px'
                    ),
                    'cta_border_radius' => array(
                        'type'          => 'text',
                        'label'         => __('Round Corners', 'fl-builder'),
                        'default'       => '4',
                        'maxlength'     => '3',
                        'size'          => '4',
                        'description'   => 'px'
                    )
                )
            )
        )
    ),
    'style' => array( // Tab
        'title' => __('Style', 'fl-builder'), // Tab title
        'sections' => array( // Tab Sections
            'gallery_general' => array(
                'title' => '',
                'fields' => array(
                    'hover_transition' => array(
                        'type' => 'select',
                        'label' => __('Hover Transition', 'fl-builder'),
                        'default' => 'fade',
                        'options' => array(
                            'fade' => __('Fade', 'fl-builder'),
                            'slide-up' => __('Slide Up', 'fl-builder'),
                            'slide-down' => __('Slide Down', 'fl-builder'),
                            'scale-up' => __('Scale Up', 'fl-builder'),
                            'scale-down' => __('Scale Down', 'fl-builder'),
                        )
                    ),
                )
            ),
            'icons' => array(
                'title' => __('Icons', 'fl-builder'),
                'fields' => array(
                    'has_icon' => array(
                        'type' => 'select',
                        'label' => __('Use Icon for Posts', 'fl-builder'),
                        'default' => 'no',
                        'options' => array(
                            'yes' => __('Yes', 'fl-builder'),
                            'no' => __('No', 'fl-builder'),
                        ),
                        'toggle' => array(
                            'yes' => array(
                                'fields' => array('icon', 'icon_position', 'icon_color', 'icon_size')
                            )
                        ),
                    ),
                    'icon' => array(
                        'type' => 'icon',
                        'label' => __('Post Icon', 'fl-builder'),
                    ),
                    'icon_position' => array(
                        'type' => 'select',
                        'label' => __('Post Icon Position', 'fl-builder'),
                        'default' => 'above',
                        'options' => array(
                            'above' => __('Above Text', 'fl-builder'),
                            'below' => __('Below Text', 'fl-builder'),
                        )
                    ),
                    'icon_size' => array(
                        'type' => 'text',
                        'label' => __('Post Icon Size', 'fl-builder'),
                        'default' => '24',
                        'maxlength' => '3',
                        'size' => '4',
                        'description' => 'px'
                    ),
                )
            ),
            'text_style' => array(
                'title' => __('Colors', 'fl-builder'),
                'fields' => array(
                    'text_color' => array(
                        'type' => 'color',
                        'label' => __('Text Color', 'fl-builder'),
                        'default' => 'ffffff',
                        'show_reset' => true
                    ),
                    'icon_color' => array(
                        'type' => 'color',
                        'label' => __('Post Icon Color', 'fl-builder'),
                        'show_reset' => true
                    ),
                    'text_bg_color' => array(
                        'type' => 'color',
                        'label' => __('Text Background Color', 'fl-builder'),
                        'default' => '333333',
                        'help' => __('The color applies to the overlay behind text over the background selections.', 'fl-builder'),
                        'show_reset' => true
                    ),
                    'text_bg_opacity' => array(
                        'type' => 'text',
                        'label' => __('Text Background Opacity', 'fl-builder'),
                        'default' => '50',
                        'maxlength' => '3',
                        'size' => '4',
                        'description' => '%'
                    ),
                )
            ),
        )
    ),
    'content' => array(
        'title' => __('Content', 'fl-builder'),
        'file' => FL_BUILDER_DIR . 'includes/loop-settings.php',
    )
));
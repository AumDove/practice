<?php
/**
 * megcrushcrush Theme Customizer.
 *
 * @package megcrush
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function megcrush_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        /**
	 * Custom Customizer Customizations
	 */
	
	// Create header background color setting
	$wp_customize->add_setting( 'header_color', array(
		'default' => '#000000',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));
	
	// Add header background color control
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_color', array(
				'label' => __( 'Header Background Color', 'megcrush' ),
				'section' => 'colors',
			)
		)
	);
        // Create header box / menu background color setting
	$wp_customize->add_setting( 'header_box_color', array(
		'default' => '#424242',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));
        // Add header box / menu background color control
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_box_color', array(
				'label' => __( 'Header Box and Menu Color', 'megcrush' ),
				'section' => 'colors',
			)
		)
	);
       
	// Add section to the Customizer
	$wp_customize->add_section( 'megcrush-options', array(
		'title' => __( 'Theme Options', 'megcrush' ),
		'capability' => 'edit_theme_options',
		'description' => __( 'Change the default display options for the theme.', 'megcrush' ),
	));
	
	// Create sidebar layout setting
	$wp_customize->add_setting( 'layout_setting',
		array(
			'default' => 'no-sidebar',
			'type' => 'theme_mod',
			'sanitize_callback' => 'megcrush_sanitize_layout', 
			'transport' => 'postMessage'
		)
	);

	// Add sidebar layout controls
	$wp_customize->add_control( 'layout_control',
		array(
			'settings' => 'layout_setting',
			'type' => 'radio',
			'label' => __( 'Sidebar position', 'megcrush' ),
			'choices' => array(
				'no-sidebar' => __( 'No sidebar (default)', 'megcrush' ),
				'sidebar-left' => __( 'Left sidebar', 'megcrush' ),
				'sidebar-right' => __( 'Right sidebar', 'megcrush' )
			),
			'section' => 'megcrush-options',
		)
	);
	
    }
        
add_action( 'customize_register', 'megcrush_customize_register' );

        /**
         * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
         */
        function megcrush_customize_preview_js() {
                wp_enqueue_script( 'megcrush_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
        }
add_action( 'customize_preview_init', 'megcrush_customize_preview_js' );
/**
 * Sanitize layout options
 */

function megcrush_sanitize_layout( $value ) {
	if ( !in_array( $value, array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) ) {
		$value = 'no-sidebar';
	}
	return $value;
}

/**
 * Inject Customizer CSS when appropriate
 */

function megcrush_customizer_css() {
	$header_color = get_theme_mod('header_color');
        $header_box_color = get_theme_mod('header_box_color');
        $menu_textcolor = get_theme_mod('header_textcolor');?>
    <style type="text/css">
            .site-header {
                background-color: <?php echo $header_color; ?>
            }
            .main-navigation a, .main-navigation a:hover, .main-navigation a:focus {
                   
                    color: <?php echo $menu_textcolor; ?>
            }
            .site-branding {
                background-color: <?php echo $header_box_color; ?>
            }
            .main-navigation{
                background-color: <?php echo $header_box_color; ?>
            }
    </style>
        

 <?php  

}
    
add_action( 'wp_head', 'megcrush_customizer_css' );




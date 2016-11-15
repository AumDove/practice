<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package megcrush
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses megcrush_header_style()
 */
function megcrush_custom_header_setup() {
    
        add_theme_support( 'custom-logo', array(
	    'width' => 125,
	    'height' => 125,
	    'flex-width' => false,
	    'flex-height' => true,
	) );
        register_default_headers( array( // Adds the default image options for the header section in customozer
                'maui' => array(
                        'url'           => get_template_directory_uri() . '/img/maui-upcountry.jpg',
                        'thumbnail_url' => get_template_directory_uri() . '/img/maui-upcountry.jpg',
                        'description'   => __( 'Maui Upcountry', 'megcrush' )
                ),
                'beach-bird' => array(
                        'url'           => get_template_directory_uri() . '/img/hookipa-bird.jpg',
                        'thumbnail_url' => get_template_directory_uri() . '/img/hookipa-bird.jpg',
                        'description'   => __( 'Beach Bird', 'megcrush' )
                ),
                'vegas' => array(
                        'url'           => get_template_directory_uri() . '/img/vegas.jpg',
                        'thumbnail_url' => get_template_directory_uri() . '/img/vegas.jpg',
                        'description'   => __( 'Blue Man Vegas', 'megcrush' )
                ),
                'grafitti' => array(
                        'url'           => get_template_directory_uri() . '/img/twin-falls-grafitti.jpg',
                        'thumbnail_url' => get_template_directory_uri() . '/img/twin-falls-grafitti.jpg',
                        'description'   => __( 'Blue Man Vegas', 'megcrush' )
                ),
        ) );
	add_theme_support( 'custom-header', apply_filters( 'megcrush_custom_header_args', array(
            'default-image'          => get_template_directory_uri() . '/img/maui-upcountry.jpg', '/img/hookipa-bird.jpg', '/img/vegas.jpg', '/img/twin-falls-grafitti.jpg',// add the default image options from above function separated 
            'default-text-color'     => 'ffffff',
            'width'                  => 1600,
            'height'                 => 500,
            'flex-width'             => true,
            'flex-height'            => true,
            'wp-head-callback'       => 'megcrush_header_style',
            'admin-head-callback'    => 'adminhead_cb_header_style',
            'admin-preview-callback' => 'adminpreview_cb_header_image',
           
	) ) );
        ;
 
    
}

add_action( 'after_setup_theme', 'megcrush_custom_header_setup' );

if ( ! function_exists( 'megcrush_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see megcrush_custom_header_setup().
 */
function megcrush_header_style() {
	$header_text_color = get_header_textcolor();

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
	 */
	if ( HEADER_TEXTCOLOR === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
                
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description,
                .main-navigation a,
                .main-navigation a:hover,
                .main-navigation a:focus{
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;

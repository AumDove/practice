<?php
/**
 * megcrush functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package megcrush
 */

if ( ! function_exists( 'megcrush_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function megcrush_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on megcrush, use a find and replace
	 * to change 'megcrush' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'megcrush', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 828, 360, true);
        add_image_size( 'megcrush-small-thumb', 300, 150, true);
	
        // This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'megcrush' ),
                'social' => esc_html__( 'Social', 'megcrush' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
        /*
         * Enable support for Post Formats.
         * see https://developer.wordpress.org/themes/functionality/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
        ) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'megcrush_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        /**
         * Add editor styles
         */
        add_editor_style( array ( 'inc/editor-style.css', 'fonts/custom-fonts.css', 'fonts/font-awesome/fonts') );
        
        
}
endif;
add_action( 'after_setup_theme', 'megcrush_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function megcrush_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'megcrush_content_width', 1640 );
}
add_action( 'after_setup_theme', 'megcrush_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function megcrush_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'megcrush' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'megcrush' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'megcrush_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function megcrush_scripts() {
	wp_enqueue_style( 'megcrush-style', get_stylesheet_uri() );

        // Add Google Fonts: Fira Sans and Merriweather

        wp_enqueue_style( 'megcrush-local-fonts', get_stylesheet_directory_uri() . '/fonts/custom-fonts.css');
        
        // Add Font Awesome icons (http://fontawesome.io) 

        wp_enqueue_style( 'megcrush-fontawesome-fonts', get_stylesheet_directory_uri() . '/fonts/font-awesome/fonts/');
        wp_enqueue_style( 'megcrush-fontawesome-style', get_stylesheet_directory_uri() . '/fonts/font-awesome/css/font-awesome.css');
       
	wp_enqueue_script( 'megcrush-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery'), '20151215', true );
        wp_localize_script( 'megcrush-navigation', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'megcrush' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'megcrush' ) . '</span>',
	) );
	wp_enqueue_script( 'megcrush-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
        
}
add_action( 'wp_enqueue_scripts', 'megcrush_scripts' );


//* Add custom background callback for background color
function custom_background_callback() {

	if ( ! get_background_color() )
		return;

	printf( '<style>body { background-color: #%s; }</style>' . "\n", get_background_color() );

}

//* Add support for custom background
add_theme_support( 'custom-background', array( 'wp-head-callback' => 'custom_background_callback' ) );
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

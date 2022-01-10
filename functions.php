<?php
	$theme = wp_get_theme();
	define('DGIBUILDER_VERSION', $theme->get('Version'));
	define('DGIBUILDER_LIB', get_template_directory() . '/inc');
	define('DGIBUILDER_PLUGINS', DGIBUILDER_LIB . '/plugins');
	define('DGIBUILDER_ADMIN', DGIBUILDER_LIB . '/admin');
	define('DGIBUILDER_FUNCTIONS', DGIBUILDER_LIB . '/functions');
	define('DGIBUILDER_CSS', get_template_directory_uri() . '/css');
	define('DGIBUILDER_JS', get_template_directory_uri() . '/js');
	
	require_once(DGIBUILDER_FUNCTIONS . '/functions.php');
	require_once(DGIBUILDER_PLUGINS . '/functions.php');
	require_once(DGIBUILDER_ADMIN . '/functions.php');

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if (!isset($content_width)) {
    $content_width = 1140;
}

remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);

if ( ! function_exists( 'dgibuilder_setup' ) ) :
	function dgibuilder_setup() {
		load_theme_textdomain( 'dgibuilder' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );	
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo', array(
			'height'      => 240,
			'width'       => 240,
			'flex-height' => true,
		) );

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'dgibuilder' ),
				'footer' => __( 'Footer Menu', 'dgibuilder' ),
				'social'  => __( 'Social Links Menu', 'dgibuilder' ),
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'css/editor-style.css', dgibuilder_fonts_url() ) );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom color scheme.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Dark Gray', 'dgibuilder' ),
					'slug'  => 'dark-gray',
					'color' => '#1a1a1a',
				),
				array(
					'name'  => __( 'Medium Gray', 'dgibuilder' ),
					'slug'  => 'medium-gray',
					'color' => '#686868',
				),
				array(
					'name'  => __( 'Light Gray', 'dgibuilder' ),
					'slug'  => 'light-gray',
					'color' => '#e5e5e5',
				),
				array(
					'name'  => __( 'White', 'dgibuilder' ),
					'slug'  => 'white',
					'color' => '#fff',
				),
				array(
					'name'  => __( 'Blue Gray', 'dgibuilder' ),
					'slug'  => 'blue-gray',
					'color' => '#4d545c',
				),
				array(
					'name'  => __( 'Bright Blue', 'dgibuilder' ),
					'slug'  => 'bright-blue',
					'color' => '#007acc',
				),
				array(
					'name'  => __( 'Light Blue', 'dgibuilder' ),
					'slug'  => 'light-blue',
					'color' => '#9adffd',
				),
				array(
					'name'  => __( 'Dark Brown', 'dgibuilder' ),
					'slug'  => 'dark-brown',
					'color' => '#402b30',
				),
				array(
					'name'  => __( 'Medium Brown', 'dgibuilder' ),
					'slug'  => 'medium-brown',
					'color' => '#774e24',
				),
				array(
					'name'  => __( 'Dark Red', 'dgibuilder' ),
					'slug'  => 'dark-red',
					'color' => '#640c1f',
				),
				array(
					'name'  => __( 'Bright Red', 'dgibuilder' ),
					'slug'  => 'bright-red',
					'color' => '#ff675f',
				),
				array(
					'name'  => __( 'Yellow', 'dgibuilder' ),
					'slug'  => 'yellow',
					'color' => '#ffef8e',
				),
			)
		);

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif; // dgibuilder_setup
add_action( 'after_setup_theme', 'dgibuilder_setup' );


add_action('admin_enqueue_scripts', 'dgibuilder_admin_scripts_css');
function dgibuilder_admin_scripts_css() {
	
	wp_enqueue_style('dgibuilder_admin_css', get_template_directory_uri() . '/inc/admin/css/admin.css', false);
	
    wp_enqueue_style('dgibuilder_select_css', get_template_directory_uri() . '/inc/admin/css/select2.min.css', false);
	
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css?ver=' . DGIBUILDER_VERSION);	
	
	wp_enqueue_script('select-js', get_template_directory_uri() . '/inc/admin/js/select2.min.js', array('jquery'), DGIBUILDER_VERSION, true);
	
	wp_enqueue_script('customizer-js', get_template_directory_uri() . '/inc/admin/js/customizer.js', array('jquery'), DGIBUILDER_VERSION, true);
}

function dgibuilder_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'dgibuilder_content_width', 840 );
}
add_action( 'after_setup_theme', 'dgibuilder_content_width', 0 );


function dgibuilder_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'dgibuilder-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'dgibuilder_resource_hints', 10, 2 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Vacation Rental 1.0
 */
function dgibuilder_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'dgibuilder' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'dgibuilder' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'dgibuilder_widgets_init' );

if ( ! function_exists( 'dgibuilder_fonts_url' ) ) :
	function dgibuilder_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'dgibuilder' ) ) {
			// $fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
			$fonts[] = get_theme_mod('google_font_header','Poppins:400,500,600,700');
			$fonts[] = get_theme_mod('google_font_body','Playfair Display:400,700,400i');
			$fonts = array_unique($fonts);
		}

		
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'dgibuilder' ) ) {
			$fonts[] = 'Montserrat:400,700';
		}

		
		if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'dgibuilder' ) ) {
			$fonts[] = 'Inconsolata:400';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				),
				'https://fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Vacation Rental 1.0
 */
function dgibuilder_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'dgibuilder_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Vacation Rental 1.0
 */
function dgibuilder_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'dgibuilder-fonts', dgibuilder_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/asset/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	// Theme block stylesheet.	
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/asset/css/bootstrap.min.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'fonts', get_template_directory_uri() . '/asset/css/font.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/asset/css/font-awesome.min.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/asset/css/slick.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'animation', get_template_directory_uri() . '/asset/css/animate.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/asset/css/font-awesome.min.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/asset/css/theme_main.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/asset/css/jquery.fancybox.css', array( 'style' ), DGIBUILDER_VERSION );
	
	wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/asset/css/theme-style.css', array( 'style' ), DGIBUILDER_VERSION );
		

	wp_enqueue_script( 'jquery-js', get_template_directory_uri() . '/asset/js/jquery.js', array( 'jquery' ), DGIBUILDER_VERSION, true );
	
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/asset/js/slick.min.js', array( 'jquery' ), DGIBUILDER_VERSION, true );
	
	wp_enqueue_script( 'fancybox-js', get_template_directory_uri() . '/asset/js/jquery.fancybox.js', array( 'jquery' ), DGIBUILDER_VERSION, true );
	
	wp_enqueue_script( 'lodash', get_template_directory_uri() . '/asset/js/lodash.min.js', array( 'jquery' ), DGIBUILDER_VERSION, true );
	
	wp_enqueue_script( 'script', get_template_directory_uri() . '/asset/js/main.js', array( 'jquery' ), DGIBUILDER_VERSION, true );	
	
	wp_enqueue_script( 'fontawesome', get_template_directory_uri() . '/asset/js/fontawesome.js', array( 'jquery' ), DGIBUILDER_VERSION, true );	
	
	//wp_enqueue_script( 'smooth-scrolling-js', get_template_directory_uri() . '/asset/js/smooth-scrolling.js', array( 'jquery' ), DGIBUILDER_VERSION, true );
	
	wp_localize_script(
		'dgibuilder-script',
		'screenReaderText',
		array(
			'expand'   => __( 'expand child menu', 'dgibuilder' ),
			'collapse' => __( 'collapse child menu', 'dgibuilder' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'dgibuilder_scripts' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Vacation Rental 1.6
 */
function dgibuilder_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'dgibuilder-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20181230' );
	// Add custom fonts.
	wp_enqueue_style( 'dgibuilder-fonts', dgibuilder_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'dgibuilder_block_editor_styles' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Vacation Rental 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function dgibuilder_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'dgibuilder_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Vacation Rental 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function dgibuilder_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Vacation Rental 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function dgibuilder_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 840 <= $width ) {
		$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	}

	if ( 'page' === get_post_type() ) {
		if ( 840 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	} else {
		if ( 840 > $width && 600 <= $width ) {
			$sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		} elseif ( 600 > $width ) {
			$sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'dgibuilder_content_image_sizes_attr', 10, 2 );


function dgibuilder_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'dgibuilder_post_thumbnail_sizes_attr', 10, 3 );

function dgibuilder_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'dgibuilder_widget_tag_cloud_args' );


function create_my_custom_posts() {
    register_post_type( 'services', array(
        'labels' => array(
            'name' => __( 'Services' ),
            'singular_name' => __( 'Services' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Services' ),
            'new_item' => __( 'New Services' ),
            'view_item' => __( 'View Services' ),
            'search_items' => __( 'Search Services' ),
            'all_items' => __( 'All Services' ),
            'add_new_item' => __( 'Add New Services' ),
            'not_found' => __( 'No Openings Yet' )
        ),
		'supports' => array(
            'title',
            'editor',
            'thumbnail',            
        ), 
        'description' => 'job openings in uvionics tech',
        'public' => true,
        'has_archive' => true,       
        'menu_position' => 5
    ) );
    register_post_type( 'testimonials', array(
        'labels' => array(
            'name' => __( 'Testimonial' ),
            'singular_name' => __( 'Testimonial' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Testimonial' ),
            'new_item' => __( 'New Testimonial' ),
            'view_item' => __( 'View Testimonial' ),
            'search_items' => __( 'Search Testimonial' ),
            'all_items' => __( 'All Testimonial' ),
            'add_new_item' => __( 'Add New Testimonial' ),
            'not_found' => __( 'No Testimonial Yet' )
        ),
		'supports' => array(
            'title',
            'editor',
           
            'thumbnail',            
        ), 
        'description' => 'Employees comments about life in company',
        'public' => true,
        'has_archive' => true,
        'menu_position' => 6
    ) );
	
	register_post_type( 'ourteams', array(
        'labels' => array(
            'name' => __( 'Our Team' ),
            'singular_name' => __( 'Our Team' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Our Team' ),
            'new_item' => __( 'New Our Team' ),
            'view_item' => __( 'View Our Team' ),
            'search_items' => __( 'Search Our Team' ),
            'all_items' => __( 'All Our Team' ),
            'add_new_item' => __( 'Add New Our Team' ),
            'not_found' => __( 'No Our Team Yet' )
        ),
		'supports' => array(
            'title',
            'editor',
           
            'thumbnail',       
        ),
        'description' => 'Employees comments about life in company',
        'public' => true,
        'has_archive' => true,
        'menu_position' => 7
    ) );
	
	register_post_type( 'portfolios', array(
        'labels' => array(
            'name' => __( 'Portfolios '),
            'singular_name' => __( 'Portfolios' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Portfolio' ),
            'new_item' => __( 'New Portfolio' ),
            'view_item' => __( 'View Portfolios' ),
            'search_items' => __( 'Search Portfolios' ),
            'all_items' => __( 'All Portfolios' ),
            'add_new_item' => __( 'Add New Portfolio' ),
            'not_found' => __( 'No Portfolio Yet' )
        ),
		'supports' => array(
            'title',
            'editor',
            'thumbnail',       
        ),
        'description' => 'Employees comments about life in company',
        'public' => true,
        'has_archive' => true,
        'menu_position' => 8
    ) );
	
	register_post_type( 'profestionals', array(
        'labels' => array(
            'name' => __( 'Profestional Team '),
            'singular_name' => __( 'Profestional Team' ),
            'add_new' => __( 'Add New' ),
            'add_new_item' => __( 'Add New Team' ),
            'new_item' => __( 'New Team' ),
            'view_item' => __( 'View Team' ),
            'search_items' => __( 'Search Team' ),
            'all_items' => __( 'All Profestional Team' ),
            'add_new_item' => __( 'Add New Team' ),
            'not_found' => __( 'No Team Yet' )
        ),
		'supports' => array(
            'title',
            'editor',
            'thumbnail',       
        ),
        'description' => 'Employees comments about life in company',
        'public' => true,
        'has_archive' => true,
        'menu_position' => 9
    ) );		
	
    flush_rewrite_rules( false );
}
add_action( 'init', 'create_my_custom_posts' );



function create_meta_box(){
	add_meta_box( 'id-metabox', 'Address', 'address', 'testimonials' );	
}
add_action( 'add_meta_boxes', 'create_meta_box' );
function address(){
	global $post;
	$address =  get_post_meta( $post->ID, '_address', true );		   
	echo 'Address';
	echo ( '<label for="address">: </label>' );
	echo ('<input type="text" style="width:100%" id="address" name="address" value="'.esc_attr( $address ).'" />');
	echo '<br>';	
}

function save_infor( $post_id ){
		
	$address = sanitize_text_field( $_POST['address'] );
	update_post_meta( $post_id, '_address', $address );
	
}
add_action( 'save_post', 'save_infor' );


function save_nonce( $post_id ){
 
	$infor_nonce = $_POST['infor_nonce'];
	if( !isset( $infor_nonce ) ) {
		return;
	}
	if( !wp_verify_nonce( $infor_nonce, 'save_nonce' ) ) {
		return;
	}
 
	$id = sanitize_text_field( $_POST['id'] );
	update_post_meta( $post_id, '_id', $id );
}
add_action( 'save_post', 'save_nonce' );




function create_employment(){
	add_meta_box( 'employment', 'More Infor', 'employment', 'profestionals' );	
}
add_action( 'add_meta_boxes', 'create_employment' );
function employment(){
	global $post;
	$employment =  get_post_meta( $post->ID, '_employment', true );		   
	echo 'Employment';
	echo ( '<label for="employment">: </label>' );
	echo ('<input type="text" style="width:100%" id="employment" name="employment" value="'.esc_attr( $employment ).'" />');
	echo '<br>';
	
	$facebook =  get_post_meta( $post->ID, '_facebook', true );		   
	echo 'Facebook';
	echo ( '<label for="facebook">: </label>' );
	echo ('<input type="text" style="width:100%" id="facebook" name="facebook" value="'.esc_attr( $facebook ).'" />');
	echo '<br>';

	$twitter =  get_post_meta( $post->ID, '_twitter', true );		   
	echo 'Twitter';
	echo ( '<label for="twitter">: </label>' );
	echo ('<input type="text" style="width:100%" id="twitter" name="twitter" value="'.esc_attr( $twitter ).'" />');
	echo '<br>';

	$linkedin =  get_post_meta( $post->ID, '_linkedin', true );		   
	echo 'Linkedin';
	echo ( '<label for="linkedin">: </label>' );
	echo ('<input type="text" style="width:100%" id="linkedin" name="linkedin" value="'.esc_attr( $linkedin ).'" />');
	echo '<br>';

	$instagram =  get_post_meta( $post->ID, '_instagram', true );		   
	echo 'Instagram';
	echo ( '<label for="instagram">: </label>' );
	echo ('<input type="text" style="width:100%" id="instagram" name="instagram" value="'.esc_attr( $instagram ).'" />');
	echo '<br>';
}

function save_infor_employment( $post_id ){
		
	$employment = sanitize_text_field( $_POST['employment'] );
	update_post_meta( $post_id, '_employment', $employment );
	
	$facebook = sanitize_text_field( $_POST['facebook'] );
	update_post_meta( $post_id, '_facebook', $facebook );
	
	$twitter = sanitize_text_field( $_POST['twitter'] );
	update_post_meta( $post_id, '_twitter', $twitter );
	
	$linkedin = sanitize_text_field( $_POST['linkedin'] );
	update_post_meta( $post_id, '_linkedin', $linkedin );
	
	$instagram = sanitize_text_field( $_POST['instagram'] );
	update_post_meta( $post_id, '_instagram', $instagram );
	
}
add_action( 'save_post', 'save_infor_employment' );


function save_nonce_employment( $post_id ){
 
	$infor_nonce = $_POST['save_nonce_employment'];
	if( !isset( $infor_nonce ) ) {
		return;
	}
	if( !wp_verify_nonce( $infor_nonce, 'save_nonce_employment' ) ) {
		return;
	}
 
	$id = sanitize_text_field( $_POST['id'] );
	update_post_meta( $post_id, '_id', $id );
}
add_action( 'save_post', 'save_nonce_employment' );


add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
  if (in_array('current-menu-item', $classes) ){
    $classes[] = 'active ';
  }
  return $classes;
}

function makeupartists_allow_html(){
    return array(
        'form'=>array(
            'role' => array(),
            'method'=> array(),
            'class'=> array(),
            'action'=>array(),
            'id'=>array(),
            ),
        'input' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(), 
            'value'=> array(), 
            'placeholder'=>array(), 
            'autocomplete' => array(),
            'data-number' => array(),
            'data-keypress' => array(),                        
            ),
        'button' => array(
            'type' => array(),
            'name'=> array(),
            'class'=> array(),
            'title'=>array(),
            'id'=>array(),                            
            ),  
        'img'=> array(
            'src' => array(),
            'alt' => array(),
            'class'=> array(),
            ),                      
        'div'=>array(
            'class'=> array(),
            ),
        'h4'=>array(
            'class'=> array(),
            ),
        'a'=>array(
            'class'=> array(),
            'href'=>array(),
            'onclick' => array(),
            'aria-expanded' => array(),
            'aria-haspopup' => array(),
            'data-toggle' => array(),
            ),
        'i' => array(
            'class'=> array(),
        ),
        'p' => array(
            'class'=> array(),
        ), 
        'br' => array(),
        'span' => array(
            'class'=> array(),
            'onclick' => array(),
            'style' => array(),
        ), 
        'strong' => array(
            'class'=> array(),
        ),  
        'ul' => array(
            'class'=> array(),
        ),  
        'li' => array(
            'class'=> array(),
        ), 
        'del' => array(),
        'ins' => array(),
        'select'=> array(
            'class' => array(),
            'name' => array(),
        ),
        'option'=> array(
            'class' => array(),
            'value' => array(),
        ),
    );
}

function makeupartists_pagination_types(){
    return array(
        "pagination" => esc_html__("Pagination", 'makeupartists'),
        "loadmore" => esc_html__("Loadmore", 'makeupartists'),
    );
}

if(!function_exists('barlounge_get_relatedpost')){
    function barlounge_get_relatedpost() {
        if(get_theme_mod('blog_single_related','yes')): ?>
                <?php                    
                    global $post;
                    $orig_post = $post;
                    $categories = wp_get_post_categories($post->ID);
                    if ($categories) :
                        $categories_ids = array();
                        foreach($categories as $individual_categories) {
                            if (isset($individual_categories->term_id)) {
                              $categories_ids[] = $individual_categories->term_id;

                            }
                        }
                        $args=array(
                            'tag__in' => $categories_ids,
                            'post__not_in' => array($post->ID),
                            'posts_per_page'=>3, // Number of related posts to display.
                            'ignore_sticky_posts '=>0,
                        );
                        $my_query = new wp_query( $args );
                        if ($my_query->have_posts()): ?>
                            <div class="related-posts">
                                <h3><span><?php echo esc_html__('Read Related Posts','barlounge')?></span></h3>
                                <div class="wrapp row">
                                    <?php    
                                        while( $my_query->have_posts() ):
                                            $my_query->the_post();
                                    ?>
                                        <?php  if (!is_sticky()):?>  
										<div class="item-post col-xl col-md-4">
											<div class="wrapp">
											<?php if ( has_post_thumbnail() ) : ?>
												<div class="thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('blog'); ?></a></div>
											<?php endif; ?>
												<div class="wrap-content">
													<div class="wrap">
														<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
														<p class="desc"><?php echo wp_trim_words( get_the_excerpt(), $num_words = 12, '' ) ?></p>
														<p class="meta"><?php echo _e('Written By &colon;','barlounge'); ?> <span class="author"><?php the_author_posts_link(); ?></span> &sol; <?php the_time('d M'); ?></p>
													</div>
												</div>
											</div>
										</div>
                            <?php 
                                        endif; 
                                    endwhile;
                                endif;
                                $post = $orig_post;
                                wp_reset_query();
                                ?>
                                </div>
                            </div>
        <?php       
                        endif;
       endif;
    }
}
if(!function_exists('barbershop_social_share')){
    function barbershop_social_share(){ ?>   
	   <ul class="social-share">
			<?php if(get_theme_mod('share_facebook','yes') == 'yes'):?>
				<li><a target="_blank" class="fb" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-facebook-square"></i></a></li>
			<?php endif;?>
			<?php if(get_theme_mod('share_instagram','yes') == 'yes'):?>
				<li><a target="_blank" class="inta" href="https://api.instagram.com/?url=<?php the_permalink(); ?>"  onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-instagram"></i></a></li>
			<?php endif;?>
			<?php if(get_theme_mod('share_twitter','yes') == 'yes'):?>
				<li><a target="_blank" class="tw" href="https://twitter.com/share?url=<?php the_permalink(); ?>&amp;hashtags=seoiz" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-twitter-square"></i></a></li>
			<?php endif;?>
			<?php if(get_theme_mod('share_pinterest','yes') == 'no'):?>
				<li><a target="_blank" class="pin" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"  onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-pinterest"></i></a></li>
			<?php endif;?>
			<?php if(get_theme_mod('share_google','yes') == 'yes'):?>
				<li><a target="_blank" class="gg" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-google-plus"></i></a></li>
			<?php endif;?>
			<?php if(get_theme_mod('share_linkedin','yes') == 'yes'):?>
				<li><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;" ><i class="fab fa-linkedin"></i></a></li>
			<?php endif;?>
		</ul>
	<?php 
    }
}
function makeupartists_pagination($max_num_pages = null) {
    global $wp_query, $wp_rewrite;

    $max_num_pages = ($max_num_pages) ? $max_num_pages : $wp_query->max_num_pages;

    // Don't print empty markup if there's only one page.
    if ($max_num_pages < 2) {
        return;
    }

    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);

    if (isset($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
    }

    $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(array(
        'base' => $pagenum_link,
        'format' => $format,
        'total' => $max_num_pages,
        'current' => $paged,
        'end_size' => 1,
        'mid_size' => 1,
        'prev_next' => true,
        'prev_text' => '<span class="prev-text">Previous Page</span>',
        'next_text' => '<span class="next-text">Next Page</span>',
        'type' => 'list'
            ));

    if ($links) :
        ?>
        <nav class="pagination">
            <?php echo wp_kses($links, makeupartists_allow_html()); ?>
        </nav>
        <?php
    endif;
}
<?php
/**
 * Goedemorgen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Goedemorgen
 */

// Theme Constants.
define( 'GOEDEMORGEN_DIR', get_template_directory() );

if ( ! function_exists( 'goedemorgen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function goedemorgen_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Goedemorgen, use a find and replace
	 * to change 'goedemorgen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'goedemorgen', get_template_directory() . '/languages' );

	/* Add default posts and comments RSS feed links to head. */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/* Set up Custom Menu locations. */
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Header Menu', 'goedemorgen' ),
		'social' => esc_html__( 'Social Menu', 'goedemorgen' ),
	) );

	/**
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

	/* Set up the WordPress core custom background feature. */
	add_theme_support( 'custom-background', apply_filters( 'goedemorgen_custom_background_args', array(
		'default-color' => 'f5f6f7',
		'default-image' => '',
	) ) );

	/* Add support for core custom logo. */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 860,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/* Add theme support for selective refresh for widgets. */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Enable support for Excerpt on Pages and Projects.
	 * See http://codex.wordpress.org/Excerpt
	 */
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * This theme styles the visual editor to resemble the theme style.
	 */
	add_editor_style(
		array(
			'css/editor-style.css',
			goedemorgen_google_fonts(),
			add_query_arg( 'action', 'goedemorgen_editor_dynamic_styles', admin_url( 'admin-ajax.php' ) ),
		)
	);

	/**
	 * Load footer social menu action only if the menu is set.
	 */
	if ( has_nav_menu( 'social' ) ) {
		add_action( 'goedemorgen_footer_middle', 'goedemorgen_add_footer_social_menu' );
	}
}
endif;
add_action( 'after_setup_theme', 'goedemorgen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function goedemorgen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'goedemorgen_content_width', 730 );
}
add_action( 'after_setup_theme', 'goedemorgen_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function goedemorgen_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'goedemorgen' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'goedemorgen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'goedemorgen' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'goedemorgen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'goedemorgen_widgets_init' );

/**
 * Register Google Fonts.
 */
function goedemorgen_google_fonts() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext,cyrillic,cyrillic-ext';

	// Google font for headings.
	$fonts[] = goedemorgen_get_font_family( 'headings' ) . ':300,300i,400,400i,700,700i';
	// Google font for body.
	$fonts[] = goedemorgen_get_font_family( 'body' ) . ':300,300i,400,400i,700,700i';

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function goedemorgen_scripts() {
	wp_enqueue_style( 'goedemorgen-google-fonts', goedemorgen_google_fonts(), array(), null );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( 'goedemorgen-style', get_stylesheet_uri() );

	wp_enqueue_script( 'goedemorgen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'goedemorgen-script', get_template_directory_uri() . '/js/goedemorgen.js', array( 'jquery' ), '1.0.0', true  );
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_scripts' );

if ( ! function_exists( 'goedemorgen_excerpt_more' ) ) :
/**
 *	Customize excerpts More tag.
 */
function goedemorgen_excerpt_more( $more ) {
	if ( ! is_search() ) {
		/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
		return sprintf( '&#x2026; <span class="link-container"><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			sprintf( esc_html__( 'Continue Reading %s', 'goedemorgen' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	}
}
add_filter( 'excerpt_more', 'goedemorgen_excerpt_more' );
endif;

if ( ! function_exists( 'goedemorgen_more_link_container' ) ) :
/**
 * Modify the post's "more" link.
 */
function goedemorgen_modify_more_link( $link ) {
	$link = str_replace( 'more-link', 'more-link button', $link );
	return sprintf( '<span class="link-container">%s</span>', $link );
}
add_filter( 'the_content_more_link', 'goedemorgen_modify_more_link' );
endif;

if ( ! function_exists( 'goedemorgen_filter_archive_title' ) ) :
/**
 * Add a span around the title prefix so that the prefix can be hidden with CSS.
 *
 * @param string $title Archive title.
 * @return string Archive title with inserted span around prefix.
 */
function goedemorgen_filter_archive_title( $title ) {
	// Split the title into parts so we can wrap them with span tag.
	$title_parts = explode( ': ', $title, 2 );

	// Glue title's parts back together.
	if ( ! empty( $title_parts[1] ) ) {
		// Add a span around the title.
		$title = '<span>' . $title_parts[0] . ': </span>' . $title_parts[1];

		// Sanitize our title.
		$title = wp_kses( $title, array( 'span' => array(), ) );
	}

	return $title;

}
add_filter( 'get_the_archive_title', 'goedemorgen_filter_archive_title' );
endif;

if ( ! function_exists( 'goedemorgen_set_tag_cloud_font_size' ) ) :
/**
 * Modify tag cloud widget font size.
 */
function goedemorgen_set_tag_cloud_font_size( $args ) {
    $args['smallest'] = 0.875;
    $args['largest'] = 0.875;
	$args['unit'] = 'rem';
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'goedemorgen_set_tag_cloud_font_size' );
endif;

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function goedemorgen_register_required_plugins() {
	// Array of plugin arrays.
	$plugins = array(
		array(
			'name'      => 'Jetpack',
			'slug'      => 'jetpack',
			'required'  => false,
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),
	);

	// TGMPA array of configuration settings.
	$config = array(
		'id'           => 'goedemorgen',
		'default_path' => '',
		'menu'         => 'goedemorgen-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'goedemorgen_register_required_plugins' );

/**
 * Load theme's settings file.
 */
require GOEDEMORGEN_DIR . '/inc/class-goedemorgen-settings.php';

/**
 * Load Dashboard welcome page.
 */
require GOEDEMORGEN_DIR . '/inc/admin/class-goedemorgen-welcome-screen.php';

/**
 * Custom template tags for this theme.
 */
require GOEDEMORGEN_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require GOEDEMORGEN_DIR . '/inc/extras.php';

/**
 * Customizer additions.
 */
require GOEDEMORGEN_DIR . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require GOEDEMORGEN_DIR . '/inc/jetpack.php';

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once GOEDEMORGEN_DIR . '/inc/class-tgm-plugin-activation.php';

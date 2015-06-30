<?php

/**
 * Functions file
 *
 * For some the main file in a theme. Here we display meta informaion and the
 * header information like menus and logo.
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The reason to use class encapsulation is to skip using function prefix and
 * checking "if function exists" every time.
 *
 * @package WordPress
 */
// The theme domain name
define( "THEME_DOMAIN_NAME", "devrix-v2" );

/**
 * Files including.
 * ----------------------------------------------------------------------------
 */

// Include the devrix-v2 Framework
require_once ( 'inc/diamond_Main.php' );

// Register all the widgets
require_once ( 'inc/widgets/main.php' );


/**
 * The main functions class
 * ----------------------------------------------------------------------------
 */
if( ! class_exists( 'Devrix_Theme' ) ) :
class Devrix_Theme {

	/**
	 * Call all loading functions for the theme. They will be started right after theme setup.
	 *
	 * @since v1.0.0
	 */
	public function __construct() {

		// Run after instalation setup.
		$this->theme_setup();

		// Register actions using add_actions() custom function.
    	$this->add_actions();

	}

	/**
	 * Initial theme setup
	 *
	 * Loading scripts and stylesheets. Register custom elements
	 * and functionality in the theme.
	 *
	 * @uses get_template_directory_uri()
	 * @uses add_theme_support()
	 * @since v1.0.0
	 */
	public function theme_setup() {

		// Add after_setup_theme() for specific functions.
		// The action call is here, because it fits more just for the theme
		// setup, instead for all other actions during using of Subtle.
		add_action( 'after_setup_theme', array( $this, 'theme_setup_core' ) );

    	// Set content width for custom media information
    	if ( ! isset( $content_width ) ) $content_width = 900;

	}

	/**
	 * The core functionality that has to be registred after the theme is setted up
	 *
	 * @since v1.0.1
	 */
	public function theme_setup_core() {

		// Add support for custom header images
		add_theme_support( 'custom-header' ) ;

		// Register the menus.
		register_nav_menus( array( 'primary' 	=> __( 'Main Menu', THEME_DOMAIN_NAME ) ) );
		register_nav_menus( array( 'featured' 	=> __( 'Featured Menu', THEME_DOMAIN_NAME ) ) );

		// One of the required wordpress supports.
		add_theme_support( 'automatic-feed-links' );

		//  Support post-thubnails as well!
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 'large', 730, 300, true ); 	// The slider max (and all other big images.)

		// Theme localization.
		load_theme_textdomain( THEME_DOMAIN_NAME );
		load_theme_textdomain( THEME_DOMAIN_NAME , get_template_directory() . '/languages' );

		// Editor style : Throught this, you should make the
		// wordpress editor look like posts. (in css manner)
		add_editor_style( '/css/editor-style.css');
	}

	/**
	 * Add actions and filters in wordpress theme. All the actions will be here.
	 *
	 * @uses add_action()
	 * @uses add_filter()
	 * @since v1.0.0
	 */
	public function add_actions() {

		// Register all scripts and styles
		add_action( 'wp_enqueue_scripts', array($this, 'load_scripts_and_styles') );

		// Register our Widgets
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );

		// Register custom fonts used in the theme.
		add_action('wp_print_styles', array( $this, 'load_fonts' ));

		// Disable the use of emojis (extra css/js we dont need)
		add_action( 'init', array( $this, 'disable_emojis' ) );

		// Custom styling for the editor.
		add_action( 'admin_init', array( $this, 'editor_style_inc' ) );

		// When logged in
		add_action( 'wp_head', array( $this, 'wpadmin_css' ) );

		// Change excerpt lenght
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 10 );

		// Add read more link instead of [...]
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

	}

	/**
	 * Loading scripts and stylesheets for Innocence
	 * The order of initialising bootstrap css files is important
	 * for the theme responsivness work proerly.
	 *
	 * @uses wp_enqueue_style()
	 * @since v1.0.0
	 */
	public function load_scripts_and_styles() {

		// CSS
		wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/master.min.css' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

		// Include jQuery from WP Core
		wp_enqueue_script( "jquery" );

		// My little script addings for jQuery use.
		wp_enqueue_script( 'waves', get_template_directory_uri() . '/assets/scripts/waves.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'headroom', get_template_directory_uri() . '/assets/scripts/headroom.min.js', array(), '1.0.0', true );
		// wp_enqueue_script( 'sidebar', get_template_directory_uri() . '/assets/scripts/sticky-sidebar.min.js', array(), '1.0.0', true );

		// We dont use it on other places
		if( is_single() ) {
			wp_enqueue_script( 'readingtime', get_template_directory_uri() . '/assets/scripts/readingTime.min.js', array(), '1.0.0', true );
		}

		// Main script file
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/scripts/scripts.js', array(), '1.0.0', true );

		// Adds JavaScript to pages with the comment form to support
		// sites with threaded comments (when in use).
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

	}

	public function wpadmin_css() {
		if ( is_user_logged_in() ) {
			wp_enqueue_style( 'custom-admin', get_template_directory_uri() . '/assets/css/wpadmin.min.css' );
		}
	}

	public function editor_style_inc() {
		add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.min.css' );
	}

	public function widgets_init() {
		// Also register sidebar here if needed.
		// register_widget( 'yourWidgetClass' );

		register_sidebar( array(
			'name' => __( 'Main Sidebar', THEME_DOMAIN_NAME ),
			'id' => 'sidebar-main'
		) );
	}

	/**
	 * Register fonts used in the theme. It is better to include them
	 * from this file instead from hardcoding in header.php
	 *
	 * @since  v1.0.0
	 */
	public function load_fonts() {
		// wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');
		// wp_enqueue_style( 'googleFonts');
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
	}

	/**
	 * Change the default valued for length of the post excerpt.
	 * @param  int $length The length of desired excerpt. (for all pages and all calls)
	 * @return int         Hardcoded value of the excerpt length
	 */
	public function excerpt_length( $length ) {
		return $length;
	}

	/**
	 * Change the default valued for after the post excerpt.
	 * @param  string $more Not used vcariable, wanted from WP
	 * @return string       Link for the post.
	 */
	public function excerpt_more( $more ) {
		return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
	}

	/**
	 * Add custom style for the header.
	 * It look quite hard to read, but the main logic is to setup
	 * custom styling when there is custom header image set.
	 *
	 * @return void
	 * @since v1.0.0
	 */
	public function custom_header_css() {
		$header_image = get_header_image();

		// This will be printed as stylesheet in the header.
		$output = '<style type="text/css">';

		// Close the style tag
		$output .= '</style>';

		// Print the final styles.
		echo $output;
	}

	/**
	 * Disables the new emoji functionality in WordPress 4.2.
	 */
	public function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_emojis_tinymce' ) );
	}

	public function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
}

// Removing this line is like not having the functions.php file
$Devrix_Theme = new Devrix_Theme;

endif;
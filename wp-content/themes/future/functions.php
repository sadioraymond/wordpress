<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

 /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
 function future_setup() {
add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
 }
add_action( 'after_setup_theme', 'future_setup' );

/**
 * Scripts and Css
 * Enqueue scripts and styles.
 */

function future_scripts() {
    wp_enqueue_style( 'future-style', get_stylesheet_uri() );
    // Load the Internet Explorer 8 specific stylesheet
	wp_enqueue_style( 'future-ie8', get_theme_file_uri('assets/css/ie8.css'), array( 'future-style' ), '1.0' );
	wp_style_add_data( 'future-ie8', 'conditional', 'lte IE 8' );
    //Html5shiv
    wp_enqueue_script( 'future-ie8-shiv', get_theme_file_uri('assets/js/ie/html5shiv.js'), array(), '3.7.3' );
	wp_script_add_data( 'future-ie8-shiv', 'conditional', 'lte IE 9' );
    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    wp_enqueue_style( 'future-ie9', get_theme_file_uri('assets/css/ie9.css'), array( 'future-style' ), '1.0' );
	wp_style_add_data( 'future-ie9', 'conditional', 'IE 9' );

}
add_action( 'wp_enqueue_scripts', 'future_scripts' );
 ?>
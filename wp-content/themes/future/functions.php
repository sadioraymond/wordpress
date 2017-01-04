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
}
add_action( 'wp_enqueue_scripts', 'future_scripts' );
 ?>
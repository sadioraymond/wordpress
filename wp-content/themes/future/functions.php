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
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 840, 341, array('center','cebter'));
	add_theme_support('title-tag');
	add_theme_support( 'custom-logo', array(
	'height'      => 72,
	'width'       => 72,
	'flex-width'  => false,
) );
   add_theme_support( 'html5',array('search-form'));
register_nav_menus( array(
		'site-nav'    => __( 'En Haut de page', 'future' ),
	) );
 }
add_action( 'after_setup_theme', 'future_setup' );

/**
 * Scripts and Css
 * Enqueue scripts and styles.
 */

function future_scripts() {
	//font awesome
	wp_enqueue_style( 'font-awesome', get_theme_file_uri('assets/css/font-awesome.min.css') );

    wp_enqueue_style( 'future-style', get_stylesheet_uri() );
    // Load the Internet Explorer 8 specific stylesheet
	wp_enqueue_style( 'future-ie8', get_theme_file_uri('assets/css/ie8.css'));
	wp_style_add_data( 'future-ie8', 'conditional', 'lte IE 8' );
    //Html5shiv
    wp_enqueue_script( 'future-ie8-shiv', get_theme_file_uri('assets/js/ie/html5shiv.js'));
	wp_script_add_data( 'future-ie8-shiv', 'conditional', 'lte IE 9' );
    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    wp_enqueue_style( 'future-ie9', get_theme_file_uri('assets/css/ie9.css'));
	wp_style_add_data( 'future-ie9', 'conditional', 'IE 9' );
	//Script de Footer
	wp_enqueue_script( 'future-skel', get_theme_file_uri( 'assets/js/skel.min.js' ), array( 'jquery' ),4.7,true );
	wp_enqueue_script( 'future-util', get_theme_file_uri( 'assets/js/util.js'), array(),4.7,true);
	wp_enqueue_script( 'future-main', get_theme_file_uri( 'assets/js/main.js'), array(),4.7,true);
	wp_enqueue_script( 'future-respond', get_theme_file_uri( 'assets/js/ie/respond.min.js'), array(),4.7,true);
	wp_script_add_data( 'future-respond', 'conditional', 'lte IE 8' );

}
add_action( 'wp_enqueue_scripts', 'future_scripts' );

function custom_excerpt_length(){
	return 10;
}
add_filter('excerpt_length','custom_excerpt_length');
function theme_prefix_the_custom_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo');
	$image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
	echo $image[0];
}
function future_next_posts_link_attributes() {
	    return 'class="button big previous"';
	}

	function future_previous_posts_link_attributes() {
	    return 'class="button big next"';
	}
	add_filter('next_posts_link_attributes', 'future_next_posts_link_attributes');
	add_filter('previous_posts_link_attributes', 'future_previous_posts_link_attributes');

	//custom Comment
	function custom_comments($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( __( '<cite class="fn">%s</cite> <span class="says">a commenté:</span>' ), get_comment_author_link() ); ?>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e( 'Votre Commentaire est en attente de modération.' ); ?></em>
          <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
        <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
        ?>
    </div>

    <?php comment_text(); ?>

    <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php
	}

 
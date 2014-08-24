<?php
/**
 * tOP functions and definitions
 *
 * @package theopenpress
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 640; /* pixels */
}

if ( ! function_exists( 'tOP_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tOP_setup() {

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on tOP, use a find and replace
   * to change 'tOP' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'tOP', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  //add_theme_support( 'post-thumbnails' );

  /*
   * Register menus
   */
  register_nav_menus( array(
    'global-nav'  => __( 'Global Nav', 'tOP' ),
    'account-nav' => __( 'Account Nav', 'tOP' )
  ) );


  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  ) );

  /*
   * Enable support for Post Formats.
   * See http://codex.wordpress.org/Post_Formats
   */
  add_theme_support( 'post-formats', array(
    'aside', 'image', 'video', 'quote', 'link'
  ) );

  // Setup the WordPress core custom background feature.
  add_theme_support( 'custom-background', apply_filters( 'tOP_custom_background_args', array(
    'default-color' => 'ffffff',
    'default-image' => '',
  ) ) );

  // Hide admin bar when viewing site
  add_filter('show_admin_bar', '__return_false');
}
endif; // tOP_setup
add_action( 'after_setup_theme', 'tOP_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tOP_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Sidebar', 'tOP' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );
}
add_action( 'widgets_init', 'tOP_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tOP_scripts() {
  wp_enqueue_style( 'tOP-app', get_template_directory_uri() . '/assets/css/app.css' );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'tOP_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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

/*
 * Add Favicon
 */
function tOP_favicon() {
  echo '<link rel="shortcut icon" href="' . get_bloginfo('url') . '/favicon.ico" />';
}
add_action('wp_head', 'tOP_favicon');


/*
 * Add Admin Favicon
 */
function tOP_admin_favicon() {
  echo '<link rel="shortcut icon" href="' . get_bloginfo('url') . '/favicon-admin.ico" />';
}
add_action('login_head', 'tOP_admin_favicon');
add_action('admin_head', 'tOP_admin_favicon');


/*
 * Cleaner nav_menu
 */
class Cleaner_Walker_Nav_Menu extends Walker {
  var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"sub-nav\">\n";
  }
  function end_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }
  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes = in_array( 'current-menu-item', $classes ) ? array( 'active' ) : array();
    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
    $id = apply_filters( 'nav_menu_item_id', '', $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
    $output .= $indent . '<li' . $id . $value . $class_names .'>';
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
  function end_el(&$output, $item, $depth) {
    $output .= "</li>\n";
  }
}

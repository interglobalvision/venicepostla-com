<?php

// Enqueue

function scripts_and_styles_method() {
  $templateuri = get_template_directory_uri();

  if (WP_DEBUG) {
    $javascriptLibrary = $templateuri . '/dist/js/library.js';
    $javascriptMain = $templateuri . '/src/js/main.js';
  } else {
    $javascriptLibrary = $templateuri . '/dist/js/library.min.js';
    $javascriptMain = $templateuri . '/dist/js/main.min.js';
  }

  $is_admin = current_user_can('administrator') ? 1 : 0;

  $animation_options = get_site_option('_igv_animation_options');

  if (!empty($animation_options['animation_images'])) {
    // If animation values set then get all the image IDs
    $ids = array_keys($animation_options['animation_images']);

    $images = [];

    // Then save the gallery size image from each ID into an array
    foreach ($ids as $id) {
      $imageUrl = wp_get_attachment_image_src($id, 'gallery');
      $images[] = $imageUrl[0];
    }

    $animationImages = $images;
  } else {
    $animationImages = null;
  }

  // $animationImages = ???;

  $javascriptVars = array(
    'siteUrl' => home_url(),
    'themeUrl' => get_template_directory_uri(),
    'isAdmin' => $is_admin,
    'animationImages' => $animationImages
  );

  wp_enqueue_script('javascript-library', $javascriptLibrary, '', '', true);

  wp_register_script('javascript-main', $javascriptMain);
  wp_localize_script('javascript-main', 'WP', $javascriptVars);
  wp_enqueue_script('javascript-main', $javascriptMain, '', '', true);

  wp_enqueue_style( 'style-site', get_stylesheet_directory_uri() . '/dist/css/site.min.css' );

  // dashicons for admin
  if (is_admin()) {
    wp_enqueue_style( 'dashicons' );
  }
}
add_action('wp_enqueue_scripts', 'scripts_and_styles_method');

// Declare thumbnail sizes

get_template_part( 'lib/thumbnail-sizes' );

// Register Nav Menus
/*
register_nav_menus( array(
  'menu_location' => 'Location Name',
) );
 */

// Add third party PHP libs

function cmb_initialize_cmb_meta_boxes() {
  if (!class_exists( 'cmb2_bootstrap_202' ) ) {
    require_once 'vendor/webdevstudios/cmb2/init.php';
    require_once 'vendor/webdevstudios/cmb2-post-search-field/lib/init.php';
  }
}
add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 11 );

function composer_autoload() {
  require_once( 'vendor/autoload.php' );
}
add_action( 'init', 'composer_autoload', 10 );

// Add libs

get_template_part( 'lib/custom-gallery' );
get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/site-options' );

// Add custom functions

get_template_part( 'lib/functions-misc' );
get_template_part( 'lib/functions-custom' );
get_template_part( 'lib/functions-filters' );
get_template_part( 'lib/functions-hooks' );
get_template_part( 'lib/functions-utility' );

?>

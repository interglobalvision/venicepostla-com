<?php

if( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

if( function_exists( 'add_image_size' ) ) {
  add_image_size( 'admin-thumb', 150, 150, false );
  add_image_size( 'opengraph', 1200, 630, true );

  add_image_size( '1800', 1800, 9999, false );
  add_image_size( '1200', 1200, 9999, false );
  add_image_size( '1000', 1000, 9999, false );
  add_image_size( '800', 800, 9999, false );
  add_image_size( '600', 600, 9999, false );
}

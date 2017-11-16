<?php

// Custom functions (like special queries, etc)


function get_animation_images() {
  $animation_options = get_site_option('_igv_animation_options');

  if (empty($animation_options['animation_images'])) {
    return null;
  }

  // If animation values set then get all the image IDs
  $ids = array_keys($animation_options['animation_images']);

  $images = [];

  // Then save the gallery size image from each ID into an array
  foreach ($ids as $id) {
    $image1800 = wp_get_attachment_image_src($id, '1800');
    $image1200 = wp_get_attachment_image_src($id, '1200');
    $image1000 = wp_get_attachment_image_src($id, '1000');
    $image800 = wp_get_attachment_image_src($id, '800');
    $image600 = wp_get_attachment_image_src($id, '600');

    $images[] = array(
      '1800' => $image1800[0],
      '1200' => $image1200[0],
      '1000' => $image1000[0],
      '800' => $image800[0],
      '600' => $image600[0],
    );
  }

  //pr($images); die;
  return $images;
}

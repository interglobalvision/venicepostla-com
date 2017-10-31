<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
  $args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
  ) );
  $posts = get_posts( $args );
  $post_options = array();
  if ( $posts ) {
    foreach ( $posts as $post ) {
      $post_options [ $post->ID ] = $post->post_title;
    }
  }
  return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_igv_';

  /**
   * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
   */

  // ABOUT
  $about_page = get_page_by_path('about');

  if (!empty($about_page) ) {
    $about_metabox = new_cmb2_box( array(
      'id'           => $prefix . 'about_metabox',
      'title'        => esc_html__( 'Options', 'cmb2' ),
      'object_types' => array( 'page' ),
      'show_on'      => array( 'key' => 'id', 'value' => array($about_page->ID) ),
    ) );

    $about_list_group = $about_metabox->add_field( array(
  		'id'          => $prefix . 'about_lists',
  		'type'        => 'group',
  		'description' => esc_html__( 'About Lists', 'cmb2' ),
  		'options'     => array(
  			'group_title'   => esc_html__( 'List {#}', 'cmb2' ), // {#} gets replaced by row number
  			'add_button'    => esc_html__( 'Add Another List', 'cmb2' ),
  			'remove_button' => esc_html__( 'Remove List', 'cmb2' ),
  			'sortable'      => true, // beta
  		),
  	) );

    $about_metabox->add_group_field( $about_list_group, array(
  		'name'       => esc_html__( 'Title', 'cmb2' ),
  		'id'         => 'title',
  		'type'       => 'text',
  	) );

    $about_metabox->add_group_field( $about_list_group, array(
  		'name'       => esc_html__( 'List', 'cmb2' ),
  		'id'         => 'list',
  		'type'       => 'wysiwyg',
  	) );

  }

  // ABOUT
  $contact_page = get_page_by_path('contact');

  if (!empty($contact_page) ) {
    $contact_metabox = new_cmb2_box( array(
      'id'           => $prefix . 'contact_metabox',
      'title'        => esc_html__( 'Options', 'cmb2' ),
      'object_types' => array( 'page' ),
      'show_on'      => array( 'key' => 'id', 'value' => array($contact_page->ID) ),
    ) );

    $contact_metabox->add_field( array(
  		'name' => esc_html__( 'Address', 'cmb2' ),
  		'id'   => $prefix . 'contact_address',
  		'type' => 'textarea_small',
  	) );

    $contact_metabox->add_field( array(
  		'name' => esc_html__( 'Telephone', 'cmb2' ),
  		'id'   => $prefix . 'contact_phone',
  		'type' => 'text_medium',
  	) );

    $contact_metabox->add_field( array(
  		'name' => esc_html__( 'Email', 'cmb2' ),
  		'id'   => $prefix . 'contact_email',
  		'type' => 'text_email',
  	) );

  }

}
?>

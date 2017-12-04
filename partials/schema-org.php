<?php
$options = get_site_option('_igv_site_options');

$ldjson = array(
  '@context' => 'http://schema.org',
  '@type' => 'Organization',
  'url' => home_url(),
);

if (isset($options['metadata_logo'])) {
  $image = wp_get_attachment_image_src($options['metadata_logo_id'], 'opengraph');

  $ldjson['logo'] = $image[0];
}

if (isset($options['socialmedia_facebook_url']) || isset($options['socialmedia_twitter']) || isset($options['socialmedia_instagram'])) {
  $ldjson['sameAs'] = array();
}

if (isset($options['socialmedia_facebook_url'])) {
  $ldjson['sameAs'][] = $options['socialmedia_facebook_url'];
}

if (isset($options['socialmedia_twitter'])) {
  $ldjson['sameAs'][] = $options['socialmedia_twitter'];
}

if (isset($options['socialmedia_instagram'])) {
  $ldjson['sameAs'][] = $options['socialmedia_instagram'];
}

?>
<script type="application/ld+json">
  <?php echo json_encode($ldjson); ?>
</script>

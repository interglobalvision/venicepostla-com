<?php
get_header();
?>

<main id="main-content"  class="grid-row align-items-center">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();

    $address = get_post_meta($post->ID, '_igv_contact_address', true);
    $phone = get_post_meta($post->ID, '_igv_contact_phone', true);
    $email = get_post_meta($post->ID, '_igv_contact_email', true);
?>
  <article <?php post_class('grid-item item-s-12 item-m-3'); ?> id="post-<?php the_ID(); ?>">
    <div class="font-uppercase"><?php the_content(); ?></div>
<?php
  if (!empty($address)) {
?>
    <h2 class="font-uppercase">Address</h2>
    <?php echo apply_filters('the_content', $address); ?>
<?php
  }

  if (!empty($phone)) {
?>
    <h2 class="font-uppercase">Telephone</h2>
    <p><a href="tel:<?php echo preg_replace("/[^0-9]/", "", $phone); ?>"><?php echo $phone; ?></a></p>
<?php
  }

  if (!empty($email)) {
?>
    <h2 class="font-uppercase">Email</h2>
    <p><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
<?php
  }
?>
  </article>
<?php
  }
}
?>
</main>

<?php
get_footer();
?>

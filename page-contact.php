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
    $insta = get_post_meta($post->ID, '_igv_contact_insta', true);
?>
  <article <?php post_class('grid-item item-s-12 item-m-3'); ?> id="post-<?php the_ID(); ?>">
    <div class="font-uppercase"><?php the_content(); ?></div>
<?php
  if (!empty($address)) {
?>
    <div class="contact-section">
      <h2 class="font-uppercase">Address</h2>
      <?php echo apply_filters('the_content', $address); ?>
    </div>
<?php
  }

  if (!empty($phone)) {
?>
    <div class="contact-section">
      <h2 class="font-uppercase">Telephone</h2>
      <a href="tel:<?php echo preg_replace("/[^0-9]/", "", $phone); ?>"><?php echo $phone; ?></a>
    </div>
<?php
  }

  if (!empty($email)) {
?>
    <div class="contact-section">
      <h2 class="font-uppercase">Email</h2>
      <a href="mailto:<?php echo $email; ?>" class="no-ajax"><?php echo $email; ?></a>
    </div>
<?php
  }

  if (!empty($insta)) {
?>
    <div class="contact-section">
      <h2 class="font-uppercase">Instagram</h2>
      <a href="https://www.instagram.com/<?php echo $insta; ?>" class="no-ajax" target="_blank" rel="noopener">@<?php echo $insta; ?></a>
    </div>
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

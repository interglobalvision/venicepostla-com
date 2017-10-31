<?php
get_header();
?>

<main id="main-content"  class="grid-row">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
  <article <?php post_class('grid-item item-s-12 item-m-3'); ?> id="post-<?php the_ID(); ?>">
    <?php the_content(); ?>
  </article>
<?php
  }
}
?>
</main>

<?php
get_footer();
?>

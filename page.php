<?php
get_header();
?>

<main id="main-content">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
  <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
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

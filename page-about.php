<?php
get_header();
?>

<div id="main-content-container">
  <main id="main-content" class="text-columns text-columns-s-1 text-columns-l-4">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      
    </article>
<?php
  }
}
?>
  </main>
</div>

<?php
get_footer();
?>

<?php
get_header();
?>

<main id="main-content">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
  <article>
    <div id="home-animation" class="grid-row align-content-center justify-center"></div>
  </article>
<?php
  }
}
?>
</main>

<?php
get_footer();
?>

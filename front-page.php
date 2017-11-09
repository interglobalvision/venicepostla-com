<?php
get_header();
?>

<main id="main-content">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
?>
  <div id="home-animation" class="grid-row align-items-center justify-center"></div>
<?php
  }
}
?>
</main>

<?php
get_footer();
?>

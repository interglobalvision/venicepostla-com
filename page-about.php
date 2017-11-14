<?php
get_header();
?>

<main id="main-content"  class="grid-row align-items-center">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();

    $lists = get_post_meta($post->ID, '_igv_about_lists', true);
?>
  <article <?php post_class('grid-item item-s-12 text-columns text-columns-s-1 text-columns-m-2 text-columns-l-3 text-columns-xl-4'); ?> id="post-<?php the_ID(); ?>">
    <div class="font-uppercase"><?php the_content(); ?></div>
<?php
  if (!empty($lists)) {
    foreach ($lists as $list) {
?>
    <div class="about-list">
      <h2 class="font-uppercase"><?php echo $list['title']; ?></h2>
      <?php
        // get list
        $content = apply_filters('the_content', $list['list']);
        // remove wordpress' <p> tags
        $filtered = preg_replace('/<\\/?p(.|\\s)*?>/','', $content);
        // split each linebreak to array
        $items = explode('<br />', $filtered);

        // render each line inside a span so each item can be separate in the DOM for sake of css column layout
        foreach($items as $item) {
          echo '<span class="about-list-item">' . $item . '</span>';
        }
      ?>
    </div>
<?php
    }
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

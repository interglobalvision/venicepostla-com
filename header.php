<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|',true,'right'); bloginfo('name'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<?php
get_template_part('partials/globie');
get_template_part('partials/seo');
?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">
  <link rel="shortcut" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon-touch.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">

<?php if (is_singular() && pings_open(get_queried_object())) { ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php } ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--[if lt IE 9]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

<section id="main-container">

  <header id="header">
    <h1 class="u-hidden">Venice Post LA</h1>
    <span id="header-item-venice" class="header-item font-size-extra"><a href="<?php echo home_url(); ?>"><?php echo url_get_contents(get_template_directory_uri() . '/dist/img/logo-venice.svg'); ?></a></span>
    <span id="header-item-post" class="header-item font-size-extra"><a href="<?php echo home_url(); ?>"><?php echo url_get_contents(get_template_directory_uri() . '/dist/img/logo-post.svg'); ?></a></span>
    <span id="header-item-left" class="header-item text-align-center">
      <?php
        if (!is_front_page()) {
      ?>
      <a href="<?php echo home_url(); ?>">HOME</a>
      <?php
        } else {
      ?>
      <a href="<?php echo home_url('about/'); ?>">ABOUT</a>
      <?php
        }
      ?>
    </span>
    <span id="header-item-right" class="header-item text-align-center">
      <?php
        if (is_page('contact')) {
      ?>
      <a href="<?php echo home_url('about/'); ?>">ABOUT</a>
      <?php
        } else {
      ?>
      <a href="<?php echo home_url('contact/'); ?>">CONTACT</a>
      <?php
        }
      ?>
    </span>
  </header>

<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package theopenpress
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- Load Typekit asynchronously -->
<script type="text/javascript">
  (function(d){var config={kitId:'pfh1zas',scriptTimeout:3000},h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive"},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)})(document);
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
  <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tOP' ); ?></a>

  <header id="masthead" class="site-header" role="banner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
      <img alt="<?php bloginfo( 'name' ); ?>" src="#">
    </a>

    <nav id="account-nav" role="navigation">
      <?php
      wp_nav_menu( array(
        'theme_location'  => 'account-nav',
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="nav account-nav">%3$s</ul>',
        'depth'           => 0,
        'walker'          => new Cleaner_Walker_Nav_Menu()
      ) );
      ?>
    </nav><!-- #account-nav -->

    <nav id="global-nav" role="navigation">
      <?php
      wp_nav_menu( array(
        'theme_location'  => 'global-nav',
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => '',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="nav global-nav">%3$s</ul>',
        'depth'           => 0,
        'walker'          => new Cleaner_Walker_Nav_Menu()
      ) );
      ?>
    </nav><!-- #global-nav -->
  </header><!-- #masthead -->

  <div id="content" class="site-content">

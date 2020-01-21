<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package NewsAnchor
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header>
        <div class="container header-wrapper">
            <div id="main-header">
                <div class="brand_logo">
                    <div id="logo" class="logo">
                        <?php if ( get_theme_mod('site_logo') ) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>">
                                <img class="site-logo" src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" />
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="nav-toggle" class="nav-toggle">
                    <div id="navbar-toggle-icon" class="navbar-toggle-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <nav id="mainnav" class="mainnav">
                    <?php wp_nav_menu( array( 
                                'theme_location'=> 'primary', 
                                'container'		=> false, 
                                'menu_class'  	=> 'clearfix', 
                                'items_wrap'  	=> '<ul class="primary-menu"><li id="%1$s" class="%2$s">%3$s</li></ul>',
                                'fallback_cb' 	=> 'newsanchor_menu_fallback',) 
                                );
                            ?>
                </nav><!-- /nav -->
            </div><!-- /.main-header -->

            <div id="mobile-menu">
                <nav id="mobile-category">
                    <?php wp_nav_menu( array( 
                            'theme_location' => 'primary',
                            'container' => false, 
                            'menu_class' => 'clearfix', 
                            'items_wrap'      => '<ul class="primary-menu"><li id="%1$s" class="%2$s">%3$s</li></ul>',
                            'fallback_cb' => 'newsanchor_menu_fallback',) 
                            ); 
                        ?>
                </nav><!-- /nav -->
            </div>
        </div>
    </header>

    <main class="page-content">
        <div class="container content-wrapper">

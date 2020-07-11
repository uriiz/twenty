<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="theme-color" content="<?php echo get_option('header_mobile_color') ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="site-header" class="header-footer-group" role="banner">
        <?php if(!is_front_page()): ?>
            <div class="container">
                <div class="back-to-home">
                    <a href="<?php echo home_url() ?>">
                        <?php _e('< Back To Home','twentytwenty-child') ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>

</header>


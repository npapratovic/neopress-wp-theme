<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title(); ?> | <?php bloginfo( 'description' ); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <link rel="icon" type="image/x-icon" href="/img/i-fis-favicon.png">

    <!-- place your Google fonts here -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- place your styles here -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(). '/style.css' ?>">
    <!-- this trick prevents browser to cache custom css file, remove in production -->
    <?php $time = time(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(). '/custom.css?v=' . $time ?>">

    <!-- all the other WP stuff -->
 	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- an example of website header -->
<section class="header" id="top">
    <div class="container container-fluid">
        <div class="row w-100 m-0">
            <div class="col col-6 col-md-2 logo">
                <a href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(). '/img/logo.svg' ?>" />
                </a>
            </div>
            <div class="col col-6 col-md-10 top-nav d-flex justify-content-end">
                <img src="<?php echo get_stylesheet_directory_uri(). '/img/menu.svg' ?>" class="d-sm-block d-md-none" />
                <nav class="d-none d-md-block main-menu-nav">
                    <?php
                    wp_nav_menu(
                        array (
                            'theme_location' => 'main-menu',
                            'menu_class' => 'main-menu'
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- an example with ACF fields to show content -->
<?php

$show_hero = get_field('show_hero_block');
if($show_hero) {
    ?>
    <section class="hero">
        <div class="container container-fluid">
            <div class="row w-100 m-0">
                <div class="col col-12 col-md-5 hero-content">
                    <h1><?php the_field('hero_title'); ?></h1>
                    <h3><?php the_field('hero_description'); ?></h3>
                    <div class="row mt-5">
                        <div class="col col-6 col-md-4">
                            <a class="btn btn-aquamarine btn-hero-left" href="<?php the_field('hero_left_button_link'); ?>"><?php the_field('hero_left_button_text'); ?></a>
                        </div>
                        <div class="col col-6 col-md-8">
                            <a class="btn btn-transparent btn-hero-right" href="<?php the_field('hero_right_button_link'); ?>"><?php the_field('hero_right_button_text'); ?></a>
                        </div>
                    </div>
                    <div class="row col col-md-12 scrolldown-row justify-content-center">
                        <a href="#about">
                            <img src="<?php echo get_stylesheet_directory_uri(). '/img/scrolldown.svg' ?>" />
                        </a>
                    </div>
                </div>
                <div class="col col-12 col-md-7 hero-image">
                    <img src="<?php the_field('hero_image'); ?>" class="responsive-img">
                </div>
            </div>
        </div>
    </section>
<?php
}
?>





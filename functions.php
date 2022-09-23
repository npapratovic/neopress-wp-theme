<?php

/* Load assets the right way
*/
function load_assets () {
    //source: https://wpmudev.com/blog/adding-scripts-and-styles-wordpress-enqueueing/
    //lets load CSS the right way
	wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array( 'style' ) );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/custom.css' );
    //lets load JS the right way:
	//wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/owl.carousel.js', array( 'jquery' ) );
	//wp_enqueue_script( 'theme-scripts', get_stylesheet_directory_uri() . '/website-scripts.js', array( 'owl-carousel', 'jquery' ), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'load_assets ' );

/* Menus setup
*/
function register_menus() {
    register_nav_menu('main-menu',__('Main Menu'));
    register_nav_menu('footer-menu',__('Footer Menu'));
}
add_action('init', 'register_menus');

/* Add Multiple sidebars
*/
if ( function_exists('register_sidebar') ) {
    $sidebar1 = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
        'id'            => 'left',
        'name'          => __( 'Left Sidebar' ),
        'description'   => __( 'Left side Sidebar' ),
    );
    $sidebar2 = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
        'id'            => 'footer',
        'name'          => __( 'Footer Sidebar' ),
        'description'   => __( 'Footer Sidebar' ),
    );
    register_sidebar($sidebar1);
    register_sidebar($sidebar2);
}

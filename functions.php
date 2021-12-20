<?php

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
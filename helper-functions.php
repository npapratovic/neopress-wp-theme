<?php

/*
Those are some random helper functions for WordPress and Woocommerce which I collected over the years.
Pick the one you need and place it in functions.php
 */

/*
 TABLE OF CONTENTS:

1) disable comments
2) custom fee on woocommerce checkout
3) attach pdf to order email 
 */

/*===================================================*/
/* 1) disable comments */
/* Wordpress disable comments without plugin, remove links from admin menu (add this code-snippet to functions.php) */
/* Disable comments from WordPress */
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
// Remove the comments icon in admin bar
add_action('wp_before_admin_bar_render', function() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});


/*===================================================*/

/*===================================================*/
/* 2) add cusotm fee on woocommerce checkout */

// Add a custom fee (fixed cart subtotal) by payment
add_action( 'woocommerce_cart_calculate_fees', 'custom_handling_fee' );
function custom_handling_fee ( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $chosen_payment_id = WC()->session->get('chosen_payment_method');

    if ( empty( $chosen_payment_id ) )
        return;

    $subtotal = $cart->subtotal;

    // SETTINGS: Here set in the array the (payment Id) / (fee cost) pairs
    $targeted_payment_ids = array(
        'cod' => 8, // Fixed fee 
    );

    // Loop through defined payment Ids array
    foreach ( $targeted_payment_ids as $payment_id => $fee_cost ) {
        if ( $chosen_payment_id === $payment_id ) {
            $cart->add_fee( __('Naknada za manipulativne troškove za plaćanje gotovinom (plaća se dostavnoj službi):', 'woocommerce'), $fee_cost, true );
        }
    }
}

// jQuery - Update checkout on payment method change
add_action( 'woocommerce_checkout_init', 'payment_methods_refresh_checkout' );
function payment_methods_refresh_checkout() {
    wc_enqueue_js( "jQuery( function($){
        $('form.checkout').on('change', 'input[name=payment_method]', function(){
            $(document.body).trigger('update_checkout');
        });
    });");
}

/*===================================================*/

/*===================================================*/

/* 3) attach pdf to order email */

add_filter( 'woocommerce_email_attachments', 'attach_terms_conditions_pdf_to_email', 10, 3);

function attach_terms_conditions_pdf_to_email ( $attachments , $id, $object ) {
	$your_pdf_path = get_template_directory() . '/uvjeti.pdf';
	$attachments[] = $your_pdf_path;
	return $attachments;
}

/*===================================================*/


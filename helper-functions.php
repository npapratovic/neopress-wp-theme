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
4) add (google adwords) conversion code only to thankyou page inside head tags 
5) Create Buy Now Button dynamically after Add To Cart button 

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


/*===================================================*/

/* 4) add (google adwords) conversion code only to thankyou page inside head tags */

add_action( 'wp_head', 'my_google_conversion', 9000 );
function my_google_conversion(){
    // On Order received endpoint only
    if( is_wc_endpoint_url( 'order-received' ) ) :

    $order_id = absint( get_query_var('order-received') ); // Get order ID

    if( get_post_type( $order_id ) !== 'shop_order' ) return; // Exit

    $order = wc_get_order( $order_id ); // Get the WC_Order Object instance
    ?>
    <!-- Event snippet for Website traffic conversion page --> 
    <script> 
		gtag('event', 'conversion', {
			'send_to': 'AW-1022397026/118rCK2Mz6wDEOKUwucD',
		    'value': <?php echo $order->get_total(); ?>,
            'currency': '<?php echo $order->get_currency(); ?>',
            'transaction_id': '<?php echo $order_id; ?>'
		}); 
    </script>  
    <?php   
    endif;
}

/*===================================================*/

/*===================================================*/

/* 5) Create Buy Now Button dynamically after Add To Cart button  */
 
    function add_content_after_addtocart() {
     
        // get the current post/product ID
        $current_product_id = get_the_ID();
     
        // get the product based on the ID
        $product = wc_get_product( $current_product_id );
     
        // get the "Checkout Page" URL
        $checkout_url = WC()->cart->get_checkout_url();
     
        // run only on simple products
        if( $product->is_type( 'simple' ) ){
            echo '<div class="clear-sec">';
            echo '</div>';
            echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="buy-now button" style="    width: 240px;
    background: #04AA6D;
    text-align: center;">Kupi odmah</a>';
            //echo '<a href="'.$checkout_url.'" class="buy-now button">Kupi odmah</a>';
        }
    }
    add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart' );

/*===================================================*/ 

/*===================================================*/

/* 6) Hide ALL shipping rates in ALL zones when Free Shipping is available  */
  
add_filter( 'woocommerce_package_rates', 'bbloomer_unset_shipping_when_free_is_available_all_zones', 9999, 2 );
   
function bbloomer_unset_shipping_when_free_is_available_all_zones( $rates, $package ) {
   $all_free_rates = array();
   foreach ( $rates as $rate_id => $rate ) {
      if ( 'free_shipping' === $rate->method_id ) {
         $all_free_rates[ $rate_id ] = $rate;
         break;
      }
   }
   if ( empty( $all_free_rates )) {
      return $rates;
   } else {
      return $all_free_rates;
   } 
}


/*===================================================*/

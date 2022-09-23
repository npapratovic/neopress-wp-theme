<?php get_header(); ?>

<?php
    /*example how to call different template*/
    if ( is_home() ) {
        get_template_part( 'templates/content', 'home' );
    } elseif ( is_page( 14 ) ) {
        get_template_part( 'templates/content', 'single' );
    } else {
        get_template_part( 'templates/content', 'regular' );
    }

?>

<?php get_footer(); ?>

<!-- an example with ACF fields to show content -->

<?php

$show_footer_cta = get_field('show_footer_cta');

if($show_footer_cta) {
   ?>

    <section class="footer-cta">
        <div class="container container-fluid">
            <div class="row w-100 m-0">
                <div class="col col-12 col-md-12 text-center">
                    <h4 class="page-title">Do you have some additional questions?</h4>
                    <p>We will get back to you within 24h!</p>
                    <a class="btn btn-aquamarine btn-footer-cta" href="<?php echo site_url(); ?>/contact-us/">Contact us <img src="<?php echo get_stylesheet_directory_uri(). '/img/email.png' ?>" /></a>
                </div>
            </div>
        </div>
    </section>

<?php
}
?>

<!-- an example of website footer -->

    <section class="footer">
        <div class="container container-fluid">
            <div class="row width-100">
                <div class="row col col-md-12 scrolldown-row justify-content-end">
                    <a href="#top">
                        <img src="<?php echo get_stylesheet_directory_uri(). '/img/scrolltotop.svg' ?>" />
                    </a>
                </div>
            </div>
            <div class="row w-100 m-0">
                 <div class="col col-12 col-md-4 footer-col">
                    <a href="<?php echo site_url(); ?>" class="footer-logo">
                        <img src="<?php echo get_stylesheet_directory_uri(). '/img/w-logo-company.svg' ?>" />
                    </a>
                     <div class="row w-100 m-0">
                         <a href="#" class="footer-social" target="_blank">
                             <img src="<?php echo get_stylesheet_directory_uri(). '/img/facebook.svg' ?>" />
                         </a>
                         <a href="#" class="footer-social" target="_blank">
                             <img src="<?php echo get_stylesheet_directory_uri(). '/img/linkedIn.svg' ?>" />
                         </a>
                         <a href="#" class="footer-social" target="_blank">
                             <img src="<?php echo get_stylesheet_directory_uri(). '/img/instagram.svg' ?>" />
                         </a>
                     </div>
                     <div class="row w-100 m-0">
                         <p>© Copyright - NEOMEDIA PLUS d.o.o. - Privacy policy</p>
                     </div>
                 </div>
                 <div class="col col-12 col-md-4 footer-col">
                     <?php dynamic_sidebar('footer'); ?>
                 </div>
                 <div class="col col-12 col-md-4 footer-col">
                    <nav class="footer-menu-nav">
                        <?php
                        wp_nav_menu(
                            array (
                                'theme_location' => 'footer-menu',
                                'menu_class' => 'footer-menu'
                            )
                        );
                        ?>
                    </nav>
                 </div>
            </div>

        </div>
    </section>

        <?php wp_footer(); ?>

<script src="<?php echo get_stylesheet_directory_uri(). '/script.js' ?>"></script>
</body>
</html>

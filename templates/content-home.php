<?php

/*
   Example how to echo repeater field content 
*/
   
$show_why_choose_us_block = get_field('show_why_choose_us_block');

if($show_why_choose_us_block) {
    ?>
    <section class="why-us-content">
        <div class="container container-fluid why-us-container">
            <div class="row w-100 m-0">
                <div class="col col-12 col-md-12 text-center">
                    <h2 class="page-title"><?php the_field('why_title'); ?></h2>
                </div>
            </div>

            <?php

            $why_content_box = get_field('why_content_box');
            if($why_content_box)
            {
                ?>
                <div class="row w-100 content-row">
                <?php
                foreach($why_content_box as $content)
                { ?>

                    <div class="col col-12 col-md-4 text-center">
                        <img src="<?php echo $content['image']; ?>" alt="">
                        <h4 class="content-title"><?php echo $content['title']; ?></h4>
                        <div class="content-content"><?php echo $content['content']; ?></div>
                    </div>

               <?php

                }
                ?>
                 </div>
                <?php

            }

            ?>

        </div>
    </section>
<?php
}
?>

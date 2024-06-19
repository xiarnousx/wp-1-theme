<?php
get_header();

while(have_posts()) {
    the_post();
    ?>
    <?php university_pageBanner(); ?>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> 
                <span class="metabox__main">Posted by <?php echo get_the_author_meta('display_name', get_the_author_ID()); ?> on <?php the_time("n.j.y"); ?> in <?php echo get_the_category_list(', ') ?></span>
                </p>
            </div>
            <?php the_content(); ?>
        </div>
    </div>
    <?php
}
get_footer();
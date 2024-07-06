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
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> 
                <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <?php the_content(); ?>
        </div>
        <div class="acf-map">
            <?php $mapLocation = get_field('map_location'); ?>
            <div data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>" class="marker">
                <h3><?php the_title(); ?></h3>
                <?php echo $mapLocation['address']; ?>
            </div> 
        </div>
        <?php
            $rPrograms = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'program',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
              ['key' => 'related_campuses' , 'compare' => 'LIKE', 'value' => '"' . get_the_ID() . '"'],
            ]
          ]);
        ?>
        <?php if ($rPrograms->have_posts()): ?>
        <hr class="section-break" />
        <h2 class="headline headline--medium">Programs Available</h2>
        <ul class="min-list link-list">
        <?php while($rPrograms->have_posts()): $rPrograms->the_post() ?>
          <li>
            <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
          </li>
        <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
    <?php
}
get_footer();
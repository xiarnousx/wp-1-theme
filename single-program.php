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
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> 
                <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <?php the_content(); ?>
        </div>
        <?php
            $rpEvents = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
              ['key' => 'related_programs' , 'compare' => 'LIKE', 'value' => '"' . get_the_ID() . '"'],
            ]
          ]);
        ?>
        <?php if ($rpEvents->have_posts()): ?>
        <hr class="section-break" />
        <h2 class="headline headline--medium"><?php echo get_the_title(); ?> Professors</h2>
        <ul class="professor-cards">
        <?php while($rpEvents->have_posts()): $rpEvents->the_post() ?>
          <li class="professor-card__list-item">
            <a class="professor-card" href="<?php echo get_the_permalink(); ?>">
              <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape'); ?>" />
              <span class="professor-card__name"><?php echo get_the_title(); ?></span>
            </a>
          </li>
        <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        <?php 
            $today = date('Ymd');
            $hpEvents = new WP_Query([
              'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => [
                ['key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type'=> 'numeric'],
                ['key' => 'related_programs' , 'compare' => 'LIKE', 'value' => '"' . get_the_ID() . '"'],
              ]
            ]);
          ?>
          <?php if($hpEvents->have_posts()): ?>
          <hr class="section-break" />
          <h2 class="headline headline--medium">Up Comming <?php echo get_the_title(); ?> Events</h2>
          <?php while($hpEvents->have_posts()): $hpEvents->the_post() ?>
          <?php get_template_part('template-parts/content', 'event'); ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
          <?php endif; ?>
          
          <?php $relatedCampuses = get_field('related_campuses'); ?>
          <?php if ($relatedCampuses): ?>
            <hr  class="section-break"/>
            <h2 class="headline headline--medium"><?php the_title(); ?> is available at these campuses:</h2>
            <ul class="min-list link-list">
            <?php foreach($relatedCampuses as $rc): ?>
              <li><a href="<?php echo get_the_permalink($rc); ?>"><?php echo get_the_title($rc); ?></a></li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
    </div>
    <?php
}
get_footer();
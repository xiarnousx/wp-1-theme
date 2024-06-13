<?php
get_header();

while(have_posts()) {
    the_post();
    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg');?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
          <p>TODO LATER</p>
        </div>
      </div>
    </div>
    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> 
                <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
            <?php the_content(); ?>

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
          <?php $eventDate = new DateTime(get_field('event_date')); ?>
          <div class="event-summary">
            <a class="event-summary__date t-center" href="#">
              <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
              <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php wp_trim_words(get_the_Content(), 19); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        </div>
    </div>
    <?php
}
get_footer();
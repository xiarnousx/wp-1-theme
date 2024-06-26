<?php
get_header();
?>
    <?php 
    university_pageBanner([
      'title' => 'All Events',
      'subtitle' => 'Now and Then'
    ]);
    ?>
    <div class="container container--narrow page-section">
        <?php while(have_posts()): the_post(); ?>
        <?php get_template_part('template-parts/content', 'event'); ?>
        <?php endwhile; ?>
        <?php echo paginate_links(); ?>
        <hr class="section-break" />
        <p><a href="<?php echo site_url('/past-events');?>" >Past Events</a></p>
    </div>

<?php
get_footer();
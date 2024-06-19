<?php
get_header();
?>
    <?php 
    university_pageBanner([
      'title' => 'Past Events',
      'subtitle' => 'Back Then'
    ]);
    ?>

    <div class="container container--narrow page-section">
        <?php
            $today = date('Ymd');
            $pastEvents = new WP_Query([
                'paged' => get_query_var('paged', 1),
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => [
                  ['key' => 'event_date', 'compare' => '<', 'value' => $today, 'type'=> 'numeric']
                ]
              ]);
        ?>
        <?php while($pastEvents->have_posts()): $pastEvents->the_post(); ?>
        <?php get_template_part('template-parts/content', 'event'); ?>
        <?php endwhile; ?>
        <?php echo paginate_links([
            'total' => $pastEvents->max_num_pages,

        ]); ?>
        <?php wp_reset_postdata(); ?>
    </div>

<?php
get_footer();
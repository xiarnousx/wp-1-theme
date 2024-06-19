<?php
get_header();
?>
    <?php 
    university_pageBanner([
      'title' => 'Welcome to our blog!',
      'subtitle' => 'Keep up to our latest news'
    ]);
    ?>
    <div class="container container--narrow page-section">
        <?php while(have_posts()): the_post(); ?>
          <div class="post-item">
              <h2 class="headline headline--medium headline--post--title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h2>
              <div class="metabox">
                <p> posted by <?php echo get_the_author_meta('display_name', get_the_author_ID()); ?> on <?php the_time("n.j.y"); ?> in <?php echo get_the_category_list(', ') ?></p>
              </div>
              <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
              </div>
          </div>
        <?php endwhile; ?>
        <?php echo paginate_links(); ?>
    </div>

<?php
get_footer();
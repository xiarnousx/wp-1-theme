<?php
get_header();
while(have_posts()) {
    the_post();
    ?>
    <?php university_pageBanner();?>

    <div class="container container--narrow page-section">
        <?php $id = wp_get_post_parent_id(get_the_ID()); ?>
        <?php if($id): ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
            <a class="metabox__blog-home-link" href="<?php echo get_permalink($id); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($id) ?></a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
      <?php endif; ?>
      <?php
        $subs = get_pages([
          'child_of' => get_the_ID(),
        ]) 
      ?>
      <?php if ($id || $subs): ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h2>
        <ul class="min-list">
            <?php 
                $childOf = $id ? $id: get_the_ID();
                wp_list_pages([
                  'title_li' => null,
                  'child_of' => $childOf,
                  'sort_column' => 'menu_order'
                ]);
            ?>
            <!--
          <li class="current_page_item"><a href="#">Our History</a></li>
              -->
        </ul>
      </div>
      <?php endif; ?>

      <div class="generic-content"><?php the_content(); ?></div>
    </div>
    <?php
}
get_footer();
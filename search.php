<?php
get_header();
?>
    <?php 
    university_pageBanner([
      'title' => 'Search Results',
      'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query()) . '&rdquo;'
    ]);
    ?>
    <div class="container container--narrow page-section">
        <?php if (have_posts()): ?>
        <?php while(have_posts()): the_post(); ?>
        <?php get_template_part('template-parts/content', get_post_type()); ?>
         
        <?php endwhile; ?>
        <?php echo paginate_links(); ?>
        <?php else: ?>
            <h2 class="headline headline--small-plus">No results matched</h2>
        <?php endif; ?>
        
        <form class="search-form" method="GET" action="<?php echo esc_url(site_url('/')); ?>" >
            <label class="headline headline--medium" for="s">Perform a New Sarch:</label>
            <div class="search-form-row">
                <input id="s" class="s" type="search" name="s" placeholder="What are you looking for?" />
                <input type="submit" class="search-submit" value="Search" />
            </div>
        </form>
    </div>
  

<?php
get_footer();
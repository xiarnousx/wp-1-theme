<?php
require get_theme_file_path('/inc/search-route.php');

function unversity_custom_rest() {
    register_rest_field('post', 'authorName', [
        'get_callback' => function() {
            return get_the_author();
        }
    ]);
}

add_action('rest_api_init', 'unversity_custom_rest');

function university_files() {
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    wp_enqueue_script('university_main_js', get_theme_file_uri('/build/index.js'), [
        'jquery'
    ], '1.0', true);
    //wp_enqueue_script('university_map_js', '//maps.googleapis.com/maps/api/js?key=AI', NULL, '1.0', true);
    wp_localize_script('university_main_js', 'universityData', [
        'root_url' => get_site_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'university_files');


function university_features() {
    add_theme_support('title-tag');
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', [
            ['key' => 'event_date', 'compare' => '>=', 'value' => $today, 'type'=> 'numeric']
        ]);
    }

    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
    }

    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function university_pageBanner($args = []) {
        if (!isset($args['title'])) {
            $args['title'] = get_the_title();
        }

        if (!isset($args['subtitle'])) {
            $args['subtitle'] = get_field('page_banner_subtitle');
        }

        if (!isset($args['banner'])) {
            $imageBanner = get_field('page_banner_background_image');
            if ($imageBanner && !is_archive() && !is_home()) {
                $args['banner'] = $imageBanner['sizes']['pageBanner'];
            } else {
                $args['banner'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }
    ?>
    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url('<?php echo $args['banner'] ?>')"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>
    </div>
    <?php
}
// Google Map Js
// Google Places
// Google Locations
function university_mapkey($api) {
    $api['key'] = 'AI....';

    return $api;
}
add_filter('acf/fields/google_map/api', 'university_mapkey');

// Redirect subscriber accounts
function university_redirect_subscribers() {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) === 1 && $currentUser->roles[0] === 'subscriber') {
        return wp_redirect(site_url('/'));
    }
}
add_action("admin_init", "university_redirect_subscribers");

function university_hide_admin_bar() {
    $currentUser = wp_get_current_user();
    if (count($currentUser->roles) === 1 && $currentUser->roles[0] === 'subscriber') {
        return show_admin_bar(false);
    }
}
add_action("wp_loaded", "university_hide_admin_bar");


// customize login screen
function university_header_url() {
    return esc_url(site_url('/'));
}

add_filter("login_header_url", "university_header_url");

function university_login_css() {
    wp_enqueue_style('google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}
add_action('login_enqueue_scripts', 'university_login_css');

function university_login_title() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'university_login_title');
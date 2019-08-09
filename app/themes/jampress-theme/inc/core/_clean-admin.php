<?php
/**
 * Disable Emoji Mess
 */
function jamPress_disable_wp_emojicons() {
  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'jamPress_disable_emojicons_tinymce' );
}
add_action( 'init', 'jamPress_disable_wp_emojicons' );

/**
 * Remove TinyMCE emojis, called in disable_wp_emojicons function
 * @return array
 * @see called in disable_wp_emojicons function to disable Emoji Mess
 */
function jamPress_disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

/**
 * Hide WordPress Update Nag to All But Admins
 * @return void
 */
function jamPress_hide_update_notice_to_all_but_admin() {
  if ( ! current_user_can( 'update_core' ) ) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
}
add_action( 'admin_head', 'jamPress_hide_update_notice_to_all_but_admin', 1 );

/**
 * Removes comments from admin menu
 * @return void
 */
function jamPress_my_remove_admin_menus() {
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'jamPress_my_remove_admin_menus' );

/**
 * Removes comments from post and pages
 * @return void
 */
function jamPress_remove_comment_support() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action('init', 'jamPress_remove_comment_support', 100);

/**
 * Removes comments from admin bar
 * @return void
 */
function jamPress_mytheme_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'jamPress_mytheme_admin_bar_render' );

// Custom css
wp_admin_css_color(
  'jamPress',
  __( 'jamPress' ),
  array('#07273E', '#14568A', '#D54E21', '#2683AE'),
  array( 'base' => '#e5f8ff', 'focus' => '#fff', 'current' => '#fff' )
);

function jamPress_change_admin_color($result) {
  return 'jamPress';
}
add_filter('get_user_option_admin_color', 'jamPress_change_admin_color');

/*
* Modify TinyMCE editor to remove H1.
*/
function jamPress_tiny_mce_remove_unused_formats($init) {
  // Add block format elements you want to show in dropdown
  $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Address=address;Préformaté=pre';
  return $init;
}
add_filter('tiny_mce_before_init', 'jamPress_tiny_mce_remove_unused_formats' );

// Remove Gutenberg
add_filter('use_block_editor_for_post', '__return_false');

// Remove dashboard
function jamPress_remove_dashboard_meta() {
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
}

add_action( 'admin_init', 'jamPress_remove_dashboard_meta' );

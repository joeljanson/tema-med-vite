<?php
function remove_post_and_comments_menu_items()
{
	remove_menu_page('edit.php');         // Remove Posts
	remove_menu_page('edit-comments.php'); // Remove Comments
}
add_action('admin_menu', 'remove_post_and_comments_menu_items');

function disable_post_type()
{
	unregister_post_type('post');
}
add_action('init', 'disable_post_type');

function disable_comments_support()
{
	// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		remove_post_type_support($post_type, 'comments');
		remove_post_type_support($post_type, 'trackbacks');
	}
}
add_action('admin_init', 'disable_comments_support');

// Close comments on the front end
function disable_comments_status()
{
	return false;
}
add_filter('comments_open', 'disable_comments_status', 20, 2);
add_filter('pings_open', 'disable_comments_status', 20, 2);

// Hide existing comments
function disable_comments_hide_existing($comments)
{
	return [];
}
add_filter('comments_array', 'disable_comments_hide_existing', 10, 2);

function remove_comments_from_admin_bar($wp_admin_bar)
{
	$wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'remove_comments_from_admin_bar', 999);

function unregister_default_widgets()
{
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
}
add_action('widgets_init', 'unregister_default_widgets');

function disable_posts_and_comments_redirect()
{
	global $pagenow;

	if ($pagenow === 'edit.php' || $pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
}
add_action('admin_init', 'disable_posts_and_comments_redirect');

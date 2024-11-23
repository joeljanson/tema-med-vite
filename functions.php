<?php
function enqueue_vite_assets()
{
	if (defined('WP_ENV') && WP_ENV === 'development') {
		// Under utveckling: Ladda Vite-servern
		echo '<script type="module" src="http://localhost:5173/main.js"></script>';
		wp_enqueue_style('theme-styles', get_template_directory_uri() . '/style.css', [], null);
	} else {
		// I produktion: Ladda från dist
		wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/index.js', [], null, true);
		wp_enqueue_style('vite-styles', get_template_directory_uri() . '/assets/css/index.css', [], null);
		wp_enqueue_style('theme-styles', get_template_directory_uri() . '/style.css', [], null);
	}
}
add_action('wp_enqueue_scripts', 'enqueue_vite_assets');

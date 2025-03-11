<?php
/*
Plugin Name: WPFlix Movies
Description: A plugin to manage movie posts and import data from TheMovieDB.org.
Version: 1.0
Author: Your Name
*/

// Include the required files
require_once plugin_dir_path(__FILE__) . 'includes/wpflix-functions.php';

// Register the custom post type and categories
add_action('init', 'wpflix_register_custom_post_type');
add_action('init', 'wpflix_add_movies_category');

// Add settings page for TMDB API key
add_action('admin_menu', 'wpflix_add_settings_page');
add_action('admin_init', 'wpflix_register_settings');

// Add a menu item to trigger the import
add_action('admin_menu', 'wpflix_add_import_menu_item');

// Rename 'Post' to 'Movies' in the admin menu
add_filter('gettext', 'wpflix_rename_post_to_movies', 10, 3);

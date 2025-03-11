<?php

// Register the custom post type
if (!function_exists('wpflix_register_custom_post_type')) {
    function wpflix_register_custom_post_type() {
        $labels = array(
            'name' => 'Movies',
            'singular_name' => 'Movie',
            'menu_name' => 'Movies',
            'name_admin_bar' => 'Movie',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Movie',
            'new_item' => 'New Movie',
            'edit_item' => 'Edit Movie',
            'view_item' => 'View Movie',
            'all_items' => 'All Movies',
            'search_items' => 'Search Movies',
            'not_found' => 'No movies found.',
            'not_found_in_trash' => 'No movies found in Trash.',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'movie'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor', 'thumbnail'),
        );

        register_post_type('movie', $args);
    }
}

// Add 'Movies' category to default post type
if (!function_exists('wpflix_add_movies_category')) {
    function wpflix_add_movies_category() {
        if (!term_exists('Movies', 'category')) {
            wp_insert_term('Movies', 'category', array(
                'description' => __('Movies category for default posts', 'wpflix'),
                'slug' => 'movies'
            ));
        }
    }
}

// Rename 'Post' to 'Movies' in the admin menu
if (!function_exists('wpflix_rename_post_to_movies')) {
    function wpflix_rename_post_to_movies($translated, $original, $domain) {
        $strings = array(
            'Post' => 'Movie',
            'Posts' => 'Movies',
            'post' => 'movie',
            'posts' => 'movies',
        );

        if (isset($strings[$original])) {
            $translated = $strings[$original];
        }

        return $translated;
    }
}

// Add settings page for TMDB API key
if (!function_exists('wpflix_add_settings_page')) {
    function wpflix_add_settings_page() {
        add_options_page(
            'TMDB Importer Settings',
            'TMDB Importer',
            'manage_options',
            'tmdb-importer',
            'wpflix_render_settings_page'
        );
    }
}

if (!function_exists('wpflix_render_settings_page')) {
    function wpflix_render_settings_page() {
        ?>
        <div class="wrap">
            <h1>TMDB Importer Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('tmdb_importer_settings');
                do_settings_sections('tmdb-importer');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

if (!function_exists('wpflix_register_settings')) {
    function wpflix_register_settings() {
        register_setting('tmdb_importer_settings', 'tmdb_api_key');

        add_settings_section(
            'tmdb_importer_main_section',
            'Main Settings',
            null,
            'tmdb-importer'
        );

        add_settings_field(
            'tmdb_api_key_field',
            'TMDB API Key',
            'wpflix_render_api_key_field',
            'tmdb-importer',
            'tmdb_importer_main_section'
        );
    }
}

if (!function_exists('wpflix_render_api_key_field')) {
    function wpflix_render_api_key_field() {
        $api_key = get_option('tmdb_api_key');
        echo '<input type="text" name="tmdb_api_key" value="' . esc_attr($api_key) . '" />';
    }
}

// Fetch data from TMDB and create custom posts
if (!function_exists('wpflix_import_movies')) {
    function wpflix_import_movies() {
        $api_key = get_option('tmdb_api_key');
        if (!$api_key) {
            return;
        }

        $response = wp_remote_get("https://api.themoviedb.org/3/movie/popular?api_key=$api_key");
        if (is_wp_error($response)) {
            return;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data['results'])) {
            foreach ($data['results'] as $movie) {
                $post_data = array(
                    'post_title' => wp_strip_all_tags($movie['title']),
                    'post_content' => $movie['overview'],
                    'post_status' => 'publish',
                    'post_type' => 'movie',
                );

                $post_id = wp_insert_post($post_data);

                if (!is_wp_error($post_id)) {
                    update_post_meta($post_id, 'tmdb_movie_id', $movie['id']);
                    update_post_meta($post_id, 'tmdb_release_date', $movie['release_date']);

                    if (isset($movie['poster_path'])) {
                        $image_url = 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'];
                        $image_data = file_get_contents($image_url);
                        $filename = basename($image_url);

                        if (wp_mkdir_p(wp_upload_dir()['path'])) {
                            $file = wp_upload_dir()['path'] . '/' . $filename;
                        } else {
                            $file = wp_upload_dir()['basedir'] . '/' . $filename;
                        }

                        file_put_contents($file, $image_data);

                        $wp_filetype = wp_check_filetype($filename, null);
                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title' => sanitize_file_name($filename),
                            'post_content' => '',
                            'post_status' => 'inherit',
                        );

                        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                        wp_update_attachment_metadata($attach_id, $attach_data);
                        set_post_thumbnail($post_id, $attach_id);
                    }
                }
            }
        }
    }
}

// Add a menu item to trigger the import
if (!function_exists('wpflix_add_import_menu_item')) {
    function wpflix_add_import_menu_item() {
        add_submenu_page(
            'edit.php?post_type=movie',
            'Import Movies',
            'Import Movies',
            'manage_options',
            'tmdb-import-movies',
            'wpflix_render_import_page'
        );
    }
}

if (!function_exists('wpflix_render_import_page')) {
    function wpflix_render_import_page() {
        if (isset($_POST['tmdb_import'])) {
            wpflix_import_movies();
            echo '<div class="updated"><p>Movies imported successfully!</p></div>';
        }
        ?>
        <div class="wrap">
            <h1>Import Movies</h1>
            <form method="post">
                <input type="hidden" name="tmdb_import" value="1" />
                <?php submit_button('Import Movies'); ?>
            </form>
        </div>
        <?php
    }
}
?>

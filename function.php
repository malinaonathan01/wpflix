<?php
/**
 * WPFlix Theme Functions
 */

// Add a custom admin menu
function wpflix_add_admin_menu() {
    add_menu_page(
        __('WPFlix Theme Settings', 'wpflix'), // Page title
        __('WPFlix', 'wpflix'), // Menu title
        'manage_options', // Capability
        'wpflix-settings', // Menu slug
        'wpflix_settings_page', // Function to display the page content
        'dashicons-admin-generic', // Icon URL
        3 // Position (near the top of the menu)
    );

    // Add the "Generate Pages" submenu item
    add_theme_page(
        'Generate Pages',           // Page title
        'Generate Pages',           // Menu title
        'manage_options',           // Capability
        'wpflix-generate-pages',    // Menu slug
        'wpflix_generate_pages_page' // Callback function
    );
}
add_action('admin_menu', 'wpflix_add_admin_menu');

// Display content for the custom admin page
function wpflix_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('WPFlix Theme Settings', 'wpflix'); ?></h1>
        <?php if (!wpflix_required_pages_exist()): ?>
            <div class="notice notice-warning">
                <p><?php _e('Please generate the required pages for Movies, TV Series, Episodes, and Blog.'); ?></p>
                <p><a href="<?php echo esc_url(admin_url('themes.php?page=wpflix-generate-pages')); ?>" class="button-primary"><?php _e('Generate Pages'); ?></a></p>
            </div>
        <?php endif; ?>
        <div class="wpflix-settings-container">
            <div class="wpflix-settings-sidebar">
                <ul class="wpflix-settings-nav">
                    <li><a href="#settings"><?php _e('Settings', 'wpflix'); ?></a></li>
                    <li><a href="#home"><?php _e('Home', 'wpflix'); ?></a></li>
                    <li><a href="#seo"><?php _e('SEO', 'wpflix'); ?></a></li>
                    <li><a href="#advertising"><?php _e('Advertising', 'wpflix'); ?></a></li>
                    <li><a href="#backup"><?php _e('Backup', 'wpflix'); ?></a></li>
                </ul>
            </div>
            <div class="wpflix-settings-content">
                <div id="settings" class="wpflix-tab-content">
                    <h2><?php _e('Settings', 'wpflix'); ?></h2>
                    <div class="wpflix-sub-settings-container">
                        <div class="wpflix-sub-settings-nav">
                            <ul>
                                <li><a href="#main-settings"><?php _e('Main Settings', 'wpflix'); ?></a></li>
                                <li><a href="#customize"><?php _e('Customize', 'wpflix'); ?></a></li>
                                <li><a href="#comments"><?php _e('Comments', 'wpflix'); ?></a></li>
                                <li><a href="#links-module"><?php _e('Links Module', 'wpflix'); ?></a></li>
                                <li><a href="#video-player"><?php _e('Video Player', 'wpflix'); ?></a></li>
                                <li><a href="#report-contact"><?php _e('Report and contact', 'wpflix'); ?></a></li>
                            </ul>
                        </div>
                        <div class="wpflix-sub-settings-content">
                            <div id="main-settings" class="wpflix-sub-tab-content">
                                <h3><?php _e('Main Settings', 'wpflix'); ?></h3>
                                <form method="post" action="options.php">
                                    <?php
                                    settings_fields('wpflix_settings_group');
                                    do_settings_sections('wpflix_settings_group');
                                    ?>
                                    <table class="form-table">
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Enable Classic Editor for All Post Types', 'wpflix'); ?></th>
                                            <td><input type="checkbox" name="wpflix_classic_editor_all" value="1" <?php checked(1, get_option('wpflix_classic_editor_all'), true); ?> /></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Items per Page (Movies, TV Series, Episodes)', 'wpflix'); ?></th>
                                            <td><input type="number" name="wpflix_items_per_page" value="<?php echo esc_attr(get_option('wpflix_items_per_page', 10)); ?>" style="width: 60px;" /></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Items per Page (Blog)', 'wpflix'); ?></th>
                                            <td><input type="number" name="wpflix_blog_items_per_page" value="<?php echo esc_attr(get_option('wpflix_blog_items_per_page', 10)); ?>" style="width: 60px;" /></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('View Count Method', 'wpflix'); ?></th>
                                            <td>
                                                <select name="wpflix_view_count_method">
                                                    <option value="regular" <?php selected(get_option('wpflix_view_count_method'), 'regular'); ?>><?php _e('Regular', 'wpflix'); ?></option>
                                                    <option value="ajax" <?php selected(get_option('wpflix_view_count_method'), 'ajax'); ?>><?php _e('Ajax', 'wpflix'); ?></option>
                                                    <option value="disable" <?php selected(get_option('wpflix_view_count_method'), 'disable'); ?>><?php _e('Disable view counting', 'wpflix'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Enable Database Cache', 'wpflix'); ?></th>
                                            <td><input type="checkbox" name="wpflix_enable_db_cache" value="1" <?php checked(1, get_option('wpflix_enable_db_cache'), true); ?> /></td>
                                        </tr>
                                        <tr valign="top">
                                            <th scope="row"><?php _e('Cache Cleaning Schedule', 'wpflix'); ?></th>
                                            <td>
                                                <select name="wpflix_cache_cleaning_schedule">
                                                    <option value="daily" <?php selected(get_option('wpflix_cache_cleaning_schedule'), 'daily'); ?>><?php _e('Daily', 'wpflix'); ?></option>
                                                    <option value="hourly" <?php selected(get_option('wpflix_cache_cleaning_schedule'), 'hourly'); ?>><?php _e('Hourly', 'wpflix'); ?></option>
                                                    <option value="manual" <?php selected(get_option('wpflix_cache_cleaning_schedule'), 'manual'); ?>><?php _e('Manual', 'wpflix'); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php submit_button(); ?>
                                </form>
                            </div>
                            <div id="customize" class="wpflix-sub-tab-content" style="display:none;">
                                <h3><?php _e('Customize', 'wpflix'); ?></h3>
                                <p><?php _e('This is the customize tab content.', 'wpflix'); ?></p>
                            </div>
                            <div id="comments" class="wpflix-sub-tab-content" style="display:none;">
                                <h3><?php _e('Comments', 'wpflix'); ?></h3>
                                <p><?php _e('This is the comments tab content.', 'wpflix'); ?></p>
                            </div>
                            <div id="links-module" class="wpflix-sub-tab-content" style="display:none;">
                                <h3><?php _e('Links Module', 'wpflix'); ?></h3>
                                <p><?php _e('This is the links module tab content.', 'wpflix'); ?></p>
                            </div>
                            <div id="video-player" class="wpflix-sub-tab-content" style="display:none;">
                                <h3><?php _e('Video Player', 'wpflix'); ?></h3>
                                <p><?php _e('This is the video player tab content.', 'wpflix'); ?></p>
                            </div>
                            <div id="report-contact" class="wpflix-sub-tab-content" style="display:none;">
                                <h3><?php _e('Report and contact', 'wpflix'); ?></h3>
                                <p><?php _e('This is the report and contact tab content.', 'wpflix'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="home" class="wpflix-tab-content" style="display:none;">
                    <h2><?php _e('Home', 'wpflix'); ?></h2>
                    <p><?php _e('This is the home tab content.', 'wpflix'); ?></p>
                </div>
                <div id="seo" class="wpflix-tab-content" style="display:none;">
                    <h2><?php _e('SEO', 'wpflix'); ?></h2>
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('wpflix_seo_settings_group');
                        do_settings_sections('wpflix_seo_settings_group');
                        ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php _e('Homepage Title', 'wpflix'); ?></th>
                                <td><input type="text" name="wpflix_homepage_title" value="<?php echo esc_attr(get_option('wpflix_homepage_title')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Homepage Meta Description', 'wpflix'); ?></th>
                                <td><textarea name="wpflix_homepage_meta_description"><?php echo esc_textarea(get_option('wpflix_homepage_meta_description')); ?></textarea></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Default Meta Description', 'wpflix'); ?></th>
                                <td><textarea name="wpflix_default_meta_description"><?php echo esc_textarea(get_option('wpflix_default_meta_description')); ?></textarea></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Default Meta Keywords', 'wpflix'); ?></th>
                                <td><input type="text" name="wpflix_default_meta_keywords" value="<?php echo esc_attr(get_option('wpflix_default_meta_keywords')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Default Open Graph Image URL', 'wpflix'); ?></th>
                                <td><input type="text" name="wpflix_default_og_image" value="<?php echo esc_attr(get_option('wpflix_default_og_image')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Twitter Card Type', 'wpflix'); ?></th>
                                <td>
                                    <select name="wpflix_twitter_card_type">
                                        <option value="summary" <?php selected(get_option('wpflix_twitter_card_type'), 'summary'); ?>><?php _e('Summary', 'wpflix'); ?></option>
                                        <option value="summary_large_image" <?php selected(get_option('wpflix_twitter_card_type'), 'summary_large_image'); ?>><?php _e('Summary Large Image', 'wpflix'); ?></option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <?php submit_button(); ?>
                    </form>
                </div>
                <div id="advertising" class="wpflix-tab-content" style="display:none;">
                    <h2><?php _e('Advertising', 'wpflix'); ?></h2>
                    <p><?php _e('This is the advertising tab content.', 'wpflix'); ?></p>
                </div>
                <div id="backup" class="wpflix-tab-content" style="display:none;">
                    <h2><?php _e('Backup', 'wpflix'); ?></h2>
                    <p><?php _e('This is the backup tab content.', 'wpflix'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <style>
        .wpflix-settings-container {
            display: flex;
        }
        .wpflix-settings-sidebar {
            width: 200px;
            margin-right: 20px;
        }
        .wpflix-settings-nav {
            list-style-type: none;
            padding: 0;
        }
        .wpflix-settings-nav li {
            margin-bottom: 10px;
        }
        .wpflix-settings-nav a {
            text-decoration: none;
            background-color: #0073aa;
            color: white;
            padding: 10px;
            display: block;
            border-radius: 3px;
        }
        .wpflix-settings-nav a:hover {
            background-color: #005177;
        }
        .wpflix-settings-content {
            flex-grow: 1;
        }
        .wpflix-tab-content {
            display: none;
        }
        .wpflix-tab-content.active {
            display: block;
        }
        .wpflix-sub-settings-nav {
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }
        .wpflix-sub-settings-nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 10px;
        }
        .wpflix-sub-settings-nav li {
            margin-bottom: 0;
        }
        .wpflix-sub-settings-nav a {
            text-decoration: none;
            background-color: #005177;
            color: white;
            padding: 10px 15px;
            border-radius: 3px;
        }
        .wpflix-sub-settings-nav a:hover {
            background-color: #003d55;
        }
        .wpflix-sub-settings-content {
            flex-grow: 1;
        }
        .wpflix-sub-tab-content {
            display: none;
        }
        .wpflix-sub-tab-content.active {
            display: block;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".wpflix-settings-nav a");
            const tabContents = document.querySelectorAll(".wpflix-tab-content");

            navLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const targetId = event.target.getAttribute("href").substring(1);

                    tabContents.forEach(content => {
                        content.style.display = "none";
                    });

                    document.getElementById(targetId).style.display = "block";

                    navLinks.forEach(link => {
                        link.classList.remove("active");
                    });

                    event.target.classList.add("active");
                });
            });

            // Show the first tab by default
            navLinks[0].classList.add("active");
            tabContents[0].style.display = "block";

             const subNavLinks = document.querySelectorAll(".wpflix-sub-settings-nav a");
            const subTabContents = document.querySelectorAll(".wpflix-sub-tab-content");

            subNavLinks.forEach(link => {
                link.addEventListener("click", function(event) {
                    event.preventDefault();
                    const targetId = event.target.getAttribute("href").substring(1);

                    subTabContents.forEach(content => {
                        content.style.display = "none";
                    });

                    document.getElementById(targetId).style.display = "block";

                    subNavLinks.forEach(link => {
                        link.classList.remove("active");
                    });

                    event.target.classList.add("active");
                });
            });

            // Show the first sub-tab by default
            subNavLinks[0].classList.add("active");
            subTabContents[0].style.display = "block";
        });
    </script>
    <?php
}

// Register Custom Post Types
function wpflix_register_custom_post_types() {
    // TV Series
    register_post_type('tv_series', array(
        'labels' => array(
            'name' => __('TV Series', 'wpflix'),
            'singular_name' => __('TV Series', 'wpflix'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'tv-series'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'menu_icon' => 'dashicons-format-video', // TV icon
        'menu_position' => 5, // Position below Movies
    ));

    // Episodes (as a hierarchical post type under TV Series)
    register_post_type('episode', array(
        'labels' => array(
            'name' => __('Episodes', 'wpflix'),
            'singular_name' => __('Episode', 'wpflix'),
            'add_new_item' => __('Add New Episode', 'wpflix'),
            'edit_item' => __('Edit Episode', 'wpflix'),
            'new_item' => __('New Episode', 'wpflix'),
            'view_item' => __('View Episode', 'wpflix'),
            'search_items' => __('Search Episodes', 'wpflix'),
            'not_found' => __('No Episodes found', 'wpflix'),
            'not_found_in_trash' => __('No Episodes found in Trash', 'wpflix'),
            'all_items' => __('All Episodes', 'wpflix'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'episodes'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_menu' => 'edit.php?post_type=tv_series', // Make it a sub-menu of TV Series
        'hierarchical' => true, // Make it hierarchical
    ));

    // Blog
    register_post_type('blog', array(
        'labels' => array(
            'name' => __('Blog', 'wpflix'),
            'singular_name' => __('Blog Post', 'wpflix'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'blog'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'menu_position' => 6, // Position below TV Series
    ));
}
add_action('init', 'wpflix_register_custom_post_types');

// Add 'Movies' category to default post type
function wpflix_add_movies_category() {
    if (!term_exists('Movies', 'category')) {
        wp_insert_term('Movies', 'category', array(
            'description' => __('Movies category for default posts', 'wpflix'),
            'slug' => 'movies'
        ));
    }
}
add_action('init', 'wpflix_add_movies_category');

// Rename 'Post' to 'Movies' in the admin menu
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
add_filter('gettext', 'wpflix_rename_post_to_movies', 10, 3);

function wpflix_rename_post_labels() {
    global $wp_post_types;

    if (isset($wp_post_types['post'])) {
        $wp_post_types['post']->labels->name = 'Movies';
        $wp_post_types['post']->labels->singular_name = 'Movie';
        $wp_post_types['post']->labels->add_new = 'Add New Movie';
        $wp_post_types['post']->labels->add_new_item = 'Add New Movie';
        $wp_post_types['post']->labels->edit_item = 'Edit Movie';
        $wp_post_types['post']->labels->new_item = 'New Movie';
        $wp_post_types['post']->labels->view_item = 'View Movie';
        $wp_post_types['post']->labels->search_items = 'Search Movies';
        $wp_post_types['post']->labels->not_found = 'No Movies found';
        $wp_post_types['post']->labels->not_found_in_trash = 'No Movies found in Trash';
        $wp_post_types['post']->labels->all_items = 'All Movies';
        $wp_post_types['post']->menu_name = 'Movies';
        $wp_post_types['post']->labels->name_admin_bar = 'Movies';
        $wp_post_types['post']->menu_icon = 'dashicons-editor-video'; // Movie icon
    }
}
add_action('init', 'wpflix_rename_post_labels');

// Enable/disable Classic Editor based on settings
function wpflix_enable_classic_editor($use_block_editor, $post_type) {
    if (get_option('wpflix_classic_editor_all')) {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'wpflix_enable_classic_editor', 10, 2);

// Register settings
function wpflix_register_settings() {
    register_setting('wpflix_settings_group', 'wpflix_classic_editor_all');
    register_setting('wpflix_settings_group', 'wpflix_items_per_page');
    register_setting('wpflix_settings_group', 'wpflix_blog_items_per_page');
    register_setting('wpflix_settings_group', 'wpflix_view_count_method');
    //register_setting('wpflix_settings_group', 'wpflix_enable_db_cache'); //remove from here
    //register_setting('wpflix_settings_group', 'wpflix_cache_cleaning_schedule'); //remove from here

    // Add default value for view count method
    add_option( 'wpflix_view_count_method', 'regular' );
    //add_option('wpflix_enable_db_cache', 0); // Default to disabled //remove from here
    //add_option('wpflix_cache_cleaning_schedule', 'daily'); // Default to daily //remove from here

    register_setting('wpflix_seo_settings_group', 'wpflix_homepage_title');
    register_setting('wpflix_seo_settings_group', 'wpflix_homepage_meta_description');
    register_setting('wpflix_seo_settings_group', 'wpflix_default_meta_description');
    register_setting('wpflix_seo_settings_group', 'wpflix_default_meta_keywords');
    register_setting('wpflix_seo_settings_group', 'wpflix_default_og_image');
    register_setting('wpflix_seo_settings_group', 'wpflix_twitter_card_type');
    register_setting('wpflix_seo_settings_group', 'wpflix_seo_author');
    register_setting('wpflix_seo_settings_group', 'wpflix_seo_canonical_url');
    register_setting('wpflix_seo_settings_group', 'wpflix_seo_robots');
}
add_action('admin_init', 'wpflix_register_settings');

// Display settings update notification
function wpflix_admin_notices() {
    if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
        echo '<div class="notice notice-success is-dismissible">
            <p>' . __('Settings updated successfully.', 'wpflix') . '</p>
        </div>';
    }
}
add_action('admin_notices', 'wpflix_admin_notices');

// Check if required pages exist
function wpflix_required_pages_exist() {
    $required_pages = array(
        'movies-archive', 
        'tvseries-archive', 
        'episodes-archive', 
        'blog-archive',
        'account-archive',
        'contact-archive',
        'ratings-archive',
        'requests-archive',
        'top-imdb-archive',
        'trending-archive'
    );
    foreach ($required_pages as $slug) {
        if (!get_page_by_path($slug)) {
            return false;
        }
    }
    return true;
}

// Handle page generation
function wpflix_generate_pages() {
    // Create Movies Page
    if (!get_page_by_path('movies-archive')) {
        wp_insert_post(array(
            'post_title' => 'Movies',
            'post_name' => 'movies-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/movies-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create TV Series Page
    if (!get_page_by_path('tvseries-archive')) {
        wp_insert_post(array(
            'post_title' => 'TV Series',
            'post_name' => 'tvseries-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/tvseries-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Episodes Page
    if (!get_page_by_path('episodes-archive')) {
        wp_insert_post(array(
            'post_title' => 'Episodes',
            'post_name' => 'episodes-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/episodes-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Blog Page
    if (!get_page_by_path('blog-archive')) {
        wp_insert_post(array(
            'post_title' => 'Blog',
            'post_name' => 'blog-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/blog-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Account Page
    if (!get_page_by_path('account-archive')) {
        wp_insert_post(array(
            'post_title' => 'Account',
            'post_name' => 'account-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/account-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Contact Page
    if (!get_page_by_path('contact-archive')) {
        wp_insert_post(array(
            'post_title' => 'Contact',
            'post_name' => 'contact-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/contact-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Ratings Page
    if (!get_page_by_path('ratings-archive')) {
        wp_insert_post(array(
            'post_title' => 'Ratings',
            'post_name' => 'ratings-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/ratings-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Requests Page
    if (!get_page_by_path('requests-archive')) {
        wp_insert_post(array(
            'post_title' => 'Requests',
            'post_name' => 'requests-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/requests-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create TOP IMdb Page
    if (!get_page_by_path('top-imdb-archive')) {
        wp_insert_post(array(
            'post_title' => 'TOP IMdb',
            'post_name' => 'top-imdb-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/top-imdb-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Create Trending Page
    if (!get_page_by_path('trending-archive')) {
        wp_insert_post(array(
            'post_title' => 'Trending',
            'post_name' => 'trending-archive',
            'post_type' => 'page',
            'page_template' => 'page-templates/trending-archive.php',
            'post_status' => 'publish'
        ));
    }

    // Redirect to WPFlix Theme Settings page
    wp_safe_redirect(admin_url('admin.php?page=wpflix-settings'));
    exit;
}

// Callback function for the "Generate Pages" menu
function wpflix_generate_pages_page() {
    wpflix_generate_pages(); // Call the page generation function
}
// Modify the query to use the items per page setting
function wpflix_adjust_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_home() && !is_front_page()) {
            $query->set('post_type', array('post', 'tv_series', 'episode'));
        }
        if (is_post_type_archive(array('tv_series', 'episode')) || ( $query->is_category() && $query->get('category_name') == 'movies' )) {
            $query->set('posts_per_page', get_option('wpflix_items_per_page', 10));
        } elseif ($query->is_post_type_archive('blog') || $query->is_home() || $query->is_category() || is_archive()) {
            $query->set('posts_per_page', get_option('wpflix_blog_items_per_page', 10));
        }
    }
}
add_action('pre_get_posts', 'wpflix_adjust_posts_per_page');

/**
 * View Count Functionality
 */
// Function to update view count
function wpflix_set_post_view() {
    $view_count_method = get_option('wpflix_view_count_method', 'regular');
    if ($view_count_method == 'disable') {
        return;
    }

    if (is_singular( array('post', 'tv_series', 'episode') )) { // Only track views for these post types
        global $post;
        $post_id = $post->ID;

        if ($view_count_method == 'regular') {
            wpflix_update_view_count($post_id);
        } elseif ($view_count_method == 'ajax') {
            // Enqueue AJAX script
            wp_enqueue_script('wpflix-view-count', get_template_directory_uri() . '/js/view-count.js', array('jquery'), null, true);
            wp_localize_script('wpflix-view-count', 'wpflix_ajax', array('ajax_url' => admin_url('admin-ajax.php'), 'post_id' => $post_id));
        }
    }
}
add_action('wp_head', 'wpflix_set_post_view');

// Function to handle AJAX view count update
add_action('wp_ajax_wpflix_update_view_count', 'wpflix_update_view_count_callback');
add_action('wp_ajax_nopriv_wpflix_update_view_count', 'wpflix_update_view_count_callback');

function wpflix_update_view_count_callback() {
    $post_id = intval($_POST['post_id']);
    wpflix_update_view_count($post_id);
    wp_die(); // Required to terminate immediately and return a proper response
}

// Core function to update view count
function wpflix_update_view_count($post_id) {
    $count_key = 'wpflix_post_views_count';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '1');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

// Function to get view count
function wpflix_get_post_view_count($post_id) {
    $count_key = 'wpflix_post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}

/**
 *  Add view count to the end of post content
 */
function wpflix_add_view_count_to_content( $content ) {
    if (is_singular( array('post', 'tv_series', 'episode') )) { // Only display view count for these post types
        global $post;
        $post_id = $post->ID;
        $view_count = wpflix_get_post_view_count($post_id);
        $content .= '<p class="view-count">'.__('Views: ', 'wpflix'). $view_count . '</p>';
    }
    return $content;
}
add_filter('the_content', 'wpflix_add_view_count_to_content');

/**
 * Pagination range function
 */
function wpflix_pagination_range() {
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages <= 1) return false;

    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

    $pagination_args = array(
        'total'        => $total_pages,
        'current'      => $paged,
        'show_all'     => false,
        'mid_size'     => 2,
        'prev_next'    => true,
        'prev_text'    => __('&laquo; Previous'),
        'next_text'    => __('Next &raquo;'),
        'type'         => 'list',
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'wpflix') . ' </span>',
    );

    return '<nav class="wpflix-pagination">' . paginate_links($pagination_args) . '</nav>';
}

/**
 * Enqueue styles
 */
function wpflix_enqueue_styles() {
    // Enqueue your custom CSS file
    wp_enqueue_style( 'wpflix-custom-style', get_template_directory_uri() . '/assets/main.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'wpflix_enqueue_styles' );
add_action('wp_head', 'wpflix_set_post_view');

/**
 * Database Cache Functionality
 */
// Function to check if database cache is enabled
function wpflix_is_db_cache_enabled() {
    return get_option('wpflix_enable_db_cache', 0);
}

// Function to get cache cleaning schedule
function wpflix_get_cache_cleaning_schedule() {
    return get_option('wpflix_cache_cleaning_schedule', 'daily');
}

// Function to clear database cache
function wpflix_clear_db_cache() {
    global $wpdb;

    // Delete all cached data
    $wpdb->query("DELETE FROM wp_options WHERE option_name LIKE '_transient_wpflix_%'");
    $wpdb->query("DELETE FROM wp_options WHERE option_name LIKE '_transient_timeout_wpflix_%'");

    // Add a notice to inform the user that the cache has been cleared
    add_action('admin_notices', 'wpflix_cache_cleared_notice');
}

// Function to display cache cleared notice
function wpflix_cache_cleared_notice() {
    ?>
    <div class="notice notice-success is_dismissible">
        <p><?php _e('WPFlix database cache cleared successfully!', 'wpflix'); ?></p>
    </div>
    <?php
}

// Function to schedule cache cleaning
function wpflix_schedule_cache_cleaning() {
    $schedule = wpflix_get_cache_cleaning_schedule();

    if ($schedule == 'daily' && !wp_next_scheduled('wpflix_daily_cache_cleaning')) {
        wp_schedule_event(time(), 'daily', 'wpflix_daily_cache_cleaning');
    } elseif ($schedule == 'hourly' && !wp_next_scheduled('wpflix_hourly_cache_cleaning')) {
        wp_schedule_event(time(), 'hourly', 'wpflix_hourly_cache_cleaning');
    }
    // If the schedule is manual, ensure no events are scheduled
    elseif ($schedule == 'manual') {
        wp_clear_scheduled_hook('wpflix_daily_cache_cleaning');
        wp_clear_scheduled_hook('wpflix_hourly_cache_cleaning');
    }
}
add_action('wp', 'wpflix_schedule_cache_cleaning');

// Function to perform daily cache cleaning
function wpflix_daily_cache_cleaning() {
    wpflix_clear_db_cache();
}
add_action('wpflix_daily_cache_cleaning', 'wpflix_daily_cache_cleaning');

// Function to perform hourly cache cleaning
function wpflix_hourly_cache_cleaning() {
    wpflix_clear_db_cache();
}
add_action('wpflix_hourly_cache_cleaning', 'wpflix_hourly_cache_cleaning');

// Function to add a button to manually clear the cache
function wpflix_add_clear_cache_button() {
    add_submenu_page(
        'wpflix-settings', // Parent menu slug
        __('Clear Cache', 'wpflix'), // Page title
        __('Clear Cache', 'wpflix'), // Menu title
        'manage_options', // Capability
        'wpflix-clear-cache', // Menu slug
        'wpflix_clear_cache_page' // Callback function
    );
}
add_action('admin_menu', 'wpflix_add_clear_cache_button');

function wpflix_clear_cache_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('WPFlix Clear Cache', 'wpflix'); ?></h1>
        <form method="post">
            <input type="hidden" name="wpflix_clear_cache" value="1">
            <?php submit_button(__('Clear Database Cache', 'wpflix')); ?>
        </form>
    </div>
    <?php

    if (isset($_POST['wpflix_clear_cache']) && $_POST['wpflix_clear_cache'] == 1) {
        wpflix_clear_db_cache();
    }
}

// Register cache settings
function wpflix_register_cache_settings() {
    register_setting('wpflix_settings_group', 'wpflix_enable_db_cache');
    register_setting('wpflix_settings_group', 'wpflix_cache_cleaning_schedule');

    // Add default values
    add_option('wpflix_enable_db_cache', 0); // Default to disabled
    add_option('wpflix_cache_cleaning_schedule', 'daily'); // Default to daily
}
add_action('admin_init', 'wpflix_register_cache_settings');

// Register Genre Taxonomy
function wpflix_register_genre_taxonomy() {
    $labels = array(
        'name'              => _x('Genres', 'taxonomy general name', 'wpflix'),
        'singular_name'     => _x('Genre', 'taxonomy singular name', 'wpflix'),
        'search_items'      => __('Search Genres', 'wpflix'),
        'all_items'         => __('All Genres', 'wpflix'),
        'parent_item'       => __('Parent Genre', 'wpflix'),
        'parent_item_colon' => __('Parent Genre:', 'wpflix'),
        'edit_item'         => __('Edit Genre', 'wpflix'),
        'update_item'       => __('Update Genre', 'wpflix'),
        'add_new_item'      => __('Add New Genre', 'wpflix'),
        'new_item_name'     => __('New Genre Name', 'wpflix'),
        'menu_name'         => __('Genre', 'wpflix'),
    );

    $args = array(
        'hierarchical'      => true, // Makes it like categories
        'labels'            => $labels,
        'show_ui'          => true,
        'show_admin_column' => true,
        'query_var'        => true,
        'rewrite'          => array('slug' => 'genre'),
        'show_in_rest'     => true, // Adds Gutenberg support
    );

    // Register the taxonomy for posts (movies), tv_series, and episodes
    register_taxonomy('genre', array('post', 'tv_series', 'episode'), $args);
}
add_action('init', 'wpflix_register_genre_taxonomy');

// Register Year Taxonomy
function wpflix_register_year_taxonomy() {
    $labels = array(
        'name'              => _x('Years', 'taxonomy general name', 'wpflix'),
        'singular_name'     => _x('Year', 'taxonomy singular name', 'wpflix'),
        'search_items'      => __('Search Years', 'wpflix'),
        'all_items'         => __('All Years', 'wpflix'),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => __('Edit Year', 'wpflix'),
        'update_item'       => __('Update Year', 'wpflix'),
        'add_new_item'      => __('Add New Year', 'wpflix'),
        'new_item_name'     => __('New Year', 'wpflix'),
        'menu_name'         => __('Year', 'wpflix'),
    );

    $args = array(
        'hierarchical'      => false, // Set to false since years don't need hierarchy
        'labels'            => $labels,
        'show_ui'          => true,
        'show_admin_column' => true,
        'query_var'        => true,
        'rewrite'          => array('slug' => 'year'),
        'show_in_rest'     => true, // Adds Gutenberg support
    );

    // Register the taxonomy for posts (movies), tv_series, and episodes
    register_taxonomy('year', array('post', 'tv_series', 'episode'), $args);
}
add_action('init', 'wpflix_register_year_taxonomy');

// Sort years in descending order in admin and frontend
function wpflix_sort_year_terms($terms, $taxonomies, $args) {
    if (is_admin() && in_array('year', $taxonomies)) {
        usort($terms, function($a, $b) {
            return strcmp($b->name, $a->name);
        });
    }
    return $terms;
}
add_filter('get_terms', 'wpflix_sort_year_terms', 10, 3);

// Add validation to ensure only valid years are added
function wpflix_validate_year_term($term, $taxonomy) {
    if ($taxonomy === 'year') {
        // Check if the term name is a valid year
        if (!is_numeric($term) || strlen($term) !== 4) {
            return new WP_Error(
                'invalid_year',
                __('Please enter a valid 4-digit year.', 'wpflix')
            );
        }
    }
    return $term;
}
add_filter('pre_insert_term', 'wpflix_validate_year_term', 10, 2);

// Register Quality Taxonomy
function wpflix_register_quality_taxonomy() {
    $labels = array(
        'name'              => _x('Qualities', 'taxonomy general name', 'wpflix'),
        'singular_name'     => _x('Quality', 'taxonomy singular name', 'wpflix'),
        'search_items'      => __('Search Qualities', 'wpflix'),
        'all_items'         => __('All Qualities', 'wpflix'),
        'parent_item'       => __('Parent Quality', 'wpflix'),
        'parent_item_colon' => __('Parent Quality:', 'wpflix'),
        'edit_item'         => __('Edit Quality', 'wpflix'),
        'update_item'       => __('Update Quality', 'wpflix'),
        'add_new_item'      => __('Add New Quality', 'wpflix'),
        'new_item_name'     => __('New Quality Name', 'wpflix'),
        'menu_name'         => __('Quality', 'wpflix'),
    );

    $args = array(
        'hierarchical'      => true, // Makes it like categories
        'labels'            => $labels,
        'show_ui'          => true,
        'show_admin_column' => true,
        'query_var'        => true,
        'rewrite'          => array('slug' => 'quality'),
        'show_in_rest'     => true, // Adds Gutenberg support
    );

    // Register the taxonomy for posts (movies), tv_series, and episodes
    register_taxonomy('quality', array('post', 'tv_series', 'episode'), $args);
}
add_action('init', 'wpflix_register_quality_taxonomy');

// Register Cast Taxonomy
function wpflix_register_cast_taxonomy() {
    $labels = array(
        'name'                       => _x('Cast', 'taxonomy general name', 'wpflix'),
        'singular_name'              => _x('Cast', 'taxonomy singular name', 'wpflix'),
        'search_items'               => __('Search Cast', 'wpflix'),
        'popular_items'              => __('Popular Cast', 'wpflix'),
        'all_items'                  => __('All Cast', 'wpflix'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Cast', 'wpflix'),
        'update_item'                => __('Update Cast', 'wpflix'),
        'add_new_item'               => __('Add New Cast', 'wpflix'),
        'new_item_name'              => __('New Cast Name', 'wpflix'),
        'separate_items_with_commas' => __('Separate cast members with commas', 'wpflix'),
        'add_or_remove_items'        => __('Add or remove cast members', 'wpflix'),
        'choose_from_most_used'      => __('Choose from the most used cast members', 'wpflix'),
        'menu_name'                  => __('Cast', 'wpflix'),
    );

    $args = array(
        'hierarchical'          => false, // Set to false to make it like tags
        'labels'               => $labels,
        'show_ui'              => true,
        'show_admin_column'    => true,
        'query_var'            => true,
        'rewrite'              => array('slug' => 'cast'),
        'show_in_rest'         => true, // Adds Gutenberg support
        'show_in_quick_edit'   => true,
        'show_in_nav_menus'    => true,
        'sort'                 => true,
    );

    // Register the taxonomy for posts (movies), tv_series, and episodes
    register_taxonomy('cast', array('post', 'tv_series', 'episode'), $args);
}
add_action('init', 'wpflix_register_cast_taxonomy');

// Register Director Taxonomy
function wpflix_register_director_taxonomy() {
    $labels = array(
        'name'                       => _x('Directors', 'taxonomy general name', 'wpflix'),
        'singular_name'              => _x('Director', 'taxonomy singular name', 'wpflix'),
        'search_items'               => __('Search Directors', 'wpflix'),
        'popular_items'              => __('Popular Directors', 'wpflix'),
        'all_items'                  => __('All Directors', 'wpflix'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Director', 'wpflix'),
        'update_item'                => __('Update Director', 'wpflix'),
        'add_new_item'               => __('Add New Director', 'wpflix'),
        'new_item_name'              => __('New Director Name', 'wpflix'),
        'separate_items_with_commas' => __('Separate directors with commas', 'wpflix'),
        'add_or_remove_items'        => __('Add or remove directors', 'wpflix'),
        'choose_from_most_used'      => __('Choose from the most used directors', 'wpflix'),
        'menu_name'                  => __('Director', 'wpflix'),
    );

    $args = array(
        'hierarchical'          => false, // Set to false to make it like tags
        'labels'               => $labels,
        'show_ui'              => true,
        'show_admin_column'    => true,
        'query_var'            => true,
        'rewrite'              => array('slug' => 'director'),
        'show_in_rest'         => true, // Adds Gutenberg support
        'show_in_quick_edit'   => true,
        'show_in_nav_menus'    => true,
        'sort'                 => true,
    );

    // Register the taxonomy for posts (movies), tv_series, and episodes
    register_taxonomy('director', array('post', 'tv_series', 'episode'), $args);
}
add_action('init', 'wpflix_register_director_taxonomy');
?>

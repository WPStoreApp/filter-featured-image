<?php
/**
 * Plugin Name: Filter Featured Image
 * Plugin URI:        https: //wpstore.app
 * Description:       Filter Featured Image can help you filter you post with or without featured image.
 * Version:           0.0.1
 * Requires at least: 5,9
 * Requires PHP:      7.2
 * Author:            Bestony
 * Author URI:        https://www.ixiqin.com
 * License:           GPL v3
 * License URI:       https: //www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       filter-featured-image
 * Domain Path:       /languages

 */
class WPStoreApp_FilterFeaturedImage
{
    public function init()
    {
        add_action('restrict_manage_posts', [$this, 'admin_posts_filter_restrict_manage_posts']);
        add_filter('parse_query', [$this, 'posts_filter']);
    }
    public function admin_posts_filter_restrict_manage_posts()
    {
        ?>
            <select name="featured_image_field" id="featured_image_field">
                <option value="0">Show All Posts</option>
                <option value="1">Show Post With Featured Image</option>
                <option value="2">Show Post Without Featured Image</option>
            </select>
        <?php
}
    public function posts_filter($query)
    {
        global $pagenow;
        if (is_admin() && $pagenow == 'edit.php' && isset($_GET['featured_image_field']) && $_GET['featured_image_field'] != '') {
            if ($_GET['featured_image_field'] == 0) {
                return $query;
            }
            if ($_GET['featured_image_field'] == 1) {
                $query->query_vars['meta_key'] = '_thumbnail_id';
                $query->query_vars['meta_compare'] = 'EXISTS';
            }
            if ($_GET['featured_image_field'] == 2) {
                $query->query_vars['meta_key'] = '_thumbnail_id';
                $query->query_vars['meta_compare'] = 'NOT EXISTS';
            }
        }

    }
}
$plugin = new WPStoreApp_FilterFeaturedImage();
$plugin->init();
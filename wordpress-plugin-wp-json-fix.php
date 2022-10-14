<?php

/**
 * Plugin Name: PC Patrol Exclude plugins
 * Description: Exclude plugins from ajax requests
 * Author: PC Patrol
 * Version: 1.0
 * Author URI: https://pcpatrol.nl
 */

add_filter( 'option_active_plugins', 'hfm_exclude_plugins' );

function hfm_exclude_plugins( $plugins ) {
    /**
     * If we're not performing our AJAX request, return early.
     */
    if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX || ! isset( $_REQUEST['action'] ) || 'benchmark_request' !== $_REQUEST['action'] ) {
     return $plugins;
    }
    /**
     * The list of plugins to exclude. Flip the array to make the check that happens later possible
     */
    $denylist_plugins = array_flip(
     array(
         'advanced-custom-fields-pro/acf.php',
         'advanced-forms/advanced-forms.php',
         'classic-editor/classic-editor.php',
         'wp-db-backup/wp-db-backup.php',
         'ewww-image-optimizer/ewww-image-optimizer.php',
         'limit-login-attempts-reloaded/limit-login-attempts-reloaded.php',
         'simple-custom-post-order/simple-custom-post-order.php',
         'theme-switcha/theme-switcha.php',
         'woocommerce/woocommerce.php',
         'wordpress-importer/wordpress-importer.php',
         'wp-mail-log/wp-mail-log.php',
         'amazon-s3-and-cloudfront/wordpress-s3.php',
         'wp-offload-ses/wp-offload-ses.php',
         'wppusher/wppusher.php'
     )
    );
    /**
     * Loop through the active plugins, if it's not in the deny list, allow the plugin to be loaded
     * Otherwise, remove it from the list of plugins to load
     */
    foreach ( $plugins as $key => $plugin ) {
     if ( ! isset( $denylist_plugins[ $plugin ] ) ) {
         continue;
     }
     unset( $plugins[ $key ] );
    }

    return $plugins;
}


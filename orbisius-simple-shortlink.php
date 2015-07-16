<?php
/*
  Plugin Name: Orbisius Simple Shortlink
  Plugin URI:  http://club.orbisius.com/products/
  Description: Simple redirect to a post, page or a custom post type.
  Version:     1.0.0
  Author:      Slavi Marinov | Orbisius
  Author URI:  http://orbisius.com
  Text Domain: my_cool_plugin
  Domain Path: /lang
 */

add_action('init', 'orb_club_short_link');

/**
 * This is supposed to set page not found page in case the ID is not valid or post doesn't exist or is not published.
 * @global type $wp_query
 * @see http://wordpress.stackexchange.com/questions/73738/how-do-i-programmatically-generate-a-404
 */
function orb_club_short_link_set_404() {
    global $wp_query;
    
    if ( !empty($wp_query) ) {
        $wp_query->set_404();
        $wp_query->max_num_pages = 0;
    }
}

/**
 * Parses the REQUEST URL for a known variable.
 * The site must be using permalinks.
 */
function orb_club_short_link() {
    if (preg_match('#^/?(?:goto|link|post|page)/(\d+)#si', $_SERVER['REQUEST_URI'], $m)) {
        $id = $m[1];
        $r = get_permalink($id);

        if (empty($r)) {
            add_action('wp', 'orb_club_short_link_set_404');
        } else {
            wp_redirect($r);
            exit;
        }
    }
}

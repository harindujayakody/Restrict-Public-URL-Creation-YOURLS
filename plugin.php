<?php
/*
Plugin Name: Restrict Public URL Creation
Plugin URI: https://yourls.org/
Description: Restricts URL creation to logged-in users only.
Version: 1.0
Author: Harindu Jayakody
Author URI: https://ekathuwa.org/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Hook into the "pre_check_shorturl" event to check user login status
yourls_add_action( 'pre_check_shorturl', 'restrict_public_url_creation' );
function restrict_public_url_creation( $args ) {
    // Check if the user is logged in
    if( yourls_is_valid_user() ) {
        // User is logged in, allow URL creation
        return;
    } else {
        // User is not logged in, restrict URL creation
        yourls_redirect( yourls_admin_url( 'index.php' ) . '?failed_login=1' );
        die();
    }
}

// Disable public interface for URL creation
yourls_add_filter( 'add_new_link', 'disable_public_link_creation' );
function disable_public_link_creation() {
    return false;
}
?>

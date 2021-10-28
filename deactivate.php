<?php

/**
 * Deactivation hook.
 */

 function agfr_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type( 'agfReport' );
    // Clear the permalinks to remove our post type's rules from the database.        
    flush_rewrite_rules();
}

// This hook is called when the deactivate button on this plugin is clicked.
register_deactivation_hook( __FILE__, 'agfr_deactivate' );

<?php

/**
 * Deactivation hook.
 */

 function agf_deactivate() {
    // Unregister the post type, so the rules are no longer in memory.
    unregister_post_type( 'agfreport' );
    // Clear the permalinks to remove our post type's rules from the database.        
    flush_rewrite_rules();
}

// This hook is called when the deactivate button on this plugin is clicked.
register_deactivation_hook( __FILE__, 'agf_deactivate' );
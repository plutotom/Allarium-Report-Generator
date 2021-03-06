<?php
// META BOX HINT
function agf_render_short_code_hint($post)
{
    global $post;

    // include self::$metaboxes_dir . 'views/shortcode-hint.php';
?>
    <div class="misc-pub-section gv-shortcode misc-pub-section-last">
        <i class="dashicons dashicons-editor-code"></i>
        <span><?php esc_html_e('Embed Shortcode', 'gravityview'); ?></span>
        <div>
            <!-- <input type="text" readonly="readonly" value="[agfGraph id=<?php echo $post->ID; ?>]" class="code widefat" /> -->
            <input type="text" readonly="readonly" value="[allarium_table id=<?php echo $post->ID; ?>]" class="code widefat" />
            <input type="text" readonly="readonly" value="[allarium_table current=true id=<?php echo $post->ID; ?>]" class="code widefat" />
            <input type="text" readonly="readonly" value="[allarium_table entry_id={enter id} id=<?php echo $post->ID; ?>]" class="code widefat" />
            <input type="text" readonly="readonly" value="[allarium_score_print_v2 id=<?php echo $post->ID; ?> entry_id=317]" class="code widefat" />
            <input type="text" readonly="readonly" value="[allarium_graph_average id=<?php echo $post->ID; ?>]" class="code widefat" />
            <span class="howto"><?php esc_html_e('Add this shortcode to a post or page to embed this view.', 'gravityview'); ?></span>
        </div>
    </div>
<?php
}

?>
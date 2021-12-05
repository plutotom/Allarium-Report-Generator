<?php


function agf_render_list_form_metabox()
{
    // Use nonce for verification
    wp_nonce_field('agf_select_form', 'agf_select_form_nonce');

    // get currently selected forms
    $current_form_id = get_post_meta($post->ID, 'selected_form_id', true);

    $current_selected_forms = get_post_meta($post->ID, 'selected_forms', true);

    // check for available gravity forms
    $forms = GFAPI::get_forms(null, "title");


?>
    <label for="agf_form_id"><?php esc_html_e('Where would you like the data to come from for this View?', 'agf'); ?></label>

    <p>
        <?php

        // If there are no forms to select, show no forms.
        if (!empty($forms)) { ?>
            <select name="agf_form_id" id="agf_form_id">
                <option value="" <?php selected('', $current_selected_forms, true); ?>>&mdash; <?php esc_html_e('list of forms', 'agf'); ?> &mdash;</option>
                <?php foreach ($forms as $form) { ?>
                    <option value="<?php echo $form['id']; ?>" <?php selected($form['id'], $current_selected_forms, true); ?>><?php echo esc_html($form['title']); ?></option>
                <?php } ?>
            </select>
        <?php } else { ?>
            <select name="agf_form_id" id="agf_form_id" class="hidden">
                <option selected="selected" value=""></option>
            </select>
        <?php } ?>

        &nbsp;<button class="button button-primary" <?php if (empty($current_selected_forms)) {
                                                        echo 'style="display:none;"';
                                                    } ?> id="gv_switch_view_button" title="<?php esc_attr_e('Switch View', 'agf'); ?>"><?php esc_html_e('Switch View Type', 'agf'); ?></button>
    </p>

    <!-- <input type="hidden" id="agf_form_id_start_fresh" name="agf_form_id_start_fresh" value="0" /> -->

<?php

}

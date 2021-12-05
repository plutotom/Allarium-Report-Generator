<?php

// Use nonce for verification
wp_nonce_field('gravityview_select_form', 'gravityview_select_form_nonce');

// get currently selected forms
$current_form_id = get_post_meta($post->ID, 'selected_form_id', true);

// check for available gravity forms
$forms = GFAPI::get_forms(null, "title");


?>
<label for="gravityview_form_id"><?php esc_html_e('Where would you like the data to come from for this View?', 'gravityview'); ?></label>

<p>
    <?php

    // If there are no forms to select, show no forms.
    if (!empty($forms)) { ?>
        <select name="gravityview_form_id" id="gravityview_form_id">
            <option value="" <?php selected('', $current_form, true); ?>>&mdash; <?php esc_html_e('list of forms', 'gravityview'); ?> &mdash;</option>
            <?php foreach ($forms as $form) { ?>
                <option value="<?php echo $form['id']; ?>" <?php selected($form['id'], $current_form, true); ?>><?php echo esc_html($form['title']); ?></option>
            <?php } ?>
        </select>
    <?php } else { ?>
        <select name="gravityview_form_id" id="gravityview_form_id" class="hidden">
            <option selected="selected" value=""></option>
        </select>
    <?php } ?>

    &nbsp;<button class="button button-primary" <?php if (empty($current_form)) {
                                                    echo 'style="display:none;"';
                                                } ?> id="gv_switch_view_button" title="<?php esc_attr_e('Switch View', 'gravityview'); ?>"><?php esc_html_e('Switch View Type', 'gravityview'); ?></button>
</p>

<?php
// hidden field to keep track of start fresh state 
?>
<input type="hidden" id="gravityview_form_id_start_fresh" name="gravityview_form_id_start_fresh" value="0" />

<?php

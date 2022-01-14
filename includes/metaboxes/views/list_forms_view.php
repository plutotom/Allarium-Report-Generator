<?php


function agf_render_list_form_metabox($post){
    // Use nonce for verification
    wp_nonce_field('agf_multi_select_form_nonce_action', 'agf_select_form_nonce');
    $helper = new Agf_helper_Class;
    
    // get post meta data
    $post_meta = get_post_meta($post->ID);

    // Gets all active forms.
    $forms = GFAPI::get_forms(null, "title");

    foreach($forms as $form){
        $form_id = $form["id"];
        $entries[$form_id] = GFAPI::get_entries($form_id);
    }

    // get the list of selected forms.
    $current_selected_forms = unserialize($post_meta["multi_selected_forms_ids"][0]);

    include "list_forms_questions_view/list_forms.php";
    include "list_forms_questions_view/list_questions.php";

    ?>


</div>
<?php

}
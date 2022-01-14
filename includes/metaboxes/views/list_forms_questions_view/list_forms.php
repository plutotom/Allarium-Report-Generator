<?php
?>
<script>
// put php variable into js variable
var agf_forms = <?php echo json_encode($forms); ?>;
var entries = <?php echo json_encode($entries); ?>;
</script>

<div id="agf-multi-select-forms-div">

    <label
        for="agf-multi-select-forms"><?php esc_html_e('What forms would you like to make this schema for?', 'agf'); ?></label>

    <?php
            // if no forms are selected, then only show 
            if($current_selected_forms !== '' || $current_selected_forms !== []){ 
                ?><select size='8' name="agf-multi-select-forms[]" id="agf-multi-select-forms" multiple><?php
                foreach ($forms as $form) {
                    if (in_array($form['id'], $current_selected_forms)) {  
                        
                        ?>
        <option selected value="<?php esc_html_e($form['id']) ?>"><?php esc_html_e($form['title']) ?></option>
        <?php
                    } else {
                        ?>
        <option value="<?php esc_html_e($form['id']) ?>"><?php esc_html_e($form['title']) ?></option>
        <?php
                    }
                           
    
        } //endforeach
    } else { Agf_Helper_Class::console_log("running?"); ?>
        <p style="color:red"><?php esc_html_e('Start with creating a form first.', 'agf'); ?></p>
        <select name="agf_null_forms" id="agf_null_forms">
            <option selected="selected" value="">Create a from first.</option>
        </select>
        <?php } //endif
    ?>
    </select>
    <input type="submit" value="Update Form Selection" class="button button-primary button-large" id="agf-save-button">
    <?php
?>
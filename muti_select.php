
<?php
?>
<head>
   <!-- multi-select style -->
   <!-- <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css"
      integrity="sha512-2sFkW9HTkUJVIu0jTS8AUEsTk8gFAFrPmtAxyzIhbeXHRH8NXhBFnLAMLQpuhHF/dL5+sYoNHWYYX2Hlk+BVHQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
        /> -->
</head>
<body>
    <h3><?php //echo $post_meta["catorgory_1"]; ?></h3>
<input type="button" value="+" onclick="addRow()">
    
    <div id="input_area">
        <input type="text" name="name" value="" />
        <input type="text" name="value" value="" />
        <label><input type="checkbox" name="check" value="1" />Checked?</label>
        <input type="button" value="-" onclick="removeRow()">
        <p>testing input area</p>
    </div>
    <div class="container py-5">    
        <!-- Multiselect dropdown -->
        <a  id='select-all'>select all</a>
<a  id='deselect-all'>deselect all</a>
        <select multiple="multiple" id="my-select" name="my-select[]">
            <?php  
                //    Putting all form questions into dropdown menu. This is so the user can select which questions they want put in a category.   
                foreach($form['fields'] as $field) {
                    if(in_array($field['type'], $field_types)) {
                        echo '<option value="'.$field['id']." ". $field['label'] .'">'.$field['label'].'</option>';
                    }
                }
            ?>
        </select>
    </div>
<script type="text/javascript">
    var form = <?php echo json_encode($form, JSON_HEX_TAG); ?>;
    var field_types = <?php echo json_encode($field_types, JSON_HEX_TAG); ?>;
    var post = <?php echo json_encode($post, JSON_HEX_TAG); ?>;
    var post_meta = <?php echo json_encode($post_meta, JSON_HEX_TAG); ?>;
    console.log(post_meta);
</script>

<?php

function agf_gform_after_subbission( $entry, $form ) {
    $new_array = [];
    Agf_Helper_Class::console_log( $entry );
    Agf_Helper_Class::console_log( $form['fields'] );
    // for each form->fields
    foreach($form["fields"] as $field){
        // if $field->id is in $entry array get the value
        if(array_key_exists($field->id, $entry)){
            $value = $entry[$field->id];
            $field_label = strtolower(str_replace(" ", "_", $field->label));
            $entry["values"][$field_label] = [
                "field_id" => $field->id,
                "type" => $field->type,
                "label" => $field_label,
                "value" => $value
            ];
        }

    }

    GFAPI::update_entry_property( $entry->id, $property, $value );

    Agf_Helper_Class::console_log( $entry );
    return $entry;
}
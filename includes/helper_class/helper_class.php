<?php
class Agf_Helper_Class
{
    public function __construct()
    {
        echo '<p>The class "', __CLASS__, '" was initiated!</p>';
    }

    public static function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }


    /**
     * Takes scored object and returns the average of all scores
     * @param  array $scored_data
     * @return object of category names (keys) with average scores as values
     */

    public static function get_average_scores($scored_data){
        if(empty($scored_data)){
            return null;
        }
        $average_scores = array();
        foreach($scored_data as $user_key => &$user){
            foreach($user['forms'] as $form_key => &$form){
                foreach($form['entries'] as $entry_key => &$entry){
                    foreach($entry['categories'] as $category_key => &$category){
                        $average_scores[$category_key]['score'] += $category;
                        $average_scores[$category_key]['count'] += 1;
                    }
                }
            }
        }
        foreach($average_scores as $category_key => &$category){
            $average_scores[$category_key]['score'] = $category['score'] / $category['count'];
            $average_scores[$category_key] = round($average_scores[$category_key]['score'], 2);
        }
        return $average_scores;
    }


    /**
     * For each form id passed given, will return an array of arrays and 
     * each array will be all questions that are in the form.
     * @param array $form_ids
     * @param array $field_types - array of field types to filter by.
     * @return array $form_questions
     */
    public static function get_form_questions($form_ids, $field_type = null){
        $form_questions = array();
        foreach($form_ids as $form_id){
            $form_questions[$form_id] = self::get_form_questions_by_form_id($form_id, $field_type);
        }
        return $form_questions;
    }

    /**
     * Gets gravity form by form id and returns an array of all questions
     * @param int $form_id
     * @param array $field_types - array of field types to filter by.
     * @return array $form_questions
     */

    public static function get_form_questions_by_form_id($form_id, $field_type = null){
        if($field_type == []){
            $field_type = null;
        }
        $form_questions = array();
        $form = GFAPI::get_form($form_id);
        foreach($form['fields'] as $field){
            if($field_type == null ){
                $form_questions[] = $field;
            }else{
                if (in_array($field['type'], $field_type)) {
                    $form_questions[] = $field;
                }
            }
            
        }
        return $form_questions;
    }

    /**
     * Gets current post selected forms and returns array of their ids
     * @param int optional $post_id option to get a specific post selected forms.
     * @return array of unique form ids
     */

    public static function get_current_post_selected_forms($post_id = null){
        if(!$post_id){
            $post_id = get_the_ID();
        }
        $post_meta = get_post_meta($post_id);
        $selected_forms = $post_meta['multi_selected_forms_ids'];
        $selected_forms = maybe_unserialize($selected_forms[0]);
        return $selected_forms;
    }

    /**
     * Returns an array of category names
     * @param {array} $scored_data - array of category objects
     * @return {array} - array of unique category names
     */

    public static function get_category_names($scored_data){
        $categories_names = array();
        foreach($scored_data as $user_key => &$user){
            foreach($user['forms'] as $form_key => &$form){
                foreach($form['entries'] as $entry_key => &$entry){
                    foreach($entry['categories'] as $category_key => &$category){
                        !in_array($category_key, $categories_names) ? $categories_names[] = $category_key : null;
                    }
                }
            }
        }
        return $categories_names;
    }

    /**
     * Searchers all categories to find what category the current question belongs too.
     * @param {int} - field_id. This is the id of the questions field in gravity forms. 
     * @param {int} form_id
     * @param {array} category data. 
     * @return {Array} if category found returns the name of the categories the question belongs too, else returns [].
     */
     
    public static function sort_by_categories($field_id, $form_id, $categories){
        $category_name_to_return = [];
        // loop thorough all categories and find if entry_id is in the category
       
        if(!empty($categories)){
        foreach($categories as $category ){
            if(!empty($category["category_questions"])){
            foreach($category["category_questions"] as $category_question){
                // if $entry_id is in the category return
                if($category_question["form_id"] == $form_id && $category_question["field_id"] == $field_id){
                    // push category name to array
                    $category_name_to_return[] = $category["category_title"];

                    // array_push($category_name_to_return, $category["category_title"]);
                    // $category["category_title"];
                    // print_r("###############################################");
                    // print_r("\n");
                    // print_r("form_id: ");
                    // print_r($category_question["form_id"]);
                    // print_r("::");
                    // print_r($form_id);
                    // print_r("\n");
                    // print_r("field_id: ");
                    // print_r($category_question["field_id"]);
                    // print_r("::");
                    // print_r($field_id);
                    // print_r("\n");
                    // print_r("entry_value: ");
                    // print_r($entry_value);
                    // print_r("\n");
                    // print_r("category_title: ");
                    // print_r($category["category_title"]);
                    // print_r("\n");
                    // print_r("question_name: ");
                    // print_r($category_question["question_name"]);
                    // print_r("\n");
                    // print_r("entry id: ");
                    // print_r($entry_id);
                    // print_r("\n");
                    // print_r("###############################################");
            }
        } // end category question loop
        } // end if categories question is not empty
        } // end category loop
        } // end if categories is not empty
    return $category_name_to_return;
    }
}
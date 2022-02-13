<?php
class Agf_Helper_Class
{



    // public static function init_plugin()
    // {
    //     //Hooks for metaboxes
    //     // add_action('add_meta_boxes', 'agf_register_reporting_metabox');
    //     add_action('add_meta_boxes', 'agf_register_list_forms_metabox');
    //     add_action('post_submitbox_misc_actions', 'agf_render_short_code_hint');
    //     add_action('save_post', 'agf_save_metabox', 10, 2);


    //     // ajax hooks
    //     add_action('wp_ajax_add_question_category', 'agf_add_question_category_process');
    //     add_action('wp_ajax_agf_update_post_meta', 'agf_update_post_meta_process');
    //     add_action('wp_ajax_agf_score_entries', 'agf_score_entries');


    //     // enqueue scripts and styles
    //     add_action('admin_enqueue_scripts', 'agf_enqueue_styles');
    //     add_action('admin_enqueue_scripts', 'agf_get_post_data_list_questions_metabox_script');
    //     //* Enqueue scripts for html to pdfP print.
    //     add_action('wp_footer', 'agf_enqueue_frontend_scripts');

    //     // Short_Code
    //     add_shortcode('allarium_score', 'agf_short_code_score');
    //     add_shortcode('allarium_score_print', 'agf_short_code_pdf_print');
    //     add_shortcode('allarium_score_average', 'agf_average_score_short_code');
    // }

    public static function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
            ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }


    /**
     * search's the entry for a email address
     * searches for @ symbol and . in the string, if both are found then assumes it is an email address
     * @param  array $entry
     * @return string email address
     */
    public static function search_for_email_address($entry)
    {
        foreach ($entry as $value) {
            // if value has a @ and . in it then assume it is an email address
            if (strpos($value, '@') !== false && strpos($value, '.') !== false) {
                $email = $value;
            }
        }
        return $email;
    }

    /**
     * Takes an array of of form ids and returns an array with all entries with form ids as keys.
     * @param  array $form_ids
     * @return array of entries
     */
    public static function get_entries_for_form($form_ids = null)
    {
        if (!is_array($form_ids)) {
            Agf_Helper_Class::console_log('Please pass an array of form ids');
            return;
        }
        // for each form id get all entries
        $entries = array();
        foreach ($form_ids as $form_id) {
            $entries[$form_id] = GFAPI::get_entries($form_id);
        }
        return $entries;
    }

    /**
     * Takes scored object and returns the average of all scores
     * @param  array $scored_data
     * @return object of category names (keys) with average scores as values
     */
    public static function get_average_scores($scored_data)
    {
        if (empty($scored_data)) {
            return null;
        }
        $average_scores = array();
        foreach ($scored_data as $user_key => &$user) {
            foreach ($user['forms'] as $form_key => &$form) {
                foreach ($form['entries'] as $entry_key => &$entry) {
                    foreach ($entry['categories'] as $category_key => &$category) {
                        $average_scores[$category_key]['score'] += $category;
                        $average_scores[$category_key]['count'] += 1;
                    }
                }
            }
        }
        foreach ($average_scores as $category_key => &$category) {
            $average_scores[$category_key]['score'] = $category['score'] / $category['count'];
            $average_scores[$category_key] = round($average_scores[$category_key]['score'], 2);
        }
        return $average_scores;
    }

    public static function alert_message($message)
    {
        echo '<script>alert("' . $message . '");</script>';
    }


    /**
     * For each form id given, gets all questions and returns an array with 
     * form_ids as keys for each form's questions.
     * @param array $form_ids
     * @param array $field_types - array of field types to filter by.
     * @return array $form_questions
     */
    public static function get_form_questions($form_ids, $field_type = null)
    {
        $form_questions = array();
        foreach ($form_ids as $form_id) {
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

    public static function get_form_questions_by_form_id($form_id, $field_type = null)
    {
        if ($field_type == []) {
            $field_type = null;
        }
        $form_questions = array();
        $form = GFAPI::get_form($form_id);
        foreach ($form['fields'] as $field) {
            if ($field_type == null) {
                $form_questions[] = $field;
            } else {
                if (in_array($field['type'], $field_type)) {
                    $form_questions[] = $field;
                }
            }
        }
        return $form_questions;
    }

    /**
     * Gets current post selected forms and returns array of their ids
     * @param int Id of post with selected forms.
     * @return array of unique form ids
     */
    public static function get_current_post_selected_forms($post_id)
    {
        if (!$post_id) {
            return Agf_Helper_Class::alert_message('No post id given');
        }
        $post_meta = get_post_meta($post_id);
        $selected_forms = $post_meta['multi_selected_forms_ids'];
        $selected_forms = maybe_unserialize($selected_forms[0]);
        return $selected_forms;
    }

    /**
     * Finds the company name field in the form and returns the value of the field
     * @param entry_id the id of an entry to search for
     * @param form_id the id of the form to search for
     * @return string company name
     */
    public static function get_company_name($entry_id, $form_id)
    {
        $entry = GFAPI::get_entry($entry_id);
        $form = GFAPI::get_form($form_id);
        foreach ($form['fields'] as $field) {
            if (strtoupper($field['label']) == strtoupper('company name')) {
                $company_name = $entry[$field['id']];
            }
        }
        return $company_name;
    }

    /**
     * Gets the value of of an entry by field label
     * @param string_to_sort_by the label of the field to search for
     * @param entry_id the id of an entry to search for
     * @param form_id the id of the form to search for
     * @return string company name
     */

    public static function get_value_by_field_label($string_to_sort_by, $entry_id, $form_id)
    {
        $entry = GFAPI::get_entry($entry_id);
        $form = GFAPI::get_form($form_id);
        self::console_log($entry);
        foreach ($form['fields'] as $field) {
            if (strtoupper($field['label']) == strtoupper($string_to_sort_by)) {
                $value = $entry[$field['id']];
            }
        }
        return $value;
    }

    /**
     * Returns an array of category names
     * @param {array} $scored_data - array of category objects
     * @return {array} - array of unique category names
     */

    public static function get_category_names($scored_data)
    {
        $categories_names = array();
        foreach ($scored_data as $user_key => &$user) {
            foreach ($user['forms'] as $form_key => &$form) {
                foreach ($form['entries'] as $entry_key => &$entry) {
                    foreach ($entry['categories'] as $category_key => &$category) {
                        !in_array($category_key, $categories_names) ? $categories_names[] = $category_key : null;
                    }
                }
            }
        }
        return $categories_names;
    }

    /**
     * Updates post meta with new scored entries.
     * The schema for this is stored in the post data. Pass the post id and that will get 
     * all the needed data from the post using the post id, then get all entries (new and old) 
     * and update the scored data object.
     * @param {array} $scored_data - array of category objects
     * @param {int} $post_id - id of post to update
     * @return {array} - array of unique category names
     * 
     */
    public static function update_post_scored_data($post_id = "default")
    {
        // get post meta data
        $category_data  = get_post_meta($post_id, 'category_data', true);
        $form_ids  = get_post_meta($post_id, 'multi_selected_forms_ids', true);
        $scored_entries  = get_post_meta($post_id, 'scored_entries', true);

        $scoring_schema = [
            "glikertcol2079ce3b4" => 0, // completely disagree
            "glikertcol2afb99d83" => 1, // Mostly disagree
            "glikertcol2c8b03172" => 2, // Somewhat Disagree
            "glikertcol2705122be" => 3, // Somewhat Agree
            "glikertcol297044e96" => 4, // Mostly Agree
            "glikertcol25100bcbb" => 5, // Completely Agree
            "glikertcol25156cc64" => null, // N/A
        ];
        $scored_obj = [];
        $form_index = 0;

        foreach ($form_ids as $form_id) {
            $entry_index = 0;
            // get entries and append to array
            $current_form_entries = GFAPI::get_entries($form_id);
            foreach ($current_form_entries as $entry) {
                $user_email = "";
                $personal_score = [];
                $entry_id = $entry['id'];
                // getting email address

                foreach ($entry as $field_id => $entry_value) {
                    // returns the names of the categories the question belongs too if the field_id and the form_id match. 
                    // if the question belongs to a category then add the question value to the category array to be scored.
                    $category_names = Agf_Helper_Class::sort_by_categories($field_id, $form_id, $category_data);

                    // [cat_name_1, cat_name_2]
                    if ($category_names != []) {

                        foreach ($entry as $field_id => $val) {
                            if (strpos($val, '@')) {
                                $user_email = $val;
                            }
                        }
                        if (empty($user_email)) {
                            $user_email = get_user_by('id', $entry["created_by"])->user_email;
                        }

                        foreach ($category_names as $category_name) {
                            // if scoring_schema includes entry value then add to array
                            // This is only for survey questions, they have a value  that looks like this: "glikertcol2079ce3b4" 
                            // and that value represents a score. See $scoring_schema.
                            if (array_key_exists($entry_value, $scoring_schema)) {
                                $entry_value = $scoring_schema[$entry_value];
                                $personal_score[$category_name][] = $entry_value;
                            } else {
                                $personal_score[$category_name][] = $entry_value;
                            }
                        }
                    }
                }
                if ($user_email != "" || !empty($user_email)) {
                    $scored_obj[$user_email]["forms"][$form_index]["entries"][$entry_index]["categories"] = $personal_score;
                    $scored_obj[$user_email]["forms"][$form_index]["entries"][$entry_index]["entry_id"] = $entry_id;
                    $scored_obj[$user_email]["forms"][$form_index]["form_id"] = $form_id;
                    $entry_index += 1;
                }
            } // end foreach entry
            if ($user_email != "" || !empty($user_email)) {
                $scored_obj[$user_email]["forms"][$form_index]["form_id"] = $form_id;
                $form_index += 1;
            }
        } // end loop for each form id

        foreach ($scored_obj as $user_key => &$user) {
            foreach ($user['forms'] as $form_key => &$form) {
                if (!empty($form['entries'])) {
                    foreach ($form['entries'] as $entry_key => &$entry) {
                        foreach ($entry['categories'] as $category_key => &$category) {
                            // $entry['categories'][$category_key] = array_sum($category);
                            $scored_obj[$user_key]["forms"][$form_key]["entries"][$entry_key]["categories"][$category_key] = round(array_sum($category) / count($category), 2);
                        }
                    }
                }
            }
        }


        // update post meta data
        update_post_meta($post_id, 'scored_entries', $scored_obj);
    }

    /**
     * Searchers all categories to find what category the current question belongs too.
     * @param {int} - field_id. This is the id of the questions field in gravity forms. 
     * @param {int} form_id
     * @param {array} category data. 
     * @return {Array} if category found returns the name of the categories the question belongs too, else returns [].
     */

    public static function sort_by_categories($field_id, $form_id, $categories)
    {
        $category_name_to_return = [];
        // loop thorough all categories and find if entry_id is in the category

        if (!empty($categories)) {
            foreach ($categories as $category) {
                if (!empty($category["category_questions"])) {
                    foreach ($category["category_questions"] as $category_question) {
                        // if $entry_id is in the category return
                        if ($category_question["form_id"] == $form_id && $category_question["field_id"] == $field_id) {
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


    /**
     * Helper function to send error messages
     * 
     */
    public static function display_notices($mes = null)
    {
        echo '<div class="error">
            <?php echo $mes ?>
        </div>';
    }

    public static function send_error_message($mes)
    {
        if ($mes && is_admin()) {
            Agf_Helper_Class::display_notices($mes);
        }
    }

    /**
     * Checks if Gravity Forms is activated
     * @return bool - true if activated, false if not
     */
    public static function gf_activation_check()
    {
        if (!class_exists('GFAPI')) {
            Agf_Helper_Class::console_log("missing some classes");
            $mes = "<p><strong>Allarium Report Generation Installation Problem</strong></p>
            <p>Gravity Forms is not installed or activated. Please install and activate Gravity Forms to use this plugin.
            </p>";

            self::display_notices($mes);
            deactivate_plugins(__FILE__, true);
            wp_die();
            return false;
        }
        // self::init_plugin();
        return true;
    }
}

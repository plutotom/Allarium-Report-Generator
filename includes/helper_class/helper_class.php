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

    /**
     * Creates a PDF print out 
     * @param {string} - html_string. This is the html string that will be printed out.
     * @param {string} - pdf_name. This is the name of the pdf file.
     * @param {string} - pdf_path. This is the path of the pdf file.
     * @return {string} - returns the path of the pdf file.
     */

     public static function pdf_print(){
        // $mpdf = new \Mpdf\Mpdf(['mode' => 'c']);
        // header('Content-Type: application/pdf');
        // $mpdf->WriteHTML("<p> here is a p tag</p>");
        // $mpdf->Output();
        // wp_die();
        // header('Content-Type: application/json');
        return true;
     }
}
<?php

function agf_short_code_pdf_print($atts){
    ob_start();
    if($_REQUEST['pdf_print'] != 'true'){    
        echo '<a href="'.get_permalink().'?pdf_print=true" class="button button-primary button-large" target="_blank">Print PDF</a>';
    }

    return ob_get_clean();

}
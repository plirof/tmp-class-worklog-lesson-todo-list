<?php
//SET SOME OPTIONS :
//$show_logical_header=true; // for many checkboxes (poor man freeze forst column alternative)
//$show_empty_lines=false; //If disabled (false) might have problem if you have empty lines
//$add_class_to_element=true; //190319 adds class name to each element(so we can add custom js for this element )
//$sorttable_js=true; //enable sortablejs (maybe slow in BIG files)
//$show_internal_element_text_outside=true; // shows text outside teaxtare/input field (this is needed for sort to work)
//$show_submit_button=true ; //shows/hide submit button 

//set some options
$show_logical_header=true;
$show_internal_element_text_outside=true; // show list text outiside select box (for sorting)


$first_week_sept10=37; //for LISTWEEKSSCH
$last_week_of_year=53; //for LISTWEEKSSCH

$show_submit_button=false ; //READ ONLY

//load main file
require ('order_lesson.php');

?>

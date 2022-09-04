<?php
/**
 * Plugin Name: Atlas Quiz
 * Description: Atlas plugin test for quiz.
 * Version: 1.0
 * Author: Umesh
 * License: A "Slug" license name e.g. GPL2
 */

// Create a new table
function atlasquiz_table(){

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $quiz_tbl = $wpdb->prefix."atlas_quiz";
    $sql = "CREATE TABLE $quiz_tbl (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `question` text NOT NULL,
        `answer_1` varchar(100) NOT NULL,
        `answer_2` varchar(100) NOT NULL,
        `answer_3` varchar(100) NOT NULL,
        `answer_4` varchar(100) NOT NULL,
        `right_answer` varchar(100) NOT NULL,
        `answer_time` int(4) NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";
    dbDelta( $sql );

    $user_answer_tbl = $wpdb->prefix."atlas_user_result";
    $user_anser_sql = "CREATE TABLE $user_answer_tbl (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id`  int(255) NOT NULL,
        `user_answer` varchar(100) NOT NULL,
        `right_answer` varchar(100) NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";
    dbDelta( $user_anser_sql );

}
register_activation_hook( __FILE__, 'atlasquiz_table' );

//Backend Code
function atlas_menu() {   //Add Menu
    add_menu_page("Atlas Quiz", "Atlas Quiz","manage_options", "atlas_quiz", "atlas_quiz_list",plugins_url('/atlas_quiz/img/icon.png'));
    add_submenu_page("atlas_quiz","Add New Quiz", "Add New Quiz","manage_options", "addnewquiz", "atlas_add_que_ans");
    add_submenu_page("atlas_quiz","Quiz Results", "Quiz Results","manage_options", "result_list", "atlas_result_list");
}
add_action("admin_menu", "atlas_menu");

function atlas_quiz_list(){
    include "quiz_list.php";
}

function atlas_result_list(){
    include "result_list.php";
}

function atlas_add_que_ans(){
    include "add_que_ans.php";
}

//Frond End
function atlas_load_plugin_script() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'atlas_style', $plugin_url . 'assets/css/atlas_style.css' );
    wp_enqueue_script('atlas_script', $plugin_url . 'assets/js/atlas_script.js', array('jquery'), rand(), true );
}
add_action( 'wp_enqueue_scripts', 'atlas_load_plugin_script' );


function atlas_quiz_form(){
    $results = '<div class="quiz_wrapper">';
    if ( is_user_logged_in() ) {
        global $wpdb;
        
        $results .= '<h3>Atlas Quiz</h3>';
        $results .= '<div class="quiz_contain">';
        if(!isset($_POST['quiz_save'])){
            $results .= '<form method="post">';
            
            $quiz_tbl = $wpdb->prefix . "atlas_quiz";
            $rows = $wpdb->get_results("SELECT * FROM $quiz_tbl");
            $count = $wpdb->num_rows;
            if(!empty($rows)) {
                foreach($rows as $row) { 
                    $count--;
                    $results .= '<div class="gquestion question'.$row->id.'">';  
                        $results .= '<span class="at_timer">'.$row->answer_time.'</span>';  
                        $results .= '<h4>'.$row->question.'</h4>';
                        $results .= '<p><input type="radio" name="quizanswer['.$row->question.']" value="'.$row->answer_1.'">'.$row->answer_1.'</p>';
                        $results .= '<p><input type="radio" name="quizanswer['.$row->question.']" value="'.$row->answer_2.'">'.$row->answer_2.'</p>';
                        $results .= '<p><input type="radio" name="quizanswer['.$row->question.']" value="'.$row->answer_3.'">'.$row->answer_3.'</p>';
                        $results .= '<p><input type="radio" name="quizanswer['.$row->question.']" value="'.$row->answer_4.'">'.$row->answer_4.'</p>';                    
                        $results .= '<p><input type="hidden" name="rn['.$row->question.']" value="'.$row->right_answer.'"></p>';                    
                        if($count != 0){
                            $results .= '<p><a class="gnext next'.$row->id.'"  data-id="'.$row->id.'" data-time="'.$row->answer_time.'">Next</a> <a class="gskip skip'.$row->id.'"  data-id="'.$row->id.'" data-time="'.$row->answer_time.'">Skip</a></p>';
                            }else{
                                $results .= '<p><button class="submit" name="quiz_save">Save</button>';
                            }                    
                    $results .= '</div>';
                } // foreach end
            } // end if    
              
            $results .= '</form>';
            
            } else{ 
                unset($_POST['quiz_save']);
                if(isset($_POST['quizanswer'])){
                    $tablename = $wpdb->prefix.'atlas_user_result';
                    $data = array(
                        'user_id' => get_current_user_id(),
                        'user_answer' => maybe_serialize($_POST['quizanswer']),
                        'right_answer' => maybe_serialize($_POST['rn'])
                    );
                    $wpdb->insert( $tablename, $data);

                    $results .= '<hr><h4>Your Result</h4>';
                    
                    foreach ($_POST['quizanswer'] as $que => $ans) {
                        $results .= '<p><strong>Question:- '.$que.'</strong></p>';
                        $results .= '<p>Your Answer:- '.$ans.'</p>';
                        $results .= '<p>Right Answer:- '.$_POST['rn'][$que].'</p>';
                    }
                }else{
                    $results .= '<p> No one answer there, Please refresh and take quiz again.</strong></p>';
                }
                
            }
        $results .= '</div>';
    } else {
        $results .= 'Please login for Quiz.';
    }
    $results .= '</div>';
    return $results;
}
add_shortcode('quizform', 'atlas_quiz_form');
?>
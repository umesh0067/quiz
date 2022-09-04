<?php
global $wpdb;

// Add record
if(isset($_POST['btn_submit'])){
    $question = $_POST['txt_question'];
    $option1 = $_POST['txt_option1'];
    $option2 = $_POST['txt_option2'];
    $option3 = $_POST['txt_option3'];
    $option4 = $_POST['txt_option4'];
    $right_ans = $_POST['txt_right_answer'];
    $ans_time = $_POST['txt_answer_time'];
    $tablename = $wpdb->prefix."atlas_quiz";

    if($question != '' && $option1 != ''&& $option2 != ''&& $option3 != ''&& $option4 != ''&& $right_ans != '' && $ans_time != ''){
        $check_data = $wpdb->get_results("SELECT * FROM ".$tablename." WHERE question ='".$question."' ");
        if(count($check_data) == 0){
            $insert_sql = "INSERT INTO ".$tablename."(question,answer_1,answer_2,answer_3,answer_4,right_answer,answer_time)
             values('".$question."','".$option1."','".$option2."','".$option3."','".$option4."','".$right_ans."','".$ans_time."') ";
            $wpdb->query($insert_sql);
            echo "Save Successfully !.";
        }
    }
}
?>
<h1>Add New Quiz</h1>
<form method='post' action=''>
    <table>
        <tr>
            <td>Question</td>
            <td><input type='text' name='txt_question'></td>
        </tr>
        <tr>
            <td>Answer1</td>
            <td><input type='text' name='txt_option1'></td>
        </tr>
        <tr>
            <td>Answer2</td>
            <td><input type='text' name='txt_option2'></td>
        </tr>
        <tr>
            <td>Answer3</td>
            <td><input type='text' name='txt_option3'></td>
        </tr>
        <tr>
            <td>Answer4</td>
            <td><input type='text' name='txt_option4'></td>
        </tr>
        <tr>
            <td>Right Answer</td>
            <td><input type='text' name='txt_right_answer'></td>
        </tr>
        <tr>
            <td>Answer Time</td>
            <td><input type='text' name='txt_answer_time'><br/>
            <lable>In Second</lable></td>

        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type='submit' name='btn_submit' value='Submit'></td>
        </tr>
    </table>
</form>
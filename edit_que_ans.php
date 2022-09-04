<?php
global $wpdb;

// Add record


$edit_data = $wpdb->get_results("SELECT * FROM ".$tablename." WHERE id ='".$editid."' ");

// echo "<pre>";
// var_dump($edit_data);
// echo "</pre>";

foreach($edit_data as $edited_data) { 

?>
<h1>Update Quiz</h1>
<form method='post' action=''>
    <table>
        <tr>
            <td>Question</td>
            <td><input type='text' name='txt_question' value="<?php echo $edited_data->question; ?>"></td>
        </tr>
        <tr>
            <td>Answer1</td>
            <td><input type='text' name='txt_option1' value="<?php echo $edited_data->answer_1; ?>"></td>
        </tr>
        <tr>
            <td>Answer2</td>
            <td><input type='text' name='txt_option2' value="<?php echo $edited_data->answer_2; ?>"></td>
        </tr>
        <tr>
            <td>Answer3</td>
            <td><input type='text' name='txt_option3' value="<?php echo $edited_data->answer_3; ?>"></td>
        </tr>
        <tr>
            <td>Answer4</td>
            <td><input type='text' name='txt_option4' value="<?php echo $edited_data->answer_4; ?>"></td>
        </tr>
        <tr>
            <td>Right Answer</td>
            <td><input type='text' name='txt_right_answer' value="<?php echo $edited_data->right_answer; ?>"></td>
        </tr>
        <tr>
            <td>Answer Time</td>
            <td><input type='text' name='txt_answer_time' value="<?php echo $edited_data->answer_time; ?>"><br/>
            <lable>In Second</lable></td>

        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type='submit' name='btn_update' value='Submit'></td>
        </tr>
    </table>
</form>
<?php
}

if(isset($_POST['btn_update'])){
    // echo "sdsd  ";
    $question = $_POST['txt_question'];
    $option1 = $_POST['txt_option1'];
    $option2 = $_POST['txt_option2'];
    $option3 = $_POST['txt_option3'];
    $option4 = $_POST['txt_option4'];
    $right_ans = $_POST['txt_right_answer'];
    $ans_time = $_POST['txt_answer_time'];
    $tablename = $wpdb->prefix."atlas_quiz";

    
    $update_sql = array('question'=> $question, 'answer_1'=>$option1,'answer_2'=>$option2,'answer_3'=>$option3,'answer_4'=>$option4,'right_answer'=>$right_ans,'answer_time'=>$ans_time);

    $data_where = array('id' => $editid);

    $wpdb->update($tablename, $update_sql, $data_where);
    echo "update Successfully !.";
    ?>
    <script>
    function pageRedirect() {
        var url = window.location.href;
        url = url.slice( 0, url.indexOf('&') );
        //alert( url );
        window.location.replace(url);
    }      
    setTimeout("pageRedirect()", 1000);
    </script>
    <?php
       
}

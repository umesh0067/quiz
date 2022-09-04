<?php
global $wpdb;
$tablename = $wpdb->prefix."atlas_quiz";
// Delete record
if(isset($_GET['delid'])){
    $delid = $_GET['delid'];
    $wpdb->query("DELETE FROM ".$tablename." WHERE id=".$delid);
}
if(isset($_GET['editid'])){
    $editid = $_GET['editid'];
    include "edit_que_ans.php";
    //$wpdb->query("DELETE FROM ".$tablename." WHERE id=".$delid);
}
?>
<h1>Quiz List</h1>
<table width='98%' border='1' style='border-collapse: collapse;'>
    <tr>
        <th>ID</th>
        <th>Question</th>
        <th>Answer1</th>
        <th>Answer2</th>
        <th>Answer3</th>
        <th>Answer4</th>
        <th>Right Answer</th>
        <th>Answer Time</th>
        <th></th>
    </tr>
    <?php
    // Select records
    $quizList = $wpdb->get_results("SELECT * FROM ".$tablename." order by id desc");
    if(count($quizList) > 0){
        $count = 1;
        foreach($quizList as $quiz){
            $id = $quiz->id;
            $question = $quiz->question;
            $option1 = $quiz->answer_1;
            $option2 = $quiz->answer_2;
            $option3 = $quiz->answer_3;
            $option4 = $quiz->answer_4;
            $right_ans = $quiz->right_answer;
            $ans_time = $quiz->answer_time;

            echo "<tr>
                <td>".$count."</td>
                <td>".$question."</td>
                <td>".$option1."</td>
                <td>".$option2."</td>
                <td>".$option3."</td>
                <td>".$option4."</td>
                <td>".$right_ans."</td>
                <td>".$ans_time."</td>
                <td><a href='?page=atlas_quiz&editid=".$id."'>Edit</a>
                <a href='?page=atlas_quiz&delid=".$id."'>Delete</a></td>
                </tr>
                ";
            $count++;
        }
    }else{
        echo "<tr><td colspan='5'>No quiz record found</td></tr>";
    }
    ?>
</table>
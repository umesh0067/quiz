<?php
global $wpdb;
$tablename = $wpdb->prefix."atlas_user_result";
?>
<h1>Quiz Results</h1>
<table width='98%' border='1' style='border-collapse: collapse;'>
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Quiz Detail</th>
    </tr>
    <?php
    // Select records
    $quizList = $wpdb->get_results("SELECT * FROM ".$tablename." order by id desc");
    if(count($quizList) > 0){
        $count = 1;
        foreach($quizList as $quiz){
            $id = $quiz->id;
            $user_info = get_userdata($quiz->user_id);
            $username = $user_info->user_login;
            $question = maybe_unserialize($quiz->user_answer);
            $result = maybe_unserialize($quiz->right_answer);
            
            echo "<tr>";
                echo "<td>".$count."</td>";
                echo "<td>".$username."</td>";
                echo "<td>";
                    foreach ($question as $key => $value) {
                        echo '<p><strong>Question:- '.$key.'</strong></p>';
                        echo '<p>User Answer:- '.$value.' | Right Answer:- '.$result[$key].'</p>';
                    }
                echo "</td>";
            echo "</tr>";
            $count++;
        }
    }else{
        echo "<tr><td colspan='5'>No result found</td></tr>";
    }
    ?>
</table>
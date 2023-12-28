<?php
    require("../API/connection.php");

    if(isset($_POST['p_id']) and isset($_POST['c_id']) and isset($_POST['v_id'])){
        date_default_timezone_set('Asia/Kolkata');
        $vote_date = date("y-m-d");
        $vote_time = date("H:i:s");
        
        mysqli_query($connect, "INSERT INTO votes_data(post_id, voters_id, candidate_id, vote_date, vote_time) VALUES ('". $_POST['p_id'] ."', '". $_POST['v_id'] ."', '". $_POST['c_id'] ."', '". $vote_date ."', '". $vote_time ."')") or die(mysqli_error($connect));

        echo "Success";
    }
?>
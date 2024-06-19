<?php
require("../API/connection.php");
session_start();
if (!isset($_SESSION['votername'])) {
    header("location: ../index.php");
}
?>

<html>

<head>
    <title>Com Based Voting System - Voters Panel</title>
    <link rel="stylesheet" href="../Voters Routes Stylesheet/voters_panel.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../Resources/logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <nav>
        <div class="logo">
            <a href="#"><img src="../Resources/logo.png">Tinsukia College</a>
        </div>
        <form method="POST">
            <div class="user">
                <button type="submit" class="logout" name="logout">LOGOUT</button>
            </div>
        </form>
    </nav>
    <hr>
    <div class="heading-container">
        <div class="heading-container1">
            <div class="heading">
                <h1>Tinsukia College Stu<span class="span">dent's Union Election</span></h1>
            </div>
            <div class="sub-heading">
                <h1>Welcome <span class="span"><?php echo $_SESSION['votername']; ?></span> !</h1>
            </div>
            <div class="imp-note">
                <h4><b style="font-size: 19px;">Note :</b></h4>
                <h5><i class='bx bxs-circle'></i>&ensp;  Once you have voted a candidate for a post, you won't be able to change it. So, make sure to choose your candidate wisely!</h5>
                <h5><i class='bx bxs-circle'></i>&ensp;  If you have voted for all the given posts, then this page will automatically logout. And you won't be able to login again!</h5>
            </div>
        </div>
    </div>
    <?php
    $fetchingPosts = mysqli_query($connect, "SELECT * FROM admin_panel_posts") or die(mysqli_error($connect));
    $isAnyPostAdded = mysqli_num_rows($fetchingPosts);
    if ($isAnyPostAdded > 0) {
        while ($row = mysqli_fetch_assoc($fetchingPosts)) {
            $postid = $row['id'];
            $postname = $row['post_name'];
    ?>
            <div class="voting-box">
                <h1><?php echo $postname; ?> :</h1>
                <table class="styled-table2">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Candidate Name</th>
                            <th>Department</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fetchingCandidates = mysqli_query($connect, "SELECT * FROM admin_panel_candidts WHERE post_id = '" . $postid . "'") or die(mysqli_error($connect));
                        $isAnyCandidateAdded = mysqli_num_rows($fetchingCandidates);
                        if ($isAnyCandidateAdded > 0) {
                            $sNo = 1;
                            while ($row2 = mysqli_fetch_assoc($fetchingCandidates)) {
                                $candidateid = $row2['id'];
                                $candidatename = $row2['candidate_name'];
                                $department = $row2['dept_name'];
                        ?>
                                <tr>
                                    <td><?php echo $sNo++; ?></td>
                                    <td><?php echo $candidatename; ?></td>
                                    <td><?php echo $department; ?></td>
                                    <td>
                                        <?php
                                        $checkIfVoteCasted = mysqli_query($connect, "SELECT * FROM votes_data WHERE voters_id = '" . $_SESSION['voter_id'] . "' AND post_id = '" . $postid . "'") or die(mysqli_error($connect));
                                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                        if ($isVoteCasted > 0) {
                                            $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                            $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                            if ($voteCastedToCandidate == $candidateid) {
                                        ?>
                                                <button class="defaultbtn">Voted</button>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <button class="actionbtn" onclick="CastVote(<?php echo $postid; ?>, <?php echo $candidateid; ?>, <?php echo $_SESSION['voter_id']; ?>)">Vote</button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" style="color: #707070; word-spacing: 5px;">No candidate is added yet!</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
    } else {
        ?>
        <div class="empty-text">
            <h1>No Election is going on!</h1>
        </div>
    <?php
    }
    ?>

    <script>
        const CastVote = (post_id, candidate_id, voter_id) => {
            $.ajax({
                type: "POST",
                url: "../Voters Routes/voters_panel_ajax.php",
                data: "p_id=" + post_id + "&c_id=" + candidate_id + "&v_id=" + voter_id,
                success: function(response) {
                    if (response == "Success") {
                        location.assign("../Voters Routes/voters_panel.php");
                    }
                }
            });
        }
    </script>

    <?php
    $checkIfVotedAllPosts = mysqli_query($connect, "SELECT * FROM votes_data WHERE voters_id = '". $_SESSION['voter_id'] ."'");
    $isVotedAllPosts = mysqli_num_rows($checkIfVotedAllPosts);

    if ((isset($_POST['logout'])) or (($isVotedAllPosts == $isAnyPostAdded) && ($isVotedAllPosts > 0))) {
        session_destroy();
    ?>
        <script>
            location.assign("../index.php");
        </script>
    <?php
    }
    ?>
</body>

</html>
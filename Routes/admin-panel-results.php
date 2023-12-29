<?php
require("../API/connection.php");
session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: ../Routes/admin-login.php");
}

if (isset($_GET['reset_all'])) {
    mysqli_query($connect, "DELETE FROM votes_data");
    mysqli_query($connect, "ALTER TABLE votes_data AUTO_INCREMENT = 0");
    mysqli_query($connect, "DELETE FROM voter_registration");
    mysqli_query($connect, "ALTER TABLE voter_registration AUTO_INCREMENT = 0");
    mysqli_query($connect, "DELETE FROM admin_panel_candidts");
    mysqli_query($connect, "ALTER TABLE admin_panel_candidts AUTO_INCREMENT = 0");
    mysqli_query($connect, "DELETE FROM admin_panel_posts");
    mysqli_query($connect, "ALTER TABLE admin_panel_posts AUTO_INCREMENT = 0");
?>
    <script>
        location.assign("admin-panel-results.php");
    </script>
<?php
}
?>

<html>

<head>
    <title>Com Based Voting System - Admin Panel</title>
    <link rel="stylesheet" href="../Routes Stylesheet/admin-panel.css">
    <link rel="shortcut icon" href="../Resources/logo.png">
</head>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

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
    <div class="sidebar">
        <div>
            <h2>Admin Panel</h2>
            <hr>
            <ul>
                <li><a href="../Routes/admin-panel-home.php">HOME</a></li>
                <li><a href="../Routes/admin-panel-posts.php">ADD POSTS</a></li>
                <li><a href="../Routes/admin-panel-candidts.php">ADD CANDIDATES</a></li>
                <li><a href="../Routes/admin-panel-results.php" style="color: #450b00; font-size: 26px; padding: 13px 0;">VIEW RESULTS</a></li>
            </ul>
        </div>
        <div class="bottom-content">
            <button onclick="ResetAll()">RESET&ensp;ALL</button>
        </div>
    </div>
    <div class="page-container">
        <div class="heading">
            <h1>Tinsukia College Stu<span class="span">dent's Union Election</span></h1>
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
                    <table class="styled-table3">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Candidate Name</th>
                                <th>Department</th>
                                <th>Votes</th>
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
                                            $voteCountQuery = mysqli_query($connect, "SELECT * FROM votes_data WHERE post_id = '" . $postid . "' AND candidate_id = '" . $candidateid . "'") or die(mysqli_error($connect));
                                            $voteCountTotal = mysqli_num_rows($voteCountQuery);
                                            echo $voteCountTotal;
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
    </div>

    <script>
        const ResetAll = () => {
            let d = confirm("Do you really want to reset everything?");
            if (d == true) {
                let e = confirm("Are you really sure? It will reset the entire database!");
                if (e == true) {
                    location.assign("admin-panel-results.php?reset_all=1");
                }
            }
        }
    </script>

    <?php
    if (isset($_POST['logout'])) {
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
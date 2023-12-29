<?php
require("../API/connection.php");

session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: ../Routes/admin-login.php");
}

if (isset($_GET['delete_id'])) {
    mysqli_query($connect, "DELETE FROM admin_panel_candidts WHERE id = '" . $_GET['delete_id'] . "'");
?>
    <script>
        location.assign("admin-panel-candidts.php");
    </script>
<?php
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
        location.assign("admin-panel-candidts.php");
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
                <li><a href="../Routes/admin-panel-candidts.php" style="color: #450b00; font-size: 26px; padding: 13px 0;">ADD CANDIDATES</a></li>
                <li><a href="../Routes/admin-panel-results.php">VIEW RESULTS</a></li>
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
        <div class="wrapper">
            <form method="POST">
                <h1>Add New Candidate</h1>
                <div class="inputbox">
                    <input type="text" name="candidatename" placeholder="Enter Candidate Name" required>
                </div>
                <div class="inputbox">
                    <select class="selectpost" name="postselection" required>
                        <option value="">Select Post</option>
                        <?php
                        $fetchingPosts = mysqli_query($connect, "SELECT * FROM admin_panel_posts") or die(mysqli_error($connect));
                        $isAnyPostAdded = mysqli_num_rows($fetchingPosts);

                        if ($isAnyPostAdded > 0) {
                            while ($row = mysqli_fetch_assoc($fetchingPosts)) {
                                $post_id = $row['id'];
                                $post_name = $row['post_name'];
                                $allowed_candidates = $row['num_candidts'];

                                $fetchingCandidate = mysqli_query($connect, "SELECT * FROM admin_panel_candidts WHERE post_id = '" . $post_id . "'") or die(mysqli_error($connect));
                                $added_candidates = mysqli_num_rows($fetchingCandidate);

                                if ($added_candidates < $allowed_candidates) {
                        ?>
                                    <option value="<?php echo $post_id; ?>"><?php echo $post_name; ?></option>
                        <?php
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="inputbox">
                    <input type="text" name="deptname" placeholder="Enter Department Name (in abbr.)" required>
                </div>
                <button type="submit" name="add_candidate" class="btn">ADD CANDIDATE</button>
            </form>
        </div>
        <table class="styled-table1">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Candidate Name</th>
                    <th>Post</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingData = mysqli_query($connect, "SELECT * FROM admin_panel_candidts") or die(mysqli_error($connect));
                $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                if ($isAnyCandidateAdded > 0) {
                    $sNo = 1;
                    while ($row = mysqli_fetch_assoc($fetchingData)) {
                        $candidate_id = $row['id'];
                        $posts_id = $row['post_id'];
                        $fetchingPostsName = mysqli_query($connect, "SELECT * FROM admin_panel_posts WHERE id = '" . $posts_id . "'") or die(mysqli_error($connect));
                        $execFetchingPostsNameQuery = mysqli_fetch_assoc($fetchingPostsName);
                        $posts_name = $execFetchingPostsNameQuery['post_name'];
                ?>
                        <tr>
                            <td><?php echo $sNo++; ?></td>
                            <td><?php echo $row['candidate_name']; ?></td>
                            <td><?php echo $posts_name; ?></td>
                            <td><?php echo $row['dept_name']; ?></td>
                            <td class="actionbtn">
                                <button onclick="DeleteRow(<?php echo $candidate_id; ?>)">Delete</button>
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
    if (isset($_POST['add_candidate'])) {
        $candidatename = mysqli_real_escape_string($connect, $_POST['candidatename']);
        $postselection = mysqli_real_escape_string($connect, $_POST['postselection']);
        $deptname = mysqli_real_escape_string($connect, $_POST['deptname']);

        mysqli_query($connect, "INSERT INTO admin_panel_candidts(post_id, candidate_name, dept_name) VALUES ('" . $postselection . "','" . $candidatename . "','" . $deptname . "')") or die(mysqli_error($connect));
        echo "<script> alert('Successfully added!'); </script>";
    ?>
        <script>
            location.assign("../Routes/admin-panel-candidts.php");
        </script>
    <?php
    }
    ?>

    <script>
        const DeleteRow = (c_id) => {
            let c = confirm("Do you really want to delete it?");
            if (c == true) {
                location.assign("admin-panel-candidts.php?delete_id=" + c_id);
            }
        }

        const ResetAll = () => {
            let d = confirm("Do you really want to reset everything?");
            if (d == true) {
                let e = confirm("Are you really sure? It will reset the entire database!");
                if (e == true) {
                    location.assign("admin-panel-candidts.php?reset_all=1");
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
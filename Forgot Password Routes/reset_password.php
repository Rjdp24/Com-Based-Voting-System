<?php
require("../API/connection.php");
?>

<html>

<head>
    <title>Com Based Voting System - Admin Login</title>
    <link rel="stylesheet" href="Stylesheet/recovery_email.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
    </nav>
    <hr>
    <div class="heading">
        <h1>Tinsukia College Stu<span class="span">dent's Union Election</span></h1>
    </div>
    <div class="wrapper">
        <form method="POST">
            <h1>Reset Password</h1>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Enter New Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="inputbox">
                <input type="password" name="cpassword" placeholder="Confirm New Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="update" class="btn">Update Password</button>
        </form>
    </div>

    <footer>
        <div class="left-part">
            <h3>Designed and Developed by :</h3>
            <p>Rajdeep Aich&ensp;|&ensp;Bisal Shah&ensp;|&ensp;Aditya Sahu &ensp;-&ensp; BCA'24 @ Tinsukia College</p>
        </div>
        <div class="right-part">
            <h3>Contact Us :</h3>
            <i class='bx bxl-instagram-alt'></i> <a href="https://www.instagram.com/kunal__shah1/">Bisal Shah</a> &ensp;| &nbsp;
            <i class='bx bxl-instagram-alt'></i> <a href="https://www.instagram.com/adityasahu395/">Aditya Sahu</a> &ensp;| &nbsp;
            <i class='bx bxl-instagram-alt'></i> <a href="https://www.instagram.com/_.rjdp_/">Rajdeep Aich</a>
        </div>
    </footer>
    
    <?php

    if (isset($_POST['update'])) {
        if(isset($_GET['token']) && isset($_GET['id'])) {
            $id = $_GET['id'];
            $token = $_GET['token'];

            $password = mysqli_real_escape_string($connect, $_POST['password']);
            $cpassword = mysqli_real_escape_string($connect, $_POST['cpassword']);

            if($password === $cpassword) {
                $updatequery = mysqli_query($connect, "UPDATE voter_registration SET `password` = '$password',`cpassword` = '$cpassword' WHERE `id` = '$id' AND `token` = '$token'") or die(mysqli_error($connect));

                if($updatequery){
                    echo "<script> alert('Password updated!'); </script>";
    ?>
                    <script>
                        location.assign("../index.php");
                    </script>
    <?php
                } else {
                    echo "<script> alert('Password not updated!'); </script>";
                }
            } else {
                echo "<script> alert('Password didnot match!'); </script>";
            }
        } else {
            echo "<script> alert('Didnot receive any user credentials. Try again!'); </script>";
        }
    }

    ?>

</body>

</html>
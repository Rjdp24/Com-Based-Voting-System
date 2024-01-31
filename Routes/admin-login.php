<?php
require("../API/connection.php");
?>

<html>

<head>
    <title>Com Based Voting System - Admin Login</title>
    <link rel="stylesheet" href="../Routes Stylesheet/admin-login.css">
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
        <div class="user">
            <a href="../index.php">LOGIN AS USER</a>
        </div>
    </nav>
    <hr>
    <div class="heading">
        <h1>Tinsukia College Stu<span class="span">dent's Union Election</span></h1>
    </div>
    <div class="wrapper">
        <form method="POST">
            <h1>Admin Login</h1>
            <div class="inputbox">
                <input type="text" name="username" autocomplete="off" placeholder="Enter Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Enter password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
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

    if (isset($_POST['login'])) {
        $query1 = "SELECT * FROM `admin_login` WHERE `Username`='$_POST[username]'";
        $query2 = "SELECT * FROM `admin_login` WHERE `Password`='$_POST[password]'";
        $result1 = mysqli_query($connect, $query1);
        $result2 = mysqli_query($connect, $query2);

        if ((mysqli_num_rows($result1) == 1) && (mysqli_num_rows($result2) == 1)) {
            session_start();
            $_SESSION['AdminLoginId'] = $_POST['username'];
            header("location:../Routes/admin-panel-home.php");
        } elseif (mysqli_num_rows($result1) != 1) {
            echo "<script> alert('Incorrect Username'); </script>";
        } else {
            echo "<script> alert('Incorrect Password'); </script>";
        }
    }

    ?>

</body>

</html>
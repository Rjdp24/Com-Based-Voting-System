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
            <h1>Recover Your Account</h1>
            <div class="inputbox">
                <input type="email" name="email" autocomplete="off" placeholder="Enter registered E-mail" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="inputbox">
                <input type="tel" name="mobile" autocomplete="off" placeholder="Enter registered Mobile number" required>
                <i class='bx bxs-phone'></i>
            </div>
            <button type="submit" name="sendmail" class="btn">Send recovery E-mail</button>
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

    if (isset($_POST['sendmail'])) {
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);

        $emailMobileQuery = mysqli_query($connect, "SELECT * FROM voter_registration WHERE `email` = '$email' AND `mobile` = '$mobile'") or die(mysqli_error($connect));

        $emailMobileQueryCount = mysqli_num_rows($emailMobileQuery);

        if($emailMobileQueryCount) {

            $userdata = mysqli_fetch_assoc($emailMobileQuery);
            $username = $userdata['name'];
            $id = $userdata['id'];
            $token = $userdata['token'];

            $subject = "Account Recovery!";
            $body = "Hi $username! Click on the given link to reset your password: http://localhost/Com-Based-Voting-System/Forgot%20Password%20Routes/reset_password.php?token=$token&id=$id ";
            $sender_email = "From: sibuaich8@gmail.com";

            if(mail($email, $subject, $body, $sender_email)) {
                echo "<script> alert('Check your mail to recover your account!'); </script>";
    ?>
                <script>
                    location.assign("../index.php");
                </script>  
    <?php
            } else {
                echo "<script> alert('Email sending failed!'); </script>";
            }
        } else {
            echo "<script> alert('The email or mobile number you have entered is not registered!'); </script>";
        }
    }

    ?>

</body>

</html>
<?php
require("../API/connection.php");
?>

<html>

<head>
    <title>Com Based Voting System - Login</title>
    <link rel="stylesheet" href="../Voters Routes Stylesheet/registration.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../Resources/logo.png">
</head>

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
            <h1>Registration</h1>
            <div class="inputbox">
                <input type="text" name="fullname" autocomplete="off" placeholder="Full name" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="inputfield">
                <div class="inputbox">
                    <input type="email" name="email" autocomplete="off" placeholder="E-mail" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="inputbox">
                    <input type="tel" name="mobile" autocomplete="off" placeholder="Mobile number" required>
                    <i class='bx bxs-phone'></i>
                </div>
            </div>
            <div class="inputfield">
                <div class="inputbox">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="inputbox">
                    <input type="password" name="cpassword" placeholder="Confirm Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
            </div>
            <div class="checkbox">
                <h4>Gender :</h4>
                <label><input type="radio" name="gender" value="Male" required>&ensp;Male</label>

                <label><input type="radio" name="gender" value="Female" required>&ensp;Female</label>

                <label><input type="radio" name="gender" value="Other" required>&ensp;Other</label>
            </div>
            <button type="submit" name="register-btn" class="btn">Register</button>
            <div class="login-link">
                <p>Already a user? <a href="../index.php"> Login Here</a></p>
            </div>
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
    if (isset($_POST['register-btn'])) {
        $name = mysqli_real_escape_string($connect, $_POST['fullname']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);
        $cpassword = mysqli_real_escape_string($connect, $_POST['cpassword']);
        $gender = mysqli_real_escape_string($connect, $_POST['gender']);

        $token = bin2hex(random_bytes(15));

        $fetching = mysqli_query($connect, "SELECT * FROM voter_registration WHERE `mobile` = '$mobile'") or die(mysqli_error($connect));
        $fetching2 = mysqli_query($connect, "SELECT * FROM voter_registration WHERE `email` = '$email'") or die(mysqli_error($connect));
        if ((mysqli_num_rows($fetching) > 0) && (mysqli_num_rows($fetching2) > 0)) {
            echo "<script> alert('User with this e-mail and mobile number already exists!'); </script>";
    ?>
            <script>
                location.assign("../Voters Routes/registration.php");
            </script>
        <?php
        } elseif (mysqli_num_rows($fetching) > 0) {
            echo "<script> alert('User with this mobile number already exists!'); </script>";
        ?>
            <script>
                location.assign("../Voters Routes/registration.php");
            </script>
        <?php
        } elseif (mysqli_num_rows($fetching2) > 0) {
            echo "<script> alert('User with this e-mail already exists!'); </script>";
        ?>
            <script>
                location.assign("../Voters Routes/registration.php");
            </script>
            <?php
        } else {
            if ($password === $cpassword) {
                mysqli_query($connect, "INSERT INTO voter_registration(name, email, mobile, password, cpassword, gender, token) VALUES ('" . $name . "', '" . $email . "', '" . $mobile . "', '" . $password . "', '" . $cpassword . "', '" . $gender . "', '". $token ."')") or die(mysqli_error($connect));
                echo "<script> alert('Successfully registered!'); </script>";
            ?>
                <script>
                    location.assign("../Voters Routes/registration.php");
                </script>
    <?php
            } else {
                echo "<script> alert('Password and Confirm Password didnot match!'); </script>";
            }
        }
    }
    ?>

</body>

</html>
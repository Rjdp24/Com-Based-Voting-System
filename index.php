<?php
require("API/connection.php");
?>
<html>

<head>
    <title>Online Voting System - Login</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="Resources/logo.png">
</head>

<body>
    <nav>
        <div class="logo">
            <a href="#"><img src="Resources/logo.png">Tinsukia College</a>
        </div>
        <div class="admin">
            <a href="Routes/admin-login.php">LOGIN AS ADMIN</a>
        </div>
    </nav>
    <hr>
    <div class="heading">
        <h1>Tinsukia College Stu<span class="span">dent's Union Election</span></h1>
    </div>
    <div class="wrapper">
        <form method="POST">
            <h1>Login</h1>
            <div class="inputbox">
                <input type="tel" name="mobile" autocomplete="off" placeholder="Enter mobile number" required>
                <i class='bx bxs-phone'></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Enter password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="login_btn" class="btn">Login</button>
            <div class="register-link">
                <p>New user? <a href="Voters Routes/registration.php"> Register Here</a></p>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['login_btn'])) {
        $query1 = mysqli_query($connect, "SELECT * FROM voter_registration WHERE `mobile` = '$_POST[mobile]' AND `password` = '$_POST[password]' AND `cpassword` = '$_POST[password]'") or die(mysqli_error($connect));

        if (mysqli_num_rows($query1) == 1) {
            $fetch = mysqli_fetch_assoc($query1);

            $parts = explode(" ", $fetch['name']);
            $firstname = array_shift($parts);
            $lastname = implode(" ", $parts);

            session_start();
            $_SESSION['votername'] = $firstname;
            $_SESSION['voter_id'] = $fetch['id'];
            header("location: Voters Routes/voters_panel.php");
        } else {
            echo "<script> alert('Invalid credentials!'); </script>";
        }
    }
    ?>
</body>

</html>
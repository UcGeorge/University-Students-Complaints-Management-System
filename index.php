<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Homepage</title>

    <link rel="stylesheet" type="text/css" href="style/design.css">
</head>

<?php

session_start();

if (isset($_POST['student'])) {
    $_SESSION['user-type'] = 'student';
    header("Location: login\login.php");
}
if (isset($_POST['staff'])) {
    $_SESSION['user-type'] = 'staff';
    header("Location: login\login.php");
}
?>

<body>

    <div class="section">
        <div class="top">
            <div class="blank"></div>
            <div class="contact"></div>
            <div class="logins">
                <img id="pic" src="assets/img/logo.png" align="left">
                <div class="p">
                    <h4>LOG IN USING ACCOUNTS BELOW:</h4><br>
                    <form method="post">
                        <input class="b" type="submit" name="student" value="STUDENT LOGIN" />
                        <input class="b" type="submit" name="staff" value="STAFF LOGIN" />
                    </form>
                </div>
            </div>

            <div class="four">
                <div class="contain">
                    <a href="index.html" class="standby">UNILAG-CMS</a>
                    <a href="login/login.html" class "click">User Login</a>

                </div>
            </div>
            <div class="last">

            </div>
        </div>

        <div class="manquee"></div>
        <div class="end" style="height: 370px;
    background-size: cover;
    background-repeat: repeat-x;
    background: url('assets/img/compla.jpg');"> </div>

        <footer></footer>
    </div>
</body>

</html>
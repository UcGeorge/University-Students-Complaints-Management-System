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
                    <a href="index.html" class="standby">UNILAG-LMS</a>
                    <a href="login/login.html" class "click">User Login</a>

                </div>
            </div>
            <div class="last">

            </div>
        </div>

        <div class="manquee"></div>
        <div class="end"> </div>

        <footer></footer>
    </div>
</body>

</html>

<!-- <!DOCTYPE html>
<html>

<head>
    <title>Complaint Management System</title>
</head>

<body>
    <script type="text/javascript" src="script/login.js"></script>
    <div class="container">
        <div class="header">
            <h2>Log In</h2>
        </div>

        <form>
            <div>
                <label for="matric"> Matric no: </label>
                <input type="text" name="matric" onchange="newStudent.onMatricChange(event)" required>
            </div>
            <br>
            <div>
                <label for="password"> Password: </label>
                <input type="password" name="password" onchange="newStudent.onPasswordChange(event)" required>
            </div>

            <button onclick="newStudent.onSubmitLogIn()" type="submit" name="login_user"><b>Log in</b> </button>
        </form>
    </div>
</body>

</html> -->
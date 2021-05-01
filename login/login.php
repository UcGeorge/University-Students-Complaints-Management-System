<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login page</title>

    <link rel="stylesheet" type="text/css" href="../style/design.css">
</head>

<?php

session_start();
$user_type = $_SESSION['user-type'];
$id_placeholder = '';

if ($user_type == 'student') {
    $id_placeholder = 'Matric Number';
} else {
    $id_placeholder = 'Lecturer Number';
}

?>

<body>
    <img src="../assets/img/logoo.png" class="center">
    <div class="main">
        <h2>UNILAG CMS</h2>
        <div class="fill">
            <form class="form-info" id="student">
                <input type="text" class="input-field" placeholder="<?php echo $id_placeholder; ?>" required>
                <br />
                <input type="password" class="input-field" placeholder="Enter Password" required>
                <br />
                <input type="checkbox" class="checkbox" required><span>Remember Password</span>

                <div class="button">
                    <button type="submit" class="lbutton">Log In</button>
                </div>
            </form>
        </div>
    </div>


</body>

</html>
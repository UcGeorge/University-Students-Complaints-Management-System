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

// Constants
$USER_DOES_NOT_EXIST = 'User does not exist';
$PASSWORD_IS_WRONG = 'Password is wrong';
$VERIFIED = 'Validated';

// define variables and set to empty values
$userID = $password = $IDErr = $passErr = null;
$process_login = false;

// Runs when POST request has been sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required field `Matric no` is empty
    if (empty($_POST["id"])) {
        $IDErr = "Identification is required";
    } else {
        // Assign `matric` to $userID variable
        $userID = test_input($_POST["id"]);
        if (!filter_var($userID, FILTER_VALIDATE_INT)) {
            $IDErr = "Invalid matric number format";
        }
    }

    // Check if required field `Password` is empty
    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        // Assign `password` to $password variable
        $password = test_input($_POST["password"]);
    }

    // Set $process_login to true if there are no errors with the form data
    if (!isset($IDErr) && !isset($passErr)) {
        $process_login = true;
    }
}

// Filter input: remove trailing whitespaces, slashes, etc.
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Process login if $process_login is true
if ($process_login) {
    // Using cURL as the HTTP request library
    $curl = curl_init();

    // Set all request parameters
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:8080/University-Students-Complaints-Management-System/api/api/dashboard.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        // Add authorization to the header
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic ' . base64_encode($userID . ':' . $password)
        ),
    ));

    // Send the request and save the response in $response
    $response = curl_exec($curl);
    // Close the connection
    curl_close($curl);

    // JSON decode the response
    $dashboard_data = json_decode($response, true);

    // echo $response;

    if ($user_type != $dashboard_data['type']) {
        $IDErr = "User is not a $user_type, use the {$dashboard_data['type']} login portal.";
        $dashboard_data['message'] = 'not verified';
    }

    if ($dashboard_data['message'] == $VERIFIED) {
        // Set session variables
        $_SESSION["auth"] = 'Authorization: Basic ' . base64_encode($userID . ':' . $password);
        $_SESSION["dashboard"] = $dashboard_data;

        // Move to dashboard
        if ($dashboard_data['type'] == 'student') {
            header("Location: ..\student\studentDash.php");
        } else {
            header("Location: ..\lecturer\dashboard.html");
        }
        exit();
    } else {
        // Show unauthorized error messages if there are any
        if ($dashboard_data['message'] == $PASSWORD_IS_WRONG) {
            $passErr = $PASSWORD_IS_WRONG;
        } else if ($dashboard_data['message'] == $USER_DOES_NOT_EXIST) {
            $IDErr = $USER_DOES_NOT_EXIST;
        }
    }
}

?>

<body>
    <img src="../assets/img/logoo.png" class="center">
    <div class="main">
        <h2>UNILAG CMS<h2 style="font-weight: lighter;"><?php echo strtoupper($user_type); ?></h2>
        </h2>
        <div class="error-container">
            <p><?php echo $IDErr; ?></p>
            <p><?php echo $passErr; ?></p>
        </div>
        <div class="fill">
            <form method="post" class="form-info" id="student" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="id" value="<?php echo $userID; ?>" class="input-field" placeholder="<?php echo $id_placeholder; ?>">
                <input type="password" name="password" value="<?php echo $password; ?>" class="input-field" placeholder="Enter Password">
                <input type="checkbox" class="checkbox"><span>Remember Password</span>
                <div class="button">
                    <input type="submit" class="lbutton" value="Log In">
                </div>
            </form>
        </div>
    </div>

</body>

</html>
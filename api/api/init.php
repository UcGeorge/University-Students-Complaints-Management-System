<?php
// Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Access-Control-Allow-Origin, Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');

// Slap whoever doesn't have authentication. SMH, wasting my time and recourses.
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Private Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(
        array('message' => 'Please use your credentials. MTCHEWWWW')
    );
    exit;
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

include_once "../config/Database.php";
include_once "../config/Authenticator.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate authenticator
$authenticator = new Authenticator($db);

// Authenticate user
$user = $authenticator->authenticate($username, $password);
if (!isset($user['username'])) {
    header('WWW-Authenticate: Basic realm="Private Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(
        array('message' => $user['message'])
    );
    exit;
}

if ($user['type'] == 'admin') {
    header('WWW-Authenticate: Basic realm="Private Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(
        array('message' => 'This is not the admin dashboard!')
    );
    exit;
}

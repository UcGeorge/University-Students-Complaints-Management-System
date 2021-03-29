<?php
// Headers
header('Content-Type: application/json');

// Slap whoever doesn't have authentication. SMH, wasting my time and recourses.
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Private Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo json_encode(
        array('message' => 'Please use your credentials.')
    );
    exit;
}

$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

include_once "../config/Database.php";
include_once "../config/Authenticator.php";
include_once "../model/Student.php";
include_once "../model/Course.php";
include_once "../model/Complaint.php";

try {

    // Instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate models
    $students = new Student($db);
    $lecturers = new Lecturer($db);
    $courses = new Course($db);
    $complaints = new Complaint($db);

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

    // Final result
    $dashboard_data = array();
    $dashboard_data['user'] = array();
    $dashboard_data['courses'] = array();

    // Get validated user's courses
    $course_list = $courses->get_course($username, $user['type']);

    // Get complaints for each course
    foreach ($course_list as $course_code => $courde_data) {
        // Get complaints list for the course
        $course_complaints = $complaints->get_by_course($course_code);

        // Add all the data to an array
        $course = array(
            'course_code' => $course_code,
            'department' => $courde_data['department'],
            'year' => $courde_data['year'],
            'course_title' => $courde_data['course_title'],
            'complaints' => $course_complaints
        );

        // Add the course to the array of courses
        array_push($dashboard_data['courses'], $course);
    }

    // Get user's data
    if ($user['type'] == 'student') {
        $dashboard_data['user'] = $students->get_student($username);
    } else {
        $dashboard_data['user'] = $lecturers->get_lecturer($username);
    }

    // Output data
    echo json_encode($dashboard_data);
    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'Error' => $e->getMessage()
        )
    );
}

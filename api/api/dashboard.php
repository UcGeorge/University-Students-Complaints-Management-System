<?php
include "init.php";
include_once "../model/Student.php";
include_once "../model/Course.php";
include_once "../model/Complaint.php";

try {

    // Instantiate models
    $students = new Student($db);
    $lecturers = new Lecturer($db);
    $courses = new Course($db);
    $complaints = new Complaint($db);

    // Final result
    $dashboard_data = array();
    $dashboard_data['user'] = array();
    $dashboard_data['courses'] = array();
    $dashboard_data['message'] = "Validated";

    // Get user's data
    if ($user['type'] == 'student') {
        $dashboard_data['user'] = $students->get_student($username);
        $dashboard_data['type'] = 'student';
    } else {
        $dashboard_data['user'] = $lecturers->get_lecturer($username);
        $dashboard_data['type'] = 'staff';
    }

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

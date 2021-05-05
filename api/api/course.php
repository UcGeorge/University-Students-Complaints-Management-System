<?php

include "init.php";

if (isset($_GET['course_code'])) {
    $course_code = $_GET['course_code'];
} else {
    echo json_encode(
        array('message' => 'Relevant parameter <course code> is missing.')
    );
    exit;
}


try {
    include "../model/Course.php";
    $courses = new Course($db);
    $list_of_tags = $courses->get_tags($course_code);
    $lecturers = $courses->get_lecturers($course_code);

    include "../model/Complaint.php";
    $complaints = new Complaint($db);
    $num_open = $complaints->get_num_open($course_code);
    $num_closed = $complaints->get_num_closed($course_code);
    $num_personal = $complaints->get_num_personal($course_code, $username);
    $course_complaints = $complaints->get_by_course($course_code);

    echo json_encode(array(
        'open' => $num_open,
        'closed' => $num_closed,
        'personal' => $num_personal,
        'complaints' => $course_complaints,
        'tags' => $list_of_tags,
        'lecturers' => $lecturers
    ));
    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'Error' => $e->getMessage()
        )
    );
}

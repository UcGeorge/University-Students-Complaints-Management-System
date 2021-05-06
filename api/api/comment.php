<?php

include "init.php";

if (isset($_POST['id'])) {
    $id = base64_decode($_POST['id']);
    $text = $_POST['text'];
} else {
    echo json_encode(
        array('message' => 'Relevant parameter <id> is missing.')
    );
    exit;
}


try {
    // include "../model/Complaint.php";
    // $complaints = new Complaint($db);
    include_once "../model/Comment.php";
    $comments = new Comment($db);

    if (isset($_POST['student'])) {
        $author = $_POST['student'];
        $type = 'student';
    } else {
        $author = $_POST['lecturer'];
        $type = 'lecturer';
    }

    echo json_encode(
        array('message' => $comments->add_comment($id, $text, $author, $type))
    );
    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'Error' => $e->getMessage()
        )
    );
}

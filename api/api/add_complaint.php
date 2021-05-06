<?php

include "init.php";

if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['category']) || !isset($_POST['desc']) || !isset($_POST['author']) || !isset($_POST['tags'])) {
    echo json_encode(
        array('message' => 'Relevant parameter is missing.')
    );
    exit;
}


try {
    include_once "../model/Complaint.php";
    $complaints = new Complaint($db);
    echo $_POST['tags'];
    echo json_encode(array('message' => $complaints->add_complaint(
        $_POST['id'],
        $_POST['title'],
        $_POST['desc'],
        $_POST['category'],
        $_POST['author'],
        json_decode($_POST['tags'])
    )));

    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'Error' => $e->getMessage()
        )
    );
}

<?php

include "init.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo json_encode(
        array('message' => 'Relevant parameter <id> is missing.')
    );
    exit;
}


try {
    include_once "../model/Comment.php";
    $comments = new Comment($db);
    echo json_encode($comments->get_comments($id));
    exit;
} catch (Exception $e) {
    echo json_encode(
        array(
            'Error' => $e->getMessage()
        )
    );
}

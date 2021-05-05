<?php

class Comment
{
    // DB stuff
    private $conn;
    private $table = 'comment';

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get comments for complaint
    public function get_comments($id)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `complaint` = '$id'";

        // echo $sql;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint = array(
                'id' => $row["id"],
                'student' => $row["student"],
                'lecturer' => $row["lecturer"],
                'text' => $row["text"],
                'dateadded' => $row["dateadded"]
            );

            array_push(
                $complaints_arr,
                $complaint
            );
        }

        return $complaints_arr;
    }
}

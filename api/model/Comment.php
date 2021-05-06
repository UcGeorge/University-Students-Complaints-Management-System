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
                'student' => $row["author-s"],
                'lecturer' => $row["author-r"],
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

    // Get comments for complaint
    public function add_comment($id, $text, $author, $type)
    {
        // echo $id, $text, $author, $type;
        // Create query
        if ($type == 'student') {
            $sql = "INSERT INTO 
                `$this->table` 
                (`author-s`, `complaint`, `text`) 
            VALUES 
                ('$author', '$id', '$text')";
        } else {
            $sql = "INSERT INTO 
                `$this->table` 
                (`author-r`, `complaint`, `text`) 
            VALUES 
                ('$author', '$id', '$text')";
        }

        if ($this->conn->query($sql) === TRUE) {
            return "New record created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

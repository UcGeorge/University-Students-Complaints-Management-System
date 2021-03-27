<?php
class Complaint
{
    // DB stuff
    private $conn;
    private $table = 'complaint';

    // Complaint Properties
    public $id;
    public $author;
    public $category;
    public $status;
    public $title;
    public $description;
    public $tags;
    public $subscribers;
    public $dateadded;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Complaints for student
    public function get_for_student($student)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` IN(
                        SELECT
                            `course`
                        FROM
                            `student-course`
                        WHERE
                            `student` = $student
                    )";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint_id = $row["id"];

            $complaint = array(
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'tags' => $row["tags"],
                'subscribers' => $row["subscribers"],
                'dateadded' => $row["dateadded"]
            );

            $complaints_arr[$complaint_id] = $complaint;
        }

        return $complaints_arr;
    }

    // Get Complaints for lecturer's inbox
    public function get_for_lecturer($lecturer)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` IN(
                        SELECT
                            `course`
                        FROM
                            `lecturer-course`
                        WHERE
                            `lecturer` = $lecturer
                    )";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint_id = $row["id"];

            $complaint = array(
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'tags' => $row["tags"],
                'subscribers' => $row["subscribers"],
                'dateadded' => $row["dateadded"]
            );

            $complaints_arr[$complaint_id] = $complaint;
        }

        return $complaints_arr;
    }

    // Get Complaints by course/category
    public function get_by_course($course_code)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` = $course_code";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint_id = $row["id"];

            $complaint = array(
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'tags' => $row["tags"],
                'subscribers' => $row["subscribers"],
                'dateadded' => $row["dateadded"]
            );

            $complaints_arr[$complaint_id] = $complaint;
        }

        return $complaints_arr;
    }
}

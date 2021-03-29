<?php
class Course
{
    // DB stuff
    private $conn;
    private $table = 'course';

    // Course Properties
    public $course_code;
    public $department;
    public $course_title;
    public $year;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Course
    public function get_course(string $id, string $type): array
    {
        // Create query
        $sql = $type == 'student' ?
            "SELECT
            *
        FROM
            `-$this->table`
        WHERE
            `course_code` IN(
                SELECT
                    `course`
                FROM
                    `student-course`
                WHERE
                    `student` = $id
            )" :
            "SELECT
            *
        FROM
            `-$this->table`
        WHERE
            `course_code` IN(
                SELECT
                    `course`
                FROM
                    `lecturer-course`
                WHERE
                    `lecturer` = $id
            )";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $result_arr = array(
                'course_code' => $row['course_code'],
                'department' => $row['department'],
                'year' => $row['year'],
                'course_title' => $row['course_title']
            );
        }

        return $result_arr;
    }
}

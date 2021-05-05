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
        $student_query =
            "SELECT
            *
        FROM
            `$this->table`
        WHERE
            `course_code` IN(
                SELECT
                    `course`
                FROM
                    `student-course`
                WHERE
                    `student` = '$id'
            )";
        $lecturer_query =
            "SELECT
            *
        FROM
            `$this->table`
        WHERE
            `course_code` IN(
                SELECT
                    `course`
                FROM
                    `lecturer-course`
                WHERE
                    `lecturer` = '$id'
            )";

        $sql = $type == 'student' ? $student_query : $lecturer_query;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $course_code = $row["course_code"];

            $course = array(
                'department' => $row['department'],
                'year' => $row['year'],
                'course_title' => $row['course_title']
            );

            $result_arr[$course_code] = $course;
        }

        return $result_arr;
    }

    // Get Tags
    public function get_tags(string $id): array
    {
        // Create query
        $sql =
            "SELECT
            *
        FROM
            `tag`
        WHERE
            `category` = '$id'";

        // echo $sql;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $tag = $row["name"];
            array_push($result_arr, $tag);
        }

        return $result_arr;
    }

    // Get Lecturers for course
    public function get_lecturers(string $course_code): array
    {
        // Create query
        $sql =
            "SELECT
            `name`
        FROM
            `lecturer`
        WHERE
            `lec_no` IN(
                SELECT
                    `lecturer`
                FROM
                    `lecturer-course`
                WHERE
                    `course` = '$course_code'
            )";

        // echo $sql;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            array_push($result_arr, $row["name"]);
        }

        return $result_arr;
    }
}

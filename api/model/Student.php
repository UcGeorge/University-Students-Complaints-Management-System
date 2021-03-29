<?php
class Student
{
    // DB stuff
    private $conn;
    private $table = 'student';

    // Student Properties
    public $mat_no;
    public $name;
    public $department;
    public $year;
    public $password;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all students authentication credentials
    public function get_auth()
    {
        // Create query
        $sql = "SELECT
                    `mat_no`,
                    `password`
                FROM
                    $this->table";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $result_arr[$row["mat_no"]] = $row["password"];
        }

        return $result_arr;
    }

    // Get student
    public function get_student($mat_no)
    {
        // Create query
        $sql =
            "SELECT
            $this->table.`mat_no`,
            $this->table.`name`,
            `department`.`name` AS `department`,
            $this->table.`year`,
            $this->table.`password`
        FROM
            $this->table
        INNER JOIN `department` ON $this->table.`department` = `department`.`id`
        WHERE
            `mat_no` = '$mat_no'";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $result_arr = array(
                'mat_no' => $row['mat_no'],
                'name' => $row['name'],
                'department' => $row['department'],
                'year' => $row['year'],
                'password' => $row['password']
            );
        }

        return $result_arr;
    }
}

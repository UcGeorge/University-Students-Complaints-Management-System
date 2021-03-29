<?php
class Lecturer
{
    // DB stuff
    private $conn;
    private $table = 'lecturer';

    // Lecturer Properties
    public $lec_no;
    public $name;
    public $password;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all lecturer authentication credentials
    public function get_auth()
    {
        // Create query
        $sql = "SELECT
                    `lec_no`,
                    `password`
                FROM
                    $this->table";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $result_arr[$row["lec_no"]] = $row["password"];
        }

        return $result_arr;
    }

    // Get lecturer
    public function get_lecturer($lec_no)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `lec_no`=$lec_no";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $result_arr = array();

        // Output data of each row to the result array
        while ($row = $result->fetch_assoc()) {
            $result_arr = array(
                'lec_no' => $row['lec_no'],
                'name' => $row['name'],
                'department' => $row['department'],
                'year' => $row['year'],
                'password' => $row['password']
            );
        }

        return $result_arr;
    }
}

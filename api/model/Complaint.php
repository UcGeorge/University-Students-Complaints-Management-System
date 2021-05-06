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
                            `student` = '$student'
                    )";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint = array(
                'id' => $row["id"],
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'dateadded' => $row["dateadded"]
            );

            array_push($complaints_arr, $complaint);
        }

        return $complaints_arr;
    }

    // Get Complaints for lecturer's inbox
    public function get_for_lecturer($lecturer)
    {
        // Create query
        $sql = "SELECT
                    $this->table.`id`,
                    `student`.`name` as `author`,
                    $this->table.`category`,
                    $this->table.`status`,
                    $this->table.`title`,
                    $this->table.`description`,
                    $this->table.`dateadded`
                FROM
                    $this->table
                INNER JOIN `student` ON $this->table.`author` = `student`.`mat_no`
                WHERE
                    `category` IN(
                        SELECT
                            `course`
                        FROM
                            `lecturer-course`
                        WHERE
                            `lecturer` = '$lecturer'
                    )";

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {
            $complaint = array(
                'id' => $row["id"],
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'dateadded' => $row["dateadded"]
            );

            array_push($complaints_arr, $complaint);
        }

        return $complaints_arr;
    }

    // Get Complaints by course/category
    public function get_by_course($course_code)
    {
        // Create query
        $sql = "SELECT
                    $this->table.`id`,
                    `student`.`name` as `author`,
                    $this->table.`category`,
                    $this->table.`status`,
                    $this->table.`title`,
                    $this->table.`description`,
                    $this->table.`dateadded`
                FROM
                    $this->table
                INNER JOIN `student` ON $this->table.`author` = `student`.`mat_no`
                WHERE
                    `category` = '$course_code'";
        // echo $sql;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {

            // Create query
            $sql = "SELECT
                    *
                FROM
                    `student-complaint`
                WHERE
                    `complaint` = {$row["id"]}";

            // Execute
            if ($result2 = $this->conn->query($sql)) {
                $num = mysqli_num_rows($result2);
            } else {
                $num = 0;
            }

            // Create query
            $sql = "SELECT
                    `tag`.`name` as `name`
                FROM
                    `tag-complaint`
                INNER JOIN `tag` ON `tag-complaint`.`tag` = `tag`.`id`
                WHERE
                    `complaint` = '{$row["id"]}'";

            // echo $sql;

            // Execute
            if ($result3 = $this->conn->query($sql)) {
                $tag_arr = array();

                // Output data of each row to the result array
                while ($row2 = $result3->fetch_assoc()) {
                    $tag = $row2["name"];
                    array_push($tag_arr, $tag);
                }
            } else {
                $tag_arr = [];
            }


            $complaint = array(
                'id' => $row["id"],
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'dateadded' => $row["dateadded"],
                'subscribers' => $num,
                'tags' => $tag_arr
            );

            array_push($complaints_arr, $complaint);
        }

        return $complaints_arr;
    }

    // Get number of closed complaints by course/category
    public function get_num_closed($course_code)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` = '$course_code'
                    AND
                    `status` = 'close'";

        // Execute
        if ($result = $this->conn->query($sql)) {
            $num = mysqli_num_rows($result);
        } else {
            $num = 0;
        }

        return $num;
    }

    // Get number of open complaints by course/category
    public function get_num_open($course_code)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` = '$course_code'
                    AND
                    `status` = 'open'";

        // Execute
        if ($result = $this->conn->query($sql)) {
            $num = mysqli_num_rows($result);
        } else {
            $num = 0;
        }

        return $num;
    }

    // Get number of open complaints by course/category
    public function get_num_personal($course_code, $user)
    {
        // Create query
        $sql = "SELECT
                    *
                FROM
                    $this->table
                WHERE
                    `category` = '$course_code'
                    AND
                    `status` = 'open'
                    AND
                    `author` = $user";

        // Execute
        if ($result = $this->conn->query($sql)) {
            $num = mysqli_num_rows($result);
        } else {
            $num = 0;
        }

        return $num;
    }

    // Get Complaints by course/category
    public function get_single($id)
    {
        // Create query
        $sql = "SELECT
                    $this->table.`id`,
                    `student`.`name` as `author`,
                    $this->table.`category`,
                    $this->table.`status`,
                    $this->table.`title`,
                    $this->table.`description`,
                    $this->table.`dateadded`
                FROM
                    $this->table
                INNER JOIN `student` ON $this->table.`author` = `student`.`mat_no`
                WHERE
                    `id` = '$id'";
        // echo $sql;

        // Execute
        $result = $this->conn->query($sql);

        // Complaints array
        $complaints_arr = array();

        // Output data of each row to complaint array
        while ($row = $result->fetch_assoc()) {

            // Create query
            $sql = "SELECT
                    *
                FROM
                    `student-complaint`
                WHERE
                    `complaint` = {$row["id"]}";

            // Execute
            if ($result2 = $this->conn->query($sql)) {
                $num = mysqli_num_rows($result2);
            } else {
                $num = 0;
            }

            // Create query
            $sql = "SELECT
                    `tag`.`name` as `name`
                FROM
                    `tag-complaint`
                INNER JOIN `tag` ON `tag-complaint`.`tag` = `tag`.`id`
                WHERE
                    `complaint` = '{$row["id"]}'";

            // echo $sql;

            // Execute
            if ($result3 = $this->conn->query($sql)) {
                $tag_arr = array();

                // Output data of each row to the result array
                while ($row2 = $result3->fetch_assoc()) {
                    $tag = $row2["name"];
                    array_push($tag_arr, $tag);
                }
            } else {
                $tag_arr = [];
            }


            $complaint = array(
                'id' => $row["id"],
                'author' => $row["author"],
                'category' => $row["category"],
                'status' => $row["status"],
                'title' => $row["title"],
                'description' => $row["description"],
                'dateadded' => $row["dateadded"],
                'subscribers' => $num,
                'tags' => $tag_arr
            );

            $complaints_arr = $complaint;
        }

        return $complaints_arr;
    }

    // Add complaint for category
    public function add_complaint($iid, $title, $desc, $cat, $auth, $tags)
    {
        // echo $id, $text, $author, $type;
        // Create query
        $sql = "INSERT INTO 
                    `complaint` (`id`, `author`, `category`, `title`, `description`) 
                VALUES
                    ('$iid', '$auth', '$cat', '$title', '$desc')";

        // echo $sql;

        if ($this->conn->query($sql) === TRUE) {
            // return "New record created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }

        foreach ($tags as $tag) {
            $sql = "INSERT INTO 
                    `tag-complaint` (`tag`, `complaint`) 
                VALUES
                    ($tag, '$iid')";

            if ($this->conn->query($sql) === TRUE) {
                // return "New record created successfully";
            } else {
                return "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }

        return 'success';
    }
}

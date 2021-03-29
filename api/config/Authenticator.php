<?php
include_once "../model/Student.php";
include_once "../model/Lecturer.php";
class Authenticator
{
    // DB stuff
    private $conn;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function authenticate(string $username, string $password): array
    {
        // Instantiate student and lecturer DB connectors
        $student_db = new Student($this->conn);
        $lecturer_db = new Lecturer($this->conn);

        // Get students and lecturers credentials
        $student_credentials = $student_db->get_auth();
        $lecturer_credentials = $lecturer_db->get_auth();

        // Check if user exists as a student
        if (array_key_exists($username, $student_credentials)) {
            // User exists as a student, check if password is wrong
            if ($student_credentials[$username] != $password) {
                header('WWW-Authenticate: Basic realm="Private Area"');
                header('HTTP/1.0 401 Unauthorized');
                return array(
                    'username' => null,
                    'type' => null,
                    'message' => 'Password is wrong'
                );
            } else {
                // Return user and type.
                return array(
                    'username' => $username,
                    'type' => 'student',
                    'message' => 'Verified'
                );
            }

            // Check if user exists as a lecturer
        } else if (array_key_exists($username, $lecturer_credentials)) {
            // User exists as a lecturer, check if password is wrong
            if ($lecturer_credentials[$username] != $password) {
                header('WWW-Authenticate: Basic realm="Private Area"');
                header('HTTP/1.0 401 Unauthorized');
                return array(
                    'username' => null,
                    'type' => null,
                    'message' => 'Password is wrong'
                );
            } else {
                // Return user and type.
                return array(
                    'username' => $username,
                    'type' => $username == '000000000' ? 'admin' : 'lecturer',
                    'message' => 'Verified'
                );
            }

            // User does not exist
        } else {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            return array(
                'username' => null,
                'type' => null,
                'message' => 'User does not exist'
            );
        }
    }
}

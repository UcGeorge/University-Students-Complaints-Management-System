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

        // Check if PHP_AUTH_USER is not part of the authorized users
        if (!array_key_exists($username, $student_credentials) && !array_key_exists($username, $lecturer_credentials)) {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            return array(
                'username' => null,
                'type' => null,
                'message' => 'User does not exist'
            );
        }

        // User exists and is a student, check if password is wrong
        if ($student_credentials[$username] != $password) {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            return array(
                'username' => null,
                'type' => null,
                'message' => 'Password is wrong'
            );
        }

        // User exists and is a lecturer, check if password is wrong
        if ($lecturer_credentials[$username] != $password) {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            return array(
                'username' => null,
                'type' => null,
                'message' => 'Password is wrong'
            );
        }

        // Check the type of user
        $type = $username == '000000000' ? 'admin' : (array_key_exists($username, $student_credentials) ? 'student' : 'lecturer');

        // Return user and type.
        return array(
            'username' => $username,
            'type' => $type,
            'message' => 'Verified'
        );
    }
}

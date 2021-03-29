<?php
class Database
{
    // DB Params
    private $host = 'localhost';
    private $db_name = 'cms';
    private $username = 'cms_admin';
    private $password = '1UyYMLLttp9Pmfp4sA';
    private $conn;

    // DB Connect
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db_name
            );

            // Check connection
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $this->conn;
    }
}

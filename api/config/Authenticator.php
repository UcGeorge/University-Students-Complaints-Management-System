<?php
class Authenticator
{
    public function authenticate($username, $password, $credentials)
    {
        // Check if PHP_AUTH_USER is not part of the authorized users
        if (!array_key_exists($username, $credentials)) {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(
                array('message' => 'User does not exist!')
            );
            return false;
        }

        // User exists, check if password is wrong
        if ($credentials[$username] != $password) {
            header('WWW-Authenticate: Basic realm="Private Area"');
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(
                array('message' => 'Password is wrong!')
            );
            return false;
        }
        return true;
    }
}

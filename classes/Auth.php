<?php

include 'autoload.php';

class Auth {
    private $username;
    private $password;
    private $mysqli;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;

        $this->mysqli = (Database::getInstance())->getConnection();
    }

    public function login () {
        if($this->validate_username($this->username) && $this->validate_password($this->password)) {
            $sql = "SELECT * FROM `users` WHERE `username` = '$this->username'";
            $result = $this->mysqli->query($sql);
            if($result->num_rows) { 
                $row = $result->fetch_assoc();
                
                if($this->password == $row['password'])
                    return true;
                else
                    return false;
            }
        }

        return false;
    }

    public function register() {
        // if(!$this->validate_username($this->username) || !$this->validate_password($this->password)) 
        //     return false;
        
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('".$this->username."', '".$this->password."')";
            
            if($this->mysqli->query($sql))
                return true; 
            else
                return false;
    }

    private function validate_username() {
        return preg_match('/[\w\.\-\_]+\@\w+\.[a-zA-Z]{2,5}/i', $this->username);
    }

    private function validate_password() {
        return (strlen($this->password) >= 5);
    }
}


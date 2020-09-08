<?php

class DbOperation
{
    private $conn;
    public $idUser;
    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    //Function to create a new user
    public function createUser( $name, $email, $pass)
    {
        if (!$this->isUserExist($name,$email)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($name, $email)
    {
        $stmt = $this->conn->prepare("SELECT idUser FROM user WHERE name = ? or email=?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    private function isLogInCorrect($name, $password)
    {
        $stmt = $this->conn->prepare("SELECT idUser FROM user WHERE name = ? and password=?");
        $stmt->bind_param("ss", $name, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    
public function logInUser($name, $pass){
         $password= md5($pass);
        if ($this->isUserExist($name,$pass)){
            if($this->isLogInCorrect($name,$password)){
               return ALL_RIGHT;
               }else{
               return USER_EXIST;
               }
        }else{
               return USER_NOT_EXIST;
        }

    }

public function createResult( $name, $date, $userScore, $enemyScore)
    {
        if ($this->isUserExist($name,$date)) {
            $stmt = $this->conn->prepare("INSERT INTO result ( idUser, date, userScore, enemyScore ) SELECT  idUser, '$date', '$userScore', '$enemyScore' FROM user WHERE   name = '$name'");
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


}
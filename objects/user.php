<?php

class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $first_name;
    public $last_name;
    public $password;
    public $email;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // register method
    function register(){

        if($this->isAlreadyExist()){
            return false;
        }
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    first_name=:first_name, last_name=:last_name, password=:password, email=:email";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->first_name));
        $this->username=htmlspecialchars(strip_tags($this->last_name));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind values
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);

        // execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    // login method
    function login(){
        // select all query
        $query = "SELECT *
                FROM
                    " . $this->table_name . "
                WHERE
                    email='".$this->email."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    //email validation method
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . "
            WHERE
                email='".$this->email."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //user id validation method
    function checkUser($id){
        $query = "SELECT *
            FROM
                " . $this->table_name . "
                WHERE
                    id= $id ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    //list users method
    function listUsers($id){
        $query = "SELECT *
            FROM
                " . $this->table_name . "
            WHERE
                id!= $id ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
       $stmt->execute();
       if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       }
       else{
           return false;
       }
    }

}

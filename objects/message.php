<?php

class Message{

    // database connection and table name
    private $conn;
    private $table_name = "messages";

    // object properties
    public $sender_user_id;
    public $receiver_user_id;
    public $message;
    public $epoch;
    public $user_id_a;
    public $user_id_b;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // sending message method
    function send_message(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                sender_id=:sender_id,
                receiver_id=:receiver_id,
                message=:message";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->message=htmlspecialchars(strip_tags($this->message));
        $timeNow =  $this->getTime();

        // bind values
        $stmt->bindParam(":sender_id", $this->sender_user_id);
        $stmt->bindParam(":receiver_id", $this->receiver_user_id);
        $stmt->bindParam(":message", $this->message);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return $stmt->errorInfo();
    }
    //view messages method
    function view_messages($user_id_a, $user_id_b){
        // query to select messages
        $query = "SELECT *
              FROM
                  " . $this->table_name . "
              WHERE
                  (`sender_id` = $user_id_a and `receiver_id` = $user_id_b) or (`sender_id` = $user_id_b and `receiver_id` = $user_id_a)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            return false;// sql errors
        }
    }
    function getTime(){
        $time = strtotime("now");
        return $time;
    }

}

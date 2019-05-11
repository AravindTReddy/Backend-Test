<?php

session_start();
// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';

if($_SERVER["REQUEST_METHOD"] == "GET"){
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare user object
$user = new User($db);
// set ID property of user to be edited

$data = json_decode(file_get_contents("php://input"));

$user->id = $data->requester_user_id;

//validating the user
$stmt = $user->checkUser($user->id);
if($stmt){
   $stmt = $user->listUsers($user->id);
   $user_arr=array(
       "users" => $stmt
   );
}
// read the details of user to be edited
else{
  $user_arr=array(
    "error_code" => 500,
    "error_title" => "Invalid Id",
    "error_message" => "The requested Id is not found, Please try again.",
  );
}
print_r(json_encode($user_arr));
// make it json format
}
else {
  $error_arr=array(
      "error_code" => 100,
      "error_title" => "Wrong Request method",
      "error_message" => "I am GET friendly! Sorry POST",
  );
  print_r(json_encode($error_arr));
}

?>

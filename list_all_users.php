<?php

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
//validating user data
if(!empty($data)){
$user->id = $data->requester_user_id;

//validating the user
$stmt = $user->checkUser($user->id);
if($stmt){
   $stmt = $user->listUsers($user->id);
   $user_arr=array(
       "users" => $stmt
   );
}
else{
  $user_arr=array(
    "error_code" => 301,
    "error_title" => "Invalid Id",
    "error_message" => "The requested Id is not found, Please try again.",
  );
}
}
else{
  $user_arr=array(
      "error_code" => 103,
      "error_title" => "No Data Exception",
      "error_message" => "Please provide me some data and try again.",
  );
}
}
else {
  $user_arr=array(
      "error_code" => 500,
      "error_title" => "Wrong Request method",
      "error_message" => "I am GET friendly! Sorry",
  );
}
// make it json format
print_r(json_encode($user_arr));
?>

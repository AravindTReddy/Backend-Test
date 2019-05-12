<?php

// include database and object files
include_once 'config/database.php';
include_once 'objects/user.php';
//request method validation
if($_SERVER["REQUEST_METHOD"] == "POST"){

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare user object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data)){

$valid = $user->validatelogin($data->email, $data->password);

if(empty($valid)){
// set user property values
$user->email = $data->email;
$user->password = $data->password;

// read the details of user to be edited
$stmt = $user->login();
if($stmt->rowCount() > 0){
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $user_arr=array(
        "id" => $row['id'],
        "email" => $row['email'],
        "first_name" => $row['first_name'],
        "last_name" => $row['last_name']
    );
}
else{
    $user_arr=array(
        "error_code" => 101,
        "error_title" => "Login Failure",
        "error_message" => "Wrong email or Password combination!",
    );
}
}
else {
  $user_arr=array(
      "error_code" => 102,
      "error_title" => "Login Failure",
      "error_message" => $valid,
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
// make it json format
print_r(json_encode($user_arr));
}
else {
  $error_arr=array(
      "error_code" => 500,
      "error_title" => "Wrong Request method",
      "error_message" => "I am POST friendly! Sorry",
  );
  print_r(json_encode($error_arr));
}
?>

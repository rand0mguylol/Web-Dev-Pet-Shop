<?php

// function createUser($postArray, $connection,  $errorArray ){
//   $firstName = validateText($postArray["firstName"]);
//   $lastName = validateText($postArray["lastName"]);

//   $filters = [
//     "mobileNumber" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^[1-9][0-9]{8,9}$/")),
//     "email"=> FILTER_SANITIZE_EMAIL,
//     "password" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/"))
//   ];

//   $sanitizeInput = filter_input_array(INPUT_POST, $filters);

//   if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
//     array_push($errorArray, "email");
//   }else{
//     $email = $sanitizeInput["email"];
//   }

//   if(!$sanitizeInput["mobileNumber"]){
//     array_push($errorArray, "mobileNumber");
//   }else{
//     $mobileNumber = $sanitizeInput["mobileNumber"];
//   }

//   if (!$errorArray){
//     $password = $sanitizeInput["password"];
//     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//     $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber) VALUES (?, ?, ?, ?, ?);");
//     $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $mobileNumber);

//     $stmt->execute();
//     $id = mysqli_insert_id($connection);
//     $stmt->close();

//     $stmt = $connection->prepare("INSERT INTO role(userId, userRole) VALUES (?, 'CUSTOMER');");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $stmt->close();

//     header("Location: index.php");
//     exit();
//   }
// }

$jsonFile = file_get_contents("sql.json");

$result = json_decode($jsonFile, true);


for($i = 0; $i<count($result); $i++){
  $hashedPassword = password_hash($result[$i]["userPassword"], PASSWORD_DEFAULT);
  $result[$i]["userPassword"] = $hashedPassword;
  // $result[$i]["firstName"] = "test";
  // echo $r["userPassword"];
  // foreach($r as $z => $v){
  //   echo $z . ": " . $v;
  //   echo "<br>";
  // }
}

$final = json_encode($result);
file_put_contents("userJson.json", $final);

// foreach($r as $key => $value){
//   // echo "<pre>";
// // var_dump($result);
// // echo "</pre>";
// echo $key . " " . $value;
// }
// echo "<pre>";
// var_dump($result);
// echo "</pre>";

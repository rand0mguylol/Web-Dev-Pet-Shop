<?php

session_start();

if(isset($_POST["signup"])) {
    require_once "../function/db.php";
    require_once "../function/helpers.php"; 
    
    $errorArray = [];
    $firstName = sanitizeText($_POST["firstName"]);
    $lastName = sanitizeText($_POST["lastName"]);
    $mobileNumber = validateMobileNumber($_POST["mobileNumber"]);
    $password = validatePassword($_POST["password"]);
    $email = validateEmail($_POST["email"]);

    $newUser = array(
      "firstName" => $firstName,
      "lastName" => $lastName,
      "mobileNumber" => $mobileNumber,
      "email" => $email,
      "password" => $password
    );

    foreach($newUser as $key => $value){
      if($value === false){
        array_push($errorArray, $key);
      }
    }

    if($errorArray){
      $_SESSION["accountCreationError"] = $errorArray;     
      header("Location:  ../register.php" );
      exit();
    }else{
      createUser($newUser, $connection);
      $_SESSION["accountCreation"] = "success";    
      header("Location:  ../index.php" );
      exit();
    }
}


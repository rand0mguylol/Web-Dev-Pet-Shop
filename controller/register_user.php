<?php

session_start();

if(isset($_POST["signup"])) {
    require_once "../function/db.php";
    require_once "../function/helpers.php"; 
    $error = createUser($_POST, $connection);

    if($error){
      $_SESSION["error"] = $error;
      header("Location:  ../register.php" );
      exit();
    }else{
      $_SESSION["accountCreation"] = "success";
      header("Location:  ../index.php" );
      exit();
    }
  }


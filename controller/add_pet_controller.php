<?php
session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (isset($_POST["addPet"])){

  $result = adminValidatePet($_POST, true);

  if(isAssociativeArray($result)){
    adminAddPet($connection, $result);
    $_SESSION["addPetMessage"] = "Successfully Added";
  }else{
    $_SESSION["addPetError"] = $result;
  }
  header("Location: ../add_pet.php");
  exit();
}


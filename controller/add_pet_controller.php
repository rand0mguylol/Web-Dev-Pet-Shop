<?php

// Add New Pet
// To handle request for adding new pet
// POST received from add_pet.php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (isset($_POST["addPet"])){

  $result = adminValidatePet($_POST);

  if(isAssociativeArray($result)){
    adminAddPet($connection, $result);
    $_SESSION["alertMessage"][] = "Successfully Added";
  }else{
    $_SESSION["addPetError"] = $result;
  }
  header("Location: ../add_pet.php");
  exit();
}


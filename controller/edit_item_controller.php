<?php
session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";


// To handle edit item POST request from edit_item.php (name of button = "updateItem")
if (isset($_POST["updateItem"]) && $_GET["type"] === "pet"){

  $result = adminValidatePet($_POST);

  // If array is associative, it is an error array, means validation failed
  if(isAssociativeArray($result)){
    adminUpdatePet($connection, $result, $_GET["id"]);
    $_SESSION["alertMessage"][] = "Item Successfully Updated";
  }else{
    $_SESSION["updateItemError"] = $result;
  }
  header("Location: ../edit_item.php?type=$_GET[type]&id=$_GET[id]");
  exit();
}


if (isset($_POST["updateItem"]) && $_GET["type"] === "product"){
  
  $result = adminValidateProduct($_POST);

  if(isAssociativeArray($result)){
    adminUpdateProduct($connection, $_GET["id"], $result);
    $_SESSION["alertMessage"][] = "Item Successfully Updated";
  }else{
    $_SESSION["updateItemError"] = $result;
  }
  header("Location: ../edit_item.php?type=$_GET[type]&id=$_GET[id]");
  exit();
}





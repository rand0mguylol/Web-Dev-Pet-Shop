<?php
session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (isset($_POST["updateItem"]) && $_GET["type"] === "pet"){

  $result = adminValidatePet($_POST);

  if(isAssociativeArray($result)){
    adminUpdatePet($connection, $result, $_GET["id"]);
    $_SESSION["updateItemMessage"] = "Item Successfully Updated";
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
    $_SESSION["updateItemMessage"] = "Item Successfully Updated";
  }else{
    $_SESSION["updateItemError"] = $result;
  }
  header("Location: ../edit_item.php?type=$_GET[type]&id=$_GET[id]");
  exit();
}





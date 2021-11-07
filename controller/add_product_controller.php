<?php
session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (isset($_POST["addProduct"])){

  $result = adminValidateProduct($_POST);

  // var_dump($result);

  if(isAssociativeArray($result)){
    adminAddProduct($connection, $result);
    $_SESSION["alertMessage"][] = "Product Successfully Added";
  }else{
    $_SESSION["addProductError"] = $result;
  }
  header("Location: ../add_product.php");
  exit();
}


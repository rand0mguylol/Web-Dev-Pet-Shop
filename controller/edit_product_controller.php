<?php
require_once "../helper/helpers.php";


// $test = filter_var(1, FILTER_VALIDATE_FLOAT);

// echo ($test) ? "yesy" : "no";

if (isset($_POST["updateItem"]) && $_GET["type"] === "pet"){
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";
  // echo $_POST["birthDate"];
  // $sanitizeArray = [$_POST["name"], $_POST["description"], ]
}


if (isset($_POST["updateItem"]) && $_GET["type"] === "product"){
  echo "<pre>";
  var_dump($_POST);
  echo "</pre>";

  $errorArray = [];

  $sanitizeTextArray = [
    "name" => $_POST["name"],
    "description" => $_POST["description"],
    "brand" => $_POST["brand"],
    "weight" => $_POST["weight"],
    "warrantyPeriod" => $_POST["warrantyPeriod"],
    "productDimensions" => $_POST["productDimensions"]
  ];

  $sanitizeNumberArray = [
    "price" => $_POST["price"],
    "quantity" => $_POST["quantity"]
  ];

  foreach ($sanitizeTextArray as $key => $value){
    if($key === "description"){
      $sanitizeTextArray[$key]= str_replace("\n", "[NEWLINE]", $value);
    }
    $sanitizeTextArray[$key] = sanitizeText($value);

    if(!$value){
      array_push($errorArray, $key);
    }

    if($key === "description"){
      $sanitizeTextArray[$key]= str_replace("[NEWLINE]", "\n", $value);
    }
  }

  $price = filter_var($_POST["price"], FILTER_VALIDATE_FLOAT);

  if(!$price){
    array_push($errorArray, "price");
  }else{
    $price = round($price, 2);
    array_push($sanitizeTextArray, $price);
  }

  $quantity= filter_var($_POST["price"], FILTER_VALIDATE_INT);

  if(!$quantity){
    array_push($errorArray, "quantity");
  }else{
    array_push($sanitizeTextArray, $quantity);
  }

  if($errorArray){
    $_SESSION["updateItemError"] = $errorArray;
  }else{
    $stmt = $connection -> prepare("UPDATE products SET name= ?  ,price = ?, quantity = ?, status = ?, 
    description = ? , brand = ? , weight = ?, warrantyPeriod = ?, productDimensions = ? WHERE productId = ?");

    $stmt->bind_param("siiisssssi", $sanitizeTextArray["name"], $sanitizeTextArray["price"], $_POST["status"], $sanitizeTextArray["status"], 
    $sanitizeTextArray["description"], $sanitizeTextArray["brand"], $sanitizeTextArray["weight"], $sanitizeTextArray["warrantyPeriod"], $sanitizeTextArray["productDimensions"], $id );
    $stmt->execute();
    $stmt->close();
    $_SESSION["updateItemMessage"] = "Item Successfully Updated";
  }
}





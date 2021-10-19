<?php

function returnType($category){
  $petArray  = ["Dog", "Cat", "Hamster"];
  $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];

  if(in_array($category, $petArray)){
    $type = "pet";
  }else if (in_array($category, $productArray)){
    $type = "product";
  }else{
    return false;
  }

  return $type;
}


function getCategoryInfo($connection, $category, $id = "", $limit = false){
  $categoryArray = [];

  $petArray  = ["Dog", "Cat", "Hamster"];
  $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];


 if(in_array($category, $petArray)){
  $sql = "SELECT pets.petId as id , pets.name, pets.price, petcategory.category, petcategory.description, petimage.imagePath FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId INNER JOIN petimage ON pets.petId = petimage.petId WHERE petCategory.category = ? AND imageType = 'Card' AND pets.petId != ?;";
  }
  else if(in_array($category, $productArray)){
  $sql = "SELECT products.productId as id, products.name, products.price,  productcategory.category, productcategory.description, productimage.imagePath FROM products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId INNER JOIN productimage ON products.productId = productimage.productId WHERE productCategory.category = ? AND imageType = 'Card' AND products.productId != ?;";
}
  else{
    return false;
  }

  if($limit){
    $sql = substr_replace($sql, " LIMIT 6", -1, -1);
  }


  $stmt = $connection->prepare($sql);

  if(!$stmt){
    return false;
  }

  $stmt->bind_param("si", $category, $id);
  $stmt->execute();
  $result = $stmt->get_result();

  while($row = $result->fetch_assoc()){
    array_push($categoryArray, $row);
    $categoryDescription = $row["description"];
    $categoryName = $row["category"];
  }

  $stmt->close();

  $resultArray = [
    "categoryArray" => $categoryArray,
    "categoryDescription" => $categoryDescription,
    "categoryName" => $categoryName
  ];

  return $resultArray;
}


function validatePassword($password){
  $passwordRegEx = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/';
  $passwordValidate = preg_match($passwordRegEx, $password);

  // if (!$passwordValidate && !in_array($sanitizeInput["password"], $errorArray)){
  //   array_push($errorArray, "password");
  // }

  if (!$passwordValidate){
    return false;
  }else{
    return $password;
  }
}

function validateMobileNumber($mobileNumber){
  $mobileRegEx = "/^[1-9][0-9]{8,9}$/";
  $mobileValidate = preg_match($mobileRegEx, $mobileNumber);

  if (!$mobileValidate){
    return false;
  }else{
    return $mobileNumber;
  }
}

function validateText($text){
  $text = trim($text);
  $text = strip_tags($text);

  return $text;
}

function createUser($postArray, $connection){
  $errorArray = [];
  $firstName = validateText($postArray["firstName"]);
  $lastName = validateText($postArray["lastName"]);

  $filters = [
    "mobileNumber" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^[1-9][0-9]{8,9}$/")),
    "email"=> FILTER_SANITIZE_EMAIL,
    "password" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/"))
  ];

  $sanitizeInput = filter_input_array(INPUT_POST, $filters);

  if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
    array_push($errorArray, "email");
  }else{
    $email = $sanitizeInput["email"];
  }

  if(!$sanitizeInput["mobileNumber"]){
    array_push($errorArray, "mobileNumber");
  }else{
    $mobileNumber = $sanitizeInput["mobileNumber"];
  }

  if(!$sanitizeInput["password"]){
    array_push($errorArray, "password");
  }else{
    $password= $sanitizeInput["password"];
  }

  if (!$errorArray){
    // $password = $sanitizeInput["password"];
    $userRole = "CUSTOMER";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber, userRole) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssis", $firstName, $lastName, $email, $hashedPassword, $mobileNumber, $userRole);

    $stmt->execute();
    $id = mysqli_insert_id($connection);
    $stmt->close();

    // $stmt = $connection->prepare("INSERT INTO role(userId, userRole) VALUES (?, 'CUSTOMER');");
    // $stmt->bind_param("i", $id);
    // $stmt->execute();
    // $stmt->close();

    return false;
  }
  else{
    return $errorArray;
  }
}

function getImage($id, $category, $imageType, $connection){
    // Get item gallery

    $type = returnType($category);

    $imageArray = array();

    if(strtolower($type) === "pet" ){
      $stmt = $connection->prepare("SELECT petimage.imagePath FROM petimage  WHERE petimage.petId = ? AND petimage.imageType = ?; ");
    }else if(strtolower($type) === "product"){
      $stmt = $connection->prepare("SELECT productimage.imagePath FROM productimage  WHERE productimage.productId= ? AND productimage.imageType = ?; ");
    }

    if(!$stmt){
      return false;
    }

    $imageType = ucfirst($imageType);

    $stmt->bind_param("is", $id, $imageType);
    $stmt->execute();
    $result = $stmt->get_result();
    
     while($row = $result->fetch_assoc()){
      array_push($imageArray, $row);
    }
    $stmt->close();

    return $imageArray;
}


function getItemInfo($id,  $category, $connection){
  $itemInfo = [
    "itemMainInfo" => array(),
    "itemSubInfo" => array()
  ];

  $type = returnType($category);

  if(strtolower($type) === "pet" ){
    $stmt = $connection->prepare("SELECT pets.petId AS id, pets.name, pets.price, pets.gender, pets.weight, pets.color, pets.petCondition, pets.vaccinated, pets.dewormed, petcategory.category FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId  WHERE pets.petID = ? AND pets.status = 1");
  }else if(strtolower($type) === "product"){
    $stmt = $connection->prepare("SELECT products.productId AS id, products.name, products.price, products.description, products.brand,  products.weight, products.warrantyPeriod, products.productDimensions, productcategory.category FROM  products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId  WHERE products.productId = ? AND products.status = 1");
  }

  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $itemInfo = [
    "itemMainInfo" => array(),
    "itemSubInfo" => array()
  ];

  if(!$row){
    return false;
  }

  foreach($row as $key => $value){
    if($key !== "name" && $key !== "price" && $key !== "description"){
      $itemInfo["itemSubInfo"][$key] = $value;
    }else{
      $itemInfo["itemMainInfo"][$key] = $value;
    }
  }
  $stmt->close();

  return $itemInfo;
}


// function getProductInfo($id, $connection){
//   $itemInfo = [
//     "itemMainInfo" => array(),
//     "itemSubInfo" => array()
//   ];
//   $stmt = $connection->prepare("SELECT product.name, product.price, product.description, product.brand,  product.weight, product.warrantyPeriod, product.productDimensions productcategory.category FROM  products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId  WHERE products.productId = ? AND products.status = 1");
//   $stmt->bind_param("i", $id);
//   $stmt->execute();
//   $result = $stmt->get_result();
//   $row = $result->fetch_assoc();
//   $itemInfo = [
//     "itemMainInfo" => array(),
//     "itemSubInfo" => array()
//   ];

//   if(!$row){
//     return false;
//   }

//   foreach($row as $key => $value){
//     if($key !== "name" && $key !== "price"){
//       $itemInfo["itemSubInfo"][$key] = $value;
//     }else{
//       $itemInfo["itemMainInfo"][$key] = $value;
//     }
//   }
//   $stmt->close();

//   return $itemInfo;
// }




?>
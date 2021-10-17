<?php
function getPets($connection, $category){
  $categoryArray = [];

  $categoryIdArray = [
    "dog" => 1,
    "cat" => 2,
    "hamster" => 3
  ];

  $stmt = $connection->prepare("SELECT pets.name, pets.price, petcategory.category, petcategory.description, petimage.imagePath FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId INNER JOIN petimage ON pets.petId = petimage.petId WHERE pets.petCatId = ? AND imageType = 'Card';");
  $stmt->bind_param("i", $categoryIdArray[$category]);
  
  
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


function getProduct($connection, $category){
  $categoryArray = [];

  
  $categoryIdArray = [
    "dogFood" => 1,
    "dogAccess" => 2,
    "dogCare" => 3,
    "catFood" => 4,
    "catAccess" => 5,
    "catCare" => 6,
    "hamsterFood" => 7,
  ];

  $stmt = $connection->prepare("SELECT products.name, products.price,  productcategory.category, productcategory.description, productimage.imagePath FROM products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId INNER JOIN productimage ON products.productId = productimage.productId WHERE products.productCatId = ? AND imageType = 'Card';");
  $stmt->bind_param("i", $categoryIdArray[$category]);
  
  
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

function createUser($postArray, $connection,  $errorArray ){
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

  if (!$errorArray){
    $password = $sanitizeInput["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber) VALUES (?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $mobileNumber);

    $stmt->execute();
    $id = mysqli_insert_id($connection);
    $stmt->close();

    $stmt = $connection->prepare("INSERT INTO role(userId, userRole) VALUES (?, 'CUSTOMER');");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
  }
}
?>
<?php

function sanitizeText($text){
  $text = trim($text);
  $text = strip_tags($text);
  $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

  return $text;
}

function validatePassword($password){
  $passwordRegEx = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/';

  $passwordValidate = filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>$passwordRegEx)));

  return $passwordValidate;
}

function validateMobileNumber($mobileNumber){
  $mobileRegEx = "/^[1]{1}[0-9]{8,9}$/";
  $mobileValidate = filter_var($mobileNumber, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>$mobileRegEx)));

  return $mobileValidate;
}

function validateState($state){
  $state = trim($state);
  $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");
  
  if(!$_POST["state"] !== "" && in_array($_POST["state"], $statesArray)){
    return $state;
  }elseif($_POST["state"] === ""){
    $state = "";
  }else{
    return false;
  }

  return $state;
}

function validatePostcode($postcode){
  $postRegEx = "/^[0-9]{5}$/";
 
  if($postcode === ""){
    return "";
  }else{
    $postcodeValidate = filter_var($postcode, FILTER_VALIDATE_REGEXP, array("options" => array("regexp"=>$postRegEx)));
  }

  return $postcodeValidate;
}

function validateEmail($email){
  $emailSanitize = filter_var($email, FILTER_SANITIZE_EMAIL);

  $email = filter_var($emailSanitize, FILTER_VALIDATE_EMAIL);
  return $email;
}


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


function createUser($newUser, $connection){
    $userRole = "CUSTOMER";
    $hashedPassword = password_hash($newUser["password"], PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber, userRole) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssis", $newUser["firstName"], $newUser["lastName"], $newUser["email"], $hashedPassword, $newUser["mobileNumber"], $userRole);

    $stmt->execute();
    $stmt->close();
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


function updateProfile($newInfo, $connection, $id){
    $stmt = $connection->prepare("UPDATE user SET firstName = ?, lastName = ?, mobileNumber = ?, addressLine = ?, city = ?, userState = ?, postcode = ? WHERE userId = ?");
    $stmt -> bind_param("ssissssi", $newInfo["firstName"], $newInfo["lastName"], $newInfo["mobileNumber"], $newInfo["addressLine"], $newInfo["city"], $newInfo["state"], $newInfo["postcode"], $id);

    $stmt->execute();
    $stmt->close();
    
     foreach ($newInfo as $key => $value){
      $_SESSION["user"][$key] = $value;
    }
  

}

function changePassword($oldpass, $newpass, $confimpass, $id, $connection){
  $stmt = $connection->prepare("SELECT userPassword FROM user WHERE userId = ?;");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  $dbPassword = $row["userPassword"];
  $verifyPassword = password_verify($oldpass, $dbPassword);
  if($verifyPassword){
    $isSame = $oldpass === $newpass ? true : false;
    $validatePassword = validatePassword($newpass);
  }else{
    return "Invalid Password";
  }

  if($isSame){
    return "New Password cannot be the same as the old password";
  }

  if($validatePassword){
    $confirmPassword = $newpass === $confimpass ? true : false;
  }else{
   return  "Length must be between 8 to 16 characters, 
            including one digit, one uppercase, one lowecase 
            character and may contain the following !@#$%&";
  }

  if($confirmPassword){
    $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("UPDATE `user` SET `userPassword`= ?  WHERE userId = ?");
    $stmt->bind_param("si", $hashedPassword, $id);
    $stmt->execute();
    $stmt->close();
    return  "Password Changed Successfully";
  }else{
    return  "Password does not match";
  }
}
?>
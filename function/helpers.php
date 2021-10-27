<?php

function sanitizeText($text)
{
    $text = trim($text);
    $text = strip_tags($text);
    $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    return $text;
}

function validatePassword($password)
{
    $passwordRegEx = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/';
    $passwordValidate = filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $passwordRegEx)));
    return $passwordValidate;
}

function validateMobileNumber($mobileNumber)
{
    $mobileRegEx = "/^[1]{1}[0-9]{8,9}$/";
    $mobileValidate = filter_var($mobileNumber, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $mobileRegEx)));
    return $mobileValidate;
}

function validateState($state)
{
    $state = trim($state);
    $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");
    if (!$_POST["state"] !== "" && in_array($_POST["state"], $statesArray)) {
        return $state;
    } elseif ($_POST["state"] === "") {
        $state = "";
    } else {
        return false;
    }
    return $state;
}

function validatePostcode($postcode)
{
    $postRegEx = "/^[0-9]{5}$/";
    if ($postcode === "") {
        return "";
    } else {
        $postcodeValidate = filter_var($postcode, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $postRegEx)));
    }
    return $postcodeValidate;
}

function validateEmail($email)
{
    $emailSanitize = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($emailSanitize, FILTER_VALIDATE_EMAIL);
    return $email;
}

function validateCartItem($cartid, $id, $quantity, $category, $connection)
{
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    if (in_array($category, $petArray)) {
        $sql = "SELECT * FROM cartitem WHERE cartId = ? AND petId = ?;";
        $category = "pet";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT * FROM cartitem WHERE cartId = ? AND productId = ?;";
        $category = "product";
    } else {
        return false;
    }
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $cartid, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            $status = null;
        } else {
            if ($category === "product") {
                $cartItemId = $row['cartItemId'];
                $oldQuantity = $row['quantity'];
                $stmt = $connection->prepare("SELECT price, quantity FROM products WHERE productId = ?;");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();
                $maxQuantity = $row['quantity'];
                $price = $row['price'];
                $newQuantity = $oldQuantity + $quantity;
                if ($newQuantity > $maxQuantity) {
                    $newQuantity = $maxQuantity;
                    $status = "maxed";
                } else {
                    $newQuantity = $newQuantity;
                    $status = "updated";
                }
                $newSubtotal = $newQuantity * $price;
                $stmt = $connection->prepare("UPDATE cartitem SET quantity = ?, subtotal =? WHERE cartItemId = ?;");
                $stmt->bind_param("iii", $newQuantity, $newSubtotal, $cartItemId);
                $stmt->execute();
                $stmt->close();
            } else {
                $status = "pet-maxed";
            }
            return $status;
        }
    }
}


function returnType($category)
{
    $petArray  = ["pet", "Dog", "Cat", "Hamster"];
    $productArray = ["product", "Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    if (in_array($category, $petArray)) {
        $type = "pet";
    } else if (in_array($category, $productArray)) {
        $type = "product";
    } else {
        return false;
    }
    return $type;
}

function getCategoryInfo($connection, $category)
{
    //
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    //
    if (in_array($category, $petArray)) {
        $sql = "SELECT petCategory.category, petcategory.description FROM  petcategory  WHERE petCategory.category = ?;";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT productcategory.category, productcategory.description FROM productcategory WHERE productCategory.category = ?;";
    } else {
        return false;
    }
    //
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryHeader = $result->fetch_assoc();
    $stmt->close();
    return $categoryHeader;
}

function getCategoryProduct($connection, $category, $searchKeyword = "",  $id = "", $limit = false)
{
    $categoryArray = [];
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    //
    if (in_array($category, $petArray)) {
        $sql = "SELECT pets.petId as id , pets.name, pets.price, petimage.imagePath FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId INNER JOIN petimage ON pets.petId = petimage.petId WHERE petCategory.category = ? AND imageType = 'Card' AND pets.petId != ? AND pets.name LIKE ? ;";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT products.productId as id, products.name, products.price, productimage.imagePath FROM products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId INNER JOIN productimage ON products.productId = productimage.productId WHERE productCategory.category = ? AND imageType = 'Card' AND products.productId != ? AND products.name LIKE ?;";
    } else {
        return false;
    }
    //
    if ($limit) {
        $sql = substr_replace($sql, " LIMIT 6", -1, -1);
    }
    $stmt = $connection->prepare($sql);
    // if(!$stmt){
    //   return false;
    // }
    $searchKeyword = "%$searchKeyword%";
    $stmt->bind_param("sis", $category, $id, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        array_push($categoryArray, $row);
    }
    $stmt->close();
    // $resultArray = [
    //   "categoryArray" => $categoryArray,
    //   "categoryDescription" => $categoryDescription,
    //   "categoryName" => $categoryName
    // ];
    return $categoryArray;
}


function createUser($newUser, $connection)
{
    $userRole = "CUSTOMER";
    $imagePath =  "./svg/profile-pic-default.svg";
    $hashedPassword = password_hash($newUser["password"], PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber, imagePath, userRole) VALUES (?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssis", $newUser["firstName"], $newUser["lastName"], $newUser["email"], $hashedPassword, $newUser["mobileNumber"], $imagePath, $userRole);
    $stmt->execute();
    $stmt->close();
}


function getImage($id, $category, $imageType, $limit = false, $connection)
{
    //
    $type = returnType($category);
    $imageArray = array();
    if (strtolower($type) === "pet") {
        $sql = "SELECT petimage.imagePath FROM petimage  WHERE petimage.petId = ? AND petimage.imageType = ?; ";
    } else if (strtolower($type) === "product") {
        $sql = "SELECT productimage.imagePath FROM productimage  WHERE productimage.productId= ? AND productimage.imageType = ?; ";
    }
    //
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        return false;
    }
    if ($limit) {
        $sql = substr_replace($sql, " LIMIT 1", -1, -1);
    }
    $imageType = ucfirst($imageType);
    $stmt->bind_param("is", $id, $imageType);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$limit) {
        while ($row = $result->fetch_assoc()) {
            array_push($imageArray, $row);
        }
        $stmt->close();
        return $imageArray;
    } else {
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row["imagePath"];
    }
}


function getItemInfo($id,  $category, $connection)
{
    $itemInfo = [
        "itemMainInfo" => array(),
        "itemSubInfo" => array()
    ];

    $type = returnType($category);
    if (strtolower($type) === "pet") {
        $stmt = $connection->prepare("SELECT pets.petId AS id, pets.name, pets.price, pets.gender, pets.weight, pets.color, pets.petCondition, pets.vaccinated, pets.dewormed, petcategory.category FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId  WHERE pets.petID = ? AND pets.status = 1");
    } else if (strtolower($type) === "product") {
        $stmt = $connection->prepare("SELECT products.productId AS id, products.name, products.price,products.quantity, products.description, products.brand,  products.weight, products.warrantyPeriod, products.productDimensions, productcategory.category FROM  products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId  WHERE products.productId = ? AND products.status = 1");
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $itemInfo = [
        "itemMainInfo" => array(),
        "itemSubInfo" => array()
    ];
    if (!$row) {
        return false;
    }
    foreach ($row as $key => $value) {
        if ($key !== "name" && $key !== "price" && $key !== "description") {
            $itemInfo["itemSubInfo"][$key] = $value;
        } else {
            $itemInfo["itemMainInfo"][$key] = $value;
        }
    }
    $stmt->close();
    return $itemInfo;
}

function getCartId($userid, $connection)
{
    $stmt = $connection->prepare("SELECT cartId FROM cart WHERE userId = ?;");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if (!$row) {
        return false;
    } else {
        $cartid = $row['cartId'];
        return $cartid;
    }
}

function getCartItems($cartid, $connection)
{
    $cartItemArray = [];
    $stmt = $connection->prepare("SELECT cartItemId, petId, productId, quantity, subtotal FROM cartitem WHERE cartid = ?;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $result = $stmt->get_result();
    $length = mysqli_num_rows($result);
    if ($length === 0) {
        return null;
    } else {
        while ($row = $result->fetch_assoc()) {
            $cartitem = [];
            $cartItemId = $row['cartItemId'];
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];
            if (isset($row['petId'])) {
                $id = $row['petId'];
                $category = "pet";
                $stmt2 = $connection->prepare('SELECT name, price FROM pets WHERE petId =?; ');
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();
                $itemName = $row2['name'];
                $itemPrice = $row2['price'];
                $image = getImage($id, $category, "Card", true, $connection);
            } else {
                $id = $row['productId'];
                $category = "product";
                $stmt2 = $connection->prepare('SELECT name, price ,quantity as maxQuantity FROM products WHERE productId =?; ');
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();
                $itemName = $row2['name'];
                $itemPrice = $row2['price'];
                $itemMaxQuantity = $row2['maxQuantity'];
                $image = getImage($id, $category, "Card", true, $connection);
            }
            $cartitem = [

                "cartItemId" => $cartItemId,
                "id" => $id,
                "category" => $category,
                "name" => $itemName,
                "quantity" => $quantity,
                "maxQuantity" => $itemMaxQuantity ?? 1,
                "price" => $itemPrice,
                "subtotal" => $subtotal,
                "image" => $image
            ];
            array_push($cartItemArray, $cartitem);
        }
        $stmt->close();
        return $cartItemArray;
    }
}

function updateCartSubtotal($cartid, $connection)
{
    $stmt = $connection->prepare("SELECT SUM(subtotal) as total FROM cartitem WHERE cartId = ? AND STATUS = 1;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $newTotal = $row['total'];
    $stmt = $connection->prepare("UPDATE cart SET total = ? WHERE cartId = ?;");
    $stmt->bind_param("ii", $newTotal, $cartid);
    $stmt->execute();
    $stmt->close();
}

function getCartSubtotal($cartid, $connection)
{
    updateCartSubtotal($cartid, $connection);
    $stmt = $connection->prepare("SELECT total FROM cart WHERE cartId = ?");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $total = $row['total'];
    $stmt->close();
    return $total;
}

function createCart($userid, $connection)
{
    $stmt = $connection->prepare("INSERT INTO cart VALUES ('',?, 0);");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $cartid = $connection->insert_id;
    $stmt->close();
    return $cartid;
}

function addCartitem($cartid, $id, $category, $quantity, $subtotal, $connection)
{
    $type = returnType($category);
    if (strtolower($type) === "pet") {
        $sql = "INSERT INTO cartitem VALUES ('',?,NULL,?,?,?,1);";
    } else if (strtolower($type) === "product") {
        $sql = "INSERT INTO cartitem VALUES ('',NULL,?,?,?,?,1);";
    } else {
        return false;
    }
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiii", $id, $cartid, $quantity, $subtotal);
        $stmt->execute();
        $stmt = $connection->prepare("UPDATE cart SET total = total + ? WHERE cartId = ?;");
        $stmt->bind_param("ii", $subtotal, $cartid);
        $stmt->execute();
        updateCartSubtotal($cartid, $connection);
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

function removeCartItem($cartItemId, $cartid, $connection)
{
    $stmt = $connection->prepare("DELETE FROM cartitem where cartItemId =?");
    $stmt->bind_param("i", $cartItemId);
    $stmt->execute();
    updateCartSubtotal($cartid, $connection);
    $stmt->close();
}

function updateProfile($newInfo, $connection, $id)
{
    $stmt = $connection->prepare("UPDATE user SET firstName = ?, lastName = ?, mobileNumber = ?, addressLine = ?, city = ?, userState = ?, postcode = ? WHERE userId = ?");
    $stmt->bind_param("ssissssi", $newInfo["firstName"], $newInfo["lastName"], $newInfo["mobileNumber"], $newInfo["addressLine"], $newInfo["city"], $newInfo["state"], $newInfo["postcode"], $id);
    $stmt->execute();
    $stmt->close();
    foreach ($newInfo as $key => $value) {
        $_SESSION["user"][$key] = $value;
    }
}

function changePassword($oldpass, $newpass, $confimpass, $id, $connection)
{
    $stmt = $connection->prepare("SELECT userPassword FROM user WHERE userId = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $dbPassword = $row["userPassword"];
    $verifyPassword = password_verify($oldpass, $dbPassword);
    if ($verifyPassword) {
        $isSame = $oldpass === $newpass ? true : false;
        $validatePassword = validatePassword($newpass);
    } else {
        return "Invalid Password";
    }
    if ($isSame) {
        return "New Password cannot be the same as the old password";
    }
    if ($validatePassword) {
        $confirmPassword = $newpass === $confimpass ? true : false;
    } else {
        return  "Length must be between 8 to 16 characters, 
            including one digit, one uppercase, one lowecase 
            character and may contain the following !@#$%&";
    }
    if ($confirmPassword) {
        $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("UPDATE `user` SET `userPassword`= ?  WHERE userId = ?");
        $stmt->bind_param("si", $hashedPassword, $id);
        $stmt->execute();
        $stmt->close();
        return  "Password Changed Successfully";
    } else {
        return  "Password does not match";
    }
}

function validateImage($image)
{
    $getImageString = getimagesizefromstring($image);
    // Using this method to check if content is image
    if (!$getImageString) {
        return false;
    }
    $mimeType = $getImageString["mime"];
    $mimeTypeArray = ["image/png", "image/jpg", "image/jpeg"];
    if (!in_array($mimeType, $mimeTypeArray)) {
        return false;
    }
    return $mimeType;
}


function saveImage($mimeType, $image, $connection, $id, $hasImage)
{
    $userDir = "../Images/User/user_" . $_SESSION["user"]["userID"];
    if (!is_dir($userDir)) {
        mkdir($userDir);
    }
    switch ($mimeType) {
        case "image/png":
            $userPic = $userDir . "/user_" . $_SESSION["user"]["userID"] . "_pic" . ".png";
            file_put_contents($userPic, $image);
            break;
        case "image/jpg":
            $userPic = $userDir . "/user_" . $_SESSION["user"]["userID"] . "_pic" . ".jpg";
            file_put_contents("$userPic", $image);
            break;
        case "image/jpeg":
            $userPic = $userDir . "/user_" . $_SESSION["user"]["userID"] . "_pic" . ".jpeg";
            file_put_contents("$userPic", $image);
            break;
    }

    $saveToDbImage = substr($userPic, 1);
    $stmt = $connection->prepare("UPDATE user SET imagePath = ? WHERE userId = ?");
    $stmt->bind_param("si", $saveToDbImage, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION["user"]["userPicture"] = $saveToDbImage;
}

// function updateReviewID($reviewId, $connection){
//     $stmt = $connection->prepare("SELECT reviewId FROM review WHERE = $reviewId WHERE OrderItemId = ?;");
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();

//     $stmt = $connection->prepare("UPDATE orderitem SET reviewId = $reviewId WHERE OrderItemId = ?;");
//     $stmt->bind_param("i", $reviewId);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     $row = $result->fetch_assoc();
//     $stmt->close();;
// }

function getOrderId($userid, $connection)
{
    $stmt = $connection->prepare("SELECT orderId FROM orders WHERE userId = ? ORDER BY orderId DESC;");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderIdArray = [];
    while ($row = $result->fetch_assoc()) {
        $id = $row["orderId"];
        array_push($orderIdArray, $id);
    };
    $stmt->close();
    return $orderIdArray;
}

function getOrderTotal($orderid, $connection)
{
    $stmt = $connection->prepare("SELECT total FROM orders WHERE orderid = ?;");
    $stmt->bind_param("i", $orderid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total = $row['total'];
    $stmt->close();
    return $total;
}

function getOrderItems($orderId, $connection){
    $orderItemArray = [];
    // foreach($orderIdArray as $orderId){}
    $stmt = $connection -> prepare("SELECT orderItemId, petId, productId, quantity, subtotal FROM orderitem WHERE orderid = ?;");
    $stmt -> bind_param("i", $orderId);
    $stmt -> execute();
    $result = $stmt -> get_result();
    while($row = $result -> fetch_assoc()){
      $orderitem = [];
      if (isset($row['petId'])){
          $orderItemId = $row["orderItemId"];
          $id = $row['petId'];
          $quantity = $row['quantity']; 
          $subtotal = $row['subtotal'];
          $category = "pet";
          $stmt2 = $connection ->prepare ('SELECT name FROM pets WHERE petId =?; ');
          $stmt2 -> bind_param("i",$id);
          $stmt2 -> execute();
          $result2 = $stmt2 -> get_result();
          $row2 = $result2 ->fetch_assoc();
          $itemName = $row2['name'];
          $image = getImage($id,$category,"Card",true,$connection);
        } else {
          $orderItemId = $row["orderItemId"];
          $id = $row['productId'];
          $quantity = $row['quantity'];
          $subtotal = $row['subtotal'];
          $category = "product";
          $stmt2 = $connection ->prepare ('SELECT name FROM products WHERE productId =?; ');
          $stmt2 -> bind_param("i",$id);
          $stmt2 -> execute();
          $result2 = $stmt2 -> get_result();
          $row2 = $result2 ->fetch_assoc();
          $itemName = $row2['name'];
          $image = getImage($id,$category,"Card",true,$connection);
        }
      $orderitem = [
        "orderItemId" => $orderItemId,
        "id" => $id,
        "category" => $category,
        "name" => $itemName,
        "quantity" => $quantity,
        "subtotal" => $subtotal,
        "image" => $image
      ];
      array_push($orderItemArray, $orderitem);
    }
    $stmt -> close();
    $stmt2 -> close();
    return $orderItemArray;
  }

// function getOrderItemId($orderItemId){
//     return $orderItemId;
// }

function createReview($orderItemId, $newReview, $connection){
    $stmt = $connection->prepare("INSERT INTO review(userId, orderItemId, rating, feedback) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("iiis", $newReview["userId"], $orderItemId, $newReview["rating"], $newReview["feedback"]);
    $stmt->execute();
    $stmt->close();
}

// If Order Item is already rated, return 1, else 0
function rateEligibility($orderItemId, $connection){
    $stmt = $connection->prepare("SELECT reviewId FROM review WHERE orderItemId = ?;");
    $stmt ->bind_param("i", $orderItemId);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $length = mysqli_num_rows($result);
    $stmt -> close();
    return $length;
}
<?php

function sanitizeText($text)
{   
    // Remove trailing and leading whitespaces
    $text = trim($text); 
    // Remove html tags
    $text = strip_tags($text);
    // FILTER_FLAG_STRIP_LOW strips bytes in the input that have a numerical value <32,
    //  most notably null bytes and other control characters such as the ASCII bell.
    $text = filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW); 
    return $text;
}

function validatePassword($password)
{
    // Regular expression to check password:
    // Length must be between 8 to 16 characters, 
    // including one digit, one uppercase, one lowecase character 
    // and may contain the following !@#$%&
    $passwordRegEx = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/';
    $passwordValidate = filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $passwordRegEx)));
    return $passwordValidate;
}

function validateMobileNumber($mobileNumber)
{
    // Regular expression to check number
    // Length must be between 9 - 10
    // Must start with 1
    // Must be digits only
    $mobileRegEx = "/^[1]{1}[0-9]{8,9}$/";
    $mobileValidate = filter_var($mobileNumber, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $mobileRegEx)));
    return $mobileValidate;
}

function validateState($state)
{   
    // Remove trailing and leading spaces
    $state = trim($state);
    $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");
    if (!$_POST["state"] !== "" && in_array($_POST["state"], $statesArray)) {
        return $state;
    }
    $state = $_POST["state"] === "" ? "" : false;
    return $state;
}

function validatePostcode($postcode)
{
    // Regular expression to check postcode
    // Length must be 5
    // Must be digits
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
    // Remove all characters except letters, digits, and !#$%&'*+_=^_{|}`@.[]
    $emailSanitize = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($emailSanitize, FILTER_VALIDATE_EMAIL);
    return $email;
}

// To check if the pet/product is added into the cart. If product exists, add quantity for the product.
function validateCartItem($cartid, $id, $quantity, $category, $connection)
{
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    if (in_array($category, $petArray)) {
        $sql = "SELECT * FROM cartitem WHERE cartId = ? AND petId = ? AND status = 1;";
        $category = "pet";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT * FROM cartitem WHERE cartId = ? AND productId = ? AND status = 1;";
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

// Validate credit card info
function validateCreditCard($cardNumber, $cardType, $expiryMonth, $expiryYear, $cvv)
{
    // Error message
    $invalidCardMsg = "Invalid card number.";
    $expiredCardMsg = "Your card is expired.";
    $InvalidCVVMsg = "Invalid CVV.";
    // Card format
    $cardValidationArray = [
        "VISA Card"  => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "MasterCard" => "/^5[1-5][0-9]{14}$/",
    ];
    // Check for card type
    foreach ($cardValidationArray as $key => $value) {
        if (preg_match($value, $cardNumber)) {
            $card = $key;
        }
    }
    // Invalid card type
    if (isset($card)) {
        if ($card === $cardType) {
            $invalidCardMsg = NULL;
        }
    }
    // Check for card expiry month/year
    $cardExpiryDate = DateTime::createFromFormat('my', $expiryMonth . $expiryYear);
    $now = new DateTime();
    if ($cardExpiryDate > $now) {
        $expiredCardMsg = NULL;
    }

    // Validate cvv format
    $cvvFormat = "/^[0-9]{3,4}$/";
    if (preg_match($cvvFormat, $cvv)) {
        $InvalidCVVMsg = NULL;
    }

    // Compile error msg
    $errMsgArray = [
        "cardErr" => $invalidCardMsg,
        "expiryErr" => $expiredCardMsg,
        "CVVErr" => $InvalidCVVMsg
    ];

    // Check error messages
    foreach ($errMsgArray as $key => $value) {
        if (is_null($value)) {
            unset($errMsgArray[$key]);
        }
    }

    // Return result
    if (!empty($errMsgArray)) {
        return $errMsgArray;
    } else {
        return false;
    }
}

// Check to see the category of the item passed into the argument
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


// Get the info for the category 
// For category.php
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


// Get the items from the category
// For category.php
function getCategoryProduct($connection, $category, $searchKeyword = "", $filter = false)
{
    $categoryArray = [];
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", 
                    "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    //
    if (in_array($category, $petArray)) {
        $sql = "SELECT pets.petId as id , pets.name, pets.price, petimage.imagePath 
        FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId 
        INNER JOIN petimage ON pets.petId = petimage.petId 
        WHERE petCategory.category = ? AND imageType = 'Card'  
        AND status = 1 AND pets.name LIKE ?;";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT products.productId as id, products.name, products.price, productimage.imagePath
         FROM products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId 
         INNER JOIN productimage ON products.productId = productimage.productId 
         WHERE productCategory.category = ? AND imageType = 'Card' 
         AND status = 1 AND quantity > 0 AND products.name LIKE ?;";
    } else {
        return false;
    }
    //Add on to string if filter is set
    switch ($filter) {

        case "priceHigh":
            $sql = substr_replace($sql, " ORDER BY price DESC;", -1, -1);
            break;

        case "priceLow":
            $sql = substr_replace($sql, " ORDER BY price ASC;", -1, -1);
            break;
    }

    $stmt = $connection->prepare($sql);

    $searchKeyword = "%$searchKeyword%";
    $stmt->bind_param("ss", $category, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        array_push($categoryArray, $row);
    }
    $stmt->close();

    if (in_array($category, $productArray)) {
    }
    return $categoryArray;
}

// Display the items from the category excluding the one that is currently viewed in item.php
// For item.php
function getCategoryOther($connection, $category, $removeID)
{
    $otherArray = [];
    $petArray  = ["Dog", "Cat", "Hamster"];
    $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
    //
    if (in_array($category, $petArray)) {
        $sql = "SELECT pets.petId as id , pets.name, pets.price, petimage.imagePath, petcategory.category FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId INNER JOIN petimage ON pets.petId = petimage.petId WHERE petCategory.category = ? AND imageType = 'Card' AND pets.petId != ? LIMIT 6";
    } else if (in_array($category, $productArray)) {
        $sql = "SELECT products.productId as id, products.name, products.price, productimage.imagePath, productcategory.category FROM products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId INNER JOIN productimage ON products.productId = productimage.productId WHERE productCategory.category = ? AND imageType = 'Card' AND products.productId != ? LIMIT 6";
    } else {
        return false;
    }

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $category, $removeID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        array_push($otherArray, $row);
    }
    $stmt->close();

    return $otherArray;
}

// Create new user for the system
function createUser($newUser, $connection)
{
    $userRole = "CUSTOMER";
    // The default image when user sign up for an account
    $imagePath =  "./svg/profile-pic-default.svg"; 
    $hashedPassword = password_hash($newUser["password"], PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, 
    userPassword, mobileNumber, imagePath, userRole) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("ssssiss", $newUser["firstName"], $newUser["lastName"], 
    $newUser["email"], $hashedPassword, $newUser["mobileNumber"], $imagePath, $userRole);
    $stmt->execute();
    $stmt->close();
}


// Get the images for the a specific item from the given category
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

// Get specific info of the item with the given id
function getItemInfo($id,  $category, $connection)
{
    $itemInfo = [
        "itemMainInfo" => array(),
        "itemSubInfo" => array()
    ];

    $type = returnType($category);
    if (strtolower($type) === "pet") {
        $stmt = $connection->prepare("SELECT  pets.name, pets.price, pets.gender, pets.weight, pets.color, pets.petCondition, pets.vaccinated, pets.dewormed, pets.status, petcategory.category FROM  pets INNER JOIN petcategory ON pets.petCatId = petCategory.petCatId  WHERE pets.petID = ? AND pets.status = 1");
    } else if (strtolower($type) === "product") {
        $stmt = $connection->prepare("SELECT products.name, products.price,products.quantity, products.description, products.brand,  products.weight, products.warrantyPeriod, products.productDimensions, products.status, productcategory.category FROM  products INNER JOIN productcategory ON products.productCatId = productCategory.productCatId  WHERE products.productId = ? AND products.status = 1 AND products.quantity > 0");
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

// To get the cart id of the user
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

// To get the cart items in the cart
function getCartItems($cartid, $connection)
{
    $cartItemArray = [];
    $stmt = $connection->prepare("SELECT cartItemId, petId, productId, quantity, subtotal FROM cartitem WHERE cartid = ? AND status = 1;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $result = $stmt->get_result();
    $length = mysqli_num_rows($result);
    // Check if there is any cart item
    if ($length === 0) {
        return null;
    } else {
        while ($row = $result->fetch_assoc()) {
            $cartitem = [];
            $cartItemId = $row['cartItemId'];
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];
            // Get pet info that is added to the cart
            if (isset($row['petId'])) {
                $id = $row['petId'];
                $category = "pet";
                $stmt2 = $connection->prepare('SELECT name, price FROM pets WHERE petId =? AND status = 1; ');
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();
                // Get pet info if pet is available
                if($row2){
                    $isItem = true;
                    $itemName = $row2['name'];
                    $itemPrice = $row2['price'];
                    $image = getImage($id, $category, "Card", true, $connection);
                } else{
                    $isItem = false;
                }
            } else {
                // Get product info added into the cart
                $id = $row['productId'];
                $category = "product";
                $stmt2 = $connection->prepare('SELECT name, price ,quantity as maxQuantity FROM products WHERE productId = ? AND status = 1; ');
                $stmt2->bind_param("i", $id);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();
                // Get product info if product is available
                if ($row2) {
                    $isItem = true;
                    $itemName = $row2['name'];
                    $itemPrice = $row2['price'];
                    $itemMaxQuantity = $row2['maxQuantity'];
                    if($quantity > $itemMaxQuantity){
                        $quantity = (int)$itemMaxQuantity;
                    }
                    $image = getImage($id, $category, "Card", true, $connection);
                } else {
                    $isItem = false;
                }
            }
            // Add cart items into the cart
            if($isItem){
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
            // Remove unavailable cartitems from cart
            } else{
                $stmt2 = $connection -> prepare('DELETE FROM cartitem WHERE cartItemId = ?;');
                $stmt2 -> bind_param("i",$cartItemId);
                $stmt2 -> execute();
                $stmt2 -> close();
            }
        }
        $stmt->close();
        // Return cart items
        if(!empty($cartItemArray)){
            return $cartItemArray;
        } else {
            return null;
        }
    }
}

// Update the total of the cart.
function updateCartTotal($cartid, $connection)
{
    $stmt = $connection->prepare("SELECT SUM(subtotal) as total FROM cartitem WHERE cartId = ? AND STATUS = 1;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $newTotal = $row['total'];
    $stmt = $connection->prepare("UPDATE cart SET total = ? WHERE cartId = ?;");
    $stmt->bind_param("si", $newTotal, $cartid);
    $stmt->execute();
    $stmt->close();
}

// Get the latest cart total
function getCartTotal($cartid, $connection)
{
    updateCartTotal($cartid, $connection);
    $stmt = $connection->prepare("SELECT total FROM cart WHERE cartId = ?");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $total = $row['total'];
    $stmt->close();
    return $total;
}

// Create cart for new users
function createCart($userid, $connection)
{
    $stmt = $connection->prepare("INSERT INTO cart VALUES ('',?, 0);");
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    $cartid = $connection->insert_id;
    $stmt->close();
    return $cartid;
}

// Add cart items into the cart
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
        $stmt->bind_param("iiis", $id, $cartid, $quantity, $subtotal);
        $stmt->execute();
        $stmt = $connection->prepare("UPDATE cart SET total = total + ? WHERE cartId = ?;");
        $stmt->bind_param("si", $subtotal, $cartid);
        $stmt->execute();
        updateCartTotal($cartid, $connection);
        $stmt->close();
        return true;
    } else {
        return false;
    }
}

// Update the users value in the database and $_SESSION values
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

// Allows user to change their password
function changePassword($oldpass, $newpass, $confimpass, $id, $connection)
{
    $stmt = $connection->prepare("SELECT userPassword FROM user WHERE userId = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $dbPassword = $row["userPassword"];
    $verifyPassword = password_verify($oldpass, $dbPassword);

    if($verifyPassword === false){
        return "Invalid Password";
    }

    $isSame = $oldpass === $newpass ? true : false;
    $validatePassword = validatePassword($newpass);

    if ($isSame) {
        return "New Password cannot be the same as the old password";
    }

    if($validatePassword === false) {
        return  "Length must be between 8 to 16 characters, 
        including one digit, one uppercase, one lowecase 
        character and may contain the following !@#$%&";
    }

    $confirmPassword = $newpass === $confimpass ? true : false;

    if($confirmPassword === false){
        return  "Password does not match";
    }

    $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("UPDATE `user` SET `userPassword`= ?  WHERE userId = ?");
    $stmt->bind_param("si", $hashedPassword, $id);
    $stmt->execute();
    $stmt->close();
    return  "Password Changed Successfully";
}

// Ensure the images uploaded by the user is valid
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

// Saves the image uploaded by the user to the database
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
            file_put_contents($userPic, $image);
            break;
        case "image/jpeg":
            $userPic = $userDir . "/user_" . $_SESSION["user"]["userID"] . "_pic" . ".jpeg";
            file_put_contents($userPic, $image);
            break;
    }

    $saveToDbImage = substr($userPic, 1);
    $stmt = $connection->prepare("UPDATE user SET imagePath = ? WHERE userId = ?");
    $stmt->bind_param("si", $saveToDbImage, $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION["user"]["userPicture"] = $saveToDbImage;
}

function createOrder($userid, $paymentMethod, $type = null, $deliveryMethod, $total, $connection)
{
    $stmt = $connection->prepare("INSERT INTO orders (userId, paymentMethod, deliveryMethod, total)  VALUES(?,?,?,?);");
    $paymentMethod = "$paymentMethod - $type";
    $stmt->bind_param("isss", $userid, $paymentMethod, $deliveryMethod, $total);
    $stmt->execute();
    $orderid = $connection->insert_id;
    return $orderid;
}

// Reduce quantity when order is created
function reduceItemQuantity($id, $category, $quantity, $connection)
{
    if ($category === "pet") {
        $stmt = $connection->prepare("DELETE FROM pets WHERE petId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } else {
        $stmt = $connection->prepare("UPDATE products SET quantity = quantity - ? WHERE productId = ?");
        $stmt->bind_param("ii", $quantity, $id);
        $stmt->execute();
        $stmt = $connection->prepare("UPDATE products SET status = 0 WHERE quantity = 0;");
        $stmt->execute();
    }
    $stmt->close();
}

// Add items into created order
function addOrderItems($cartid, $orderid, $connection)
{
    $pets = [];
    $products = [];
    $stmt = $connection->prepare("SELECT petId, productId, quantity, subtotal FROM cartitem WHERE cartId = ? AND STATUS = 1;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // Add pet into pet array
        if ($row['petId']) {
            $petid = $row['petId'];
            $quantity = $row["quantity"];
            $subtotal = $row["subtotal"];
            $pet = [
                'id' => $petid,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            array_push($pets, $pet);
        } else {
            // Add product into product array
            $productid = $row['productId'];
            $quantity = $row["quantity"];
            $subtotal = $row["subtotal"];
            $product = [
                'id' => $productid,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            array_push($products, $product);
        }
    }
    // Set cartitem to unavailable in the cart
    $stmt = $connection->prepare("UPDATE cartitem SET status = 0 WHERE cartId = ?;");
    $stmt->bind_param("i", $cartid);
    $stmt->execute();
    // Insert pets into order
    if (!empty($pets)) {
        foreach ($pets as $pet) {
            $id = $pet['id'];
            $category = "pet";
            $quantity = $pet['quantity'];
            $subtotal = $pet['subtotal'];
            reduceItemQuantity($id, $category, $quantity, $connection);
            $stmt = $connection->prepare("INSERT INTO orderitem (petId,orderId,quantity,subtotal)VALUES(?,?,?,?);");
            $stmt->bind_param("iiis", $id, $orderid, $quantity, $subtotal);
            $stmt->execute();
        }
    }
    // Insert products into order
    if (!empty($products)) {
        foreach ($products as $product) {
            $id = $product['id'];
            $category = "product";
            $quantity = $product['quantity'];
            $subtotal = $product['subtotal'];
            reduceItemQuantity($id, $category, $quantity, $connection);
            $stmt = $connection->prepare("INSERT INTO orderitem (productId,orderId,quantity,subtotal)VALUES(?,?,?,?);");
            $stmt->bind_param("iiis", $id, $orderid, $quantity, $subtotal);
            $stmt->execute();
        }
    }
    $stmt->close();
}

// Get array of order IDs of current account
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

// Get order total
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

// Get order item details in an array
function getOrderItems($orderId, $connection)
{
    $orderItemArray = [];
    $stmt = $connection->prepare("SELECT orderItemId, petId, productId, quantity, subtotal FROM orderitem WHERE orderid = ?;");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $orderitem = [];
        if (isset($row['petId'])) {
            $orderItemId = $row["orderItemId"];
            $id = $row['petId'];
            $itemType = 'pet';//
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];
            $category = "pet";
            $stmt2 = $connection->prepare('SELECT name FROM pets WHERE petId =?; ');
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $itemName = $row2['name'];
            $image = getImage($id, $category, "Card", true, $connection);
        } else {
            $orderItemId = $row["orderItemId"];
            $id = $row['productId'];
            $itemType = 'product';//
            $quantity = $row['quantity'];
            $subtotal = $row['subtotal'];
            $category = "product";
            $stmt2 = $connection->prepare('SELECT name FROM products WHERE productId =?; ');
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $itemName = $row2['name'];
            $image = getImage($id, $category, "Card", true, $connection);
        }
        $orderitem = [
            "orderItemId" => $orderItemId,
            "id" => $id,
            "itemType" => $itemType,//
            "category" => $category,
            "name" => $itemName,
            "quantity" => $quantity,
            "subtotal" => $subtotal,
            "image" => $image
        ];
        array_push($orderItemArray, $orderitem);
    }
    $stmt->close();
    $stmt2->close();
    return $orderItemArray;
}

// Insert review record into review table in database
function createReview($orderItemId, $newReview, $connection)
{
    $stmt = $connection->prepare("INSERT INTO review(userId, orderItemId, rating, feedback) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("iiis", $newReview["userId"], $orderItemId, $newReview["rating"], $newReview["feedback"]);
    $stmt->execute();
    $stmt->close();
}

// Check if order item has been rated
function rateEligibility($orderItemId, $connection)
{
    $stmt = $connection->prepare("SELECT reviewId FROM review WHERE orderItemId = ?;");
    $stmt->bind_param("i", $orderItemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $length = mysqli_num_rows($result);
    $stmt->close();
    return $length;
}

// Get total reviews of product
function getTotalProductReviews($productId, $category, $connection)
{
    $type = returnType($category);
    if (strtolower($type) === "product") {
        $stmt = $connection->prepare("SELECT review.reviewId FROM review INNER JOIN orderitem ON review.orderItemId = orderitem.orderItemId 
        WHERE orderitem.productId = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalReviews = mysqli_num_rows($result);
        $stmt->close();
        return $totalReviews;
    }
}

// Get array of review details of product
function getProductReviews($productId, $category, $connection)
{
    $type = returnType($category);
    if (strtolower($type) === "product") {
        $productReviewsArray = [];
        $stmt = $connection->prepare("SELECT user.firstName, user.lastName, review.rating, review.feedback, review.createdAt
        FROM user INNER JOIN review ON user.userId = review.userId INNER JOIN orderitem ON review.orderItemId = orderitem.orderItemId 
        WHERE orderitem.productId = ? ORDER BY review.createdAt DESC LIMIT 3");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $productReview = [];
            $firstName = $row["firstName"];
            $lastName = $row["lastName"];
            $rating = $row["rating"];
            $feedback = $row["feedback"];
            $createdAt = $row["createdAt"];
            $productReview = [
                "firstName" => $firstName,
                "lastName" => $lastName,
                "rating" => $rating,
                "feedback" => $feedback,
                "createdAt" => $createdAt,
            ];
            array_push($productReviewsArray, $productReview);
        }
        $stmt->close();
        return $productReviewsArray;
    }
}

// Get an array of the total for each star rating value (1-5) of a product
function getEachRatingTotal($productId, $category, $connection)
{
    $type = returnType($category);
    if (strtolower($type) === "product") {
        $eachRatingTotalArray = [];
        $stmt = $connection->prepare("SELECT review.rating FROM review INNER JOIN orderitem ON review.orderItemId = orderitem.orderItemId 
        WHERE orderitem.productId = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalOneStar = 0;
        $totalTwoStar = 0;
        $totalThreeStar = 0;
        $totalFourStar = 0;
        $totalFiveStar = 0;
        while ($row = $result->fetch_assoc()) {
            $rating = $row["rating"];
            if ($rating == 1) {
                $totalOneStar++;
            } elseif ($rating == 2) {
                $totalTwoStar++;
            } elseif ($rating == 3) {
                $totalThreeStar++;
            } elseif ($rating == 4) {
                $totalFourStar++;
            } else {
                $totalFiveStar++;
            }
        }
        $eachTotalRating = [
            "totalOneStar" => $totalOneStar,
            "totalTwoStar" => $totalTwoStar,
            "totalThreeStar" => $totalThreeStar,
            "totalFourStar" => $totalFourStar,
            "totalFiveStar" => $totalFiveStar,
        ];
        $stmt->close();
        return $eachTotalRating;
    }
}

// Get average rating of a product
function getAvgRating($productId, $connection)
{
    $stmt = $connection->prepare("SELECT AVG(review.rating) as AverageRating FROM review INNER JOIN orderitem ON review.orderItemId = orderitem.orderItemId 
    WHERE orderitem.productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $avgRating = $row['AverageRating'];
    $stmt->close();
    return $avgRating;
}

// Get the search results for admin.php
function getAdminSearch($connection, $type, $q)
{
    $adminSearchArray = [];
    if ($type === "pet") {
        $sql = "SELECT DISTINCT pets.petId as id, pets.name, pets.status, petcategory.category FROM pets, petcategory WHERE pets.petCatId = petcategory.petCatId   AND (pets.name LIKE ? OR petcategory.category LIKE ?);";
    } else if ($type === "product") {
        $sql = "SELECT DISTINCT products.productId as id, products.name, products.status, productcategory.category FROM products, productcategory WHERE products.productCatId = productcategory.productCatId  AND (products.name LIKE ? OR productcategory.category LIKE ?);";
    } else {
        return false;
    }
    //
    $stmt = $connection->prepare($sql);

    $searchKeyword = "%$q%";

    $stmt->bind_param("ss", $searchKeyword, $searchKeyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        array_push($adminSearchArray, $row);
    }
    $stmt->close();
    // $resultArray = [
    //   "categoryArray" => $categoryArray,
    //   "categoryDescription" => $categoryDescription,
    //   "categoryName" => $categoryName
    // ];
    return $adminSearchArray;
}

// Get the info of the item admin would like to edit
function getAdminEditItem($connection, $type, $id)
{
    if ($type === "pet") {
        $sql = "SELECT pets.name, pets.price, pets.status, pets.gender, pets.birthDate, pets.weight, pets.color, pets.petCondition, pets.vaccinated, pets.dewormed,  pets.petCatId, petCategory.category  
        FROM  pets, petCategory  WHERE pets.petCatId = petCategory.petCatId AND petid = ? ;";
    } else if ($type === "product") {
        $sql = "SELECT products.name, products.price, products.quantity, products.status, products.description, products.brand, products.weight, products.warrantyPeriod, products.productDimensions, products.productCatId, productCategory.category
        FROM products, productCategory  WHERE products.productCatId = productCategory.productCatId AND  productid = ?;";
    } else {
        return false;
    }
    //
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $itemArray = $result->fetch_assoc();
    $stmt->close();
    
    return $itemArray;
}

// Check if an array is an associative array
function isAssociativeArray($array)
{
    if (count(array_filter(array_keys($array), 'is_string')) > 0) {
        return true;
    }
    return false;
}

// Check to see if the values enter by admin for pet is valid
// For edit item and add pet
function adminValidatePet($postArray)
{
    $errorArray = [];
    $category = "";
    $sanitizeTextArray = [
        "name" => ucfirst($postArray["name"]),
        "weight" => strtolower($postArray["weight"]),
        "color" => ucfirst($postArray["color"]),
        "petCondition" => ucfirst($postArray["petCondition"])
    ];

    $validateSelectArray = [
        "vaccinated" => $postArray["vaccinated"],
        "dewormed" => $postArray["dewormed"]
    ];

    foreach ($sanitizeTextArray as $key => $value) {
        $sanitizeProducttArray[$key] = sanitizeText($value);

        if (!$value) {
            array_push($errorArray, "Invalid $key");
        }
    }

    foreach ($validateSelectArray as $key => $value) {

        if (strtolower($value) !== "yes" && strtolower($value) !== "no") {
            array_push($errorArray, "$key field has invalid value");
        }
    }

    $status = filter_var($postArray["status"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 1)));

    if (!$status && $status !== 0) {
        array_push($errorArray, "Status field has invalid value");
    }

    $price = filter_var($postArray["price"], FILTER_VALIDATE_FLOAT);

    if ($price === false) {
        array_push($errorArray, "Invalid Price");
    } else {
        $price = round($price, 2);
    }

    $gender = ucfirst($postArray["gender"]);

    if (strtolower($gender) !== "male" && strtolower($gender) !== 'female') {
        array_push($errorArray, "Invalid Gender");
    }

    // Separate the string from -, will have an array with 3 values.
    $checkBirthDate = explode("-", $postArray["birthDate"]);
    if (checkdate((int)$checkBirthDate[1], (int)$checkBirthDate[2], (int)$checkBirthDate[0])) {
        $new_date = date("Y-m-d", strtotime($_POST["birthDate"]));
    } else {
        array_push($errorArray, "Invalid Birth Date");
    }



    $category = filter_var($postArray["category"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 3)));

    if (!$category) {
        array_push($errorArray, "Invalid value in category field");
    }


    if ($errorArray) {
        return $errorArray;
    }

    $adminPetArray = [
        "name" => $sanitizeTextArray["name"],
        "weight" => $sanitizeTextArray["weight"],
        "color" => $sanitizeTextArray["color"],
        "petCondition" => $sanitizeTextArray["petCondition"],
        "birthDate" => $new_date,
        "price" => $price,
        "gender" => $gender,
        "status" => $status,
        "vaccinated" => $validateSelectArray["vaccinated"],
        "dewormed" => $validateSelectArray["dewormed"],
        "category" => $category
    ];

    return $adminPetArray;
}

// Insert updated values of pet to the database
function adminUpdatePet($connection, $petArray, $id)
{
    $stmt = $connection->prepare("UPDATE pets SET name= ?, price = ?,  status = ?, 
    gender = ? , birthDate = ? , weight = ?, color = ?, petCondition = ?, vaccinated = ?, dewormed = ?, petCatId = ? WHERE petId = ?");

    $stmt->bind_param(
        "ssisssssssii",
        $petArray["name"],
        $petArray["price"],
        $petArray["status"],
        $petArray["gender"],
        $petArray["birthDate"],
        $petArray["weight"],
        $petArray["color"],
        $petArray["petCondition"],
        $petArray["vaccinated"],
        $petArray["dewormed"],
        $petArray["category"],
        $id
    );
    $stmt->execute();
    $stmt->close();
}

// Check to see if the values enter by admin for product is valid
// For edit item and add product
function adminValidateProduct($postArray)
{
    $errorArray = [];

    $sanitizeProducttArray = [
        "name" => $postArray["name"],
        "description" => $postArray["description"],
        "brand" => $postArray["brand"],
        "weight" => strtolower($postArray["weight"]),
        "warrantyPeriod" => strtolower($postArray["warrantyPeriod"]),
        "productDimensions" => $postArray["productDimensions"]
    ];

    foreach ($sanitizeProducttArray as $key => $value) {
        if ($key === "description") {
            $sanitizeProducttArray[$key] = str_replace("\n", "[NEWLINE]", $value);
        }
        $sanitizeProducttArray[$key] = sanitizeText($value);

        if ($value === false) {
            array_push($errorArray, "Invalid " . strtolower($key));
        }

        if ($key === "description") {
            $sanitizeProducttArray[$key] = str_replace("[NEWLINE]", "\n", $value);
        }
    }

    $price = filter_var($postArray["price"], FILTER_VALIDATE_FLOAT);

    if ($price === false) {
        array_push($errorArray, "Invalid Price");
    } else {
        $price = round($price, 2);
    }

    $quantity = filter_var($postArray["quantity"], FILTER_VALIDATE_INT);

    if (!$quantity && $quantity !== 0) {
        array_push($errorArray, "Invalid Quantity");
    }

    $status = filter_var($postArray["status"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 0, "max_range" => 1)));

    if (!$status && $status !== 0) {
        array_push($errorArray, "Invalid value in status field");
    }else{
        $status = ($quantity === 0) ? 0 : $status;
    }



    $category = filter_var($postArray["category"], FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 7)));

    if (!$category) {
        array_push($errorArray, "Invalid value in category field");
    }


    if ($errorArray) {
        return $errorArray;
    }

    $adminProductArray = [
        "name" => $sanitizeProducttArray["name"],
        "description" => $sanitizeProducttArray["description"],
        "brand" => $sanitizeProducttArray["brand"],
        "weight" => $sanitizeProducttArray["weight"],
        "warrantyPeriod" => $sanitizeProducttArray["warrantyPeriod"],
        "productDimensions" => $sanitizeProducttArray["productDimensions"],
        "price" => $price,
        "quantity" => $quantity,
        "status" => $status,
        "category" => $category
    ];

    return $adminProductArray;
}

// Insert updated values of product to the database
function adminUpdateProduct($connection, $id, $productArray)
{
    $stmt = $connection->prepare("UPDATE products SET name= ?  ,price = ?, quantity = ?, status = ?, 
    description = ? , brand = ? , weight = ?, warrantyPeriod = ?, productDimensions = ?, productCatId= ? WHERE productId = ?");

    $stmt->bind_param(
        "ssiisssssii",
        $productArray["name"],
        $productArray["price"],
        $productArray["quantity"],
        $productArray['status'],
        $productArray["description"],
        $productArray["brand"],
        $productArray["weight"],
        $productArray["warrantyPeriod"],
        $productArray["productDimensions"],
        $productArray["category"],
        $id
    );
    $stmt->execute();
    $stmt->close();
}

// Insert new pet into the database
// For add_pet.php
function adminAddPet($connection, $petArray)
{
    $stmt = $connection->prepare("INSERT INTO pets(name, price, status, gender, birthDate, weight, color, petCondition, vaccinated, dewormed, petCatId)  
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param(
        "ssisssssssi",
        $petArray["name"],
        $petArray["price"],
        $petArray["status"],
        $petArray['gender'],
        $petArray["birthDate"],
        $petArray["weight"],
        $petArray["color"],
        $petArray["petCondition"],
        $petArray["vaccinated"],
        $petArray["dewormed"],
        $petArray["category"]
    );
    $stmt->execute();
    $stmt->close();
}


// Insert new product into the database
// For add_product.php
function adminAddProduct($connection, $productArray)
{
    $stmt = $connection->prepare("INSERT INTO products(name, price, quantity, status, description, brand, weight, warrantyPeriod, productDimensions, productCatId)  
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param(
        "ssiisssssi",
        $productArray["name"],
        $productArray["price"],
        $productArray["quantity"],
        $productArray['status'],
        $productArray["description"],
        $productArray["brand"],
        $productArray["weight"],
        $productArray["warrantyPeriod"],
        $productArray["productDimensions"],
        $productArray["category"]
    );
    $stmt->execute();
    $stmt->close();
}

// Insert new card image for the item
function addNewItemCardImage($mimeType, $image, $connection, $id, $category, $name, $type)
{
    $category = str_replace(" ", "_", $category);
    $name = str_replace(" ", "_", $name);
    // Check to see if dir exists, if not, create one
    $cardImageDir = "../Images/$category/$name/Card";
    if (!is_dir($cardImageDir)) {
        mkdir($cardImageDir, 0777, true);
    }

    $name .=  "_Card_319_409";

    switch ($mimeType) {
        case "image/png":
            $cardPic = $cardImageDir .  "/$name" . ".png";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpg":
            $cardPic = $cardImageDir . "/$name" . ".jpg";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpeg":
            $cardPic = $cardImageDir .  "/$name" . ".jpeg";
            file_put_contents($cardPic, $image);
            break;
    }

    $saveToDbImage = substr($cardPic, 1);

    if ($type === "pet") {
        $stmt = $connection->prepare("INSERT INTO petimage(petid, imageName, imagePath, imageType) VALUES (?, ?, ?, 'Card');");
        $stmt->bind_param("iss", $id, $name, $saveToDbImage);
    } elseif ($type === "product") {
        $stmt = $connection->prepare("INSERT INTO productimage(productid, imageName, imagePath, imageType) VALUES (?, ?, ?, 'Card');");
        $stmt->bind_param("iss", $id, $name, $saveToDbImage);
    }

    $stmt->execute();
    $stmt->close();
}

// Update the imagePath of the card image of the item in the database
function overwriteItemCardImage($mimeType, $image, $connection, $id,  $name, $currentImagePath, $type)
{

    // Get the dir where the old image is stored in
    $currentDirName = "." . dirname($currentImagePath) . "/";
    $files = glob("$currentDirName" . "*"); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file)) {
            unlink($file); // delete file
        }
    }
    $name = str_replace(" ", "_", $name);

    switch ($mimeType) {
        case "image/png":
            $cardPic = $currentDirName .  $name . "_Card_319_409" . ".png";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpg":
            $cardPic = $currentDirName  . $name . "_Card_319_409" . ".jpg";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpeg":
            $cardPic = $currentDirName  .  $name . "_Card_319_409" . ".jpeg";
            file_put_contents($cardPic, $image);
            break;
    }

    $saveToDbImage = substr($cardPic, 1);


    if ($type === "pet") {
        $stmt = $connection->prepare("UPDATE petimage SET imagePath = ? WHERE petid = ? AND imageType = 'Card';");
        $stmt->bind_param("si", $saveToDbImage, $id);
    } elseif ($type === "product") {
        $stmt = $connection->prepare("UPDATE productimage SET imagePath = ? WHERE productid = ? AND imageType = 'Card';");
        $stmt->bind_param("si", $saveToDbImage, $id);
    }

    $stmt->execute();
    $stmt->close();
}
// Insert new gallery image for an item into the database
function addNewItemGalleryImage($mimeType, $image, $connection, $id, $dirName, $name, $type)
{
    switch ($mimeType) {
        case "image/png":
            $cardPic = $dirName .  "$name" . ".png";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpg":
            $cardPic = $dirName . "$name" . ".jpg";
            file_put_contents($cardPic, $image);
            break;
        case "image/jpeg":
            $cardPic = $dirName .  "$name" . ".jpeg";
            file_put_contents($cardPic, $image);
            break;
    }

    $saveToDbImage = substr($cardPic, 1);

    if ($type === "pet") {
        $stmt = $connection->prepare("INSERT INTO petimage(petid, imageName, imagePath, imageType) VALUES (?, ?, ?, 'Gallery');");
        $stmt->bind_param("iss", $id, $name, $saveToDbImage);
    } elseif ($type === "product") {
        $stmt = $connection->prepare("INSERT INTO productimage(productid, imageName, imagePath, imageType) VALUES (?, ?, ?, 'Gallery');");
        $stmt->bind_param("iss", $id, $name, $saveToDbImage);
    }

    $stmt->execute();
    $stmt->close();
}

<?php session_start(); 

  if(isset($_POST["saveProfile"], $_GET["id"], $_SESSION["user"]["userID"])){

    require_once "../function/db.php"; 

    $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");


    $userId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_var($userId, FILTER_VALIDATE_INT);

    $firstName = validateText($_POST["firstName"]);
    $lastName = validateText($_POST["lastName"]);
    $addressLine = validateText($_POST["addressLine"]);
    $city = validateText($_POST["city"]);

    if($_POST["postcode"] !== ""){
      $postcode = filter_input(INPUT_POST, "postcode", FILTER_VALIDATE_REGEXP, array("regexp"=>"/^[0-9]{5}$/"));
    }else{
      $postcode = 0;
    }

    if(!$_POST["state"] !== ""){
      
    }

    $stmt = $connection->prepare("UPDATE user SET firstName = ?, lastName = ?, mobileNumber = ?, addressLine = ?, city = ?, userState = ?, postcode = ? WHERE userId = ?");



  }
?>

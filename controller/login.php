<?php 

session_start();

if(isset($_POST["signin"]) && isset($_GET["page"])){
  require_once "../function/db.php";

  $page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);
  $lastPage = !$page? "": $page;

  $filters = [
    "email"=> FILTER_SANITIZE_EMAIL,
    "password" => FILTER_SANITIZE_STRING,
  ];

  $sanitizeInput = filter_input_array(INPUT_POST, $filters);

  if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
    array_push($emptyArray, "email");
  }

  if($_POST["password"] === ""){
    array_push($emptyArray, "password");
  }

  if (!$emptyArray){
    $email = $sanitizeInput["email"];
    $password = $sanitizeInput["password"];

    $stmt = $connection->prepare("SELECT * FROM user WHERE email = ?;");

    if(!$stmt){
      $_SESSION["isValidLogin"] = "error";

    }
    $stmt->bind_param("s", $email);


    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $stmt->close();

    $verifyPassword = password_verify($password, $row["userPassword"]);  
    $validLogin = ($verifyPassword === false) ? false : true;

    if ($validLogin){
      $_SESSION["user"] = array(
        "userID" => $row["userId"],
        "firstName" => $row["firstName"],
        "lastName" => $row["lastName"],
        "email" => $row["email"],
        "addressLine" => $row["addressLine"],
        "mobileNumber" =>$row["mobileNumber"],
        "city" => $row["city"],
        "state" => $row["userState"],
        "userPicture" => $row["imagePath"],
        "postcode" => $row["postcode"],
        "userRole" => $row["userRole"]
      );
  
      $_SESSION["isValidLogin"] = "success";
    }
    else{
      $_SESSION["isValidLogin"] = "error";
    
    }
  }
  else{
    $_SESSION["isValidLogin"] = $emptyArray;
  }

  header("Location: ../$lastPage");
  exit();
}

if(isset($_POST["logout"]) && isset($_GET["page"])){
  $page = filter_input(INPUT_GET, "page", FILTER_SANITIZE_STRING);
  $lastPage = !$page? "": $page;
  session_unset();
  session_destroy();
  header("Location: ../$lastPage");
  exit();
}


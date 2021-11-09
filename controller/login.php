<?php

session_start();

// To handle user login request sent from header,php (name of button = "signin")
if (isset($_POST["signin"]) && isset($_GET["page"])) {
    require_once "../connection/db.php";
    $loginErrorArray = [];
    $lastPageQuery = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

    // Get the last page the user was on before signing in
    $lastPage = $lastPageQuery["page"];
    // Get the query string from the last page the user was on before signing in
    $queryString = $lastPageQuery["queryString"];


    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($loginErrorArray, "email");
    }
    if ($_POST["password"] === "") {
        array_push($loginErrorArray, "password");
    }
    if (!$loginErrorArray) {
        $password = $_POST["password"];
        $stmt = $connection->prepare("SELECT * FROM user WHERE email = ?;");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $verifyPassword = password_verify($password, $row["userPassword"]);
        $validLogin = ($verifyPassword === false) ? false : true;
        if ($validLogin) {
            $_SESSION["user"] = array(
                "userID" => $row["userId"],
                "firstName" => $row["firstName"],
                "lastName" => $row["lastName"],
                "email" => $row["email"],
                "addressLine" => $row["addressLine"],
                "mobileNumber" => $row["mobileNumber"],
                "city" => $row["city"],
                "state" => $row["userState"],
                "userPicture" => $row["imagePath"],
                "postcode" => $row["postcode"],
                "userRole" => $row["userRole"]
            );
            $_SESSION["alertMessage"][] = "Login Successful";
        } else {
            $_SESSION["alertMessage"][] = "Incorrect Login Details";
        }
    } else {
        $_SESSION["loginErrorArray"] = $loginErrorArray;
        $_SESSION["alertMessage"][] = "Invalid Details";
    }
   if (!$queryString){
        header("Location: ../$lastPage");
        exit();
    } else {
        header("Location: ../$lastPage?$queryString");
        exit();
    }
}
if (isset($_POST["logout"]) && isset($_GET["page"])) {
    $lastPageQuery = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

     // Get the last page the user was on before logging out
    $lastPage = $lastPageQuery["page"];
    // Get the query string from the last page the user was on before  logging out
    $queryString = $lastPageQuery["queryString"];
    
    session_unset();
    session_destroy();

    if (!$queryString){
        header("Location: ../$lastPage");
        exit();
    } else {
        header("Location: ../$lastPage?$queryString");
        exit();
    }
}

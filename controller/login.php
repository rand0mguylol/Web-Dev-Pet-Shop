<?php

session_start();

// var_dump(($_GET));
if (isset($_POST["signin"]) && isset($_GET["page"])) {
    require_once "../connection/db.php";
    $loginErrorArray = [];
    $lastPageQuery = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $lastPage = !$lastPageQuery["page"] ? "" : $lastPageQuery["page"];
    if (count($lastPageQuery) > 1) {
        array_shift($_GET);
        foreach ($_GET as $key => $value) {
            $lastPage .= "&" . $key . "=" . $value;
        }
    }

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
            $_SESSION["loginMessage"] = "Login Successful";
        } else {
            $_SESSION["loginMessage"] = "Incorrect Login Details";
        }
    } else {
        $_SESSION["loginErrorArray"] = $loginErrorArray;
        $_SESSION["loginMessage"] = "Invalid Detials";
    }
    header("Location: ../$lastPage");
    exit();
}
if (isset($_POST["logout"]) && isset($_GET["page"])) {
    $lastPageQuery = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $lastPage = !$lastPageQuery["page"] ? "" : $lastPageQuery["page"];
    session_unset();
    session_destroy();
    if (count($lastPageQuery) > 1) {
        array_shift($_GET);
        foreach ($_GET as $key => $value) {
            $lastPage .= "&" . $key . "=" . $value;
        }
    }
    header("Location: ../" . $lastPage);
    exit();
}

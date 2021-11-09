<?php session_start();

// Handle update profile POST request from profile.php (Profile Tab) (Name of button = saveProfile )

if (isset($_POST["saveProfile"], $_SESSION["user"]["userID"])) {
    require_once "../connection/db.php";
    require_once "../helper/helpers.php";
    //
    $profileErrorArray = [];
    $firstName = sanitizeText($_POST["firstName"]);
    $lastName = sanitizeText($_POST["lastName"]);
    $addressLine = sanitizeText($_POST["addressLine"]);
    $city = sanitizeText($_POST["city"]);
    //
    $mobileNumber = validateMobileNumber($_POST["mobileNumber"]);
    if ($mobileNumber === false) {
        array_push($profileErrorArray, "mobileNumber");
    }
    //
    $postcode = validatePostcode($_POST['postcode']);
    if ($postcode === false) {
        array_push($profileErrorArray, "postcode");
    }
    //
    $state = validateState($_POST['state']);
    if ($state === false) {
        array_push($profileErrorArray, "state");
    }
    //
    if (!$profileErrorArray) {
        $newInfo = array(
            "firstName" => $firstName,
            "lastName" => $lastName,
            "mobileNumber" => $mobileNumber,
            "addressLine" => $addressLine,
            "city" => $city,
            "state" => $state,
            "postcode" => $postcode
        );
        updateProfile($newInfo, $connection, $_SESSION["user"]["userID"]);
        $_SESSION["alertMessage"][] = "Info Saved";
    } else {
        $_SESSION["alertMessage"][] = "Invalid Details";
        $_SESSION["profileUpdateError"] = $profileErrorArray;
    }
    //
    header("Location: ../profile.php");
    exit();
}

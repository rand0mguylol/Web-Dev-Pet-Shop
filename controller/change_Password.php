<?php
session_start();
require_once "./connection/db.php";
require_once "./helper/helpers.php";

if (isset($_POST["changePass"], $_SESSION["user"]["userID"])) {
    //
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    $_SESSION["passwordChangeMsg"] = changePassword($_POST["oldPassword"], $_POST["newPassword"], $_POST["confirmPassword"], $_SESSION["user"]["userID"], $connection);
    header("Location: ../profile.php");
    exit();
}

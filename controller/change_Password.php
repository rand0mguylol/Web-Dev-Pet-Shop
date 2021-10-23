<?php
session_start();
require_once "../function/db.php";
require_once "../function/helpers.php";

if(isset($_POST["changePass"], $_GET["id"], $_SESSION["user"]["userID"])){

  $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
  
  $_SESSION["passwordChangeMsg"] = changePassword($_POST["oldPassword"], $_POST["newPassword"], $_POST["confirmPassword"], $id, $connection);
  header("Location: ../profile.php");
  exit();
}


<?php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

// var_dump($_POST);
if (!isset($_SESSION["user"]["userRole"], $_POST["type"], $_POST["id"], $_POST["deleteCardImage"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}

if($_POST["type"] === "pet"){
  $stmt = $connection -> prepare("DELETE FROM `petimage` WHERE petid = ? AND imageType = 'Card';");
}elseif($_POST["type"] === "product"){
  $stmt = $connection -> prepare("DELETE FROM `productimage` WHERE productid = ? AND imageType = 'Card';");
}

$stmt->bind_param("i", $_POST["id"]);
$stmt->execute();
$stmt->close();


$_SESSION["alertMessage"] = "Image Deleted";
header("Location: ../admin.php");
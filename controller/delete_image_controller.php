<?php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";


if (!isset($_SESSION["user"]["userRole"], $_POST["type"], $_POST["imageid"], $_POST["deleteImage"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}


// To handle delete image request from delete_image.php
if(strtolower($_POST["type"]) === "pet"){
  $stmt = $connection -> prepare("DELETE FROM `petimage` WHERE petimageid = ? AND imageType = ?;");
}elseif(strtolower($_POST["type"]) === "product"){
  $stmt = $connection -> prepare("DELETE FROM `productimage` WHERE productimageid = ? AND imageType = ?;");
}

$imageType = ucfirst(sanitizeText($_POST["imageType"]));

$stmt->bind_param("is", $_POST["imageid"], $imageType);
$stmt->execute();
$stmt->close();

// Delete selected image from server folder
unlink("." . $_POST["imagePath"]);

$_SESSION["alertMessage"][] = "Image Deleted";
header("Location: ../delete_image.php?id=" . $_GET["id"] . "&type=" . $_POST["type"] . "&imageType=". $imageType);
exit();
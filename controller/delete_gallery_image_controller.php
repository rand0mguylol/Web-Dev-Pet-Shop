<?php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

// var_dump($_POST);
if (!isset($_SESSION["user"]["userRole"], $_POST["type"], $_POST["imageid"], $_POST["deleteGalleryImage"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}

// var_dump($_POST);

if($_POST["type"] === "pet"){
  $stmt = $connection -> prepare("DELETE FROM `petimage` WHERE petimageid = ? AND imageType = 'Gallery';");
}elseif($_POST["type"] === "product"){
  $stmt = $connection -> prepare("DELETE FROM `productimage` WHERE productimageid = ? AND imageType = 'Gallery';");
}

$stmt->bind_param("i", $_POST["imageid"]);
$stmt->execute();
$stmt->close();


$_SESSION["alertMessage"] = "Image Deleted";
header("Location: ../delete_gallery.php?id=" . $_GET["id"] . "&type=" . $_POST["type"]);
exit();
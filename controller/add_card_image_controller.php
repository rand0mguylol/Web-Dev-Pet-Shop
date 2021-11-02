<?php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (!isset($_SESSION["user"]["userRole"], $_GET["type"], $_GET["id"], $_GET["category"], $_POST["addCardImage"] ,$_GET["name"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}

if($_GET["type"] === "pet"){
  $stmt = $connection->prepare("SELECT petimage.petid, petimage.imagePath FROM petimage WHERE petimage.petid = ? AND imageType = 'Card'");
}elseif($_GET["type"] === "product"){
  $stmt = $connection->prepare("SELECT productimage.productid, productimage.imagePath FROM productimage WHERE productimage.productid = ? AND imageType = 'Card'");
}
  $stmt->bind_param("i", $_GET["id"]);
  $stmt->execute();
  $result = $stmt->get_result();
  $checkIdExist= $result->fetch_assoc();
  $stmt->close();

  $dataURI = $_POST["cardImage"];
  $image = file_get_contents($dataURI);
  //
  $imageMime = validateImage($image);
  //
  if (!$imageMime) {
      $_SESSION["uploadImageMessage"] = "Invalid Image Type";
  }

  if (!$checkIdExist) {
    //
    $_SESSION["uploadImageMessage"] = "Image Updated";
    addNewItemCardImage($imageMime, $image, $connection, $_GET["id"], $_GET["category"], $_GET["name"], $_GET["type"]);
  }else{
    $currentImagePath = $checkIdExist["imagePath"];
    $_SESSION["uploadImageMessage"] = "Image Updated";
    overwriteItemCardImage($imageMime, $image, $connection, $_GET["id"], $_GET["name"], $currentImagePath, $_GET["type"]);  
  }

  header("Location: ../add_card_image.php?id=$_GET[id]&category=$_GET[category]&type=$_GET[type]&name=$_GET[name]");
  exit();
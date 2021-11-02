<?php

use function PHPSTORM_META\override;

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (!isset($_SESSION["user"]["userRole"], $_GET["type"], $_GET["id"], $_GET["category"], $_POST["addGalleryImage"] ,$_GET["name"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}

if($_GET["type"] === "pet"){
  $stmt = $connection->prepare("SELECT petimage.petid, petimage.imagePath FROM petimage WHERE petimage.petid = ? AND imageType = 'Gallery'");
}elseif($_GET["type"] === "product"){
  $stmt = $connection->prepare("SELECT productimage.productid, productimage.imagePath FROM productimage WHERE productimage.productid = ? AND imageType = 'Gallery'");
}
$checkIdExistArray = [];
  $stmt->bind_param("i", $_GET["id"]);
  $stmt->execute();
  $result = $stmt->get_result();

  while( $row = $result->fetch_assoc()){
    array_push($checkIdExistArray, $row);
  }
  $stmt->close();

  $dataURI = $_POST["galleryImage"];
  $image = file_get_contents($dataURI);
  //
  $imageMime = validateImage($image);
  //
  if (!$imageMime) {
      $_SESSION["uploadImageMessage"] = "Invalid Image Type";
  }

  if (count($checkIdExistArray) === 0) {
    //
    $_SESSION["uploadImageMessage"] = "Image Added";
    addNewItemGalleryImage($imageMime, $image, $connection, $_GET["id"], $_GET["category"], $_GET["name"], $_GET["type"]);
  }else{
    $currentImagePath = $checkIdExistArray[0]["imagePath"];
    $_SESSION["uploadImageMessage"] = "Image Added";
    $index = count($checkIdExistArray) + 1;
    insertItemGalleryImage($imageMime, $image, $connection, $_GET["id"], $_GET["name"], $currentImagePath, $_GET["type"], $index);  
  }

  header("Location: ../add_gallery_image.php?id=$_GET[id]&category=$_GET[category]&type=$_GET[type]&name=$_GET[name]");
  exit();

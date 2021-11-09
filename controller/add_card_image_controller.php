<?php

// To handle request for adding card images for an item
// POST received from add_card_image.php

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

  // Get the dataURI of the image file submitted by the admin
  $dataURI = $_POST["cardImage"];
  $image = file_get_contents($dataURI);
  //
  $imageMime = validateImage($image);
  //Check to see if correct file extension 
  if (!$imageMime) {
      $_SESSION["alertMessage"][] = "Invalid Image Type";
  }

  // Check if the item has an existing card image
  if (!$checkIdExist) {
    $_SESSION["alertMessage"][] = "Image Updated";
    addNewItemCardImage($imageMime, $image, $connection, $_GET["id"], $_GET["category"], $_GET["name"], $_GET["type"]);
  }else{
    // Get the correct image path from the current card image
    $currentImagePath = $checkIdExist["imagePath"];
    $_SESSION["alertMessage"][] = "Image Updated";
    overwriteItemCardImage($imageMime, $image, $connection, $_GET["id"], $_GET["name"], $currentImagePath, $_GET["type"]);  
  }

  header("Location: ../add_card_image.php?id=$_GET[id]&category=$_GET[category]&type=$_GET[type]&name=$_GET[name]");
  exit();

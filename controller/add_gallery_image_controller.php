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
      $_SESSION["alertMessage"][] = "Invalid Image Type";
  }

  $index = count($checkIdExistArray) + 1;


  if (count($checkIdExistArray) === 0) {
    //  $category = str_replace(" ", "_", $category);
    $category = str_replace(" ", "_", $_GET["category"]);
    $name = str_replace(" ", "_", $_GET["name"]);
    $dirName = "../Images/$category/$name/Gallery/";
    if (!is_dir($dirName )) {
        mkdir($dirName , 0777, true);
    }

    $name .=  "_Gallery_550_550";

    addNewItemGalleryImage($imageMime, $image, $connection, $_GET["id"], $dirName, $name, $_GET["type"]);
  }else{
    $currentImagePath = $checkIdExistArray[0]["imagePath"];
    $dirName = "." . dirname($currentImagePath) . "/";
    $name = str_replace(" ", "_", $_GET["name"]) . "_$index" . "_Gallery_550_550";
    addNewItemGalleryImage($imageMime, $image, $connection, $_GET["id"], $dirName, $name, $_GET["type"]);  
  }

  $_SESSION["alertMessage"][] = "Image Added";
  header("Location: ../add_gallery_image.php?id=$_GET[id]&category=$_GET[category]&type=$_GET[type]&name=$_GET[name]");
  exit();

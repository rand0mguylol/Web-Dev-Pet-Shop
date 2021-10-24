<?php

session_start();

if(isset($_SESSION["user"]["userID"], $_POST["uploadPic"])){

  $hasImage = $_SESSION["user"]["userPicture"] === "" ? false : true;
  require_once "../function/helpers.php";
  require_once "../function/db.php";

  $dataURI = $_POST["newProfilePic"];
  $image = file_get_contents($dataURI);

  $imageMime = validateImage($image);

  if(!$imageMime){
    $_SESSION["uploadImageMessage"] = "Invalid Image Type";
    header("Location: ../profile.php");
    exit();
  }

  $_SESSION["uploadImageMessage"] = "Image Updated";
  saveImage($imageMime, $image, $connection, $_SESSION["user"]["userID"], $hasImage);
  header("Location: ../profile.php");
  exit();
}

if(isset($_SESSION["user"]["userID"], $_POST["removeProfilePic"])){
  require_once "../function/db.php";
  $defaultPic = "./svg/profile-pic-default.svg";
  $stmt = $connection->prepare("UPDATE user SET imagePath = ? WHERE userId = ?");
  $stmt->bind_param("si", $defaultPic, $_SESSION["user"]["userID"]);
  $stmt->execute();
  $stmt->close();
  $_SESSION["user"]["userPicture"] = $defaultPic;

  $files = glob("../Images/User/user_". $_SESSION["user"]["userID"] ."/*"); // get all file names
  foreach($files as $file){ // iterate files
    if(is_file($file)) {
      unlink($file); // delete file
    }
  }
  $_SESSION["uploadImageMessage"] = "Image Updated";
  header("Location: ../profile.php");
  exit();
}



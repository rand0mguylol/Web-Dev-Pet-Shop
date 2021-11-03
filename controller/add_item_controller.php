<?php

use function PHPSTORM_META\override;

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

if (!isset($_SESSION["user"]["userRole"], $_POST["type"], $_POST["id"], $_POST["addItem"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

if($_POST["type"] === "pet"){
  $stmt = $connection->prepare("UPDATE pets SET status= 1 WHERE pets.petId = ? ");
}elseif($_POST["type"] === "product"){
  $stmt = $connection->prepare("UPDATE products SET status= 1 WHERE products.petId = ? ");
}

$stmt->bind_param("i", $id);
$stmt->execute();

$_SESSION["alertMessage"] = "Item Added";
header("Location: ../admin.php");
exit();
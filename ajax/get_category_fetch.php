<?php

session_start();
require_once "../helper/helpers.php";
require_once "../connection/db.php";

$category = sanitizeText($_GET["categoryName"]);
if (isset($_GET["q"]) && $_GET["q"] !== "") {
      $q = sanitizeText($_GET["q"]);
      $categoryArray = getCategoryProduct($connection, $category, $q);
  } else {
      $categoryArray = getCategoryProduct($connection, $category);
  }

  header("Content-Type: application/json");
  echo json_encode($categoryArray);
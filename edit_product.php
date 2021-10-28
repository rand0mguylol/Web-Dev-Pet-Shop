<?php session_start(); 
$title = "Admin Panel";

require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (isset($_SESSION["user"]["userRole"], $_GET["id"], $_GET["type"]) && $_SESSION["user"]["userRole"] === "STAFF") {

  if (empty($_GET["id"]) || empty($_GET["type"])){
    header("Location: ./index.php");
    exit();
  }

  $type = sanitizeText($_GET["type"]);


  $itemArray = getAdminEditItem($connection, $type, $_GET["id"]);
}

else {
  header("Location: ./index.php");
  exit();
}

?>

<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>
<div class="main-wrapper profile">

  
</div>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/profile.js"></script>
<script src="./js/aos.js"></script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>
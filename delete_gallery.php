<?php

session_start();
require_once "./helper/helpers.php";
require_once "./connection/db.php";

// var_dump($_POST);
if (!isset($_SESSION["user"]["userRole"], $_GET["type"], $_GET["id"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}
$galleryArray = [];
if($_GET["type"] === "pet"){
  $stmt = $connection -> prepare("SELECT petimage.petImageId as id, petimage.imageName, petimage.imagePath FROM petimage WHERE petimage.petid = ? AND petimage.imageType = 'Gallery';");
}elseif($_GET["type"] === "product"){
  $stmt = $connection -> prepare("SELECT productimage.productImageId as id, productimage.imageName, productimage.imagePath FROM productimage WHERE productid = ? AND imageType = 'Gallery';");
}

$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$result = $stmt->get_result();
// echo "<pre>";
// var_dump($result);
// echo "</pre>";

// if(!$result){
//   $_SESSION["alertMessage"] = "There are no images to be deleted";
//   header("Location: ../admin.php");
//   exit();
// }
while($row= $result->fetch_assoc()){
  array_push($galleryArray, $row);
}

if(isset($_SESSION["alertMessage"])){
  $alertMessage = $_SESSION["alertMessage"];
  unset($_SESSION["alertMessage"]);
}
?>

<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>

<?php if (isset($alertMessage)) : ?>
    <div data-aos="fade-down" class="text-center alert alert-success alert-dismissible fade show position-fixed mx-auto login-alert" role="alert">
        <strong><?php echo $alertMessage; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container my-5">
  <div class = "w-75 mx-auto">
    <form action="./controller/delete_gallery_image_controller.php?id=<?php echo $_GET["id"];?>" class = "row g-3 justify-content-center" method="POST">
      <input type="hidden" name = "type" value = "<?php echo $_GET["type"];?>">
      <select class="form-select d-inline-block w-50" aria-label="Default select example" name = "imageid" >
        <?php foreach ($galleryArray as $gallery): ?>
        <option value="<?php echo $gallery["id"];?>"><?php echo $gallery["imageName"];?></option>
        <?php endforeach; ?>
      </select>
      <button class = "btn btn-info w-25 ms-3" type = "submit" name = "deleteGalleryImage">Delete Gallery Image</button>
    </form>
  </div>

  <div class = "row row-cols-3 flex-wrap my-5">
    <?php foreach ($galleryArray as $gallery): ?>
    <div class = "col text-center">
      <div>
        <img src="<?php echo $gallery["imagePath"];?>" alt="" class = "img-fluid shadow" style ="width: 300px; height: 300px;">
      </div>
        <p class = "mt-5 text-center test"><?php echo $gallery["imageName"];?></p>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>

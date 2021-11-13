<?php

session_start();
require_once "./helper/helpers.php";
require_once "./connection/db.php";

// var_dump($_POST);
if (!isset($_SESSION["user"]["userRole"], $_GET["type"], $_GET["id"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ../index.php");
  exit();
}
$imageArray = [];
if($_GET["type"] === "pet"){
  $stmt = $connection -> prepare("SELECT petimage.petImageId as imageid, petimage.imageName, petimage.imagePath FROM petimage WHERE petimage.petid = ? AND petimage.imageType = ?;");
}elseif($_GET["type"] === "product"){
  $stmt = $connection -> prepare("SELECT productimage.productImageId as imageid, productimage.imageName, productimage.imagePath FROM productimage WHERE productid = ? AND imageType = ?;");
}

$imageType = ucfirst(sanitizeText($_GET["imageType"]));
$type = sanitizeText($_GET["type"]);

$stmt->bind_param("is", $_GET["id"], $imageType);
$stmt->execute();
$result = $stmt->get_result();

while($row= $result->fetch_assoc()){
  array_push($imageArray , $row);
}

?>

<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>

<div class="container my-5">
  <div class = "w-75 mx-auto">
    <form action="./controller/delete_image_controller.php?id=<?php echo $_GET["id"];?>" class = "row g-3 justify-content-center" method="POST">
    <input type="hidden" name = "imageType" value = "<?php echo $imageType;?>">
      <input type="hidden" name = "type" value = "<?php echo $type;?>">
      <input type="hidden" name = "imagePath" value ="" id = "imagePathInput">
      <select class="form-select d-inline-block w-50" aria-label="Default select example" name = "imageid" id = "imageSelect"  onchange="getImagePath(this)" required>
        <?php foreach ($imageArray  as $image): ?>
        <option value="<?php echo $image["imageid"];?>" data-imagepath = "<?php echo $image["imagePath"];?>"><?php echo $image["imageName"];?></option>
        <?php endforeach; ?>
      </select>
      <button class = "btn btn-info w-25 ms-3" type = "submit" name = "deleteImage"  <?php  if (empty($imageArray))  echo "disabled"?>>Delete <?php echo $imageType;?> Image</button>
    </form>
  </div>

  <div class = "row my-5">
    <?php if (empty($imageArray)): ?>
    <p class = 'col-12 text-center lead'>This item has no images</p>
    <?php else: ?>
    <?php foreach ($imageArray  as $image): ?>
    <div class = "col mb-5 text-center">
      <div>
      <?php if(strtolower($imageType) === "gallery"):?>
        <img src="<?php echo $image["imagePath"];?>" alt="" class = "img-fluid shadow image-show" style ="width: 300px; height: 300px;"  onerror="this.alt='Image Not Found'">
        <?php else: ?>
          <img src="<?php echo $image["imagePath"];?>" alt="" class = "img-fluid shadow image-show" style ="width: 319px; height: 409px;" onerror="this.alt='Image Not Found'">
          <?php endif; ?>
      </div>
        <!-- <p class = "mt-5 text-center"><?php echo $image["imageName"];?></p> -->
        <!-- <div class = "mt-5 text-center"><?php echo $image["imageName"];?></div> -->
        <div class = "mt-5 text-center"><small ><?php echo $image["imageName"];?></small></div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>

  </div>
</div>

<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>

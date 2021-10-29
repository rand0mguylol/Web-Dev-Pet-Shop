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
<div class="main-wrapper profile mt-3 mb-5">
  <div class="container-fluid edit-item-container">
    <div class = "d-flex justify-content-between mt-5">
      <div class = " item-current-info">
        <h2 class = "mb-3">Current Info</h2>
      <?php foreach($itemArray as $key => $value): ?>
        <div>
            <p class="specific-item-property fw-bold"><?php echo ucfirst($key); ?> </p>
            <?php if($key === "description"): ?>
            <p><?php echo nl2br(str_replace('\n', "<br>", $itemArray['description'])); ?></p>
            <?php else: ?>
            <p><?php echo $value; ?></p>
            <?php endif; ?>
        </div>
      <?php endforeach; ?>
      </div>
      <div class = "">
      <h2 class = "mb-3">Edit Info</h2>
        <form class="row g-3 " id="register-form" action="./controller/edit_product_controller.php?type=<?php echo $_GET["type"]?>" method="POST">
          <?php if ($_GET["type"] === "pet"): ?>
              <div class="col-md-12">
                  <label for="inputFirstName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="inputFirstName" placeholder="Name" name="name" value = "<?php echo $itemArray["name"];?>">
              </div>
              <div class="col-md-12">
                  <label for="inputLastName" class="form-label">Price</label>
                  <input type="number" class="form-control" id="inputLastName" placeholder="Price" name="price" value = "<?php echo $itemArray["price"];?>">
              </div>
              <div class="col-md-6">
                  <label for="inputTelephone" class="form-label">Status</label>
                  <select class="form-select" aria-label="Default select example" name = "status">
                    <option value = "1" <?php if ($itemArray["status"] === 1)  echo "selected";?> >Available</option>
                    <option value="0" <?php if ($itemArray["status"] === 0)  echo "selected";?> >Not Available</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="inputEmail" class="form-label">Gender</label>
                  <select class="form-select" aria-label="Default select example" name = "gender">
                    <option value = "Male" <?php if (strtolower($itemArray["gender"] === "male"))  echo "selected";?> >Male</option>
                    <option value="Female" <?php if (strtolower($itemArray["gender"] === "female"))  echo "selected";?>>Female</option>
                  </select>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Birth Date</label>
                  <input type="date" class="form-control" id="inputEmail"  name="birthDate"  value = "<?php echo $itemArray['birthDate'];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Weight" name="weight" value = "<?php echo $itemArray["weight"];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Color</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Color" name="color" value = "<?php echo $itemArray["color"];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Pet Condition</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Pet Condition" name="petCondition"  value = "<?php echo $itemArray["petCondition"];?>"required>
              </div>
              <div class="col-md-6">
                  <label for="inputEmail" class="form-label">Vaccinated</label>
                  <select class="form-select" aria-label="Default select example" name = "vaccinated">
                    <option value = "Yes" <?php if (strtolower($itemArray["vaccinated"] === "yes"))  echo "selected";?>>Yes</option>
                    <option value="No" <?php if (strtolower($itemArray["vaccinated"] === "no"))  echo "selected";?>>No</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="inputEmail" class="form-label">Dewormed</label>
                  <select class="form-select" aria-label="Default select example" name = "dewormed">
                    <option value = "Yes"  <?php if (strtolower($itemArray["dewormed"] === "yes"))  echo "selected";?>>Yes</option>
                    <option value="No"  <?php if (strtolower($itemArray["dewormed"] === "no"))  echo "selected";?>>No</option>
                  </select>
            </div>

          <?php else: ?>
              <div class="col-md-12">
                  <label for="inputFirstName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="inputFirstName" placeholder="Name" name="name" value = "<?php echo $itemArray["name"];?>">
              </div>
              <div class="col-md-12">
                  <label for="inputLastName" class="form-label">Price</label>
                  <input type="number" class="form-control" id="inputLastName" placeholder="Price" name="price" value = "<?php echo $itemArray["price"];?>">
              </div>
              <div class="col-md-12">
                  <label for="inputLastName" class="form-label">Quantity</label>
                  <input type="number" class="form-control" id="inputLastName" placeholder="Quantity" name="quantity" value = "<?php echo $itemArray["quantity"];?>">
              </div>
              <div class="col-md-6">
                  <label for="inputTelephone" class="form-label">Status</label>
                  <select class="form-select" aria-label="Default select example">
                    <option value = "1" <?php if ($itemArray["status"] === 1)  echo "selected";?> >Available</option>
                    <option value="0" <?php if ($itemArray["status"] === 0)  echo "selected";?> >Not Available</option>
                  </select>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Description</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="25" name = "description"><?php echo  htmlspecialchars(str_replace('\n', "\n", $itemArray["description"]))?></textarea>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Brand</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Brand" name="brand"  value = "<?php echo $itemArray["brand"];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Weight</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Weight" name="weight" value = "<?php echo $itemArray["weight"];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Warranty Period</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Warranty Period" name="warrantyPeriod" value = "<?php echo $itemArray["warrantyPeriod"];?>" required>
              </div>
              <div class="col-md-12">
                  <label for="inputEmail" class="form-label">Product Dimensions</label>
                  <input type="text" class="form-control" id="inputEmail" placeholder="Product Dimensions" name="productDimensions"  value = "<?php echo $itemArray["productDimensions"];?>"required>
              </div>
          <?php endif; ?>
            <button class = "btn btn-primary" type = "submit" name = "updateItem">Update Item</button>
          </form>
      </div>
    </div>

  </div>
</div>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/profile.js"></script>
<script src="./js/aos.js"></script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>
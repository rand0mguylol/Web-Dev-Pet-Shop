<?php 
session_start();
$title = "Admin Panel - Edit Product";
require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (!isset($_SESSION["user"]["userRole"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ./index.php");
  exit();
}


if(isset($_SESSION["addProductError"])){
  $errorArray= $_SESSION["addProductError"];
  unset($_SESSION["addProductError"]);
}


?>
<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>


<?php if(isset($errorArray)): ?>
<div class="modal fade" id="editProductModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Error</h5>
            </div>
            <div class="modal-body">
            <?php foreach($errorArray as $err): ?>
            <p><?php echo $err;?></p>
            <?php endforeach; ?>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary closeEditProductModal"  data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container my-5 px-5">
  <h1 class = "text-center mb-5">Add Product</h1>
  <form action="./controller/add_product_controller.php" class = "row g-3" method="POST">
    <div class="col-md-12">
        <label for="inputFirstName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputFirstName" placeholder="Name" name="name" >
    </div>
    <div class="col-md-12">
        <label for="inputLastName" class="form-label">Price</label>
        <input type="number" step = ".01" class="form-control" id="inputLastName" placeholder="Price" name="price" >
    </div>
    <div class="col-md-12">
        <label for="inputLastName" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="inputLastName" placeholder="Quantity" name="quantity" >
    </div>
    <div class="col-md-6">
        <label for="inputTelephone" class="form-label">Status</label>
        <select class="form-select" aria-label="Default select example" name = "status">
          <option value = "1" selected >Available</option>
          <option value="0" >Not Available</option>
        </select>
    </div>
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Description</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="25" name = "description"></textarea>
    </div>
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Brand</label>
        <input type="text" class="form-control" id="inputEmail" placeholder="Brand" name="brand"  required>
    </div>
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Weight</label>
        <input type="text" class="form-control" id="inputEmail" placeholder="Weight" name="weight" required>
    </div>
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Warranty Period</label>
        <input type="text" class="form-control" id="inputEmail" placeholder="Warranty Period" name="warrantyPeriod" required>
    </div>
    <div class="col-md-12">
        <label for="inputEmail" class="form-label">Product Dimensions</label>
        <input type="text" class="form-control" id="inputEmail" placeholder="Product Dimensions" name="productDimensions" required>
    </div>
    <div class="col-md-6">
      <label for="" class="form-label">Category</label>
      <select class="form-select" aria-label="Default select example" name = "category">
        <option value = "1" selected>Dog Food</option>
        <option value = "2">Dog Accessories</option>
        <option value = "3">Dog Care Products</option>
        <option value="4" >Cat Food</option>
        <option value="5" >Cat Accessories</option>
        <option value="6" >Cat Care Products</option>
        <option value="7">Hamster Food</option>
      </select>
    </div>
    <button class = "btn btn-primary" type = "submit" name = "addProduct">Add Product</button>
  </form>
</div>

<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script src = "./js/admin_modal.js"></script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>
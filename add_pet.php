<?php 
session_start();
$title = "Admin Panel - Edit Product";
require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (!isset($_SESSION["user"]["userRole"]) && $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ./index.php");
  exit();
}

if(isset($_SESSION["addPetMessage"])){
  $alertMessage = $_SESSION["addPetMessage"];
  unset($_SESSION["addPetMessage"]);
}

if(isset($_SESSION["addPetError"])){
  $errorArray= $_SESSION["addPetError"];
  unset($_SESSION["addPetError"]);
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

<?php if(isset($errorArray)): ?>
<div class="modal fade" id="editProductModal"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Failed</h5>
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
  <h1 class = "text-center mb-5">Add Pet</h1>
  <form action="./controller/add_pet_controller.php" class = "row g-3" method="POST">
    <div class="col-md-12">
        <label for="inputFirstName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputFirstName" placeholder="Name" name="name" >
      </div>
    <div class="col-md-12">
        <label for="inputLastName" class="form-label">Price</label>
        <input type="number" class="form-control" id="inputLastName" placeholder="Price" name="price" >
    </div>
    <div class="col-md-6">
      <label for="inputTelephone" class="form-label">Status</label>
      <select class="form-select" aria-label="Default select example" name = "status">
        <option value = "1" selected>Available</option>
        <option value="0"  >Not Available</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Gender</label>
      <select class="form-select" aria-label="Default select example" name = "gender">
        <option value = "Male" sekected >Male</option>
        <option value="Female" >Female</option>
      </select>
    </div>
    <div class="col-md-12">
      <label for="birthDate" class="form-label">Birth Date</label>
      <input type="date" class="form-control" id="birthDate"  name="birthDate"  required>
    </div>
    <div class="col-md-12">
      <label for="weight" class="form-label">Weight</label>
      <input type="text" class="form-control" id="weight" placeholder="Weight" name="weight"required>
    </div>
    <div class="col-md-12">
      <label for="color" class="form-label">Color</label>
      <input type="text" class="form-control" id="color" placeholder="Color" name="color"  required>
    </div>
    <div class="col-md-12">
      <label for="petCondition" class="form-label">Pet Condition</label>
      <input type="text" class="form-control" id="petCondition" placeholder="Pet Condition" name="petCondition" required>
    </div>
    <div class="col-md-6">
      <label for="" class="form-label">Vaccinated</label>
      <select class="form-select" aria-label="Default select example" name = "vaccinated">
        <option value = "Yes" selected>Yes</option>
        <option value="No">No</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="" class="form-label">Dewormed</label>
      <select class="form-select" aria-label="Default select example" name = "dewormed">
        <option value = "Yes"  selected>Yes</option>
        <option value="No">No</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="" class="form-label">Category</label>
      <select class="form-select" aria-label="Default select example" name = "category">
        <option value = "1" selected>Dog</option>
        <option value="2" >Cat</option>
        <option value="3">Hamster</option>
      </select>
    </div>
    <button class = "btn btn-primary" type = "submit" name = "addPet">Add Pet</button>
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
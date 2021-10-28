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
  <div class="container">
    <h1>EDIT ITEM</h1>
    <?php if ($_GET["type"] === "pet"): ?>
      <form class="row g-3 " id="register-form" action="./controller/register_user.php" method="POST">
        <div class="col-md-12">
            <label for="inputFirstName" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name="firstName" value = "<?php echo $itemArray["name"];?>">
        </div>
        <div class="col-md-12">
            <label for="inputLastName" class="form-label">Price</label>
            <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name="lastName" value = "<?php echo $itemArray["price"];?>">
        </div>
        <div class="col-md-6">
            <label for="inputTelephone" class="form-label">Status</label>
            <select class="form-select" aria-label="Default select example">
              <option value = "1" <?php if ($itemArray["status"] === 1)  echo "selected";?> >Available</option>
              <option value="0" <?php if ($itemArray["status"] === 0)  echo "selected";?> >Not Available</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputEmail" class="form-label">Gender</label>
            <select class="form-select" aria-label="Default select example">
              <option value = "Male" <?php if (strtolower($itemArray["gender"] === "male"))  echo "selected";?> >Male</option>
              <option value="Female" <?php if (strtolower($itemArray["gender"] === "female"))  echo "selected";?>>Female</option>
            </select>        
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label">Birth Date</label>
            <input type="text" class="form-control" id="inputEmail" placeholder="Email Address" name="email"  required>
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label">Weight</label>
            <input type="text" class="form-control" id="inputEmail" placeholder="Email Address" name="email" value = "<?php echo $itemArray["weight"];?>" required>
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label">Color</label>
            <input type="text" class="form-control" id="inputEmail" placeholder="Email Address" name="email" value = "<?php echo $itemArray["color"];?>" required>
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label">Pet Condition</label>
            <input type="text" class="form-control" id="inputEmail" placeholder="Email Address" name="email"  value = "<?php echo $itemArray["petCondition"];?>"required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail" class="form-label">Vaccinated</label>
            <select class="form-select" aria-label="Default select example">
              <option value = "Yes" <?php if (strtolower($itemArray["vaccinated"] === "yes"))  echo "selected";?>>Yes</option>
              <option value="No" <?php if (strtolower($itemArray["vaccinated"] === "no"))  echo "selected";?>>No</option>
            </select>           
        </div>
        <div class="col-md-6">
            <label for="inputEmail" class="form-label">Dewormed</label>
            <select class="form-select" aria-label="Default select example">
              <option value = "Yes"  <?php if (strtolower($itemArray["dewormed"] === "yes"))  echo "selected";?>>Yes</option>
              <option value="No"  <?php if (strtolower($itemArray["dewormed"] === "no"))  echo "selected";?>>No</option>
            </select>           
      </div>
      <button class = "btn btn-primary" type = "submit">Update Item</button>
    </form>
    <?php endif; ?>
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
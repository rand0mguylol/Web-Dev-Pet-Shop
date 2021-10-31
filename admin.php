<?php session_start(); 
$title = "Admin Panel";

require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (isset($_SESSION["user"]["userRole"]) && $_SESSION["user"]["userRole"] === "STAFF") {


    if (isset($_GET["searchItem"]) && $_GET["q"] !== "") {
        $q = sanitizeText($_GET["q"]);
        $adminSearchArray = getAdminSearch($connection, $_GET["itemType"], $q);   
    } 

}

else {
    header("Location: ./index.php");
    exit();
}

?>

<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>


<div class="container-fluid  admin-search-container mt-5">
  <div class="search-container mx-auto">
    <form action="" class=" " method="GET">
      <div class = "d-flex d-inline justify-content-between search-form">
        <input type="text" class="form-control search-bar d-inline q" id="inputFirstName" placeholder="Search for Item" name="q" value="<?php if (isset($q)) echo $q ?>">
        <!-- <input type="hidden" value="<?php echo $category; ?>" name="category"> -->
        <button class="btn search text-end" name="searchItem"><img src="./svg/search (1).svg" alt=""></button>
      </div>   
      <div class="form-check mt-3">
        <input class="form-check-input" type="radio" name="itemType" value = "pet" id="itemTypePet" checked>
        <label class="form-check-label" for="itemTypePet">
          Pet
        </label>
      </div>
      <div class="form-check mt-3">
        <input class="form-check-input" type="radio" name="itemType" value = "product" id="itemTypeProduct" >
        <label class="form-check-label" for="itemTypeProduct">
          Product
        </label>
      </div>  
    </form>
  </div>

  <div class ="my-5 text-center">
      <a href="" class = "btn btn-primary me-5">Add Pet</a>
      <a href="" class = "btn btn-info">Add Product</a>
  </div>

  <div>
      <?php if (isset($adminSearchArray, $_GET["q"]) && empty($adminSearchArray)) : ?>
          <p class='text-center lead'> There are no products that match your search</p>
      <?php elseif (isset($adminSearchArray)) : ?>
          <table class="table table-striped">
              <thead>
              <tr>
                  <th scope="col" colspan="5"><?php echo ucfirst( $_GET["itemType"]); ?></th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($adminSearchArray as $item) : ?>
              <tr>
                  <td><?php echo $item["name"]?></td>
                  <td><a href="./edit_product.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>" class = "text-decoration-none">Edit</a></td>
                  <td>Delete</td>
                  <td>Add Image</td>
                  <td>Delete Image</td>
              </tr>
              <?php endforeach; ?>
              </tbody>
          </table>
      <?php endif; ?>
  </div>
</div>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script>
    const searchButton = document.querySelector(".q")
    console.dir(searchButton)
</script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>

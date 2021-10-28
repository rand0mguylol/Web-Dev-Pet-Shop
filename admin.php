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
<div class="main-wrapper profile">
    <div class="container border border-dark profile-container my-5  d-flex align-items-stretch">
        <div class="row align-items-stretch">
            <div class="col-3 px-0  pb-5 nav-tab-container d-flex flex-column justify-content-center">
                <div>
                   
                    <div class="nav nav-tabs profile-tab flex-column" id="nav-tab" role="tablist">
                        <button class=" nav-link active" id="nav-add-product-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-add-product" type="button" role="tab" aria-controls="nav-add-product"
                            aria-selected="true">Add Item</button>
                        <button class=" nav-link" id="nav-edit-product-tab" data-bs-toggle="tab" data-bs-target="#nav-edit-product"
                            type="button" role="tab" aria-controls="nav-edit-product" aria-selected="false">Edit
                            Item</button>
                        <button class=" nav-link" id="nav-delete-product-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-delete-product" type="button" role="tab" aria-controls="nav-delete-product"
                            aria-selected="false">Delete Item</button>
                        <button class=" nav-link" id="nav-add-image-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-add-image" type="button" role="tab" aria-controls="nav-add-image"
                            aria-selected="false">Add Item Image</button>
                        <button class=" nav-link" id="nav-delete-image-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-delete-image" type="button" role="tab" aria-controls="nav-delete-image"
                            aria-selected="false">Delete Item Image</button>
                    </div>
                </div>
            </div>
            <div class="col-9 ">
                <div class="tab-content mt-3" id="nav-tabContent">
                    <!-- Add Porduct Tab  -->
                    <div class="tab-pane fade mx-auto " id="nav-add-product" role="tabpanel"
                        aria-labelledby="nav-add-product-tab">
                        <h1>Add</h1>
                    </div>
                    <!-- End of Add Product Tab -->

                    <!-- Edit Product Tab -->
                    <div class="tab-pane fade show active" id="nav-edit-product" role="tabpanel" aria-labelledby="nav-edit-product-tab">
                      <div class="search-container mx-auto">
                          <form action="" class=" " method="GET">
                              <div class = "d-flex d-inline justify-content-between search-form">
                                <input type="text" class="form-control search-bar d-inline" id="inputFirstName" placeholder="Search for Item" name="q" value="<?php if (isset($q)) echo $q ?>">
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

                      <div class=" mt-5 d-flex flex-wrap">
                          <?php if (isset($adminSearchArray, $_GET["q"]) && empty($adminSearchArray)) : ?>
                              <p class='text-center lead'> There are no products that match your search</p>
                          <?php elseif (isset($adminSearchArray)) : ?>
                                <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th scope="col"><?php echo ucfirst( $_GET["itemType"]); ?></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach ($adminSearchArray as $item) : ?>
                                    <tr>
                                      <td><a href="./edit_product.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>" class = "text-decoration-none text-dark"><?php echo $item["name"]?></a></td>
                                    </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                </table>
                          <?php endif; ?>
                      </div>
                    </div>
                    <!-- End of Edit Product Tab -->

                    <!-- Delete Product Tab -->
                    <div class="tab-pane fade" id="nav-delete-product" role="tabpanel" aria-labelledby="nav-delete-product-tab">
                        <h1>r</h1>
                    </div>
                    <!--  End of delete product tab-->
                    <div class="tab-pane fade" id="nav-add-image" role="tabpanel" aria-labelledby="nav-add-image-tab">
                        <h1>r1</h1>
                    </div>
                    <div class="tab-pane fade" id="nav-delete-image" role="tabpanel" aria-labelledby="nav-delete-image-tab">
                        <h1>r2</h1>
                    </div>
                </div>
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
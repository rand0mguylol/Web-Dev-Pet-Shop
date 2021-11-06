<?php session_start(); 
$title = "Admin Panel";

require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (isset($_SESSION["user"]["userRole"]) && $_SESSION["user"]["userRole"] === "STAFF") {


    if (isset($_GET["searchItem"]) && $_GET["q"] !== "") {
        $q = sanitizeText($_GET["q"]);
        $adminSearchArray = getAdminSearch($connection, $_GET["itemType"], $q);   
    } 

    // if(isset($_SESSION["alertMessage"])){
    //   $alertMessage = $_SESSION["alertMessage"];
    //   unset($_SESSION["alertMessage"]);
    // }

    // echo "<pre>";
    // var_dump($adminSearchArray);
    // echo "</pre>";
}

else {
    header("Location: ./index.php");
    exit();
}

?>

<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>

<!-- <?php if (isset($alertMessage)) : ?>
    <div data-aos="fade-down" class="text-center alert alert-success alert-dismissible fade show position-fixed mx-auto login-alert" role="alert">
        <strong><?php echo $alertMessage; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?> -->

<!-- Delete Modal for Item -->
<div class="modal fade" id="deleteItemModal"  tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p id = "deleteItemBody"></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            <form action="./controller/delete_item_controller.php" method="POST">
              <input type="hidden" name = "type" value = "" id = "deleteItemTypeInput">
              <input type="hidden" name = "id" id = "deleteItemIDInput" value = "">
              <button type="submit" class="btn btn-danger" name = "deleteItem">Yes, delete it</button>
            </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addItemModal"  tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <p id = "addItemBody"></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            <form action="./controller/add_item_controller.php" method="POST">
              <input type="hidden" name = "type" value = "" id = "addItemTypeInput">
              <input type="hidden" name = "id" id = "addItemIDInput" value = "">
              <button type="submit" class="btn btn-danger" name = "addItem">Yes, add it</button>
            </form>
            </div>
        </div>
    </div>
</div>

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
      <a href="./add_pet.php" class = "btn btn-primary me-5">Add Pet</a>
      <a href="./add_product.php" class = "btn btn-info">Add Product</a>
  </div>

  <div>
      <?php if (isset($adminSearchArray, $_GET["q"]) && empty($adminSearchArray)) : ?>
          <p class='text-center lead'> There are no products that match your search</p>
      <?php elseif (isset($adminSearchArray)) : ?>
          <table class="table table-striped">
              <thead>
              <tr>
                  <th scope="col" colspan="7"><?php echo ucfirst( $_GET["itemType"]); ?></th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($adminSearchArray as $item) : ?>
              <tr>
                  <td><?php echo $item["name"]?></td>
                  <td><a href="./edit_item.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>" class = "text-decoration-none">Edit</a></td>
                  <?php if($item["status"] === 1): ?>
                  <td><button type="button" class="btn btn-danger deleteItemBtn" data-bs-toggle="modal" data-bs-target="#deleteItemModal" data-type = "<?php echo $_GET["itemType"];?>" data-id = "<?php echo $item["id"];?>"  data-name = "<?php echo $item["name"];?>">Remove</button></td>
                  <?php else: ?>
                  <td><button type="button" class="btn btn-danger addItemBtn" data-bs-toggle="modal" data-bs-target="#addItemModal" data-type = "<?php echo $_GET["itemType"];?>" data-id = "<?php echo $item["id"];?>"  data-name = "<?php echo $item["name"];?>">Add</button></td>
                  <?php endif; ?>
                  <td><a href="./add_card_image.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>&category=<?php echo $item["category"];?>&name=<?php echo $item["name"];?>" class = "text-decoration-none">Add Card Image</a></td>
                  <td><a href="./add_gallery_image.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>&category=<?php echo $item["category"];?>&name=<?php echo $item["name"];?>" class = "text-decoration-none">Add Gallery Image</a></td>
                  <td><a href="./delete_image.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>&imageType=Card" class="btn btn-info">Delete Card Image</a></td>
                  <td><a href="./delete_image.php?id=<?php echo $item["id"];?>&type=<?php echo $_GET["itemType"]?>&imageType=Gallery" class="btn btn-success">Delete Gallery Image</a></td>
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
    // console.dir(searchButton)

    const deleteItemBtn = document.querySelectorAll(".deleteItemBtn")
    const deleteItemIDInput = document.querySelector("#deleteItemIDInput")
    const deleteItemTypeInput = document.querySelector("#deleteItemTypeInput")
    const deleteItemBody = document.querySelector("#deleteItemBody")
    // const deleteCardImg = document.querySelector("#deleteCardImg")

    for(const btn of deleteItemBtn){
      btn.addEventListener("click", function(){
        deleteItemTypeInput.value = this.dataset.type
        deleteItemIDInput.value = this.dataset.id
        deleteItemBody.innerHTML = this.dataset.name
        // deleteCardImg.src = this.dataset.image
      })
    }

    const addItemBtn = document.querySelectorAll(".addItemBtn")
    const addItemIDInput = document.querySelector("#addItemIDInput")
    const addItemTypeInput = document.querySelector("#addItemTypeInput")
    const addItemBody = document.querySelector("#addItemBody")
    // const deleteCardImg = document.querySelector("#deleteCardImg")

    for(const btn of addItemBtn){
      btn.addEventListener("click", function(){
        addItemTypeInput.value = this.dataset.type
        addItemIDInput.value = this.dataset.id
        addItemBody.innerHTML = this.dataset.name
        // deleteCardImg.src = this.dataset.image
      })
    }

</script>
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>

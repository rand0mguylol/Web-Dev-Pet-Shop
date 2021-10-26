<?php session_start(); 
  require_once "./function/helpers.php";
  require_once "./function/db.php";

  $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");

  // Return to index if not login
  if(!isset($_SESSION["user"]["userID"])){
    header("Location: index.php");
    exit();
  }
  
  if(isset($_SESSION["passwordChangeMsg"])){
    $profileUpdateMsg= $_SESSION["passwordChangeMsg"];
    unset($_SESSION["passwordChangeMsg"]);
  }

  if(isset($_SESSION["profileUpdateMessage"])){
    $profileUpdateMsg= $_SESSION["profileUpdateMessage"];
    unset($_SESSION["profileUpdateMessage"]);
  }

  if(isset($_SESSION["profileUpdateError"])){
    $profileErrorArray = $_SESSION["profileUpdateError"];
    unset($_SESSION["profileUpdateError"]);
  }

  if(isset($_SESSION["uploadImageMessage"])){
    $profileUpdateMsg = $_SESSION["uploadImageMessage"];
    unset($_SESSION["uploadImageMessage"]);
  }

  // Order History
  $userid = $_SESSION['user']['userID'] ?? null;
  if (isset($userid)) {
    $orderId = getOrderId($userid, $connection);  
}

?>

<?php require_once "header.php"; ?>
<div class="main-wrapper profile">

<?php require_once "navbar.php"; ?>

<!-- 
  <div class="container mt-5">
    <p class = "lead"><?php if(isset($profileUpdateMsg)) echo $profileUpdateMsg; ?></p>
  </div> -->


  <div class="container border border-dark profile-container my-5  d-flex align-items-stretch">
    <div class = "row align-items-stretch">
      <div class="col-3 px-0  pb-5 nav-tab-container d-flex flex-column justify-content-center">
        <div>
          <div class = "text-center mb-5">
            <img src="<?php echo  $_SESSION["user"]["userPicture"] ?>" alt="" class = "img-fluid shadow rounded-circle userProfilePicture" >
          </div>
            <div class="nav nav-tabs profile-tab flex-column" id="nav-tab" role="tablist">
              <button class=" nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
              <button class=" nav-link" id="nav-pic-tab" data-bs-toggle="tab" data-bs-target="#nav-pic" type="button" role="tab" aria-controls="nav-pic" aria-selected="false">Profile Picture</button>
              <button class=" nav-link" id="nav-privacy-tab" data-bs-toggle="tab" data-bs-target="#nav-privacy" type="button" role="tab" aria-controls="nav-privacy" aria-selected="false">Privacy</button>
              <button class=" nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="false">Order</button>
            </div>
        </div>
      </div>
      <div class="col-9 my-auto">  
        <div class="tab-content mt-3" id="nav-tabContent">
          <!-- Profile Tab  -->
          <div class="tab-pane fade show active mx-auto" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form action="./controller/update_profile.php" class = "row g-3 justify-content-center" id = "profile-form" method="POST">
              <div class="col-md-12">
                <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name = "firstName"  value = "<?php echo $_SESSION["user"]["firstName"];?>">        
              </div>
              <div class="col-md-12">
                <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name = "lastName" value = "<?php echo $_SESSION["user"]["lastName"];?>">              
              </div>
              <div class="col-md-12">
                <div class="input-group">
                  <div class="input-group-text">+60</div>
                  <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789" name = "mobileNumber" value = "<?php echo $_SESSION["user"]["mobileNumber"];?>">             

                </div>
            </div>
            <div class="col-9 my-auto">
                <div class="tab-content mt-3" id="nav-tabContent">
                    <!-- Profile Tab  -->
                    <div class="tab-pane fade mx-auto" id="nav-profile" role="tabpanel"
                        aria-labelledby="nav-profile-tab">
                        <form action="./controller/update_profile.php" class="row g-3 justify-content-center"
                            id="profile-form" method="POST">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputFirstName" placeholder="First Name"
                                    name="firstName" value="<?php echo $_SESSION["user"]["firstName"];?>">
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputLastName" placeholder="Last Name"
                                    name="lastName" value="<?php echo $_SESSION["user"]["lastName"];?>">
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-text">+60</div>
                                    <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789"
                                        name="mobileNumber" value="<?php echo $_SESSION["user"]["mobileNumber"];?>">
                                </div>
                                <?php if(isset($profileErrorArray) && in_array("mobileNumber", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0 d-block">Please enter a valid mobile number</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputAddressLine" placeholder="Address Line"
                                    name="addressLine" value="<?php echo $_SESSION["user"]["addressLine"];?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="inputPostcode" placeholder="Postcode"
                                    name="postcode"
                                    value="<?php echo isset($_SESSION["user"]["postcode"]) &&  ($_SESSION["user"]["postcode"]) !== 0 ? $_SESSION["user"]["postcode"]:"";?>">
                                <?php if(isset($profileErrorArray) && in_array("postcode", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0 d-block">Please enter a valid postcode</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputCity" placeholder="City" name="city"
                                    value="<?php echo  $_SESSION["user"]["city"];?>">
                            </div>
                            <div class="col-md-12">
                                <select id="inputState" class="form-select" name="state">
                                    <?php if(!$_SESSION["user"]["userState"]): ?>
                                    <option selected value="">Select State</option>
                                    <?php endif; ?>
                                    <?php foreach($statesArray as $s): ?>
                                    <option value="<?php echo $s;?>"
                                        <?php if ($_SESSION["user"]["state"] === $s) echo "selected";?>><?php echo $s;?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($profileErrorArray) && in_array("state", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0">Please select a valid state</p>
                                <?php endif; ?>
                            </div>

                            <div class="col-12 text-center"><button type="submit"
                                    class="btn offcanvas-save-profile rounded-pill mt-5 px-5"
                                    name="saveProfile">Save</button></div>
                        </form>
                    </div>
                    <!-- End of Profile Tab -->

                    <!-- Picture Tab -->
                    <div class="tab-pane fade" id="nav-pic" role="tabpanel" aria-labelledby="nav-pic-tab">
                        <div class="outer-crop-wrapper text-center">
                            <div class="box mx-auto">
                                <img src="" alt="" id="cropBox" style="display: block; max-width: 100%;">
                            </div>
                            <small class="imageExtensionMessage">Only jpg, png and jpeg are accepted</small>
                        </div>

                        <div class="mt-5">
                            <form action="./controller/change_Profile_Pic.php" class="imageForm" method="POST">
                                <input type="hidden" name="uploadPic" value="">
                                <input type="file" class="fileInput" accept="image/png, image/jpg, image/jpeg">
                                <button type="reset" class="btn btn-dark fileInputResetBtn">Reset</button>
                                <button class="hidden uploadPicBtn btn" type="button">Upload</button>
                            </form>

                            <form action="./controller/change_Profile_Pic.php" class="" method="POST">
                                <button class="hidden btn btn-danger removePicBtn" type="submit"
                                    name="removeProfilePic">Remove Current Pic</button>
                            </form>
                        </div>
                    </div>

                    <!-- End of Picture Tab -->

                    <!-- Privacy Tab -->
                    <div class="tab-pane fade" id="nav-privacy" role="tabpanel" aria-labelledby="nav-privacy-tab">
                        <form action="./controller/change_Password.php" class="row g-3 justify-content-center"
                            id="password-form" method="POST">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Old Password"
                                    name="oldPassword">
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="New Password"
                                    name="newPassword">
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                    name="confirmPassword">
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn offcanvas-save-profile rounded-pill mt-5 px-5"
                                    name="changePass">Change Password</button>
                            </div>
                        </form>
                    </div>

                    <!--  End of privacy tab-->

                    <!-- Order Tab -->
                    <div class="tab-pane fade show active" id="nav-order" role="tabpanel"
                        aria-labelledby="nav-order-tab">
                        <div class="container">
                            <?php if (empty($orderId)) : ?>
                            <h2>No previous orders.</h2>
                            <?php else:?>
                            <?php foreach ($orderId as $order):
                            $total = getOrderTotal($order, $connection);
                            $orderItems = getOrderItems($order, $connection);?>
                            <div class="card mb-3 border rounded">
                                <?php foreach ($orderItems as $item):?>
                                <div class="card border-0 bg-transparent">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="<?php echo "$item[image].jpg";?>" alt="Item Image"
                                                    class="img-responsive img-thumbnail">
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <p><?php echo $item["name"];?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="text-end"><?php echo "x$item[quantity]";?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="text-end"><?php echo "RM$item[subtotal]";?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <div class="card-footer">
                                    <p class="text-end">
                                        OrderID: <?php echo $order;?><br>
                                        Order Total: RM<?php echo $total;?>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach;?>
                            <?php endif;?>
                        </div>
                    </div>

                    <!-- End of order tab -->
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"
    integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const image = document.querySelector("#cropBox")

const fileInput = document.querySelector(".fileInput")
const uploadPicBtn = document.querySelector(".uploadPicBtn")
const resetImageBtn = document.querySelector(".fileInputResetBtn")
const removePicBtn = document.querySelector(".removePicBtn")
const imageForm = document.querySelector(".imageForm")
const outerCropWrapper = document.querySelector(".outer-crop-wrapper")
const userProfilePicture = document.querySelector(".userProfilePicture")

console.dir(
    userProfilePicture
)

console.log(typeof(userProfilePicture.src))

if (userProfilePicture.src !== userProfilePicture.baseURI && userProfilePicture.src.includes(
        "/svg/profile-pic-default.svg") === false) {
    removePicBtn.classList.remove("hidden")
}

// imageForm.addEventListener("submit", function(e){
//   e.preventDefault()
// })

const imageCrop = new Cropper(image, {
    aspectRatio: 1,
    viewMode: 2,

    preview: ".preview",

    minCropBoxWidth: 550,
    minCropBoxHeight: 550,

    minContainerHeight: 550,
    minContainerWidth: 550,

    minCanvasWidth: 550,
    minCanvasHeight: 550
})


resetImageBtn.addEventListener("click", function() {
    uploadPicBtn.classList.add("hidden")
    imageCrop.destroy()

})

fileInput.addEventListener("change", function(e) {
    const imageCrop = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 2,

        preview: ".preview",

        minCropBoxWidth: 550,
        minCropBoxHeight: 550,

        minContainerHeight: 550,
        minContainerWidth: 550,

        minCanvasWidth: 550,
        minCanvasHeight: 550
    })
    const result = getImageURL(this)

    if (e.target.value) {
        uploadPicBtn.classList.remove("hidden")
    }
})

const inputImageErrorMessage = document.createElement("small")
inputImageErrorMessage.innerHTML = "Only images are allowed"
inputImageErrorMessage.classList.add("d-block")

uploadPicBtn.addEventListener("click", function() {
    const cropImage = imageCrop.getCroppedCanvas({
        width: 200,
        height: 200,
        fillColor: '#fff',
        imageSmoothingEnabled: false,
        imageSmoothingQuality: 'low',
    })

    if (!cropImage) {

        if (outerCropWrapper.contains(inputImageErrorMessage) === false) {
            outerCropWrapper.appendChild(inputImageErrorMessage)
        }

    } else {
        const finalImage = cropImage.toDataURL();
        const inputWithImageData = document.createElement("input")
        inputWithImageData.type = "text"
        inputWithImageData.name = "newProfilePic"
        inputWithImageData.setAttribute("value", finalImage)
        imageForm.appendChild(inputWithImageData)
        imageForm.submit()
    }
})

// resetImageBtn.addEventListener("click", function(){
// })

function getImageURL(input) {
    const reader = new FileReader()

    reader.addEventListener("load", function(e) {
        imageCrop.replace(e.target.result)
    })

    if (input) {
        reader.readAsDataURL(input.files[0])
    }
}
</script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(
      {
        offset: 300
      }
    )
    </script>
<?php require_once "script_links.php"; ?>
<?php session_start(); 
$title = "Admin Panel";

require_once "./helper/helpers.php";
require_once "./connection/db.php";

if (!isset($_SESSION["user"]["userRole"], $_GET["name"], $_GET["type"], $_GET["id"], $_GET["category"]) || $_SESSION["user"]["userRole"] !== "STAFF") {
  header("Location: ./index.php");
  exit();
}

$name = $_GET["name"];

if(isset($_SESSION["uploadImageMessage"])){
  $alertMessage = $_SESSION["uploadImageMessage"];
  unset($_SESSION["uploadImageMessage"]);
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

<div class="container my-5 px-5">
    <h1 class = "text-center mt-5">Add Gallery Image</h1>
    <h2 class = "text-center my-3"><?php echo $name; ?></h2>
    <!-- <p class = "text-center lead">If the item has an existing card image, it will be overwritten</p> -->

    <div class="outer-crop-wrapper text-center">
        <div class="box mx-auto">
            <img src="" alt="" id="cropBox" style="display: block; max-width: 100%;">
        </div>
        <small class="imageExtensionMessage">Only jpg, png and jpeg are accepted</small>
    </div>

    <div class="mt-5 text-center">
        <form action="./controller/add_gallery_image_controller.php?id=<?php echo $_GET["id"];?>&category=<?php echo $_GET["category"];?>&type=<?php echo $_GET["type"];?>&name=<?php echo $_GET["name"];?>" class="imageForm" method="POST">
            <input type="hidden" name="addGalleryImage" value="">
            <input type="file" class="fileInput" accept="image/png, image/jpg, image/jpeg">
            <button type="reset" class="btn btn-dark fileInputResetBtn">Reset</button>
            <button class="hidden uploadPicBtn btn" type="button">Upload</button>
        </form>

        <!-- <form action="./controller/change_Profile_Pic.php" class="" method="POST">
            <button class="hidden btn btn-danger removePicBtn" type="submit" name="removeProfilePic">Remove Current Pic</button>
        </form> -->
    </div>
</div>


<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script>
  const image = document.querySelector("#cropBox")

const fileInput = document.querySelector(".fileInput")
const uploadPicBtn = document.querySelector(".uploadPicBtn")
const resetImageBtn = document.querySelector(".fileInputResetBtn")
// const removePicBtn = document.querySelector(".removePicBtn")
const imageForm = document.querySelector(".imageForm")
const outerCropWrapper = document.querySelector(".outer-crop-wrapper")
// const userProfilePicture = document.querySelector(".userProfilePicture")

// console.dir(
//     userProfilePicture
// )

// console.log(typeof(userProfilePicture.src))

// if (userProfilePicture.src !== userProfilePicture.baseURI && userProfilePicture.src.includes(
//         "/svg/profile-pic-default.svg") === false) {
//     removePicBtn.classList.remove("hidden")
// }

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
        width: 550,
        height: 550,
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
        inputWithImageData.name = "galleryImage"
        inputWithImageData.setAttribute("value", finalImage)
        imageForm.appendChild(inputWithImageData)
        imageForm.submit()
    }
})

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
<!-- For Rating System -->
<script src="./js/rating.js"></script>
<?php require_once "./components/footer.php"; ?>
</body>

</html>

<?php
session_start();
require_once "./connection/db.php";
require_once "./helper/helpers.php";
$petArray  = ["Dog", "Cat", "Hamster"];
if (isset($_GET["category"], $_GET["id"])) {
    $category = sanitizeText($_GET["category"]);
    $categoryClean = filter_var($category, FILTER_SANITIZE_STRING);
    $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $id = (int) $id;
    $itemInfo = getItemInfo($id, $categoryClean, $connection);
    $itemGalleryArray = getImage($id,  $categoryClean, "Gallery", false, $connection);
    $itemThumbnailArray = getImage($id, $categoryClean, "Thumbnail", false, $connection);
    $quantity = $itemInfo['itemSubInfo']['quantity'] ?? 1;
    $others = getCategoryOther($connection, $categoryClean, $id);
    $productReviewsArray = getProductReviews($id, $categoryClean, $connection);
    $totalReviews = getTotalProductReviews($id, $categoryClean, $connection);
    $eachRatingTotal = getEachRatingTotal($id, $categoryClean, $connection);
    $itemType = returnType($categoryClean);
    if ($itemType == "product")
    {
        $avgRating = getAvgRating($id, $connection);
    }
} else {
    header("Location: index.php");
    exit();
}
if (isset($_POST['add-to-cart-btn'])) {
    $itemID = $id;
    $itemQuantity = (int) $_POST['item_quantity'];
    $itemPrice = $itemInfo['itemMainInfo']['price'];
    $subtotal = $itemQuantity * $itemPrice;
    $userid = $_SESSION['user']['userID'];
    $cartid = getCartId($userid, $connection);
    if (!$cartid) {
        $cartid = createCart($userid, $connection);
    }
    $validation = validateCartItem($cartid, $itemID, $itemQuantity, $categoryClean, $connection);
    if (!$validation) {
        $addCartItem = addCartitem($cartid, $itemID, $categoryClean, $itemQuantity, $subtotal, $connection);
    }
}
?>
<?php $title = $itemInfo['itemMainInfo']['name'];?>
<?php require_once "./components/header.php"; ?>

<div class="main-wrapper specific">
    <?php require_once "./components/navbar.php"; ?>
    <section class="container item-section mt-5">
        <nav class="mb-5"
            style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-start">
                <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="./category.php?category=<?php echo ($itemInfo["itemSubInfo"]["category"]); ?>"><?php echo $itemInfo["itemSubInfo"]["category"]; ?></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $itemInfo["itemMainInfo"]["name"]; ?>
                </li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12 col-md-9 col-lg-6 col-xl-5 order-lg-1">
                <div class="glider-contain">
                    <div class="glider-gallery-view">
                        <?php
                        foreach ($itemGalleryArray as $galleryPic) : ?>
                        <div>
                            <img src="<?php echo "$galleryPic[imagePath]" ?>" alt="">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 col-lg-12 col-xl-1 thumbnail-col order-lg-0">
                <div role="tablist" class="thumbnail "></div>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 item-inner-section order-5">
                <div class=" item-info-section mb-4">
                    <h1 class="item-info-header "><span
                            class="fw-bold"><?php echo $itemInfo['itemMainInfo']['name']; ?></span></h1>
                    <div class="d-flex justify-content-between align-items-baseline">
                        <p class="d-inline mt-2 item-info-price lead fs-3">
                            <?php echo "RM "  . number_format($itemInfo['itemMainInfo']['price'], 2, '.', ''); ?></p>

                        <!-- Display Average Star Rating -->
                        <?php if ($itemType == "product" && $totalReviews != 0):?>
                        <div class="item-stars d-inline me-5">
                            <?php
                            $limit = floor($avgRating);
                            $remainder = fmod($avgRating, $limit);
                            for($i = 0; $i < $limit; $i++) {
                                echo ("<img src='./svg/star-fill.svg' alt='Yellow Star'>");
                            }
                            if ($remainder >= 0.5){
                                echo ("<img src='./svg/star-half.svg' alt='Half Star'>");
                            } elseif ($remainder != 0){
                                echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                            }
                            if($avgRating < 4.5){                 
                                for($i = 0; $i < 5 - ceil($avgRating); $i++){
                                    echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                }
                            }
                            ?>
                            <!-- Display Total Reviews -->
                            <span class="ms-2">(<?php echo $totalReviews;?>)</span>
                            <!-- End of Display Total Reviews -->
                        </div>
                        <?php endif; ?>
                        <!-- End of Display Average Star Rating -->
                    </div>
                </div>
                <hr>
                <div>
                    <div>
                        <div>
                            <form action="" method="POST">
                                <div class=" item-quantity-section mb-3">
                                    <input type="hidden" name="productId" value="<?php echo $id ?>">
                                    <label for="quantity" class="mb-3">Quantity: </label>
                                    <input type="number" class="text-center rounded" name="item_quantity" min="1"
                                        max="<?php echo $quantity; ?>" value="1" class="d-block"
                                        <?php if (in_array($itemInfo['itemSubInfo']['category'], $petArray)) {
                                                                                                                                                                                echo 'readonly';
                                                                                                                                                                            } ?>>
                                    <?php echo "<div class='text-danger'>There is only $quantity stock left.</div>"; ?>
                                </div>
                                <div>
                                    <button type="submit" class="rounded-pill btn btn-success add-to-cart-btn mb-3"
                                        name="add-to-cart-btn">Add to Cart</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['add-to-cart-btn'])) {
                                if ($validation) {
                                    if ($validation === "maxed") {
                                        echo "<div class='alert alert-warning' role='alert'>
                Maxed amount of this item has been added into your cart. </div>";
                                    } elseif ($validation === "updated") {
                                        echo "<div class='alert alert-info' role='alert'>
                $itemQuantity of this item has been added into your cart.</div>";
                                    } else {
                                        echo "<div class='alert alert-danger' role='alert'>
                This item is already in your cart. </div>";
                                    }
                                } else {
                                    if ($addCartItem) {
                                        echo "<div class='alert alert-success' role='alert'>
                Congratulations! You added this item to cart successfully!
            </div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="item-share-section mt-4">
                    <h6 class="fw-bold mb-3">SHARE</h6>
                    <div class="share ">
                        <a href=""><img src="./svg/facebook_share.svg" class="me-3" alt=""></a>
                        <a href=""><img src="./svg/twitter_share.svg" class="me-3" alt=""></a>
                        <a href=""><img src="./svg/instagram_share.svg" class="me-3" alt=""></a>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mt-5">
        <nav class="specific-tabs-section">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class=" nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pet Info</button>
                <button class=" nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Description</button>
                <?php if ($itemType == "product"):?>
                <button class=" nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                    type="button" role="tab" aria-controls="nav-review" aria-selected="false">Review</button>
                <?php endif; ?>
            </div>
        </nav>

        <div class="tab-content mt-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div>
                    <div class="specific-item-info">
                        <?php foreach ($itemInfo["itemSubInfo"] as $key => $value) : ?>
                        <div>
                            <p class="specific-item-property fw-bold"><?php echo ucfirst($key); ?> </p>
                            <p><?php echo $value; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php if (isset($itemInfo["itemMainInfo"]['description'])) : ?>
                <p><?php echo nl2br(str_replace('\n', "<br>", $itemInfo["itemMainInfo"]['description'])); ?></p>
                <?php endif; ?>
            </div>

            <!-- Review Tab Content-->
            <?php if ($itemType == "product"):?>
            <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                <div class="">
                    <div class="review-inner-section">
                        <div class="review-header-section">
                            <div class="ratings align-self-start">
                                <h3>Ratings</h3>
                                <div class="mb-2">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <span class="ms-2">(<?php echo $eachRatingTotal["totalFiveStar"];?>)</span>
                                </div>
                                <div class="mb-2">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <span class="ms-2">(<?php echo $eachRatingTotal["totalFourStar"];?>)</span>
                                </div>
                                <div class="mb-2">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <span class="ms-2">(<?php echo $eachRatingTotal["totalThreeStar"];?>)</span>
                                </div>
                                <div class="mb-2">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <span class="ms-2">(<?php echo $eachRatingTotal["totalTwoStar"];?>)</span>
                                </div>
                                <div class="mb-2">
                                    <img src="./svg/star-fill.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <img src="./svg/star-fill-white.svg" alt="">
                                    <span class="ms-2">(<?php echo $eachRatingTotal["totalOneStar"];?>)</span>
                                </div>
                            </div>
                        </div>

                        <!-- <div class = "review-body-section"> -->

                        <!-- Product Reviews -->
                        <?php foreach($productReviewsArray as $review):?>
                        <div class="review-indi">
                            <div class="review-indi-info mb-1">
                                <h5 class="d-inline me-3"><?php echo $review["firstName"] . " " . $review["lastName"];?>
                                </h5>
                                <small><?php echo date('d/m/Y g:ia', strtotime($review["createdAt"]));?></small>
                            </div>
                            <div class="review-stars mb-3">
                                <?php 
                                    for($i = 1; $i <= $review["rating"]; $i++){
                                        echo "<img src='./svg/star-fill.svg' alt='Yellow Star'>";
                                    }
                                    for($i = 1; $i <= 5 - $review["rating"]; $i++){
                                        echo "<img src='./svg/star-fill-white.svg' alt='Gray Star'>";
                                    }
                                    ?>
                            </div>
                            <?php if ($review["feedback"] != "");?>
                            <div class="review-indi-description">
                                <p><?php echo $review["feedback"];?></p>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
    </section>

    <section class="other-products-section mt-5 pt-5">
        <div class="container">
            <h3>Other Products in this Category</h3>
            <div class="glider-contain mt-5">
                <div class="glider-other-products">
                    <?php foreach ($others as $cat) : ?>
                    <div>
                        <div class="card-wrapper specific">
                            <div class="card-main-section">
                                <img src="<?php echo "$cat[imagePath]" ?>" alt="" class="img-fluid">
                                <div class="card-main-section-icon">
                                    <button class="btn card-icon-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                            <path
                                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                        </svg>
                                    </button>
                                    <button class="btn card-icon-wrapper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                            <path
                                                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="card-content-section">
                                <a href="<?php echo "item.php?category=$categoryClean&id=$cat[id]"; ?>"
                                    class="text-decoration-none text-dark">
                                    <h5 class="text-center mt-2 px-2 text-truncate"><?php echo $cat["name"] ?></h5>
                                </a>
                            </div>
                            <div class="card-rating-section text-center">
                                <?php 
                                $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
                                if (in_array($cat["category"], $productArray)):
                                {
                                $avgRating = getAvgRating($cat["id"], $connection);
                                $totalReviews = getTotalProductReviews($cat["id"], $cat["category"], $connection);
                                }
                                ?>
                                <div class="stars">
                                    <?php 
                                    if ($totalReviews == 0){
                                        echo ("<small class='align-bottom'>No ratings</small>");  
                                    }
                                    if ($totalReviews != 0):
                                    ?>
                                    <?php
                                        $limit = floor($avgRating);
                                        $remainder = fmod($avgRating, $limit);
                                        for($i = 0; $i < $limit; $i++) {
                                            echo ("<img src='./svg/star-fill.svg' alt='Yellow Star'>");
                                        }
                                        if ($remainder >= 0.5){
                                            echo ("<img src='./svg/star-half.svg' alt='Half Star'>");
                                        } elseif ($remainder != 0){
                                            echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                        }
                                        if($avgRating < 4.5){                 
                                            for($i = 0; $i < 5 - ceil($avgRating); $i++){
                                                echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                            }
                                        }
                                    ?>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-price-section text-center">
                                <span>RM<?php echo number_format($cat["price"],2 , ".", "") ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button aria-label="Previous" class="glider-prev" id="other-products-prev">«</button>
                <button aria-label="Next" class="glider-next" id="other-products-next">»</button>
                <div role="tablist" class="dots"></div>
            </div>
        </div>
    </section>

    <?php require_once "./components/footer.php"; ?>
</div>
<?php require_once "./script/general_scripts.php"?>
<script>
const thumbjson = `<?php echo json_encode($itemGalleryArray); ?>`;
</script>
<script src="./js/aos.js"></script>
<script src="./js/item.js"></script>
</body>

</html>
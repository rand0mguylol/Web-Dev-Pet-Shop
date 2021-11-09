<?php
session_start();
require_once "./connection/db.php";
require_once "./helper/helpers.php";

if (isset($_GET["category"])) {
    $q = "";
    $sortBy = "";
    $category = sanitizeText($_GET["category"]);
    $categoryHeader = getCategoryInfo($connection, $category);
    $categoryName = $categoryHeader["category"];
    $categoryDescription = $categoryHeader["description"];
    if (!$categoryHeader) {
        header("Location: ./index.php");
        exit();
    }
    //
    if (isset($_GET["q"])) {
        $q = sanitizeText($_GET["q"]);
    }

    if(isset($_GET["sortBy"])){
        $sortBy = $_GET["sortBy"];
    }

    $categoryArray = getCategoryProduct($connection, $category, $q, $sortBy);


} else {
    header("Location: ./index.php");
    exit();
}

if(isset($_GET["clearFilter"])){
    unset($_GET["clearFilter"]);
    unset($_GET["sortBy"]);
    if(!empty($q)){
        header("Location: ./category.php?category=$category&q=$q");
    }else{
        header("Location: ./category.php?category=$category");

    }
    exit();
}
?>
<?php $title = "$category";?>
<?php require_once "./components/header.php"; ?>

<div class="offcanvas offcanvas-start justify-content-center" tabindex="-1" id="sidenavCanvas"
    aria-labelledby="sidenavCanvasLabel">
    <div class="offcanvas-header justify-content-end">
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php include "./components/category_nav.php"; ?>
    </div>
</div>

<div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="filterCanvas"
    aria-labelledby="filterCanvasLabel">
    <div class="offcanvas-header justify-content-end">
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" class="filter-form">
        <input type="hidden" value="<?php echo $category; ?>" name="category">
            <input type="hidden" value="<?php echo $q; ?>" name="q">
            <fieldset class="mb-3">
                <legend>Sort By</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortBy" id="sortHighestPrice" value = "priceHigh" <?php if (strtolower($sortBy) === "pricehigh") echo "checked"?>>
                    <label class="form-check-label" for="sortHighestPrice">
                        Highest Price
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortBy" id="sortLowestPrice" value = "priceLow" <?php if (strtolower($sortBy) === "pricelow") echo "checked"?>>
                    <label class="form-check-label" for="sortLowestPrice">
                        Lowest Price
                    </label>
                </div>
            </fieldset>
            <button type="submit" class="mt-5 w-100 clear-filter-button" name = "clearFilter">CLEAR FILTERS</button>
            <button type="submit" class="mt-2 w-100 submit-filter-button">SUBMIT FILTERS</button>
        </form>
    </div>
</div>

<div class="main-wrapper general">
    <?php require_once "./components/navbar.php"; ?>
    <section class="breadcrumb-section">
        <div class="container  mt-5">
            <nav class="mb-5 "
                style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $categoryName; ?></li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="general-product-header-section">
        <div class="container text-center">
            <h1><?php echo $categoryName; ?></h1>
            <p class="w-50"><?php echo $categoryDescription; ?></p>
        </div>
    </section>

    <section class="search-section mt-5 position-sticky py-3">
        <div class="container medium-inner-wrapper d-flex justify-content-center align-items-baseline">
            <div>
                <button class=" view-button" data-bs-toggle="offcanvas" data-bs-target="#sidenavCanvas"
                    aria-controls="sidenavCanvas">
                    <img src="./svg/list.svg" alt="">
                    <h6 class="d-inline">View</h6>
                </button>
            </div>
            <div class="search-container">
                <form action="" class="search-form d-flex d-inline justify-content-between" method="GET">
                    <input type="text" class="form-control search-bar d-inline" id="inputFirstName"
                        placeholder="Search for Products" name="q" value="<?php if (isset($q)) echo $q ?>">
                        <input type="hidden" value="<?php echo $sortBy; ?>" name="sortBy">
                    <input type="hidden" value="<?php echo $category; ?>" name="category">
                    <button class="btn search text-end"><img src="./svg/search (1).svg" alt=""></button>
                </form>
            </div>
            <div class="filter-container">
                <button class="filter-button" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas"
                    aria-controls="filterCanvas">
                    <img src="./svg/filter.svg" alt="">
                    <h6 class="d-inline">Filter</h6>
                </button>
            </div>
        </div>
    </section>

    <section class="product-section mt-5 ">
        <div class="d-flex ">
            <nav class="navbar navbar-expand-xxl navbar-light bg-transparent d-inline-block ps-4 general-side-nav">
                <div class="collapse navbar-collapse flex-column" id="navbarTogglerDemo01">
                    <?php include "./components/category_nav.php"; ?>
                </div>
            </nav>
            <div class="container d-flex flex-wrap">
                <?php if (empty($categoryArray) && isset($_GET["q"])) : ?>
                <p class='text-center lead'> There are no products that match your search</p>
                <?php elseif (empty($categoryArray)) : ?>
                <p class='text-center lead'> There are no products in this category</p>
                <?php else : ?>
                <?php foreach ($categoryArray as $cat) : ?>
                <div class="product-indi">
                    <div class="card-wrapper general">
                        <div class="card-main-section">
                            <img src="<?php echo "$cat[imagePath]"; ?>" alt="" class="img-fluid">
                            <div class="card-main-section-icon">
                                <button class="btn card-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-bag" viewBox="0 0 16 16">
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                    </svg>
                                </button>
                                <button class="btn card-icon-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-share" viewBox="0 0 16 16">
                                        <path
                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="card-content-section">
                            <a href="<?php echo "item.php?category=$categoryName&id=$cat[id]"; ?>"
                                class="text-decoration-none text-dark">
                                <h5 class="text-center mt-2 px-2 text-truncate"><?php echo $cat["name"]; ?></h5>
                            </a>
                        </div>
                        <div class="card-rating-section text-center">
                            <div class="stars">
                                <?php 
                                $productArray = ["Dog Food", "Cat Food", "Hamster Food", "Dog Care Products", "Cat Care Products", "Dog Accessories", "Cat Accessories"];
                                if (in_array($categoryName, $productArray)):
                                {
                                $avgRating = getAvgRating($cat["id"], $connection);
                                $totalReviews = getTotalProductReviews($cat["id"], $categoryName, $connection);
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
                        </div>
                        <div class="card-price-section text-center">
                            <span><?php echo "RM" . number_format($cat["price"],2 , ".", ""); ?></span>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<a href="#" class="to-top">
    <img src="./svg/chevron-up.svg" alt="">
</a>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script src="./js/category.js"></script>
</body>

</html>
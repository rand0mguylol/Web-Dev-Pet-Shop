<?php
session_start();
require_once "./function/db.php";
require_once "./function/helpers.php";

if(isset($_GET["category"])){

  $category = sanitizeText($_GET["category"]);

    $categoryHeader = getCategoryInfo($connection, $category);
    $categoryName = $categoryHeader["category"];
    $categoryDescription = $categoryHeader["description"];

    if(!$categoryHeader){
        header("Location: index.php");
        exit();
    }
  
  if(isset($_GET["q"]) && $_GET["q"] !== ""){
    $q = sanitizeText($_GET["q"]);
    $categoryArray= getCategoryProduct($connection, $category, $q);
  }else{
    $categoryArray = getCategoryProduct($connection, $category);
  }
  
}
else{
  header("Location: index.php");
  exit();
}

if(isset($_GET["category"], $_GET["q"])){

}
?>

<?php require_once "header.php"; ?>


<div class="offcanvas offcanvas-start justify-content-center" tabindex="-1" id="sidenavCanvas"
    aria-labelledby="sidenavCanvasLabel">
    <div class="offcanvas-header justify-content-end">
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
       <?php include "./category_nav.php"; ?>
    </div>
</div>


<div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="filterCanvas"
    aria-labelledby="filterCanvasLabel">
    <div class="offcanvas-header justify-content-end">
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" class="filter-form">
            <fieldset class="mb-3">
                <legend>Sort By</legend>            
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortBy" id="sortHighestPrice">
                    <label class="form-check-label" for="sortHighestPrice">
                        Highest Price
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortBy" id="sortLowestPrice">
                    <label class="form-check-label" for="sortLowestPrice">
                        Lowest Price
                    </label>
                </div>
            </fieldset>

            <fieldset>
                <legend>Rating</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ratingBy" id="ratingHighest">
                    <label class="form-check-label" for="ratingHighest">
                        Highest Rating
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ratingBy" id="ratingLowest">
                    <label class="form-check-label" for="ratingLowest">
                        Lowest Rating
                    </label>
                </div>
            </fieldset>
            <button type="reset" class="mt-5 w-100 clear-filter-button">CLEAR FILTERS</button>
        </form>
    </div>
</div>

<div class="main-wrapper general">

    <?php require_once "navbar.php"; ?>

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
        <!-- <nav class ="navbar navbar-expand-xxl navbar-light bg-transparent d-inline-block ps-4 general-side-nav">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav> -->

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
                        placeholder="Search for Products" name = "q" value ="<?php if(isset($q)) echo $q?>">
                    <input type="hidden" value = "<?php echo $category; ?>" name = "category">
                    <button class="btn search text-end" name = "search"><img src="./svg/search (1).svg" alt=""></button>
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

                <?php include "./category_nav.php"; ?>
                </div>
            </nav>
            <div class="container d-flex flex-wrap">

            <?php if (empty($categoryArray) && isset($_GET["q"])): ?>
                <p class = 'text-center lead'> There are no products that match your search</p>
            <?php elseif (empty($categoryArray)): ?>
                <p class = 'text-center lead'> There are no products in this category</p>
            <?php else: ?>
                <?php foreach($categoryArray as $cat): ?>
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
                                <img src="./svg/star-fill.svg" alt="">
                                <img src="./svg/star-fill.svg" alt="">
                                <img src="./svg/star-fill.svg" alt="">
                                <img src="./svg/star-fill-white.svg" alt="">
                                <img src="./svg/star-fill-white.svg" alt="">
                                <small class=" align-bottom">1 out of 5</small>
                            </div>
                        </div>
                        <div class="card-price-section text-center">
                            <span><?php echo "RM $cat[price]"; ?></span>
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

<script>
const toTop = document.querySelector(".to-top");
const subNavToggle = document.querySelectorAll(".dropdown-toggle");
const subNavMenu = document.querySelectorAll(".dropdown-menu");
const navCol = document.querySelector(".navbar-collapse")
window.addEventListener("scroll", () => {
    if (window.pageYOffset > 100) {
        toTop.classList.add("active");
        for (i = 0; i < subNavToggle.length; ++i) {
            subNavToggle[i].classList.remove("show")
        };
        for (i = 0; i < subNavMenu.length; ++i) {
            subNavMenu[i].classList.remove("show")
        };
        navCol.classList.remove("show")
    } else {
        toTop.classList.remove("active");
    }
    })
  </script>
   <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init(
      {
        offset: 300
      }
    )
  </script>
  <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
<?php require_once "script_links.php"; ?>
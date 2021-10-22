<?php
session_start();
require_once "./function/db.php";
require_once "./function/helpers.php";
  // var_dump($_GET);

if(isset($_GET["category"])){

  $category = sanitizeText($_GET["category"]);
  $categoryClean = filter_var($category, FILTER_SANITIZE_STRING);
  

  $informaton = getCategoryInfo($connection, $categoryClean);

  if(!$informaton){
    header("Location: index.php");
    exit();
  }

  $categoryDescription = $informaton["categoryDescription"];
  $categoryArray = $informaton["categoryArray"];
  $categoryName = $informaton["categoryName"];
}
else{
  header("Location: index.php");
  exit();
}
?>

<?php require_once "header.php"; ?>


  <div class="offcanvas offcanvas-start justify-content-center" tabindex="-1" id="sidenavCanvas" aria-labelledby="sidenavCanvasLabel">
    <div class="offcanvas-header justify-content-end">
      <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-column">
        <li class="nav-item">
          <h6>Pets</h6>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Dog</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Cat</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Hamster</a>
        </li>
        <li class="nav-item mt-3">
          <h6>Care Products</h6>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Dog Care Products</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Cat Care Products</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Hamster Care Products</a>
        </li>
        <li class="nav-item mt-3">
          <h6>Accessories</h6>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Dog Accessories</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Cat Accessories</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Hamster Accessories</a>
        </li>
        <li class="nav-item mt-3">
          <h6>Food</h6>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Dog Food</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Cat Food</a>
        </li>
        <li class="nav-item ps-2">
          <a class="nav-link" href="#">Hamster Food</a>
        </li>
      </ul>
    </div>
  </div>


  <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="filterCanvas" aria-labelledby="filterCanvasLabel">
    <div class="offcanvas-header justify-content-end">
      <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <form action="" class = "filter-form ">
        <fieldset class = "mb-3">
          <legend>Sort By</legend>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortBy" id="sortBestSeller">
            <label class="form-check-label" for="sortBestSeller">
              Best Seller
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortBy" id="sortNewArrival" >
            <label class="form-check-label" for="sortNewArrival">
              New Arrival
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortBy" id="sortHighestPrice">
            <label class="form-check-label" for="sortHighestPrice">
              Highest Price
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="sortBy" id="sortLowestPrice" >
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
      <button type="reset" class = "mt-5 w-100 clear-filter-button" >CLEAR FILTERS</button>
      </form>
    </div>
  </div>

  <div class = "main-wrapper general">

<?php require_once "navbar.php"; ?>

    <section class = "breadcrumb-section">
      <div class = "container  mt-5">
        <nav class = "mb-5 " style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $categoryName; ?></li>
          </ol>
        </nav>
      </div>
    </section>
    
    <section class = "general-product-header-section">
      <div class = "container text-center">
        <h1><?php echo $categoryName; ?></h1>
        <p class = "w-50"><?php echo $categoryDescription; ?></p>
      </div>
    </section>


    <section class = "search-section mt-5 position-sticky py-3">
      <!-- <nav class ="navbar navbar-expand-xxl navbar-light bg-transparent d-inline-block ps-4 general-side-nav">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav> -->
      
      <div class = "container medium-inner-wrapper d-flex justify-content-center align-items-baseline">

        <div>
          <button class=" view-button" data-bs-toggle="offcanvas" data-bs-target="#sidenavCanvas" aria-controls="sidenavCanvas">
            <img src="./svg/list.svg" alt="">
            <h6 class = "d-inline">View</h6>
          </button>
        </div>

        <div class = "search-container">
          <form action="" class = "search-form d-flex d-inline justify-content-between">
            <input type="text" class="form-control search-bar d-inline" id="inputFirstName" placeholder="Search for Products">
            <button class = "btn search text-end" ><img src="./svg/search (1).svg" alt="" ></button>
          </form>
        </div>
        <div class = "filter-container">
          <button class = "filter-button" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas" aria-controls="filterCanvas">
              <img src="./svg/filter.svg" alt="">
              <h6 class = "d-inline">Filter</h6>
          </button>
        </div>
      </div>
    </section>


    <section class = "product-section mt-5 ">
      
      <div class = "d-flex ">
        <nav class = "navbar navbar-expand-xxl navbar-light bg-transparent d-inline-block ps-4 general-side-nav">
          <div class="collapse navbar-collapse flex-column" id="navbarTogglerDemo01">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-column">
              <li class="nav-item">
                <h6>Pets</h6>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Dog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Cat</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Hamster</a>
              </li>
              <li class="nav-item mt-3">
                <h6>Care Products</h6>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Dog Care Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Cat Care Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Hamster Care Products</a>
              </li>
              <li class="nav-item mt-3">
                <h6>Accessories</h6>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Dog Accessories</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Cat Accessories</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Hamster Accessories</a>
              </li>
              <li class="nav-item mt-3">
                <h6>Food</h6>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Dog Food</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Cat Food</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Hamster Food</a>
              </li>                               
            </ul>
          </div>
        </nav>
        <div class = "container d-flex flex-wrap">
          
        <?php foreach($categoryArray as $cat): ?>
          <div class = "product-indi">
            <div class = "card-wrapper general">
              <div class = "card-main-section">
                <img src="<?php echo "$cat[imagePath].jpg"; ?>" alt="" class = "img-fluid">
                <div class = "card-main-section-icon">
                    <button class ="btn card-icon-wrapper">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                      </svg>
                    </button>
                    <button class = "btn card-icon-wrapper">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                      </svg>
                    </button>
                </div>
              </div>
              <div class = "card-content-section">
                <a href="<?php echo "item.php?category=$categoryName&id=$cat[id]"; ?>" class = "text-decoration-none text-dark">
                  <h5 class="text-center mt-2 px-2 text-truncate"><?php echo $cat["name"]; ?></h5>
                </a>
              </div>
              <div class = "card-rating-section text-center">
                <div class = "stars">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <small class = " align-bottom">1 out of 5</small>
                </div>
              </div>
              <div class = "card-price-section text-center">
                <span><?php echo "RM $cat[price]"; ?></span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
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
  <script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
  <script>
    function loadThumbnail(selector) {
      for (let thumbnail of selector){
        thumbnail.innerHTML = `<img src="./images/specific_pets/pomeranian_gallery_sqaure_550_550.jpg" alt="" class = "img-fluid">`;
      }
    }

    const carousel = new Glider(document.querySelector('.glider-other-products'), {
      slidesToShow: 3,
      slidesToScroll: 1,
      draggable: true,
      dots: '.dots',
      arrows: {
        prev: '#other-products-prev',
        next: '#other-products-next'
      },
      dragVelocity: 2,
      scrollLock: true,
      resizeLock: true,
      rewind: true,

      responsive: [
          {
            breakpoint: 0,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },

          {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
          },
          
          {
              breakpoint: 992,
              settings: {
                  slidesToShow: 3,
                  slidesToScroll: 1
              }
          },

          {
            breakpoint: 1400,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }

      ]
    });

    const gallery = new Glider(document.querySelector('.glider-gallery-view'), {
      slidesToShow: 1,
      dots: '.thumbnail',
      draggable: true,
      dragVelocity: 2,
      scrollLock: true,
      resizeLock: true,
      arrows: {
        prev: '#thumbnail-glider-prev',
        next: '#thumbnail-glider-next'
      }, 
    });

    const thumbnails = gallery.dots.children;

    loadThumbnail(thumbnails)

    window.addEventListener("resize", function() {
      loadThumbnail(thumbnails)
    })
  </script>
<?php require_once "script_links.php"; ?>
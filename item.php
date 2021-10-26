<?php
session_start();
require_once "./function/db.php";
require_once "./function/helpers.php";
$petArray  = ["Dog", "Cat", "Hamster"];
if (isset($_GET["category"], $_GET["id"])) {
  $category = sanitizeText($_GET["category"]);
  $categoryClean = filter_var($category, FILTER_SANITIZE_STRING);
  $id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
  $id = (int) $id;
  $itemInfo = getItemInfo($id, $categoryClean, $connection);
  $itemGalleryArray = getImage($id,  $categoryClean, "Gallery", false, $connection);
  $itemThumbnailArray = getImage($id, $categoryClean, "Thumbnail", false, $connection);
  $removeId = $itemInfo["itemSubInfo"]['id'];
  $quantity = $itemInfo['itemSubInfo']['quantity'] ?? 1;
  $others = getCategoryInfo($connection, $categoryClean, $removeId, true);
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
  $validation = validateCartItem($cartid, $itemID,$itemQuantity, $categoryClean, $connection);
  if (!$validation) {
    $addCartItem = addCartitem($cartid, $itemID, $categoryClean, $itemQuantity, $subtotal, $connection);
  }
}
?>

<?php require_once "header.php"; ?>

<div class="main-wrapper specific">
  <?php require_once "navbar.php"; ?>


  <section class="container item-section mt-5">
    <nav class="mb-5" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-start">
        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="./category.php?category=<?php echo ($itemInfo["itemSubInfo"]["category"]); ?>"><?php echo $itemInfo["itemSubInfo"]["category"]; ?></a>
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
          <h1 class="item-info-header "><span class="fw-bold"><?php echo $itemInfo['itemMainInfo']['name']; ?></span></h1>
          <div class="d-flex justify-content-between align-items-baseline">
            <p class="d-inline mt-2 item-info-price lead fs-3">
              <?php echo "RM "  . number_format($itemInfo['itemMainInfo']['price'],2,'.',''); ?></p>
            <div class="item-stars d-inline me-5">
              <img src="./svg/star-fill.svg" alt="">
              <img src="./svg/star-fill.svg" alt="">
              <img src="./svg/star-fill.svg" alt="">
              <img src="./svg/star-fill.svg" alt="">
              <img src="./svg/star-fill.svg" alt="">
              <span class="ms-2">(4)</span>
            </div>
          </div>
          <!-- <p class = "item-info-description">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nesciunt, cumque?</p> -->
        </div>
        <hr>
        <div>
          <div>
            <div>
              <form action="" method="POST">
                <div class=" item-quantity-section mb-3">
                  <input type="hidden" name="productId" value="<?php echo $itemInfo['itemSubInfo']['id']; ?>">
                  <label for="quantity" class="mb-3">Quantity: </label>
                  <input type="number" class="text-center rounded" name="item_quantity" min="1" max="<?php echo $quantity; ?>" value="1" class="d-block" <?php if (in_array($itemInfo['itemSubInfo']['category'], $petArray)) {echo 'readonly';} ?>>
                  <?php echo "<div class='text-danger'>There is only $quantity stock left.</div>"; ?>
                </div>
                <div>
                  <button type="submit" class="rounded-pill btn btn-success add-to-cart-btn mb-3" name="add-to-cart-btn">Add to Cart</button>
                </div>
              </form>
              <?php
              if (isset($_POST['add-to-cart-btn'])) {
                if ($validation) {
                  if($validation === "maxed"){
                    echo "<div class='alert alert-warning' role='alert'>
                Maxed amount of this item has been added into your cart. </div>";
                  }elseif($validation === "updated"){
                  echo "<div class='alert alert-info' role='alert'>
                $itemQuantity of this item has been added into your cart.</div>";
                }else{
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
        <button class=" nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pet Info</button>
        <button class=" nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Description</button>
        <button class=" nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">Review</button>
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
                  <span class="ms-2">(5)</span>
                </div>
                <div class="mb-2">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <span class="ms-2">(5)</span>
                </div>
                <div class="mb-2">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <span class="ms-2">(5)</span>
                </div>
                <div class="mb-2">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <span class="ms-2">(5)</span>
                </div>
                <div class="mb-2">
                  <img src="./svg/star-fill.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <img src="./svg/star-fill-white.svg" alt="">
                  <span class="ms-2">(5)</span>
                </div>
              </div>
              <button class="btn btn-warning mt-4">WRITE A REVIEW</button>
            </div>

            <!-- <div class = "review-body-section"> -->
            <div class="review-indi">
              <div class="review-indi-info mb-3">
                <h5 class="d-inline me-3">John Doe</h5>
                <small>09/09/09</small>
              </div>
              <div class="review-stars mb-3">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
              </div>
              <div class="review-indi-description">
                <h4 class="fw-bold">Fast</h4>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In expedita blanditiis
                  totam laborum reiciendis esse iusto vitae, dicta modi quas, deleniti ut harum
                  similique? Vero magnam hic ducimus accusantium sunt.</p>
              </div>
            </div>

            <div class="review-indi">
              <div class="review-indi-info mb-3">
                <h5 class="d-inline  me-3">Kate</h5>
                <small>09/09/09</small>
              </div>
              <div class="review-stars mb-3">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
              </div>
              <div class="review-indi-description">
                <h4 class="fw-bold">Not Good Boy</h4>
                <p>It shat on my bed</p>
              </div>
            </div>

            <div class="review-indi">
              <div class="review-indi-info mb-3">
                <h5 class="d-inline  me-3">Bruce Wayne</h5>
                <small>09/09/09</small>
              </div>
              <div class="review-stars mb-3">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
                <img src="./svg/star-fill-white.svg" alt="">
              </div>
              <div class="review-indi-description">
                <h4 class="fw-bold">Father's Day</h4>
                <p>My father would have love this. Oh well.</p>
              </div>
            </div>
            <!-- </div> -->
          </div>
        </div>
        </div>
        </div>
        </section>

  <section class="other-products-section mt-5 pt-5">
    <div class="container">
      <h3>Other Products in this Category</h3>
      <div class="glider-contain mt-5">
        <div class="glider-other-products">

          <?php foreach ($others["categoryArray"] as $cat) : ?>
            <div>
              <div class="card-wrapper specific">
                <div class="card-main-section">
                  <img src="<?php echo "$cat[imagePath]" ?>" alt="" class="img-fluid">
                  <div class="card-main-section-icon">
                    <button class="btn card-icon-wrapper">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                      </svg>
                    </button>
                    <button class="btn card-icon-wrapper">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                      </svg>
                    </button>
                  </div>
                </div>
                <div class="card-content-section">
                  <a href="<?php echo "item.php?category=$others[categoryName]&id=$cat[id]"; ?>" class="text-decoration-none text-dark">
                    <h5 class="text-center mt-2 px-2 text-truncate"><?php echo $cat["name"] ?></h5>
                  </a>
                </div>
                <div class="card-rating-section text-center">
                  <div class="stars">
                    <img src="./svg/star-fill.svg" alt="">
                    <img src="./svg/star-fill.svg" alt="">
                    <img src="./svg/star-fill.svg" alt="">
                    <img src="./svg/star-fill-white.svg" alt="">
                    <img src="./svg/star-fill-white.svg" alt="">
                    <small class=" align-bottom">6 out of 5</small>
                  </div>
                </div>
                <div class="card-price-section text-center">
                  <span><?php echo $cat["price"] ?></span>
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

<?php require_once "footer.php"; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.js"></script>
<script>
  const thumbjson = `<?php echo json_encode($itemGalleryArray); ?>`;
  const thumb = JSON.parse(thumbjson)
  // console.log(thumb)

  function loadThumbnail(thumbnailArray, selector) {
    for (let i = 0; i < thumbnailArray.length; i++) {
      selector[i].innerHTML = `<img src="${thumbnailArray[i].imagePath}" alt="" class = "img-fluid">`;
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

    responsive: [{
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
    eventPropagate: false,
  });

  thumbnailsButton = gallery.dots.children;
  loadThumbnail(thumb, thumbnailsButton)

  window.addEventListener("resize", function() {
    loadThumbnail(thumb, thumbnailsButton)
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

<?php require_once "./script_links.php"; ?>
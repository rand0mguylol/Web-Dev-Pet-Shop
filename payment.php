<?php require_once "header.php"; ?>
<?php require_once "navbar.php" ?>
<div class="cart-container container-fluid px-lg-5 my-lg-3">
  <div class="row mx-lg-n5">
    <!-- cart details -->
    <section class="col-md-7 py-3 px-lg-5 border bg-light">
      <h3 class = "m-md-4">Your Shopping Cart</h3>
      <!-- product list -->
      <div class="container d-grid gap-3">
        <div class="row text-center border-bottom">
          <h5 class=" col-6">Product</h5>
          <h5 class=" col-2">Quantity</h5>
          <h5 class=" col-4">Total Price</h5>
        </div>
        <!-- Product -->
        <div class="row product-container">
          <div class="product col-6">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-md-2 my-auto text-center">
            <div class="input-group">
              <span class="input-group-prepend">
                <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                  <span class="fas fa-minus"></span>
                </button>
              </span>
              <input type="text" name="quant[1]" class="form-control input-number text-center" value="1" min="1" max="">
              <span class="input-group-append">
                <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                  <span class="fas fa-plus"></span>
                </button>
              </span>
            </div>
          </div>
          <div class="col-4 my-auto text-center">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
        <!-- Product -->
        <div class="row product-container">
          <div class="product col-6">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-md-2 my-auto text-center">
            <div class="input-group">
              <span class="input-group-prepend">
                <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                  <span class="fas fa-minus"></span>
                </button>
              </span>
              <input type="text" name="quant[1]" class="form-control input-number text-center" value="1" min="1" max="">
              <span class="input-group-append">
                <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                  <span class="fas fa-plus"></span>
                </button>
              </span>
            </div>
          </div>
          <div class="col-md-4 my-auto text-center">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
        <!-- Product -->
        <div class="row product-container">
          <div class="product col-md-6">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-md-2 my-auto text-center">
            <div class="input-group">
              <span class="input-group-prepend">
                <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                  <span class="fas fa-minus"></span>
                </button>
              </span>
              <input type="text" name="quant[1]" class="form-control input-number text-center" value="1" min="1" max="">
              <span class="input-group-append">
                <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                  <span class="fas fa-plus"></span>
                </button>
              </span>
            </div>
          </div>
          <div class="col-md-4 my-auto text-center">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
      </div>
      <!-- End of product list -->
    </section>
    <!-- end of cart details -->
    <!-- payment -->
    <section class="col-md-5 py-3 px-lg-5 border bg-light">
      <div class="row ">

        <p>test</p>
      </div>
      <div class="row lower">
        <p>test</p>
      </div>
    </section>
    <!-- end of payment -->
  </div>
</div>
<script>

</script>
<?php require_once "footer.php"; ?>
<?php require_once "script_links.php"; ?>
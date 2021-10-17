<?php require_once "header.php"; ?>
<?php require_once "navbar.php" ?>
<div class="cart-container container-fluid px-lg-5 my-lg-3 ">
  <div class="row justify-content-around mx-lg-5">
    <!-- cart details -->
    <section class="col-md-7 py-3 px-lg-5 border bg-light rounded-3">
      <h3 class="m-4">Your Shopping Cart</h3>
      <!-- product list -->
      <div class="container">
        <div class="row border-bottom mb-4">
          <h5 class=" col-5 text-start">Product</h5>
          <h5 class=" col-3 text-center">Quantity</h5>
          <h5 class=" col-4 text-end">Total Price</h5>
        </div>
        <!-- Product -->
        <div class="row product-container mb-4 align-items-center">
          <div class="product col-5 text-start">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-3">
            <div class="input-group justify-content-center">
              <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                <i class="fas fa-minus fa-sm"></i>
              </button>
              <input type="text" name="quant[1]" class="form-control input-number text-center" value="1" min="1" max="">
              <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                <i class="fas fa-plus fa-sm"></i>
              </button>
            </div>
          </div>
          <div class="col-4 text-end">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
        <!-- Product -->
        <div class="row product-container mb-4 align-items-center">
          <div class="product col-5 text-start">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-3">
            <div class="input-group justify-content-center">
              <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                <i class="fas fa-minus fa-sm"></i>
              </button>
              <input type="text" name="quant[1]" class="form-control input-number text-center quantity-input" value="1" min="1" max="">
              <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                <i class="fas fa-plus fa-sm"></i>
              </button>
            </div>
          </div>
          <div class="col-4 text-end">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
        <!-- Product -->
        <div class="row product-container mb-4 align-items-center">
          <div class="product col-5 text-start">
            <a href="#">
              <img src="./images/home/home_cat_square_200_200.jpg" alt="Product" id="productpic" class=" paymentpic img-thumbnail img-responsive">
              <p class="d-inline-block">Product</p>
            </a>
          </div>
          <div class="col-3">
            <div class="input-group justify-content-center">
              <button type="button" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                <i class="fas fa-minus fa-sm"></i>
              </button>
              <input type="text" name="quant[1]" class="form-control input-number text-center" value="1" min="1" max="">
              <button type="button" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                <i class="fas fa-plus fa-sm"></i>
              </button>
            </div>
          </div>
          <div class="col-4 text-end">
            RM70.00
          </div>
        </div>
        <!-- End of Product -->
      </div>
      <!-- End of product list -->
      <div class="row p-4 border-top ">
        <div class="col-6">

        </div>
        <div class="col-6 text-end">
          <div class="row">
            <div class="col-6">
              <h6>Subtotal:</h6>
            </div>
            <div class="col-6">
              <h6> RM239.99</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <h6>Shipping:</h6>
            </div>
            <div class="col-6">
              <h6>FREE</h6>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top p-4">
        <div class="col-6 order-xs-2">
          <a href="" class="btn btn-default"><i class="fas fa-arrow-left pe-2"></i>Continue Shopping</a>
        </div>
        <div class="col-6 order-xs-1">
          <div class="row text-end text-xs-center">
            <div class="col-6">
              <h4>Total:</h4>
            </div>
            <div class="col-6">
              <h4>RM239.99</h4>
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- end of cart details -->
    <!-- payment -->
    <section class="col-md-4 py-3 px-lg-3 border bg-light rounded-3">
      <div class="row">
        <h3 class="m-4">Payment Info</h3>
      </div>
      <div class="container">
        <div class="card">
          <!-- Payment Method -->
          <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item credit-card col-6" role="presentation">
              <button class="nav-link active" id="credit-card-tab" data-bs-toggle="pill" data-bs-target="#credit-card-method" type="button" role="tab" aria-controls="credit-card-method" aria-selected="true">
                <i class="far fa-credit-card fa-md p-2"></i>
                Credit Card
              </button>
            </li>
            <li class="nav-item online-banking col-6" role="presentation">
              <button class="nav-link" id="online-banking-tab" data-bs-toggle="pill" data-bs-target="#online-banking-method" type="button" role="tab" aria-controls="online-banking-method" aria-selected="false">
                <i class="fas fa-university fa-md p-2"></i>
                FPX Online Banking
              </button>
            </li>
          </ul>
          <!-- End of Payment Method -->
          <!-- Credit Card -->
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active m-4" id="credit-card-method" role="tabpanel" aria-labelledby="credit-card-tab">
              <form role="form">
                <div class="form-group m-3">
                  <h5>Payment method: </h5>
                  <div class="custom-control custom-radio m-2">
                    <input type="radio" id="visa-card" name="payment-method" class="custom-control-input">
                    <label class="custom-control-label" for="visa-card"><i class="fab fa-cc-visa fa-lg me-2"></i>VISA</label>
                  </div>
                  <div class="custom-control custom-radio m-2">
                    <input type="radio" id="mastercard" name="payment-method" class="custom-control-input">
                    <label class="custom-control-label" for="mastercard"><i class="fab fa-cc-mastercard fa-lg me-2"></i>MasterCard</label>
                  </div>
                </div>
                <div class="form-group m-3">
                  <label for="holder-name">Card Holder (As stated on card)</label>
                  <input type="text" class="form-control" name="holder-name" id="holder-name">
                </div>
                <div class="form-group m-3">
                  <label for="card-number">Card Number</label>
                  <input type="number" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX" name="card-number" id="card-number">
                </div>
                <div class="form-group m-3">
                  <label>Expiration Date</label>
                  <div class="input-group">
                    <input type="number" class="form-control" placeholder="MM" name="expiration-m">
                    <input type="number" class="form-control" placeholder="YY" name="expiration-y">
                  </div>
                </div>
                <div class="form-group m-3">
                  <label for="cvv">CVV</label>
                  <input type="number" class="form-control" name="cvv" id="cvv">
                </div>
                <div class="form-group text-center m-3">
                  <button class="btn btn-primary" type="button">Confirm</button>
                </div>
              </form>
            </div>
            <!-- End of Credit Card -->
            <div class="tab-pane fade" id="online-banking-method" role="tabpanel" aria-labelledby="online-banking-tab">
              <form role ="form">
                <div class="form-group m-3">
                  <h5>Select Your Bank:</h5>
                  <div class="custom-control custom-radio m-2">
                    <input type="radio" id="maybank" name="payment-method" class="custom-control-input">
                    <label class="custom-control-label" for="maybank">Maybank2u</label>
                  </div>
                  <div class="custom-control custom-radio m-2">
                    <input type="radio" id="cimb-bank" name="payment-method" class="custom-control-input">
                    <label class="custom-control-label" for="cimb-bank">CIMB Bank</label>
                  </div>
                  <div class="custom-control custom-radio m-2">
                    <input type="radio" id="public-bank" name="payment-method" class="custom-control-input">
                    <label class="custom-control-label" for="public-bank">Public Bank</label>
                  </div>
                </div>
                <div class="form-group m-3">
                  <label for="bank-account">Account Name</label>
                  <input type="text" class="form-control" placeholder="" name="bank-account" id="bank-account">
                </div>
                <div class="form-group m-3">
                  <label for="bank-password">Password</label>
                  <input type="password" class="form-control" placeholder="" name="bank-password" id="bank-password">
                </div>
                <div class="form-group text-center m-3">
                  <button class="btn btn-primary" type="button">Confirm</button>
                </div>
            </div>
          </div>
          </form>
    </section>
    <!-- end of payment -->
  </div>
</div>
<?php require_once "footer.php"; ?>
<?php require_once "script_links.php"; ?>
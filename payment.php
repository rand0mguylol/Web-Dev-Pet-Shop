<?php session_start();?>
<?php require_once "./function/db.php";?>
<?php require_once "header.php"; ?>
<?php require_once "navbar.php"; ?>
<?php 
  $userid = $_SESSION['user']['userID'] ?? null;
  if (isset($userid)) {
    $cartid = getCartId($userid, $connection);
    $subtotal = getCarttotal($cartid, $connection);
    $cartitems = getCartItems($cartid, $connection);
    $cartTotal = getCartTotal($cartid, $connection);
  }
  if (isset($_POST['bank-payment-btn'])){
    var_dump($_POST);
  }
  if (isset($_POST['credit-card-btn'])){
    var_dump($_POST);
  }
?>
<div class="cart-container container-fluid px-lg-5 my-lg-3 ">
  <div class="row mx-lg-5 justify-content-around">
    <!-- cart details -->
    <section class="col-md-7 py-3 px-lg-5 border bg-light rounded-3">
      <h3 class="m-4">Your Shopping Cart</h3>
      <!-- product list -->
      <div class="container">
        <div class="row border-bottom mb-4">
          <div class="col-1"></div>
          <h6 class=" col-6 text-start">Product</h6>
          <h6 class=" col-3 text-center">Quantity</h6>
          <h6 class=" col-2 text-end">Total Price</h6>
        </div>
        <?php if (!$cartitems):?>
          <div class="row">
            <h6 class= "col">Sadly there is nothing left in your cart... Back to your shopping journey Go Go Go~</h6>
          </div>
        <?php else:?>
          <?php foreach($cartitems as $index =>$item):?>
            <!-- Product -->
            <form method="POST" action = "./controller/remove_cart_item.php">
              <div class="row product-container mb-4 align-items-center">
                <div class="col-1 text-center">
                  <button type= "submit" name ="remove-item-from-cart-btn" value = "<?php echo $cartitems[$index]['cartItemId'];?>"><i class="fas fa-times fa-sm"></i></button>
                </div>
                <div class="product col-6 text-start">
                  <div class="card mb-3 border-0 bg-transparent ">
                    <div class="row no-gutters align-items-center text-center">
                      <div class="col-md-4">
                        <a href="#">
                          <img src="<?php echo $cartitems[$index]['image'];?>" alt="<?php echo $cartitems[$index]['name'],' Image';?>" id="productpic" class=" paymentpic img-thumbnail img-responsive">
                        </a>
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <p class="card-text"><?php echo $cartitems[$index]['name'];?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group justify-content-center">
                    <button type="submit" class="btn btn-outline-secondary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                      <i class="fas fa-minus fa-sm"></i>
                    </button>
                    <input type="hidden" name="product[<?php echo $index;?>]['id']" value="<?php echo $cartitems[$index]['id'];?>">
                    <input type="number" name="product[<?php echo $index;?>]['quantity']" class="form-control input-number text-center quantity-input" value="<?php echo $cartitems[$index]['quantity'];?>" min="1" max="<?php echo $cartitems[$index]['maxQuantity'];?>">
                    <button type="submit" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="quant[1]">
                      <i class="fas fa-plus fa-sm"></i>
                    </button>
                  </div>
                </div>
                <div class="col-2 text-end">
                  RM <?php echo number_format($cartitems[$index]['subtotal'], 2, '.', '');?>
                </div>
              </div>
            </form>
            <!-- End of Product -->
            <?php endforeach?>
          <?php endif ?>
      </div>
      <!-- End of product list -->
      <div class="row p-4 border-top ">
        <div class="col-6">
        </div>
        <div class="col-6 text-end">
          <div class="row">
            <div class="col-6">
              <h6>Subtotal: </h6>
            </div>
            <div class="col-6">
              <h6>RM <span id = "subtotal"><?php echo number_format($cartTotal, 2, '.', '');?></span></h6>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <h6>Shipping:</h6>
            </div>
            <div class="col-6">
              <h6><span id = "shippingFee">FREE</span></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="row border-top p-4">
        <div class="col-6 order-xs-2">
          <a href="./index.php" class="btn btn-default"><i class="fas fa-arrow-left pe-2"></i>Continue Shopping</a>
        </div>
        <div class="col-6 order-xs-1">
          <div class="row text-end text-xs-center">
            <div class="col-6">
              <h5>Total:</h5>
            </div>
            <div class="col-6">
              <h5>RM <span id= "totalAmount"><?php echo number_format($cartTotal, 2, '.', '');?></span></h5>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end of cart details -->
    <!-- payment -->
    <section class="col-md-4 py-2 px-lg-2 border bg-light rounded-3">
      <div class="row">

      </div>
      <div class="row">
        <h3 class="m-4">Payment Info</h3>
      </div>
      <div class="container">
        <div class="card my-3">
          <!-- Payment Method -->
          <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
            <li class="nav-item credit-card" role="presentation">
              <button class="nav-link active" id="credit-card-tab" data-bs-toggle="pill" data-bs-target="#credit-card-method" type="button" role="tab" aria-controls="credit-card-method" aria-selected="true">
                <i class="far fa-credit-card fa-md p-2"></i>
                Credit Card
              </button>
            </li>
            <li class="nav-item online-banking" role="presentation">
              <button class="nav-link" id="online-banking-tab" data-bs-toggle="pill" data-bs-target="#online-banking-method" type="button" role="tab" aria-controls="online-banking-method" aria-selected="false">
                <i class="fas fa-university fa-md p-2"></i>
                FPX Online Banking
              </button>
            </li>
          </ul>
          <!-- End of Payment Method -->
          <!-- Credit Card -->
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active m-3" id="credit-card-method" role="tabpanel" aria-labelledby="credit-card-tab">
              <form action="" method = "POST">
              <input type="hidden"  class = "payment-total" name = "total" value="">
              <input type="hidden" class = "cartId" value = "<?php echo $cartid;?>">
              <div class="form-group m-3">
                <h5>Payment method: </h5>
                <div class="custom-control custom-radio m-2">
                  <input type="radio" id="visa-card" name="payment-method" class="custom-control-input" value ="Visa Card">
                  <label class="custom-control-label" for="visa-card"><i class="fab fa-cc-visa fa-lg me-2"></i>VISA</label>
                </div>
                <div class="custom-control custom-radio m-2">
                  <input type="radio" id="mastercard" name="payment-method" class="custom-control-input" value="mastercard">
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
                  <input type="number" class="form-control" placeholder="MM" name="expiration-month">
                  <input type="number" class="form-control" placeholder="YY" name="expiration-year">
                </div>
              </div>
              <div class="form-group m-3">
                <label for="cvv">CVV</label>
                <input type="number" class="form-control" name="cvv" id="cvv">
              </div>
              <div class="form-group text-center m-3">
                <button class="btn btn-primary <?php if(!$cartitems){echo 'disabled' ;}?>" type="submit" name="credit-card-btn">Confirm</button>
              </div>
              </form>
            </div>
            <!-- End of Credit Card -->
            <div class="tab-pane fade m-3" id="online-banking-method" role="tabpanel" aria-labelledby="online-banking-tab">
              <form action="" method = "POST">
              <div class="form-group m-3">
                <input type="hidden"  class ="payment-total" name = "total" value="">
                <input type="hidden" class = "cartId" value = "<?php echo $cartid;?>">
                <h5>Select Your Bank:</h5>
                <div class="custom-control custom-radio m-2">
                  <input type="radio" id="maybank" name="payment-method" value = "Maybank" class="custom-control-input">
                  <label class="custom-control-label" for="maybank">Maybank2u</label>
                </div>
                <div class="custom-control custom-radio m-2">
                  <input type="radio" id="cimb-bank" name="payment-method" value = "CIMB Bank" class="custom-control-input">
                  <label class="custom-control-label" for="cimb-bank">CIMB Bank</label>
                </div>
                <div class="custom-control custom-radio m-2">
                  <input type="radio" id="public-bank" name="payment-method" value = "Public Bank" class="custom-control-input">
                  <label class="custom-control-label" for="public-bank">Public Bank</label>
                </div>
              </div>
              <div class="form-group m-3">
                <input type="hidden"  class ="total" value="">
                <label for="bank-account">Account Name</label>
                <input type="text" class="form-control" placeholder="" name="bank-account" id="bank-account">
              </div>
              <div class="form-group m-3">
                <label for="bank-password">Password</label>
                <input type="password" class="form-control" placeholder="" name="bank-password" id="bank-password">
              </div>
              <div class="form-group text-center m-3">
                <button class="btn btn-primary <?php if(!$cartitems){echo 'disabled';}?>" type="submit" name="bank-payment-btn">Confirm</button>
              </div>
            </div>
            </form>
          </div>
    </section>
    <!-- end of payment -->
  </div>
</div>
<?php require_once "footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $total = $("#totalAmount").text();
  $subtotal = $("#subtotal").text();
  $shippingFee = $("#shippingFee").text();
  $totalInput = $(".payment-total").val($subtotal);
  console.log($totalInput);
;
</script>
<?php require_once "script_links.php"; ?>
<!-- Import required resources -->
<?php session_start(); ?>
<?php require_once "./connection/db.php"; ?>
<?php $title = "Checkout Page"; ?>
<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>
<?php
//Get UserID,cartID, subtotal, cartitems and subtotal
$userid = $_SESSION['user']['userID'] ?? null;
if (isset($userid)) {
    $cartid = getCartId($userid, $connection);
    $cartitems = getCartItems($cartid, $connection);
    $cartSubtotal = getCartTotal($cartid, $connection);
}
//Handle credit card payment
if (isset($_POST['cardPaymentBtn'])) {
    //Get payment info
    $cardNumber = str_replace("-", "", $_POST['cardNumber']);
    $paymentMethod = $_POST['paymentMethod'];
    $type = $_POST['cardType'];
    $expiryMonth = $_POST['expiryMonth'];
    $expiryYear = $_POST['expiryYear'];
    $cvv = $_POST['cvv'];
    $deliveryMethod = $_POST['deliveryMethod'];
    $total = $_POST['total'];
    //Handle errors
    $err = validateCreditCard($cardNumber, $type, $expiryMonth, $expiryYear, $cvv);
    if (!$err) {
        $orderid = createOrder($userid, $paymentMethod, $type, $deliveryMethod, $total, $connection);
        if ($orderid) {
            addOrderItems($cartid, $orderid, $connection);
            $_SESSION['payment'] = [
                'orderID' => $orderid,
                'paymentMethod' => "$paymentMethod - $type",
                'deliveryMethod' => $deliveryMethod,
                "total" => $total
            ];
        }
    } else {
        $_SESSION['payment'] = NULL;
    }
}

//Handle banking payment
if (isset($_POST['bankingPaymentBtn'])) {
    //Get payment info
    $paymentMethod = $_POST['paymentMethod'];
    $type = $_POST['bank'];
    $deliveryMethod = $_POST['deliveryMethod'];
    $total = $_POST['total'];
    //Create order
    $orderid = createOrder($userid, $paymentMethod, $type, $deliveryMethod, $total, $connection);
    if ($orderid) {
        addOrderItems($cartid, $orderid, $connection);
        $_SESSION['payment'] = [
            'orderID' => $orderid,
            'paymentMethod' => "$paymentMethod - $type",
            'deliveryMethod' => $deliveryMethod,
            "total" => $total
        ];
    }
}
?>

<div class=" container-fluid p-5 m-3 ">
    <div class="row mx-lg-5 justify-content-around">
        <!-- cart details -->
        <section class="col-md-7 py-3 px-lg-5 border bg-light rounded-3 d-flex justify-content-end flex-column">
            <div class="h4 mt-3 mb-4">Your Shopping Cart:</div>
            <section class="container">
                <div class="row border-bottom mb-4">
                    <div class="col-1"></div>
                    <h6 class=" col-6 text-center">Item</h6>
                    <h6 class=" col-3 text-center">Quantity</h6>
                    <h6 class=" col-2 text-end">Total Price</h6>
                </div>
            </section>
            <!-- product list -->
            <section class="cart-container container overflow-auto">
                <?php if (!$cartitems) : ?>
                    <div class="row">
                        <h6 class="col no-cart-item">Sadly there is nothing left in your cart... Back to your shopping journey Go Go Go~</h6>
                    </div>
                <?php else : ?>
                    <?php foreach ($cartitems as $key => $value) : ?>
                        <!-- Product -->
                        <form method="POST" action="./controller/update_cart_item.php" name="<?php echo $key; ?>">
                            <div class="row product-container mb-4 align-items-center">
                                <input type="hidden" name="<?php echo $key; ?>[cartItemId]" value="<?php echo $cartitems[$key]['cartItemId']; ?>">
                                <input type="hidden" name="<?php echo $key; ?>[price]" value="<?php echo $cartitems[$key]['price']; ?>">
                                <div class="col-1 text-center">
                                    <button type="submit" name="removeItemBtn"><i class="fas fa-trash-alt fa-lg"></i></button>
                                </div>
                                <div class="product col-6 text-start">
                                    <div class="card mb-3 border-0 bg-transparent ">
                                        <div class="row no-gutters align-items-center text-center">
                                            <div class="col-md-4">
                                                <a href="#">
                                                    <img src="<?php echo $cartitems[$key]['image']; ?>" alt="<?php echo $cartitems[$key]['name'], ' Image'; ?>" id="productpic" class=" paymentpic img-thumbnail img-responsive">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p class="card-text text-start"><?php echo $cartitems[$key]['name']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="input-group justify-content-center">
                                        <button type="button" class="btn btn-outline-secondary btn-number quantity-changer" <?php if($cartitems[$key]['quantity'] === 1 || $cartitems[$key]['category'] === "pet"){ echo 'disabled= disabled';} ?> data-type="minus" data-field="<?php echo $key; ?>">
                                            <i class="fas fa-minus fa-sm"></i>
                                        </button>
                                        <input type="number" name="<?php echo $key; ?>[quantity]" class="form-control input-number text-center quantity-input" value="<?php echo $cartitems[$key]['quantity']; ?>" <?php if($cartitems[$key]['category'] === "pet"){ echo 'disabled= disabled';} ?> min="1" max="<?php echo $cartitems[$key]['maxQuantity']; ?>">
                                        <button type="button" class="btn btn-outline-secondary btn-number quantity-changer" <?php if($cartitems[$key]['quantity'] === $cartitems[$key]['maxQuantity'] || $cartitems[$key]['category'] === "pet"){ echo 'disabled= disabled';} ?>  data-type="plus" data-field="<?php echo $key; ?>">
                                            <i class="fas fa-plus fa-sm"></i>
                                        </button>
                                        <button type="submit" class="d-none" name="quantityUpdateBtn" data-field="<?php echo $key; ?>"> </button>
                                    </div>
                                </div>
                                <div class="col-2 text-end">
                                    RM <span id="itemSubtotal" data-field="<?php echo $key; ?>"><?php echo number_format($cartitems[$key]['subtotal'], 2, '.', ''); ?></span>
                                </div>
                            </div>
                        </form>
                        <!-- End of Product -->
                    <?php endforeach ?>
                <?php endif ?>
            </section>
            <!-- End of product list -->
            <section class="container mt-auto">
                <div class="row">
                    <div class="row p-3 py-4 border-top border-bottom">
                        <!-- Delivery Option & Subtotal & Shipping Fee -->
                        <div class="col-6">
                            <div class="row">
                                <div class="row">
                                    Delivery Option:
                                </div>
                                <div class="row">
                                    <select class="form-select" aria-label="delivery" name="delivery" id="deliveryOption">
                                        <option selected>Select Your Delivery Option</option>
                                        <option value="J&T">J&T</option>
                                        <option value="PosLaju">PosLaju</option>
                                        <option value="NinjaVan">Ninja Van</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Subtotal: </h6>
                                </div>
                                <div class="col-6">
                                    <h6>RM <span id="subtotal"><?php echo number_format($cartSubtotal, 2, '.', ''); ?></span></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <h6>Shipping:</h6>
                                </div>
                                <div class="col-6">
                                    <h6><span id="shippingFee">FREE</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Continue Shopping & Total section  -->
                    <div class="row p-4">
                        <div class="col-6 order-xs-2">
                            <a href="./index.php" class="btn btn-default"><i class="fas fa-arrow-left pe-2"></i>Continue Shopping</a>
                        </div>
                        <div class="col-6 order-xs-1">
                            <div class="row text-end text-xs-center">
                                <div class="col-6">
                                    <h5>Total:</h5>
                                </div>
                                <div class="col-6">
                                    <h5>RM <span id="totalAmount"><?php echo number_format($cartSubtotal, 2, '.', ''); ?></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Continue Shopping & Total section -->
                </div>
            </section>
        </section>
        <!-- end of cart details -->
        <!-- payment -->
        <section class="col-md-4 py-2 px-lg-2 border bg-light rounded-3  d-flex align-items-center flex-column justify-content-center">
            <div class="row">
                <h3 class="m-4">Payment Info</h3>
            </div>
            <div class="container">
                <div class="card mb-3">
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
                        <div class="tab-pane fade show active m-4" id="credit-card-method" role="tabpanel" aria-labelledby="credit-card-tab">
                            <form action="" method="POST">
                                <input type="hidden" name="paymentMethod" value="Credit Card">
                                <input type="hidden" name="cartId" value="<?php echo $cartid; ?>">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                <input type="hidden" name="total" class="paymentTotal" value="">
                                <input type="hidden" name="deliveryMethod" class="orderDelivery" value="">
                                <div class="form-group m-3">
                                    <label for="cardType" class="pb-1">Select Your Card Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cardType" id="visa-card" value="VISA Card" checked>
                                        <label class="form-check-label" for="visa-card">
                                            <i class="fab fa-cc-visa fa-lg me-2"></i>VISA
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cardType" id="mastercard" value="MasterCard">
                                        <label class="form-check-label" for="mastercard">
                                            <i class="fab fa-cc-mastercard fa-lg me-2"></i>MasterCard
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group m-3">
                                    <label for="holderName">Card Holder Name (As stated on card)</label>
                                    <input type="text" class="form-control" name="holderName" id="holderName" pattern="([A-z0-9??-??\s]){2,}" required>
                                </div>
                                <div class="form-group m-3">
                                    <label for="cardNumber">Card Number</label>
                                    <input type="number" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX" name="cardNumber" id="cardNumber" required>
                                </div>
                                <div class="form-group m-3">
                                    <label>Card Expiry Date</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="MM" name="expiryMonth" required>
                                        <input type="number" class="form-control" placeholder="YY" name="expiryYear" required>
                                    </div>
                                </div>
                                <div class="form-group m-3">
                                    <label for="cvv">CVV</label>
                                    <input type="number" class="form-control" name="cvv" id="cvv" required>
                                </div>
                                <div class="form-group text-center m-3">
                                    <button class="btn btn-primary payment-btn disabled" type="submit" name="cardPaymentBtn">Confirm</button>
                                </div>
                            </form>
                        </div>
                        <!-- End of Credit Card -->
                        <div class="tab-pane fade" id="online-banking-method" role="tabpanel" aria-labelledby="online-banking-tab">
                            <form action="" method="POST">
                                <input type="hidden" name="paymentMethod" value="Banking">
                                <input type="hidden" name="cartId" value="<?php echo $cartid; ?>">
                                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                <input type="hidden" name="total" class="paymentTotal" value="">
                                <input type="hidden" name="deliveryMethod" class="orderDelivery" value="">
                                <div class="form-group m-3">
                                    <label for="paymentMethod" class="pb-1">Select Your Bank</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bank" id="maybank" value="Maybank" checked>
                                        <label class="form-check-label" for="maybank">
                                            Maybank2u
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bank" id="cimb-bank" value="CIMB Bank">
                                        <label class="form-check-label" for="cimb-bank">
                                            CIMB Bank
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bank" id="public-bank" value="Public Bank">
                                        <label class="form-check-label" for="public-bank">
                                            Public Bank
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group m-3">
                                    <label for="bank-account">Account Name</label>
                                    <input type="text" class="form-control" placeholder="" name="bank-account" id="bank-account" required>
                                </div>
                                <div class="form-group m-3">
                                    <label for="bank-password">Password</label>
                                    <input type="password" class="form-control" placeholder="" name="bank-password" id="bank-password" required>
                                </div>
                                <div class="form-group text-center m-3">
                                    <button class="btn btn-primary payment-btn disabled" type="submit" name="bankingPaymentBtn">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
        </section>
        <!-- end of payment -->
    </div>
</div>
<button type="button" class="btn btn-primary d-none" id="paymentModalBtn" data-bs-toggle="modal" data-bs-target="#paymentReport">
</button>
<!-- Payment Modal -->
<div class="modal fade" id="paymentReport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal header -->
            <div class="modal-header <?php if (isset($_SESSION['payment'])) {
                                            echo "bg-success";
                                        } else {
                                            echo "bg-danger";
                                        }; ?>">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php if (isset($_SESSION['payment'])) {
                                                                        echo "Payment Successful";
                                                                    } else {
                                                                        echo "Error!";
                                                                    }; ?></h5>
                <?php if ($_SESSION['payment'] === "-1") : ?>
                    <button type="button" class="close unset-session" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <?php endif ?>
            </div>
            <!-- Modal content -->
            <div class="modal-body">
                <?php if (isset($_SESSION['payment'])) : ?>
                    <div class='container'>
                        <div class='row p-1 border-bottom h5'>Receipt</div>
                        <div class='row p-1'>OrderID : <?php echo $_SESSION['payment']['orderID']; ?></div>
                        <div class='row p-1'>Payment Method : <?php echo $_SESSION['payment']['paymentMethod']; ?></div>
                        <div class='row p-1'>Delivery Method : <?php echo $_SESSION['payment']['deliveryMethod']; ?></div>
                        <div class='row p-1'>Total Paid : RM<?php echo $_SESSION['payment']['total']; ?></div>
                    </div>
                <?php else : ?>
                    <?php foreach ($err as $msg) : ?>
                        <div class="row p-1"><?php echo $msg; ?></div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <!-- Modal Buttons -->
            <div class="modal-footer">
                <?php if (isset($_SESSION['payment'])) {
                    echo "<a href='./index.php' class='btn btn-primary unset-session'>Back To Home</a>";
                } else {
                    echo "<a href='./index.php' class='btn btn-primary unset-session' >Back To Home</a>
                    <button type='button' class='btn btn-secondary unset-session' data-bs-dismiss='modal'>Try Again</button>";
                }; ?>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->
<?php require_once "./components/footer.php"; ?>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script src="./js/payment.js"></script>
<script>
    //Toggle modal
    <?php if (isset($_POST['bankingPaymentBtn']) || isset($_POST['cardPaymentBtn']) || isset($_SESSION['payment'])) : ?>
        $('#paymentModalBtn').click();
    <?php endif ?>
    //Unset payment session
    <?php if (isset($_SESSION['payment'])) : ?>
        $('.unset-session').click(
            deletePaymentSession
        );
    <?php endif ?>
</script>
</body>

</html>
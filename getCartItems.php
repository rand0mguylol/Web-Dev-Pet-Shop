<?php session_start(); ?>
<?php require_once "./connection/db.php"; ?>
<?php require_once "./helper/helpers.php"; ?>
<?php $userid = $_SESSION['user']['userID'] ?? null; ?>
<?php if (isset($userid)) {
  $cartid = getCartId($userid, $connection);
  $subtotal = getCartTotal($cartid, $connection);
  $cartitems = getCartItems($cartid, $connection);
} ?>
<?php if (!$cartitems) : ?>
  <div class="row">
    <h6 class="col no-cart-item">Sadly there is nothing left in your cart... Back to your shopping journey Go Go Go~</h6>
  </div>
<?php else : ?>
  <?php foreach ($cartitems as $key => $value) : ?>
    <!-- Product -->
    <form method="POST" action="./controller/update_cart_item.php">
      <div class="row product-container mb-4 align-items-center">
        <input type="hidden" name="product[<?php echo $key; ?>][cartItemId]" value="<?php echo $cartitems[$key]['cartItemId']; ?>">
        <div class="col-1 text-center">
          <button type="submit" name="removeItemBtn" data-field="<?php echo $key;?>"><i class="fas fa-trash-alt fa-lg"></i></button>
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
            <button type="submit" class="btn btn-outline-secondary btn-number" <?php if ($cartitems[$key]['quantity'] === 1) {echo "disabled='disabled'";}?> data-type="minus" data-field="<?php echo $key;?>">
              <i class="fas fa-minus fa-sm"></i>
            </button>
            <input type="number" name="product[<?php echo $key;?>][quantity]" class="form-control input-number text-center quantity-input" value="<?php echo $cartitems[$key]['quantity']; ?>" min="1" max="<?php echo $cartitems[$key]['maxQuantity']; ?>">
            <button type="submit" class="btn btn-outline-secondary btn-number" data-type="plus" data-field="<?php echo $key;?>">
              <i class="fas fa-plus fa-sm"></i>
            </button>
          </div>
        </div>
        <div class="col-2 text-end">
          RM <?php echo number_format($cartitems[$key]['subtotal'], 2, '.', ''); ?>
        </div>
      </div>
    </form>
    <!-- End of Product -->
  <?php endforeach ?>
<?php endif ?>
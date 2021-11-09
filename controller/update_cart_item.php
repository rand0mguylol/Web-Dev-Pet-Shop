//To handle request from payment.php to update products quantity
<?php session_start();?>
<?php require_once "../connection/db.php" ?>
<?php require_once "../helper/helpers.php" ?>

<?php
//To remove cart item from cart
function removeCartItem($cartItemId,$cartid,$connection){
  $stmt = $connection -> prepare ("DELETE FROM cartitem where cartItemId =?");
  $stmt -> bind_param("i",$cartItemId);
  $stmt -> execute();
  updateCartTotal($cartid,$connection);
  $stmt -> close();
  header("Location: ../payment.php");
  exit();
}

//To update cart item quantity
function updateCartItemQuantity($cartItemId,$cartid,$quantity,$subtotal,$connection){
  $stmt = $connection -> prepare ("UPDATE cartitem SET quantity = ?, subtotal = ? WHERE cartItemId =?");
  $stmt -> bind_param("isi",$quantity,$subtotal,$cartItemId);
  $stmt -> execute();
  updateCartTotal($cartid,$connection);
  header("Location: ../payment.php");
  exit();
}

$cartid = getCartId($_SESSION['user']['userID'],$connection);
//execute the removeCartItem function when remove button is selected
if (isset($_POST['removeItemBtn'])){
  foreach ($_POST as $item){
    $deletedId  = $item['cartItemId'];
    removeCartItem($deletedId,$cartid,$connection);
  }

}
//execute the updateCartItemQuantity function when the cartitem quantity is changed
if (isset($_POST['quantityUpdateBtn'])){
  foreach ($_POST as $item){
    $cartItemId = $item['cartItemId'];
    $quantity = (int)$item['quantity'];
    $price = (float)$item['price'];
    $subtotal = $price * $quantity;
    updateCartItemQuantity($cartItemId,$cartid,$quantity,$subtotal,$connection);
  }
}
?>

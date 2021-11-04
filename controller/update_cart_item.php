<?php session_start();?>
<?php require_once "../connection/db.php" ?>
<?php require_once "../helper/helpers.php" ?>
<?php
function removeCartItem($cartItemId,$cartid,$connection){
  $stmt = $connection -> prepare ("DELETE FROM cartitem where cartItemId =?");
  $stmt -> bind_param("i",$cartItemId);
  $stmt -> execute();
  updateCartTotal($cartid,$connection);
  $stmt -> close();
  header("Location: ../payment.php");
  exit();
}

function updateCartItemQuantity($cartItemId,$cartid,$quantity,$subtotal,$connection){
  $stmt = $connection -> prepare ("UPDATE cartitem SET quantity = ?, subtotal = ? WHERE cartItemId =?");
  $stmt -> bind_param("iii",$quantity,$subtotal,$cartItemId);
  $stmt -> execute();
  updateCartTotal($cartid,$connection);
  header("Location: ../payment.php");
  exit();
}

$cartid = getCartId($_SESSION['user']['userID'],$connection);
if (isset($_POST['removeItemBtn'])){
  foreach ($_POST as $item){
    $deletedId  = $item['cartItemId'];
    removeCartItem($deletedId,$cartid,$connection);
  }

}
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

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
$cartid = getCartId($_SESSION['user']['userID'],$connection);
$deleted_cartitem_id = $_POST['remove-item-from-cart-btn'];
removeCartItem($deleted_cartitem_id,$cartid,$connection);
?>

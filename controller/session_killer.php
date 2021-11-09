<?php session_start();?>

<?php 
//destroy payment session
if (isset($_POST['destroyPaymentSession'])){
  echo"yes";
  unset($_SESSION['payment']);
}
?>
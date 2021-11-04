<?php session_start();?>
<?php 
if (isset($_POST['destroyPaymentSession'])){
  echo"yes";
  unset($_SESSION['payment']);
}
?>
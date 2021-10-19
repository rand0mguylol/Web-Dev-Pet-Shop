<?php session_start(); 

  if(isset($_POST["saveProfile"], $_GET["id"], $_SESSION["user"]["userID"])){
    require_once "../function/db.php";
    require_once "../function/helpers.php"; 
    $error = updateProfile($_POST, $connection, $_GET["id"]);

    if($error){
      $_SESSION["profileUpdateError"] = $error;
    }else{
      $_SESSION["profileUpdate"] = "success";
    }
    header("Location: ../profile.php");
    exit();

    // $r = array_diff_assoc($_POST, $_SESSION["user"]);
    // echo "<pre>";
    // var_dump($r);
    // echo "<\pre>";
  }
?>

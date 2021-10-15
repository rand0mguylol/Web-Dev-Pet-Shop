<?php
  $emptyArray = [];
  $isLogin = false;
  // $validLogin = false;

  if(isset($_POST["signin"])){
    require_once "function/db.php";
    
    $filters = [
      "email"=> FILTER_SANITIZE_EMAIL,
      "password" => FILTER_SANITIZE_STRING,
    ];

    $sanitizeInput = filter_input_array(INPUT_POST, $filters);

    if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
      array_push($emptyArray, "email");
    }

    if($_POST["password"] === ""){
      array_push($emptyArray, "password");
    }

    if (!$emptyArray){
      $email = $sanitizeInput["email"];
      $password = $sanitizeInput["password"];

      $stmt = $connection->prepare("SELECT email, userPassword, firstName, lastName FROM user WHERE email = ?;");
      $stmt->bind_param("s", $email);


      $stmt->execute();
      $result = $stmt->get_result();

      $row = $result->fetch_assoc();
      $stmt->close();

      if($row){
        $verifyPassword = password_verify($password, $row["userPassword"]);  
        $isLogin = ($verifyPassword === false) ? false : true;
        $validLogin = ($verifyPassword === false) ? false : true;

        if ($validLogin){
          $_SESSION["firstName"] = $row["firstName"];
          $_SESSION["lastName"] = $row["lastName"];
        }
      }
    }
  }

  if(isset($_POST["logout"])){
    session_unset();
    session_destroy();
    $validLogin = false;
  }

  // var_dump($_SESSION);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
  <link rel="stylesheet" href="./newapp.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <title>Home Page</title>
</head>
<body>

  <!-- Offcanvas -->
  <?php if (!$isLogin): ?>
  <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas" aria-labelledby="accountCanvasLabel">
    <div class="offcanvas-header flex-column">
      <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">SIGN IN</h2>
    </div>
    <div class="offcanvas-body mb-5">
    <?php if (isset($_POST["signin"])): ?>
      <div class="p-3 mb-2 bg-danger text-white text-center rounded-pill">INCORRECT LOGIN DETAILS</div>
    <?php endif; ?>
      <div>
        <form action="" class="row g-3 row-cols-1" method = "POST">
          <div class = "col">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name = "email" required>
            <?php if(isset($_POST["email"]) && in_array("email", $emptyArray)): ?>
              <small>Please enter a valid email.</small>
            <?php endif; ?>
          </div>

          <div class = "col">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" placeholder = "Password" name = "password" required>
            <?php if(isset($_POST["password"]) && in_array("password", $emptyArray)): ?>
              <small>Please do not leave the field blank.</small>
            <?php endif; ?>
          </div>

          <div class = "col-12 text-center"><button type="submit" class="btn btn-primary offcanvas-sign-in" name = "signin">Sign in</button></div>
        </form>

        <div class = "account-links d-flex justify-content-around mt-5">
          <a href="" class = "text-decoration-none"><small>Forgot Password?</small></a>
          <a href="" class = "text-decoration-none"><small>Create Account</small></a>
        </div>
      </div>
    </div>
  </div>
  <?php else: ?>

   <!-- Offcanvas -->
   <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas" aria-labelledby="accountCanvasLabel">
    <div class="offcanvas-header flex-column">
      <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel"><?php echo $_SESSION['firstName'] . " ". $_SESSION['lastName']; ?> </h2>
    </div>
    <div class="offcanvas-body mb-5">
      <div>
        <form action="" class="row g-3 row-cols-1" method = "POST">
          <div class = "col-12 text-center"><button type="submit" class="btn btn-primary offcanvas-sign-in" name = "logout">Log Out</button></div>
        </form>

      </div>
    </div>
  </div>

  <?php endif; ?>


  <!-- Cart offcanvas -->
  <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="cartCanvas" aria-labelledby="cartCanvasLabel">
    <div class="offcanvas-header flex-column">
      <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">CART IS EMPTY</h2>
    </div>
    <div class="offcanvas-body mb-5">
      <div>
      </div>
    </div>
  </div>
  <!-- End of Offcanvas --> 
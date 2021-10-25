<?php
  $loginErrorArray = [];

  $folder = $_SERVER["REQUEST_URI"];
  $path = dirname($folder);
  $currentPage = $path !== "\\" ?basename($folder):"";
 
  $loginMessage = isset($_SESSION["loginMessage"]) ? $_SESSION["loginMessage"] : null;
  $loginErrorArray = isset($_SESSION["loginErrorArray"]) ? $_SESSION["loginErrorArray"]: [];
  unset($_SESSION["loginMessage"]);
  unset($_SESSION["loginErrorArray"]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
  <link rel="stylesheet" href="newapp.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
  <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Home Page</title>
</head>
<body>

  <!-- Offcanvas -->
  <?php if (!isset($_SESSION["user"]["userID"])): ?>
  <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas" aria-labelledby="accountCanvasLabel">
    <div class="offcanvas-header flex-column">
      <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">SIGN IN</h2>
    </div>
    <div class="offcanvas-body mb-5">
    <?php if (isset($validLogin) && $validLogin === false): ?>
      <div class="p-3 mb-2 bg-danger text-white text-center rounded-pill">INCORRECT LOGIN DETAILS</div>
    <?php endif; ?>
      <div>
        <form action=" <?php echo './controller/login.php?page='.$currentPage;?>" class="row g-3 row-cols-1" method = "POST">
          <div class = "col">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name = "email" required>
            <?php if(in_array("email", $loginErrorArray)): ?>
              <small>Please enter a valid email.</small>
            <?php endif; ?>
          </div>

          <div class = "col">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" placeholder = "Password" name = "password" required>
            <?php if(in_array("password", $loginErrorArray)): ?>
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

      <div class = "text-center mb-3">
          <img src="<?php echo  $_SESSION["user"]["userPicture"] ?>" alt="" class = "img-fluid shadow rounded-circle userProfilePicture" >
        </div>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel"><?php echo $_SESSION['user']['firstName'] . " ". $_SESSION['user']['lastName']; ?> </h2>
    </div>
    <div class="offcanvas-body mb-5">
      <div>
      <div class = "col-12 text-center"><a class="btn  offcanvas-view-account rounded-pill px-5 mb-4" href="profile.php">View Account</a></div>
        <form action="<?php echo './controller/login.php?page='.$currentPage;?>" class="row g-3 row-cols-1" method = "POST">
          <div class = "col-12 text-center"><button type="submit" class="btn offcanvas-sign-in rounded-pill px-5" name = "logout">Log Out</button></div>
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
  
  <!-- Alert for pages. AOS CSS and JS required -->
  <!-- The variable depends on the page -->
  <?php if (isset($loginMessage)): ?>
  <div data-aos = "fade-down"  class="text-center alert alert-success alert-dismissible fade show position-fixed mx-auto login-alert" role="alert">
  <strong><?php echo $loginMessage; ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if (isset($profileUpdateMsg)): ?>
  <div data-aos = "fade-down"  class="text-center alert alert-success alert-dismissible fade show position-fixed mx-auto login-alert" role="alert">
  <strong><?php echo $profileUpdateMsg; ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>


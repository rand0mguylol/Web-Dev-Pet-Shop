<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="../../public/css/newapp.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <title>Home Page</title>


</head>
<body>

  <!-- Offcanvas -->
  <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas" aria-labelledby="accountCanvasLabel">
    <div class="offcanvas-header flex-column">
      <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">SIGN IN</h2>
    </div>
    <div class="offcanvas-body mb-5">
      <div>
        <form action="" class="row g-3 row-cols-1">
          <div class = "col">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Email Address">
          </div>

          <div class = "col">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" placeholder = "Password">
          </div>

          <div class = "col-12 text-center"><button type="submit" class="btn btn-primary offcanvas-sign-in">Sign in</button></div>
        </form>

        <div class = "account-links d-flex justify-content-around mt-5">
          <a href="" class = "text-decoration-none"><small>Forgot Password?</small></a>
          <a href="" class = "text-decoration-none"><small>Create Account</small></a>
        </div>
      </div>
    </div>
  </div>
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

  <?php echo $content?>
  
  <script src="../../public/js/script.js"></script>
</body>
</html>

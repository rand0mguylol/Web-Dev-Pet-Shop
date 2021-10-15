<?php
  session_start();
  $errorArray = [];

  // $test = 'F1@fffffffff';
  // $r = preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/', $test);
  // echo $r;

  // $mobileRegEx = "/^[1-9][0-9]{8,9}$/";
  // $mobileValidate = preg_match($mobileRegEx, "1234567890");
  // echo $mobileValidate;
  if(isset($_POST["signup"])){
    require_once "./function/db.php";
    require_once "./function/helpers.php";

    $firstName = validateText($_POST["firstName"]);
    $lastName = validateText($_POST["lastName"]);

    $filters = [
      "mobileNumber" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^[1-9][0-9]{8,9}$/")),
      "email"=> FILTER_SANITIZE_EMAIL,
      "password" => array("filter" => FILTER_VALIDATE_REGEXP, "options"=>array("regexp"=>"/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%&]{8,12}$/"))
    ];

    $sanitizeInput = filter_input_array(INPUT_POST, $filters);

    if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
      array_push($errorArray, "email");
    }else{
      $email = $sanitizeInput["email"];
    }

    if(!$sanitizeInput["mobileNumber"]){
      array_push($errorArray, "mobileNumber");
    }else{
      $mobileNumber = $sanitizeInput["mobileNumber"];
    }

    if (!$errorArray){
      $password = $sanitizeInput["password"];
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $connection->prepare("INSERT INTO user(firstName, lastName, email, userPassword, mobileNumber) VALUES (?, ?, ?, ?, ?);");
      $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $mobileNumber);

      $stmt->execute();
      $stmt->close();
      header("Location: index.php");
      exit();
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link rel="stylesheet" href="./newapp.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Register For An Account</title>
</head>
<body>
  
  <div class = "container my-5 ">
    <h1 class = "mb-5 text-center">REGISTER AN ACCOUNT</h1> 
    <form class="row g-3 " id = "register-form" action="register.php" method = "POST">
    <div class="col-md-12">
      <label for="inputFirstName" class="form-label">First Name</label>
      <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name = "firstName" value = "<?php echo isset($_POST['firstName']) && !in_array("firstName", $errorArray) ? htmlspecialchars($firstName): '' ; ?>">
      <?php if(in_array("firstName", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid first name</p>
      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <label for="inputLastName" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name = "lastName" value = "<?php echo isset($_POST['lastName']) && !in_array("lastName", $errorArray) ? htmlspecialchars($lastName): '' ; ?>">
      <?php if(in_array("lastName", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid last name</p>
      <?php endif; ?>
    </div>
    
    <div class="col-md-12">
      <label for="inputTelephone" class="form-label">Mobile Number</label>
      <div class="input-group">
        <div class="input-group-text">+60</div>
        <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789" name = "mobileNumber" value = "<?php echo isset($_POST['mobileNumber']) && !in_array("mobileNumber", $errorArray) ? htmlspecialchars($mobileNumber): '' ; ?>">
        <?php if(in_array("mobileNumber", $errorArray)):  ?>
        <p class = "mt-1 text-danger mb-0 ps-3 d-block">Please enter a valid mobile number</p>
        <?php endif; ?>
      </div>
    </div>
   
    <div class="col-md-12">
      <label for="inputEmail" class="form-label">Email</label>
      <input type="text" class="form-control" id="inputEmail" placeholder="Email Address" name = "email" value = "<?php echo isset($_POST['email']) && !in_array("email", $errorArray) ? htmlspecialchars($email): '' ; ?>" required>
      <?php if(in_array("email", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid email</p>
      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <label for="inputPassword" class="form-label">Password</label>
      <input type="password" class="form-control" id="inputPassword" placeholder = "Password" name = "password" required>
      <small class = "mt-1"    <?php if(in_array("password", $errorArray)):  ?> style = "color:red" <?php endif; ?>>Length must be between 8 to 16 characters, including one digit, one uppercase, one lowecase character and may contain the following !@#$%& </small>
    </div>
    
    <div class="col-md-12">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick = "viewPassword()">
        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary" name = "signup">Sign Up</button>
    </div>
    </form>
  </div>

  <script>
    function viewPassword(){
      const password = document.querySelector("#inputPassword")
      if (password.type === "password") {
        password.type ="text";
      } else{
        password.type = "password"
      }
    }
  </script>
 <?php require_once "script_links.php"; ?>
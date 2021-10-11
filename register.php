<?php

  if(filter_var("80765", FILTER_VALIDATE_INT) === false){
    echo "yes";
  }else{
    echo"np";  }

  $errorArray = [];

if(isset($_POST["signup"])){
  require_once "function/db.php";


  echo gettype($_POST["postcode"]);

  $filters = [
    "firstName"=> FILTER_SANITIZE_STRING,
    "lastName" => FILTER_SANITIZE_STRING,
    "mobileNumber" => FILTER_SANITIZE_STRING,
    "icNumber" => FILTER_SANITIZE_STRING,
    "email"=> FILTER_SANITIZE_EMAIL,
    "password" => FILTER_SANITIZE_STRING,
    "addressLine" => FILTER_SANITIZE_STRING,
    "postcode" => FILTER_SANITIZE_STRING,
    "city" => FILTER_SANITIZE_STRING,
    "state" => FILTER_SANITIZE_STRING
  ];

  $sanitizeInput = filter_input_array(INPUT_POST, $filters);

  if (!filter_var($sanitizeInput["email"], FILTER_VALIDATE_EMAIL)){
    $errorArray[] = $sanitizeInput["email"];
  }

  $mobileRegEx = "/^[1-9]{9,10}$/";
  $mobileValidate = preg_match($mobileRegEx, $sanitizeInput["mobileNumber"]);

  $postcodeRegEx = "/^[0-9]{5}$/";
  $postcodeValidate = preg_match($postcodeRegEx, $sanitizeInput["postcode"]);


  foreach ($sanitizeInput as $key => $value){
    if (!$value){
      $errorArray[] = $key;
    }
  }

  // var_dump($errorArray);

  if (!$errorArray){
    extract($sanitizeInput);
    // echo $firstName;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO user (firstName, lastName, email, userPassword, mobileNumber, identificationNumber, addressLine, city, stateName, postcode, imagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DEFAULT);");
    $stmt->bind_param("ssssiisssi", $firstName, $lastName, $email, $hashedPassword, $mobileNumber, $icNumber, $addressLine, $city, $state, $postcode);

    // if(!mysqli_stmt_prepare($statement, $sql)){
    //   echo "failed";
    //   header("Location: register.php");
    //   exit();
    // }

    $stmt->execute();
    $stmt->close();
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
    <form class="row g-3 " id = "register-form" action="" method = "POST">
    <div class="col-md-6">
      <label for="inputFirstName" class="form-label">First Name</label>
      <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name = "firstName">
      <?php if(in_array("firstName", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid first name</p>
      <?php endif; ?>
    </div>
    <div class="col-md-6">
      <label for="inputLastName" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name = "lastName">
      <?php if(in_array("lastName", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid last name</p>
      <?php endif; ?>
    </div>
    
    <div class="col-md-12">
      <label for="inputTelephone" class="form-label">Mobile Number</label>
      <div class="input-group">
        <div class="input-group-text">+60</div>
        <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789" name = "mobileNumber">
        <?php if(in_array("mobileNumber", $errorArray)):  ?>
        <p class = "mt-1 text-danger mb-0">Please enter a valid mobile number</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-12">
      <label for="inputIC" class="form-label">Identification Number</label>
      <input type="text" class="form-control" id="inputIC" placeholder="Identification Number" name = "icNumber" required>
      <small class = "mt-1">Only digits, no "-".</small>
      <?php if(in_array("icNumber", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid identification number</p>
      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <label for="inputEmail" class="form-label">Email</label>
      <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name = "email" required>
      <?php if(in_array("email", $errorArray)):  ?>
      <p class = "mt-1 text-danger mb-0">Please enter a valid email</p>
      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <label for="inputPassword" class="form-label">Password</label>
      <input type="password" class="form-control" id="inputPassword" placeholder = "Password" name = "password" required>
      <small class = "mt-1"    <?php if(in_array("password", $errorArray)):  ?> style = "text-color:red" <?php endif; ?>>Length must be between 8 to 16 characters, including one digit, one special, one uppercase and one lowecase character.</small>
    </div>
    
    <div class="col-md-12">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" onclick = "viewPassword()">
        <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
      </div>
    </div>
    <div class="col-md-12">
      <label for="inputAddress" class="form-label">Address</label>
      <input type="text" class="form-control" id="inputAddress" placeholder="Address" name = "addressLine" required>
      <?php if(in_array("addressLine", $errorArray)):  ?>
        <p class = "mt-1 text-danger mb-0">Please enter a valid address</p>
      <?php endif; ?>
    </div>
    <div class="col-md-2">
      <label for="inputPostCode" class="form-label">Postcode</label>
      <input type="number" class="form-control" id="inputPostCode" placeholder="10000" name = "postcode"  min = "0" required>
      <?php if(in_array("postcode", $errorArray)):  ?>
        <p class = "mt-1 text-danger mb-0">Please enter a valid postcode</p>
      <?php endif; ?>
    </div>
    <div class="col-md-10">
      <label for="inputCity" class="form-label">City</label>
      <input type="text" class="form-control" id="inputCity" placeholder="Selangor" name = "city" required>
      <?php if(in_array("city", $errorArray)):  ?>
        <p class = "mt-1 text-danger mb-0">Please enter a valid city</p>
      <?php endif; ?>
    </div>
    <div class="col-md-12">
      <label for="inputState" class="form-label">State</label>
      <select id="inputState" class="form-select" name = "state" required>
        <option value = "Johor">Johor</option>
        <option value = "Kedah">Kedah</option>
        <option value = "Kelantan">Kelantan</option>
        <option value = "Malacca">Malacca</option>
        <option value = "Negeri Sembilan">Negeri Sembilan</option>
        <option value = "Pahang">Pahang</option>
        <option value = "Penang">Penang</option>
        <option value = "Perak">Perak</option>
        <option value = "Perlis">Perlis</option>
        <option value = "Sabah">Sabah</option>
        <option value = "Sarawak">Sarawak</option>
        <option value = "Selangor" selected>Selangor</option>
        <option value = "Terengganu">Terengganu</option>
        <option value =  "Kuala Lumpur">Kuala Lumpur</option>
        <option value = "Putrajaya">Putrajaya</option>
        <option value = "Labuan">Labuan</option>
      </select>
    </div>
    <!-- <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck">
        <label class="form-check-label" for="gridCheck">
          Check me out
        </label>
      </div>
    </div> -->
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

  <script>

    const inputPostcode = document.querySelector("#inputPostCode");

    inputPostcode.addEventListener("keypress", function(e){
      if (e.target.value.length > 4){
        e.preventDefault()
      }
    })

    // const inputTelphone = document.querySelector("#inputTelephone");

    // inputTelphone.addEventListener("keypress", function(e){
    //   if(parseInt(e.target.value) === false){
    //     e.preventDefault();
    //   }
    // })
    
  </script>
 <?php require_once "script_links.php"; ?>
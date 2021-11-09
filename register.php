<?php
session_start();
$errorArray = [];
if (isset($_SESSION["accountCreationError"])) {
    $errorArray =  $_SESSION["accountCreationError"];
    unset($_SESSION["accountCreationError"]);
}

$title = "Register Account";
?>


<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>
<div class="container my-5 rounded-3 px-5 py-5 bg-none border shadow ">
    <h1 class="mb-5 text-center">REGISTER AN ACCOUNT</h1>
    <form class="row g-3 " id="register-form" action="./controller/register_user.php" method="POST">

        <div class="col-md-12">
            <label for="inputFirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name="firstName" value="<?php echo isset($_POST['firstName']) && !in_array("firstName", $errorArray) ? htmlspecialchars($firstName) : ''; ?>">
        </div>

        <div class="col-md-12">
            <label for="inputLastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name="lastName" value="<?php echo isset($_POST['lastName']) && !in_array("lastName", $errorArray) ? htmlspecialchars($lastName) : ''; ?>">
        </div>

        <div class="col-md-12">
            <label for="inputTelephone" class="form-label">Mobile Number*</label>
            <div class="input-group">
                <div class="input-group-text">+60</div>
                <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789" name="mobileNumber" value="<?php echo isset($_POST['mobileNumber']) && !in_array("mobileNumber", $errorArray) ? htmlspecialchars($mobileNumber) : ''; ?>" required>
                <?php if (in_array("mobileNumber", $errorArray)) :  ?>
                    <p class="mt-1 text-danger mb-0 ps-3 d-block">Please enter a valid mobile number</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-12">
            <label for="registerEmail" class="form-label">Email*</label>
            <input type="email" class="form-control" id="registerEmail" placeholder="Email Address" name="email" value="<?php echo isset($_POST['email']) && !in_array("email", $errorArray) ? htmlspecialchars($email) : '' ?>" required>
            <?php if (in_array("email", $errorArray)) :  ?>
                <p class="mt-1 text-danger mb-0">Please enter a valid email</p>
            <?php endif; ?>
            <?php if (in_array("emailTaken", $errorArray)) :  ?>
                <p class="mt-1 text-danger mb-0">Email has been taken</p>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <label for="registerPassword" class="form-label">Password*</label>
            <input type="password" class="form-control" id="registerPassword" placeholder="Password" name="password" required>
            <div class="<?php if (in_array("password", $errorArray))  echo "border border-danger ps-3 rounded mt-3"; ?>"><small class="fs-6  fst-italic fw-lighter <?php if (in_array("password", $errorArray))  echo "text-danger"; ?>">Length must be between 8 to 16 characters, including one digit, one uppercase, one lowecase character and may contain the following !@#$%& </small></div>
        </div>

        <div class="col-md-12">
            <div class="form-check form-switch">
                <input class="form-check-input view-Password" type="checkbox" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Show Password</label>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
        </div>
    </form>
</div>
<?php require_once "./components/footer.php"; ?>
<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script src="./js/register.js"></script>
</body>

</html>
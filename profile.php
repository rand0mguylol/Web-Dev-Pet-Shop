<?php session_start(); 

// var_dump($_SESSION);
  $statesArray = array("Johor", "Kedah", "Kelantan", "Malacca", "Negeri Sembilan", "Pahang", "Penang", "Perak", "Perlis", "Sabah", "Sarawak", "Selangor", "Terengganu", "Kuala Lumpur", "Putrajaya", "Labuan");

  // Return to index if not login
  if(!isset($_SESSION["user"]["userID"])){
    header("Location: index.php");
    exit();
  }
  
  if(isset($_SESSION["passwordChangeMsg"])){
    $passwordMsg = $_SESSION["passwordChangeMsg"];
    unset($_SESSION["passwordChangeMsg"]);
  }

  if(isset($_SESSION["profileUpdate"])){
    var_dump($_SESSION);
    echo "update success";
    unset($_SESSION["profileUpdate"]);
  }

  if(isset($_SESSION["profileUpdateError"])){
    $profileErrorArray = $_SESSION["profileUpdateError"];
    unset($_SESSION["profileUpdateError"]);
  }

?>

<?php require_once "header.php"; ?>

<div class="main-wrapper profile">
    <?php require_once "navbar.php"; ?>

    <div class="container border border-dark profile-container my-5  d-flex align-items-stretch">
        <div class="row align-items-stretch">
            <div class="col-3 px-0 d-flex align-items-center nav-tab-container">
                <div class="nav nav-tabs profile-tab flex-column" id="nav-tab" role="tablist">
                    <button class=" nav-link active" id="nav-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                        aria-selected="true">Profile</button>
                    <button class=" nav-link" id="nav-pic-tab" data-bs-toggle="tab" data-bs-target="#nav-pic"
                        type="button" role="tab" aria-controls="nav-pic" aria-selected="false">Profile Picture</button>
                    <button class=" nav-link" id="nav-privacy-tab" data-bs-toggle="tab" data-bs-target="#nav-privacy"
                        type="button" role="tab" aria-controls="nav-privacy" aria-selected="false">Privacy</button>
                    <button class=" nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                        type="button" role="tab" aria-controls="nav-order" aria-selected="false">Order</button>
                </div>
            </div>
            <div class="col-9 my-auto">
                <div class="tab-content mt-3" id="nav-tabContent">
                    <!-- Profile Tab  -->
                    <div class="tab-pane fade show active mx-auto" id="nav-profile" role="tabpanel"
                        aria-labelledby="nav-profile-tab">
                        <form action="./controller/update_profile.php?id=<?php echo $_SESSION["user"]["userID"]; ?>"
                            class="row g-3 justify-content-center" id="profile-form" method="POST">
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputFirstName" placeholder="First Name"
                                    name="firstName" value="<?php echo $_SESSION["user"]["firstName"];?>">
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputLastName" placeholder="Last Name"
                                    name="lastName" value="<?php echo $_SESSION["user"]["lastName"];?>">
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-text">+60</div>
                                    <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789"
                                        name="mobileNumber" value="<?php echo $_SESSION["user"]["mobileNumber"];?>">
                                </div>
                                <?php if(isset($profileErrorArray) && in_array("mobileNumber", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0 d-block">Please enter a valid mobile number</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="inputAddressLine" placeholder="Address Line"
                                    name="addressLine" value="<?php echo $_SESSION["user"]["addressLine"];?>">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="inputPostcode" placeholder="Postcode"
                                    name="postcode"
                                    value="<?php echo isset($_SESSION["user"]["postcode"]) &&  ($_SESSION["user"]["postcode"]) !== 0 ? $_SESSION["user"]["postcode"]:"";?>">
                                <?php if(isset($profileErrorArray) && in_array("postcode", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0 d-block">Please enter a valid postcode</p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="inputCity" placeholder="City" name="city"
                                    value="<?php echo  $_SESSION["user"]["city"];?>">
                            </div>
                            <div class="col-md-12">
                                <select id="inputState" class="form-select" name="state">
                                    <?php if(!$_SESSION["user"]["userState"]): ?>
                                    <option selected value="">Select State</option>
                                    <?php endif; ?>
                                    <?php foreach($statesArray as $s): ?>
                                    <option value="<?php echo $s;?>"
                                        <?php if ($_SESSION["user"]["state"] === $s) echo "selected";?>><?php echo $s;?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($profileErrorArray) && in_array("state", $profileErrorArray)):  ?>
                                <p class="mt-1 text-danger mb-0">Please select a valid state</p>
                                <?php endif; ?>
                            </div>

                            <div class="col-12 text-center"><button type="submit"
                                    class="btn offcanvas-save-profile rounded-pill mt-5 px-5"
                                    name="saveProfile">Save</button></div>
                        </form>
                    </div>
                    <!-- End of Profile Tab -->

                    <!-- Picture Tab -->
                    <div class="tab-pane fade" id="nav-pic" role="tabpanel" aria-labelledby="nav-pic-tab">


                    </div>

                    <!-- End of Picture Tab -->

                    <!-- Privacy Tab -->
                    <div class="tab-pane fade" id="nav-privacy" role="tabpanel" aria-labelledby="nav-privacy-tab">
                        <form action="./controller/change_Password.php?id=<?php echo $_SESSION["user"]["userID"]; ?>"
                            class="row g-3 justify-content-center" id="password-form" method="POST">
                            <p class="lead"><?php if(isset($passwordMsg)) echo $passwordMsg; ?></p>
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Old Password"
                                    name="oldPassword">
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="New Password"
                                    name="newPassword">
                            </div>
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                    name="confirmPassword">
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn offcanvas-save-profile rounded-pill mt-5 px-5"
                                    name="changePass">Change Password</button>
                            </div>
                        </form>
                    </div>

                    <!--  End of privacy tab-->

                    <!-- Order Tab -->
                    <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
                        <div class="container">
                            <div class="row">Hello</div>

                        </div>
                    </div>

                    <!-- End of order tab -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "script_links.php"; ?>
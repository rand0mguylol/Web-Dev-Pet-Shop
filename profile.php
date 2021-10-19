<?php session_start(); ?>

<?php require_once "header.php"; ?>

<div class="main-wrapper profile">
<?php require_once "navbar.php"; ?>

  <div class="container border border-dark profile-container mt-5  d-flex align-items-stretch">
    <div class = "row align-items-stretch">
      <div class="col-3 px-0 d-flex align-items-center nav-tab-container">
          <div class="nav nav-tabs profile-tab flex-column" id="nav-tab" role="tablist">
            <button class=" nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
            <button class=" nav-link" id="nav-pic-tab" data-bs-toggle="tab" data-bs-target="#nav-pic" type="button" role="tab" aria-controls="nav-pic" aria-selected="false">Profile Picture</button>
            <button class=" nav-link" id="nav-privacy-tab" data-bs-toggle="tab" data-bs-target="#nav-privacy" type="button" role="tab" aria-controls="nav-privacy" aria-selected="false">Privacy</button>
            <button class=" nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-order" aria-selected="false">Order</button>
          </div>
      </div>
      <div class="col-9 my-auto">  
        <div class="tab-content mt-3" id="nav-tabContent">
          <!-- Profile Tab  -->
          <div class="tab-pane fade show active mx-auto" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form action="" class = "row g-3 justify-content-center" id = "profile-form">
              <div class="col-md-12">
                <label for="inputFirstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="inputFirstName" placeholder="First Name" name = "firstName"  value = "<?php echo isset($_SESSION["firstName"]) ? $_SESSION["firstName"] : '';?> ">        
              </div>
              <div class="col-md-12">
              <label for="inputLastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="inputLastName" placeholder="Last Name" name = "lastName">              
              </div>
              <div class="col-md-12">
              <label for="inputTelephone" class="form-label">Mobile Number</label>
                <div class="input-group">
                  <div class="input-group-text">+60</div>
                  <input type="tel" class="form-control" id="inputTelephone" placeholder="123456789" name = "mobileNumber" value = "">
                </div>
              </div>
              <div class="col-md-12">
                <label for="inputAddressLine" class="form-label">Address Line</label>
                <input type="text" class="form-control" id="inputAddressLine" placeholder="Address Line" name = "addressLine">              
              </div>
              <div class="col-md-4">
              <label for="inputPostcode" class="form-label">Postcode</label>
                <input type="text" class="form-control" id="inputPostcode" placeholder="Postcode" name = "postcode">              
              </div>
              <div class="col-md-8">
              <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity" placeholder="City" name = "city">              
              </div>
              <div class="col-md-12">
              <label for="inputState" class="form-label">State</label>
                <input type="text" class="form-control" id="inputState" placeholder="State" name = "state">              
              </div>
            </form>
          </div>
        <!-- End of Porfile Tab -->

        <!-- Picture Tab -->
          <div class="tab-pane fade" id="nav-pic" role="tabpanel" aria-labelledby="nav-pic-tab">   

          </div>

          <!-- End of Picture Tab -->

          <!-- Privacy Tab -->
          <div class="tab-pane fade" id="nav-privacy" role="tabpanel" aria-labelledby="nav-privacy-tab">   
            
          </div>

          <!--  End of privacy tab-->

          <!-- Order Tab -->
          <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">   
          
          </div>

          <!-- End of order tab -->
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once "script_links.php"; ?>
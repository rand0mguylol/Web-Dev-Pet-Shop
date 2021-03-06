<?php
//
require_once "./helper/helpers.php";
require_once "./connection/db.php";
//
$loginErrorArray = [];

//NEW WAY
// Retrive the query string of the current page
$queryString = $_SERVER["QUERY_STRING"];
$folder = $_SERVER["SCRIPT_NAME"];

// Get the current page
$currentPage= basename($folder);

$alertMessage = isset($_SESSION["alertMessage"]) ? $_SESSION["alertMessage"] : null;
$loginErrorArray = isset($_SESSION["loginErrorArray"]) ? $_SESSION["loginErrorArray"] : [];
unset($_SESSION["alertMessage"]);
unset($_SESSION["loginErrorArray"]);
//
$userid = $_SESSION['user']['userID'] ?? null;
if (isset($userid)) {
    $cartid = getCartId($userid, $connection);
    if (!$cartid) {
        $cartid = createCart($userid, $connection);
    }
    $total = getCartTotal($cartid, $connection);
    $cartitems = getCartItems($cartid, $connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
    <link rel="stylesheet" href="./css/newapp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"
        integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title><?php echo $title ?></title>
</head>

<body>
    <!-- Offcanvas -->
    <?php if (!isset($_SESSION["user"]["userID"])) : ?>
    <!-- Offcanvas for users that are not logged in -->
    <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas"
        aria-labelledby="accountCanvasLabel">
        <div class="offcanvas-header flex-column">
            <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">SIGN IN</h2>
        </div>
        <div class="offcanvas-body mb-5">
            <?php if (isset($validLogin) && $validLogin === false) : ?>
            <div class="p-3 mb-2 bg-danger text-white text-center rounded-pill">INCORRECT LOGIN DETAILS</div>
            <?php endif; ?>
            <div>
                <form
                    action="<?php echo './controller/login.php?page=' . $currentPage . '&queryString=' . $queryString; ?>"
                    class="row g-3 row-cols-1" method="POST">
                    <div class="col">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email Address"
                            name="email" required>
                        <?php if (in_array("email", $loginErrorArray)) : ?>
                        <small>Please enter a valid email.</small>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password"
                            name="password" required>
                        <?php if (in_array("password", $loginErrorArray)) : ?>
                        <small>Please do not leave the field blank.</small>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary offcanvas-sign-in" name="signin">Sign in</button>
                    </div>
                </form>
                <div class="account-links d-flex justify-content-center mt-5">
                    <a href="./register.php" class="text-decoration-none"><small>Create Account</small></a>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <!-- Offcanvas for users that are logged in-->
    <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="accountCanvas"
        aria-labelledby="accountCanvasLabel">
        <div class="offcanvas-header flex-column">
            <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            <div class="text-center mb-3">
                <img src="<?php echo  $_SESSION["user"]["userPicture"] ?>" alt=""
                    class="img-fluid shadow rounded-circle userProfilePicture">
            </div>
            <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">
                <?php echo $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName']; ?> </h2>
        </div>
        <div class="offcanvas-body mb-5">
            <?php if ($_SESSION["user"]["userRole"] === "STAFF"): ?>
            <div class="col-12 text-center">
                <a class="btn  offcanvas-view-account rounded-pill px-5 mb-4" href="admin.php">Admin Panel</a>
            </div>
            <?php endif; ?>
            <div class="col-12 text-center">
                <a class="btn  offcanvas-view-account rounded-pill px-5 mb-4" href="profile.php">View Account</a>
            </div>
            <form action="<?php echo './controller/login.php?page=' . $currentPage . '&queryString=' . $queryString; ?>"
                class="row g-3 row-cols-1" method="POST">
                <div class="col-12 text-center"><button type="submit" class="btn offcanvas-sign-in rounded-pill px-5"
                        name="logout">Sign Out</button></div>
            </form>

        </div>
    </div>
    <?php endif; ?>

    <!-- Cart offcanvas -->
    <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="cartCanvas"
        aria-labelledby="cartCanvasLabel">
        <div class="offcanvas-header flex-column overflow-auto">
            <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            <?php if (!isset($cartitems)) : ?>
            <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">
                Cart is empty.
            </h2>
            <?php else : ?>
            <section class=" offcanvas-title mt-3 text-start border-bottom">
                <h3> Your Cart items:</h3>
            </section>
            <section class="offcanvas-body mb-5 text-center">
                <div class="overflow-y">
                    <?php foreach ($cartitems as $item) : ?>
                    <div class="card mb-3">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-4">
                                <img src="<?php echo $item['image']; ?>" class="card-img text-center"
                                    alt="<?php echo $item['name'] . ' Image'; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column">
                                    <section>
                                        <h5 class="card-title text-start text-muted <?php if (strlen($item['name']) > 20) {
                                                                                                echo "h6";
                                                                                            } ?>">
                                            <?php echo $item['name']; ?></h5>
                                    </section>
                                    <section class="row card-text text-start m-0">
                                        <div class="col-5 p-0">
                                            Quantity
                                        </div>
                                        <div class="col-2 p-0 text-center">
                                            :
                                        </div>
                                        <div class="col-5 p-0">
                                            <?php echo $item['quantity']; ?>
                                        </div>
                                    </section>
                                    <section class="row card-text text-start m-0">
                                        <div class="col-5 p-0 ">
                                            Total
                                        </div>
                                        <div class="col-2 p-0 text-center">
                                            :
                                        </div>
                                        <div class="col-5 p-0">
                                            RM<?php echo number_format((float)$item['subtotal'], 2, '.', ''); ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </section>
            <div>
                <a href="./payment.php" class="btn btn-outline-dark" href="./payment.php">Pay >></a>
            </div>
        </div>
    </div>
    <?php endif ?>
    </div>
    </div>
    <!-- End of Offcanvas -->

    <!-- Alert for pages. AOS CSS and JS required -->
    <!-- The variable depends on the page -->
    <?php if (isset($alertMessage)) : ?>
    <div data-aos="fade-down"
        class="text-center alert alert-success alert-dismissible fade show position-fixed mx-auto login-alert"
        role="alert">
        <?php foreach($alertMessage as $alert): ?>
        <strong><?php echo $alert; ?></strong>
        <br>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Review Offcanvas -->
    <div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="reviewCanvas"
        aria-labelledby="reviewCanvasLabel">

        <!-- Title & X Button -->
        <div class="offcanvas-header flex-column">
            <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">REVIEW PRODUCT</h2>
        </div>
        <div class="offcanvas-body mb-5">
            <div>
                <!-- Form -->
                <form action="" class="row g-3 row-cols-1" method="POST">
                    <!-- Star Rating -->
                    <div class="card-rating-section d-inline-block text-center">
                        <p>Rating: </p>
                        <i class="fa fa-star fa-2x" data-index-num="0"></i>
                        <i class="fa fa-star fa-2x" data-index-num="1"></i>
                        <i class="fa fa-star fa-2x" data-index-num="2"></i>
                        <i class="fa fa-star fa-2x" data-index-num="3"></i>
                        <i class="fa fa-star fa-2x" data-index-num="4"></i>
                    </div>
                    <input type="hidden" id="rating" name="rating" value="-1">
                    <!-- Error Message for Rating -->
                    <?php if (isset($_POST["submit"]) && in_array("ratingErr", $errorArray)) :  ?>
                    <p class="mt-1 text-danger mb-0 text-center">Please select a rating</p>
                    <?php else : ?>
                    <p class="mt-1 mb-0"></p>
                    <?php endif; ?>

                    <!-- Feedback Textarea -->
                    <div class="col">
                        <label for="feedback" class="form-label">Feedback:</label>
                        <textarea class="form-control" resize="none" id="feedback" name="feedback" rows="5"
                            placeholder="Share your experience with the product and help others make better purchases!"></textarea>
                    </div>
                    <!-- Error Message for Feedback -->
                    <?php if (isset($_POST["submit"]) && in_array("feedbackErr", $errorArray)) :  ?>
                    <p class="mt-1 text-danger mb-0 text-center">Feedback must not be over 50 characters long</p>
                    <?php else : ?>
                    <p class="mt-1 mb-0"></p>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <div class="col-12 text-center submitButtonContainer">
                        <input type="hidden" name="reviewItemId" class="reviewItemInput" value="">
                        <button type="submit" class="btn btn-warning offcanvas-submit" id="submit_review"
                            name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End of Offcanvas -->
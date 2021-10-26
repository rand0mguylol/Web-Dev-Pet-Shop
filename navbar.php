<nav class="navbar navbar-expand-lg navbar-light fw-bolder home-nav" id="home-nav">
    <div class="container">
        <a class="navbar-brand logo" href="#"><img src="./images/Logo2.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-auto-close="true" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Pets</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./category.php?category=Dog">Dogs</a></li>
                        <li><a class="dropdown-item" href="./category.php?category=Cat">Cats</a></li>
                        <li><a class="dropdown-item" href="./category.php?category=Hamster">Hamster</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown has-megamenu">
                    <a class="nav-link dropdown-toggle" data-bs-auto-close="true" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Products</a>
                    <div class="dropdown-menu megamenu" role="menu">
                        <div class="row g-3 megamenu-container">
                            <div class="col-lg-3 col-6 megamenu-section">
                                <div class="col-megamenu">
                                    <h5 class="title"><u>Pet Food</u></h4>
                                        <ul class="list-unstyled">
                                            <li><a class="dropdown-item" href="./category.php?category=Cat Food">Cat Food</a></li>
                                            <li><a class="dropdown-item" href="./category.php?category=Dog Food">Dog Food</a></li>
                                            <li><a class="dropdown-item" href="./category.php?category=Hamster Food">Hamster Food</a></li>
                                        </ul>
                                </div> <!-- //megamenu-main -->
                            </div><!-- end col-1 -->
                            <div class="col-lg-3 col-6 megamenu-section">
                                <div class="col-megamenu">
                                    <h5 class="title"><u>Pet Accessories</u></h5>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="./category.php?category=Cat Accessories">Cat Accessories</a></li>
                                        <li><a class="dropdown-item" href="./category.php?category=Dog Accessories">Dog Accessories</a></li>
                                    </ul>
                                </div> <!-- //megamenu-col-1 -->
                            </div><!-- end col-2 -->
                            <div class="col-lg-3 col-6 megamenu-section">
                                <div class="col-megamenu">
                                    <h5 class="title"><u>Care Products</u></h5>
                                    <ul class="list-unstyled">
                                        <li><a class="dropdown-item" href="./category.php?category=Cat Care Products">Cat Care Products</a></li>
                                        <li><a class="dropdown-item" href="./category.php?category=Dog Care Products">Dog Care Products</a></li>
                                    </ul>
                                </div> <!-- //megamenu-col-2 -->
                            </div><!-- end col-3 -->
                        </div><!-- end row -->
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>
            <div class="navbar-nav align-self-center d-flex">
                <a class="nav-link " data-bs-toggle="offcanvas" href="#accountCanvas" role="button" aria-controls="accountCanvasExample"><img class="me-2" src="./svg/person-circle.svg" alt="">Account</a>
                <a class="nav-link" data-bs-toggle="offcanvas" href="#cartCanvas" role="button" aria-controls="cartCanvasExample"><img class="me-2" src="./svg/cart.svg" alt="">Cart</a>
            </div>
        </div>
</nav>
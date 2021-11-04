<?php session_start(); 

require_once "./connection/db.php";
?>
<?php $title = "PetterTogether - Home Page";?>
<?php require_once "./components/header.php"; ?>
<!-- Main Section - Navbar & Hero Section -->
<section class="main-section">
    <div class="background-filter">
        <?php require_once "./components/navbar.php"; ?>
        <div class="container lead-content pb-5">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <h1 class="lead-header">Defining<span>Relationships</span></h1>
                    <p class="lead-paragraph lead mt-3">Expand the family today with the world's leading pet store, PetterTogether! Regardless of whether your companion is a dog, cat or hamster. they will all be a purrfect addition to the family!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Main Section - Navbar & Hero Section -->

<!-- Start of Companion Section -->
<section class="companion-/section mt-5">
    <div class="container">
        <h2 class="sub-header-home text-center">Choosing the right companion</h2>
        <div class=" animal-showcase">
            <div class="row justify-content-center justify-content-lg-between align-items-center" data-aos="fade-right" data-aos-delay="100">
                <div class="col-12 col-lg-7 animal-showcase-text">
                    <h3>Men's Best Friend</h3>
                    <p class="lead">Man's best friend will be by your side whether you're having a good day or down in the dumps. Their playfulness and affection will surely cheer you up. </p>
                    <a href="./category.php?category=Dog" class="btn btn-danger mt-3">Browse Now</a>
                </div>
                <div class="col-12 col-lg-4 animal-showcase-img">
                    <img src="./images/home/home_dog_square_300_300.jpg" alt="" class="img-fluid shadow rounded-circle ">
                </div>
            </div>
            <div class="row justify-content-center justify-content-lg-between align-items-center" data-aos="fade-right" data-aos-delay="100">
                <div class="col-12 col-lg-7 animal-showcase-text">
                    <h3>Purrfect Pawtner</h3>
                    <p class="lead">These felines are for those who want a more elegant and sophisticated companion to join their family. Their affection will help make every day a brighter one for you.</p>
                    <a href="./category.php?category=Cat" class="btn btn-danger mt-3">Browse Now</a>
                </div>
                <div class="col-12 col-lg-4 animal-showcase-img">
                    <img src="./images/home/home_cat_square_300_300.jpg" alt="" class="img-fluid shadow rounded-circle ">
                </div>
            </div>
            <div class="row justify-content-center justify-content-lg-between align-items-center" data-aos="fade-right" data-aos-delay="100">
                <div class="col-12 col-lg-7 animal-showcase-text">
                    <h3>Ball of Fur</h3>
                    <p class="lead">These little furballs are literal balls of joy when raised by owners in a loving environment. You'll find it fun to watch and take care of them.</p>
                    <a href="./category.php?category=Hamster" class="btn btn-danger mt-3">Browse Now</a>
                </div>
                <div class="col-12 col-lg-4 animal-showcase-img">
                    <img src="./images/home/home_hamster_square_300_300.jpg" alt="" class="img-fluid shadow rounded-circle ">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Companion Section -->

<!-- Recommendation Section -->
<section class="recommendation">
    <div class="container text-center">
        <h2 class="sub-header-home">Enhance The Relationship</h2>
        <div class="row mt-5 justify-content-xl-between  align-items-center">
            <div class="col-12 col-xl-3 col-md-6 recommendation-indi card-outer">
                <div class="card-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-main-section">
                        <img src="./Images/Dog_Food/CESAR_Dog_Food_Beef_x6_Wet_Food/Card/CESAR_Dog_Food_Beef_x6_Wet_Food_1_Card_319_409.jpg" alt="" class="img-fluid">
                        <div class="card-main-section-icon">
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                </svg>
                            </button>
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="card-content-section">
                        <a href="item.php?category=Dog Food&id=2" class="text-decoration-none text-dark">
                            <h5 class="text-center mt-2 px-2 text-truncate">CESAR Dog Food Beef x6 Dog Tray Dog Wet Food</h5>
                        </a>
                    </div>

                    <div class="card-rating-section text-center">
                        <div class="stars">
                            <?php 
                            $avgRating = getAvgRating(2, $connection);
                            $totalReviews = getTotalProductReviews(2, "Dog Food", $connection);
                            ?>
                            <div class="stars">
                                <?php 
                                if ($totalReviews == 0){
                                    echo ("<small class='align-bottom'>No ratings</small>");  
                                }
                                if ($totalReviews != 0):
                                ?>
                                <?php
                                    $limit = floor($avgRating);
                                    $remainder = fmod($avgRating, $limit);
                                    for($i = 0; $i < $limit; $i++) {
                                        echo ("<img src='./svg/star-fill.svg' alt='Yellow Star'>");
                                    }
                                    if ($remainder >= 0.5){
                                        echo ("<img src='./svg/star-half.svg' alt='Half Star'>");
                                    } elseif ($remainder != 0){
                                        echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                    }
                                    if($avgRating < 4.5){                 
                                        for($i = 0; $i < 5 - ceil($avgRating); $i++){
                                            echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                        }
                                    }
                                ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-price-section text-center">
                        <span>RM 20.50</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-3 col-md-6 recommendation-indi card-outer">
                <div class="card-wrapper" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-main-section">
                        <img src="./Images/Cat_Food/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg/Card/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_1_Card_319_409.jpg" alt="" class="img-fluid">
                        <div class="card-main-section-icon">
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                </svg>
                            </button>
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="card-content-section">
                        <a href="item.php?category=Cat Food&id=25" class="text-decoration-none text-dark">
                            <h5 class="text-center mt-2 px-2 text-truncate">IAMS Cat Dry Food Adult Indoor Weight & Hairball Care Chicken 3kg Cat Food</h5>
                        </a>
                    </div>

                    <div class="card-rating-section text-center">
                        <div class="stars">
                            <?php 
                            $avgRating = getAvgRating(25, $connection);
                            $totalReviews = getTotalProductReviews(25, "Cat Food", $connection);
                            ?>
                            <div class="stars">
                                <?php 
                                if ($totalReviews == 0){
                                    echo ("<small class='align-bottom'>No ratings</small>");  
                                }
                                if ($totalReviews != 0):
                                ?>
                                <?php
                                    $limit = floor($avgRating);
                                    $remainder = fmod($avgRating, $limit);
                                    for($i = 0; $i < $limit; $i++) {
                                        echo ("<img src='./svg/star-fill.svg' alt='Yellow Star'>");
                                    }
                                    if ($remainder >= 0.5){
                                        echo ("<img src='./svg/star-half.svg' alt='Half Star'>");
                                    } elseif ($remainder != 0){
                                        echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                    }
                                    if($avgRating < 4.5){                 
                                        for($i = 0; $i < 5 - ceil($avgRating); $i++){
                                            echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                        }
                                    }
                                ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-price-section text-center">
                        <span>RM 72.90</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-3 col-md-12 recommendation-indi card-outer">
                <div class="card-wrapper" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-main-section">
                        <img src="./Images/Dog_Accessories/Reflective Rope Pet Dog Leash/Card/Leash_Nylon_1_Card_319_409.jpg" alt="" class="img-fluid">
                        <div class="card-main-section-icon">
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                </svg>
                            </button>
                            <button class="btn card-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="card-content-section">
                        <a href="item.php?category=Dog Accessories&id=17" class="text-decoration-none text-dark">
                            <h5 class="text-center mt-2 px-2 text-truncate">Reflective Rope Pet Dog Leash Nylon Traction Rope Running Strap Belt Glow Lead</h5>
                        </a>
                    </div>

                    <div class="card-rating-section text-center">
                    <div class="stars">
                            <?php 
                            $avgRating = getAvgRating(17, $connection);
                            $totalReviews = getTotalProductReviews(17, "Dog Accessories", $connection);
                            ?>
                            <div class="stars">
                                <?php 
                                if ($totalReviews == 0){
                                    echo ("<small class='align-bottom'>No ratings</small>");  
                                }
                                if ($totalReviews != 0):
                                ?>
                                <?php
                                    $limit = floor($avgRating);
                                    $remainder = fmod($avgRating, $limit);
                                    for($i = 0; $i < $limit; $i++) {
                                        echo ("<img src='./svg/star-fill.svg' alt='Yellow Star'>");
                                    }
                                    if ($remainder >= 0.5){
                                        echo ("<img src='./svg/star-half.svg' alt='Half Star'>");
                                    } elseif ($remainder != 0){
                                        echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                    }
                                    if($avgRating < 4.5){                 
                                        for($i = 0; $i < 5 - ceil($avgRating); $i++){
                                            echo ("<img src='./svg/star-fill-white.svg' alt='Gray Star'>");
                                        }
                                    }
                                ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-price-section text-center">
                        <span>MYR 31.90</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=" our-trust py-5">
    <div class="container home-wrapper ">
        <div class="row justify-content-center align-items-start">
            <div class="col-12 col-md-4 text-center our-trust-indi">
                <div class="mb-3 icon headphone"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-headset" viewBox="0 0 16 16">
                        <path d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5z" />
                    </svg></div>
                <div class="our-trust-text">
                    <h5 class="mb-3">24/7 Service</h5>
                    <p>Do not hesitate to contact us if you have any inquries!</p>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center our-trust-indi">
                <div class="mb-3 icon dollar"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#228B22" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                        <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                    </svg></div>
                <div class="our-trust-text">
                    <h5 class="mb-3">Affordable Pricing</h5>
                    <p>Owning a pet isn't cheap. Let us ease your burden with our affordable products</p>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center our-trust-indi">
                <div class="mb-3 icon thumbup"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#FFD700" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                    </svg></div>
                <div class="our-trust-text">
                    <h5 class="mb-3">Certified Branding</h5>
                    <p>Your pets deserve the best!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "./components/footer.php"; ?>
<a href="#" class="to-top">
    <img src="./svg/chevron-up.svg" alt="">
</a>

<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
<script src="./js/to-top.js"></script>
</body>

</html>
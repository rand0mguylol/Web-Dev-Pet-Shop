<?php // require_once "db_review.php"; ?>
<?php
    // $rating = $_POST["star_rating"];
    // $review = $_POST["feedback"];
    ?>

<?php
    // if(isset($_POST["submit"])){
    //     $createdAt = date('Y-m-d H:i:s');
    
    //     $sqlquery = "INSERT INTO review VALUES
    //     (NULL, userId, productId, $rating, $feedback, createdAt)";
    
    //     if ($connection->query($sqlquery) === TRUE) {
    //         echo "Review has been submitted.";
    //     } else {
    //         echo "Error: " . $sql . $connection->error;
    //     }
    // }
    // ?>
<?php // endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1/glider.min.css">
    <link rel="stylesheet" href="./newapp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bitter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Added for Star Rating System -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://kit.fontawesome.com/1c713f6eed.js" crossorigin="anonymous"></script> -->

    <title>Review</title>
</head>

<body>
    <!-- Remove lines until here when completed -->
    <!-- Offcanvas -->
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
                <form action="" class="row g-3 row-cols-1" method="POST">
                    <!-- Star Rating -->
                    <div class="card-rating-section d-inline-block text-center">
                        <p>Rating: </p>
                        <i class="fa fa-star fa-2x" data-index-num="0" style="color: gray"></i>
                        <i class="fa fa-star fa-2x" data-index-num="1" style="color: gray"></i>
                        <i class="fa fa-star fa-2x" data-index-num="2" style="color: gray"></i>
                        <i class="fa fa-star fa-2x" data-index-num="3" style="color: gray"></i>
                        <i class="fa fa-star fa-2x" data-index-num="4" style="color: gray"></i>
                    </div>

                    <!-- WaiYuan's Star Rating Template -->
                    <!-- <div class="card-rating-section text-center">
                        <div class="stars">
                            <img src="./svg/star-fill.svg" alt="">
                            <img src="./svg/star-fill.svg" alt="">
                            <img src="./svg/star-fill.svg" alt="">
                            <img src="./svg/star-fill-white.svg" alt="">
                            <img src="./svg/star-fill-white.svg" alt="">
                        </div>
                    </div> -->

                    <!-- Feedback Textarea -->
                    <div class="col">
                        <label for="feedback" class="form-label">Feedback:</label>
                        <textarea class="form-control" resize="none" id="feedback" name="feedback" rows="5"
                            placeholder="Share your experience with the product and help others make better purchases!"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-warning offcanvas-submit" id="submit_review"
                            name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Button for Review (Cut and Paste in Account page & Specific Product/item.php page's Review Tab) -->
    <button class="btn btn-warning" data-bs-toggle="offcanvas" href="#reviewCanvas" role="button"
        aria-controls="reviewCanvasExample">Review</button>

    <!-- After Submit button for review is clicked, remove button -->

    <?php require_once "script_links.php"; ?>
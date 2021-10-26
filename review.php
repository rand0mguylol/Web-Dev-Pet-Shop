<?php

session_start();

if (isset($_POST["submit"])) {
    require_once "./function/db.php";
    require_once "./function/helpers.php";

    $errorArray = [];
    $userid = $_SESSION["user"]["userID"];
    $productid = 1;

    if ($_POST["rating"] != -1) {
        $rating = $_POST["rating"];
        $rating++;
    } else {
        array_push($errorArray, "ratingErr");
        // $rateError = "Select a rating";
    }

    if (strlen($_POST["feedback"]) <= 50) {
        $feedback = sanitizeText($_POST["feedback"]);
    } else {
        array_push($errorArray, "feedbackErr");
        // $feedbackError = "Feedback must not be over 50 characters long";
    }



    // foreach($newReview as $key => $value){
    //   if($value === false){
    //     array_push($errorArray, $key);
    //   }
    // }

    if (!empty($errorArray)) {
        //   $_SESSION["reviewCreationError"] = $errorArray;   
        //   echo "Validation Error" ;
        //   header("Location:  ./profile.php" );
        //   exit();
    } else {
        $newReview = array(
            "userId" => $userid,
            "productId" => $productid,
            "rating" => $rating,
            "feedback" => $feedback
        );
        createReview($newReview, $connection);
        // $_SESSION["reviewCreation"] = "success";
        echo "Review successfully added";
        header("Location:  ./review.php");
        exit();
    }
}
?>
<?php require_once "header.php"; ?>
<!-- Remove lines until here when completed -->
<div class="container">
    <!-- Button for Review (Cut and Paste in Account page & Specific Product/item.php page's Review Tab) -->
    <div class="">
        <button class="btn btn-warning" data-bs-toggle="offcanvas" href="#reviewCanvas" role="button" aria-controls="reviewCanvasExample">Review</button>
    </div>
</div>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end justify-content-center" tabindex="-1" id="reviewCanvas" aria-labelledby="reviewCanvasLabel">

    <!-- Title & X Button -->
    <div class="offcanvas-header flex-column">
        <button type="button" class="btn-close text-reset align-self-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h2 class="offcanvas-title mt-3" id="offcanvasExampleLabel">REVIEW PRODUCT</h2>
    </div>
    <div class="offcanvas-body mb-5">
        <div>
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
                <?php if (isset($_POST["submit"]) && in_array("ratingErr", $errorArray)) :  ?>
                    <p class="mt-1 text-danger mb-0 text-center">Please select a rating</p>
                <?php else : ?>
                    <p class="mt-1 mb-0"></p>
                <?php endif; ?>

                <!-- Feedback Textarea -->
                <div class="col">
                    <label for="feedback" class="form-label">Feedback:</label>
                    <textarea class="form-control" resize="none" id="feedback" name="feedback" rows="5" placeholder="Share your experience with the product and help others make better purchases!"></textarea>
                </div>
                <?php if (isset($_POST["submit"]) && in_array("feedbackErr", $errorArray)) :  ?>
                    <p class="mt-1 text-danger mb-0 text-center">Feedback must not be over 50 characters long</p>
                <?php else : ?>
                    <p class="mt-1 mb-0"></p>
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-warning offcanvas-submit" id="submit_review" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- After Submit button for review is clicked, remove button -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    let ratedIndex = -1;

    $(document).ready(function() {
        starColorGray();

        $(".fa-star").on("click", function() {
            ratedIndex = parseInt($(this).data("index-num"));
            $("#rating").val(ratedIndex);
        });

        $(".fa-star").mouseover(function() {
            starColorGray();

            let hoverIndex = parseInt($(this).data("index-num"));
            for (let i = 0; i <= hoverIndex; i++)
                $(".fa-star:eq(" + i + ")").css("color", "orange");
        });

        $(".fa-star").mouseleave(function() {
            starColorGray();

            if (ratedIndex != -1)
                for (let i = 0; i <= ratedIndex; i++)
                    $(".fa-star:eq(" + i + ")").css("color", "orange");
        });
    });

    function starColorGray() {
        $(".fa-star").css("color", "gray");
    }
</script>

<?php require_once "script_links.php"; ?>
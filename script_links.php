<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
    integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"
    integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous">
</script>
<script src="./js/script.js"></script>

<!-- Added for Star Rating System -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
let = rateIndex = -1;

$(document).ready(function() {
    // Uncomment this and remove style="color: gray" for stars in review.php
    // starColorGray();

    $(".fa-star").on("click", function() {
        rateIndex = parseInt($(this).data("index-num"))
    });

    $(".fa-star").mouseover(function() {
        starColorGray();

        let hoverIndex = parseInt($(this).data("index-num"));
        for (let i = 0; i <= hoverIndex; i++)
            $(".fa-star:eq(" + i + ")").css("color", "orange");
    });

    $(".fa-star").mouseleave(function() {
        starColorGray();

        if (rateIndex != -1)
            for (let i = 0; i <= rateIndex; i++)
                $(".fa-star:eq(" + i + ")").css("color", "orange");
    });
});

function starColorGray() {
    $(".fa-star").css("color", "gray");
}
</script>

</body>

</html>
let ratedIndex = -1;

$(document).ready(function() {
    starColorGray();
    
    // Set star rating value when star is clicked
    $(".fa-star").on("click", function() {
        ratedIndex = parseInt($(this).data("index-num"));
        $("#rating").val(ratedIndex);
    });

    // Set star color to orange when mouse is hovered over star
    $(".fa-star").mouseover(function() {
        starColorGray();

        let hoverIndex = parseInt($(this).data("index-num"));
        for (let i = 0; i <= hoverIndex; i++)
            $(".fa-star:eq(" + i + ")").css("color", "orange");
    });

    // Set all star colors to gray excpet for the stars equal to clicked star rating
    $(".fa-star").mouseleave(function() {
        starColorGray();

        if (ratedIndex != -1)
            for (let i = 0; i <= ratedIndex; i++)
                $(".fa-star:eq(" + i + ")").css("color", "orange");
    });
});

// Set star color to gray
function starColorGray() {
    $(".fa-star").css("color", "gray");
}
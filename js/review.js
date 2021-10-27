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
const oldTotal = parseFloat($("#totalAmount").text());
    const subtotal = parseFloat($("#subtotal").text());
    var totalInput = $(".payment-total").val(subtotal);
    var deliveryOptions = ["J&T", "PosLaju", "NinjaVan"];
    var deliveryOptionSelector = $("#deliveryOption");
    $(deliveryOptionSelector).change(function() {
        var deliveryOption = deliveryOptionSelector.val();
        if ($.inArray(deliveryOption, deliveryOptions) > -1 && !$(".no-cart-item").text()) {
            if ($(".payment-btn").hasClass("disabled")) {
                $(".payment-btn").removeClass("disabled");
            }
            $("#shippingFee").text("RM15.00");
            $shippingFee = 15;
            var newTotal = subtotal + $shippingFee;
        } else {
            $(".payment-btn").addClass("disabled");
            $("#shippingFee").text("FREE");
            var newTotal = oldTotal;
        }
        $("#totalAmount").text(newTotal.toFixed(2));
        $('.paymentTotal').val(newTotal.toFixed(2));
        $('.orderDelivery').val(deliveryOption);
    })

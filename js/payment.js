function deletePaymentSession() {
    $.post('./controller/session_killer.php', {
        destroyPaymentSession: 1
    });
}

$('.quantity-changer').click(function(e) {
    e.preventDefault();
    var targetData = $(this).attr('data-field');
    var operation = $(this).attr('data-type');
    var price = parseFloat($("input[name='" + targetData + "[price]']").val());
    var QuantityInput = $("input[name='" + targetData + "[quantity]']");
    var oldQuantity = parseInt(QuantityInput.val());
    if (!isNaN(oldQuantity)) {
        if (operation == 'minus') {
            if (oldQuantity > QuantityInput.attr('min')) {
                QuantityInput.val(oldQuantity - 1).change();
                $("button[data-field ='" + targetData + "'][data-type ='plus']").attr('disabled', false);
            }
            if (parseInt(QuantityInput.val()) == QuantityInput.attr('min')) {
                $("button[data-field ='" + targetData + "'][data-type ='minus']").attr('disabled', true);
            }
        } else if (operation == 'plus') {
            if (oldQuantity < QuantityInput.attr('max')) {
                QuantityInput.val(oldQuantity + 1).change();
                $("button[data-field ='" + targetData + "'][data-type ='minus']").attr('disabled', false);
            }
            if (parseInt(QuantityInput.val()) == QuantityInput.attr('max')) {
                $("button[data-field ='" + targetData + "'][data-type ='plus']").attr('disabled', true);
            }
        }
        var updateBtn = $("button[name='quantityUpdateBtn'][data-field ='" + targetData + "']");
        updateBtn.click();
    } else {
        QuantityInput.val(1);
    }
})
$('.quantity-input').change(function() {
    var minQuantity = parseInt($(this).attr('min'));
    var maxQuantity = parseInt($(this).attr('max'));
    var currentQuantity = parseInt($(this).val());
    var name = $(this).attr('name');
    var field = name.split('[quantity]')[0];
    if (currentQuantity > minQuantity) {
        $(".btn-number[data-type='minus'][data-field='" + field + "']").removeAttr('disabled')
    } else {
        $(this).val(min);
    }
    if (currentQuantity < maxQuantity) {
        $(".btn-number[data-type='plus'][data-field='" + field + "']").removeAttr('disabled')
    } else {
        $(this).val(maxQuantity);
    }
    var updateBtn = $("button[name='quantityUpdateBtn'][data-field ='" + field + "']");
    updateBtn.click();
});
$('.quantity-input').keydown(function(e) {
    if (e.keyCode == 13) {
        var updateBtn = $("button[name='quantityUpdateBtn'][data-field ='" + field + "']");
        updateBtn.click();
    }
})

$("#deliveryOption").change(function() {
    var subtotal = parseFloat($("#subtotal").text());
    var deliveryOptions = ["J&T", "PosLaju", "NinjaVan"];
    var deliveryOption = $("#deliveryOption").val();
    if (
        $.inArray(deliveryOption, deliveryOptions) > -1 &&
        !$(".no-cart-item").text()
    ) {
        if ($(".payment-btn").hasClass("disabled")) {
            $(".payment-btn").removeClass("disabled");
        }
        $("#shippingFee").text("RM15.00");
        $shippingFee = 15;
        var newTotal = subtotal + $shippingFee;
    } else {
        $(".payment-btn").addClass("disabled");
        $("#shippingFee").text("FREE");
        var newTotal = subtotal;
    }
    $("#totalAmount").text(newTotal.toFixed(2));
    $(".paymentTotal").val(newTotal.toFixed(2));
    $(".orderDelivery").val(deliveryOption);
}
);

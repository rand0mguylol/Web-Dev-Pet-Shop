<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous">
</script>
<script src="./js/script.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
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
    $(function(){
        <?php if (isset($_POST['bankingPaymentBtn']) || isset($_POST['cardPaymentBtn']) || isset($_SESSION['payment'])): ?>
            $('#modalBtn').click();
        <?php endif ?>
    })
    
</script>
</body>

</html>
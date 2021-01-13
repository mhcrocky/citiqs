
<div style="background:red;text-align: center;" id="header-img" class="w-100" style="text-align:center">


    <div class="form-group has-feedback">
        <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
    </div>

</div>
<?php if (!empty($tickets)) : ?>
<div class="shop__item-list selectedSpotBackground full-height">
    <?php foreach ($tickets as $ticket): ?>
    <div class="shop__single-item">
        <div class="shop__single-item__info">
            <!-- wrapped long description and title -->
            <div>
                <strong
                    class="shop__single-item__info--title productName"><?php echo $ticket['ticketDescription']; ?></strong>
            </div>
        </div>
        <div class="shop__single-item__image">
            <img style="display: none;" src="https://tiqs.com/alfred/assets/images/productImages/2909_1608623878.png"
                alt="<?php echo $ticket['ticketDescription']; ?>">
        </div>
        <!-- ADDED DIV FOR + PRICE - -->
        <div style="min-width: 270px;" class="shop__single-item__cart-wrapper">
            <div class="shop__single-item__price items priceQuantity">
                <span><?php echo $ticket['ticketPrice']; ?></span>
            </div>
            <div class="shop__single-item__quanitity-buttons">
                <div class="shop__single-item__add-to-cart items priceQuantity"
                    onclick="removeOrder('<?php echo $ticket['ticketId']; ?>', '<?php echo $ticket['ticketPrice']; ?>')">
                    <span style="font-size:16px; vertical-align: middle; text-align:center">
                        <i class="fa fa-minus priceQuantity" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="shop__single-item__quiantity">
                    <div class="shop__single-item__add-to-cart items priceQuantity">
                        <span id="orderQuantityValue_<?php echo $ticket['ticketId']; ?>"
                            class="countOrdered priceQuantity" style="font-size:14px;">0</span>
                    </div>
                </div>
                <div class="shop__single-item__add-to-cart items priceQuantity"
                    onclick="addOrder('<?php echo $ticket['ticketId']; ?>', '<?php echo $ticket['ticketQuantity']; ?>', '<?php echo $ticket['ticketPrice']; ?>')">
                    <span style="font-size:16px; vertical-align: middle; text-align:center">
                        <i class="fa fa-plus priceQuantity" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
            <!-- end quantity buttons -->
        </div>
    </div>
    <?php endforeach; ?>
    <div class="bottom-bar footer">
        <div class="container">
            <div class="row">
                <!--				<div class="col-12 col-md-6 text-center text-left-md">-->
                <div class="col-12 text-center text-left-md">
                    <div style="background: red !important;" class="totalButton">
                        <p class="button-main button-secondary bottom-bar__checkout totalButton">TOTAL: <span
                                class="bottom-bar__total-price">€&nbsp;<span class="totalPrice">00.00</span></span> </p>
                        <!-- <button class='button-main button-secondary' onclick="focusCheckOutModal('modal__checkout__list')">Order List</button> -->
                    </div>
                </div>
                <!--				<div class="col-12 col-md-6 text-center text-right-md">-->
                <div style="background: red !important;" class="col-12 text-center text-right-md">
                    <button class="button-main button-secondary bottom-bar__checkout payButton" onclick="checkout(0)"
                        style="width:100%">PAY</button>
                </div>
            </div>
        </div>
    </div>


</div>
<?php endif; ?>

<script>
function removeOrder(id, price) {
    var quantityValue = $("#orderQuantityValue_" + id).text();
    var totalPrice = $(".totalPrice").text()
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    if (quantityValue == 0) {
        return;
    }
    quantityValue--;
    totalPrice = totalPrice - price;
    $("#orderQuantityValue_" + id).text(quantityValue);
    return $(".totalPrice").text(totalPrice.toFixed(2));
}

function addOrder(id, limit, price) {
    var quantityValue = $("#orderQuantityValue_" + id).text();
    var totalPrice = $(".totalPrice").text()
    quantityValue = parseInt(quantityValue);
    totalPrice = parseInt(totalPrice);
    price = parseInt(price);
    limit = parseInt(limit);
    if (quantityValue == limit) {
        return;
    }
    quantityValue++;
    totalPrice = totalPrice + price;
    $("#orderQuantityValue_" + id).text(quantityValue);
    return $(".totalPrice").text(totalPrice.toFixed(2));
}
</script>
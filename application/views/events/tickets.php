<div style="background:red;text-align: center;" id="header-img" class="w-100" style="text-align:center">


    <div class="form-group has-feedback">
        <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250" height="auto" />
    </div>

</div>
<form id="my-form" action="<?php echo base_url(); ?>events/your_tickets" method="POST">
    <?php if (!empty($tickets)) : ?>
    <input type="hidden" id="current_time" name="current_time" value="">
    <div class="shop__item-list selectedSpotBackground full-height">
        <?php foreach ($tickets as $ticket): ?>
        <input type="hidden" id="quantity_<?php echo $ticket['ticketId']; ?>" name="quantity[]" value="0">
        <input type="hidden" name="id[]" value="<?php echo $ticket['ticketId']; ?>">
        <input type="hidden" name="descript[]" value="<?php echo $ticket['ticketDescription']; ?>">
        <input type="hidden" name="price[]" value="<?php echo $ticket['ticketPrice']; ?>">
        <div class="shop__single-item">
            <div class="shop__single-item__info">
                <!-- wrapped long description and title -->
                <div>
                    <strong
                        class="shop__single-item__info--title productName"><?php echo $ticket['ticketDescription']; ?></strong>
                </div>
            </div>
            <div class="shop__single-item__image">
                <img style="display: none;"
                    src="https://tiqs.com/alfred/assets/images/productImages/2909_1608623878.png"
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
                                    class="bottom-bar__total-price">€&nbsp;<span class="totalPrice">00.00</span></span>
                            </p>
                            <!-- <button class='button-main button-secondary' onclick="focusCheckOutModal('modal__checkout__list')">Order List</button> -->
                        </div>
                    </div>
                    <!--				<div class="col-12 col-md-6 text-center text-right-md">-->
                    <div style="background: red !important;" class="col-12 text-center text-right-md">
                        <button id="pay" type="submit"
                            class="button-main button-secondary bottom-bar__checkout payButton"
                            style="width:100%">PAY</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <?php endif; ?>
</form>
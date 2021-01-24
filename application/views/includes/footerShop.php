<!-- MODAL CHECKOUT -->

<!-- MODAL ADDITIONAL OPTIONS -->
<div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="w-100 modal-header text-right">
                <h5 class="modal-title text-left">Your Cart</h5>
                <p class="menu-list__price--discount ml-auto timer"></p>
                <button style="margin-left: 0px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="update-form" action="<?php echo base_url(); ?>booking_events/update_quantity" method="POST">
            <input type="hidden" class="exp_sec" name="exp_sec">
                <?php $total = 0; ?>
                <?php if($this->session->userdata('tickets')): 
                    $tickets = $this->session->userdata('tickets'); ?>
                <div class="menu-list">
                    <?php foreach($tickets as $ticket): 
                        $total = $total + floatval($ticket['amount']); ?>
                        <input type="hidden" id="quantity_<?php echo $ticket['id']; ?>" name="quantity[]" value="0">
                    <input type="hidden" name="id[]" value="<?php echo $ticket['id']; ?>">
                    <input type="hidden" name="descript[]" value="<?php echo $ticket['descript']; ?>">
                    <input type="hidden" name="price[]" value="<?php echo $ticket['price']; ?>">
                    <div id="ticket_<?php echo $ticket['id']; ?>" class="menu-list__item">
                        <div class="menu-list__name">
                            <b class="menu-list__title">Description</b>
                            <div>
                                <p class="menu-list__ingredients"><?php echo $ticket['descript']; ?></p>
                            </div>
                        </div>
                        <div class="menu-list__left-col ml-auto">
                            <div class="menu-list__price mx-auto">
                                <b class="menu-list__price--discount mx-auto"><?php echo $ticket['price']; ?>€</b>
                            </div>
                            <div class="quantity-section mx-auto mb-2">
                                <button class="quantity-button"
                                    onclick="removeTicket('<?php echo $ticket['id']; ?>','<?php echo $ticket['price']; ?>')">-</button>
                                <input id="ticketQuantityValue_<?php echo $ticket['id']; ?>" type="text"
                                    value="<?php echo $ticket['quantity']; ?>" placeholder="0"
									onfocus="clearTotal(this, '<?php echo $ticket['price']; ?>')"
									onblur="ticketQuantity(this,'<?php echo $ticket['id']; ?>', '<?php echo $ticket['price']; ?>')"
                                    onchange="ticketQuantity(this,'<?php echo $ticket['id']; ?>', '<?php echo $ticket['price']; ?>')"
                                    oninput="absVal(this);" placeholder="0" class="quantity-input">
                                <button type="button" class="quantity-button"
                                    onclick="addTicket('<?php echo $ticket['id']; ?>', '50', '<?php echo $ticket['price']; ?>')">+</button>
                            </div>
                            <b class="menu-list__type mx-auto">
                                <button onclick="deleteTicket('<?php echo $ticket['id']; ?>')" type="button" class="btn btn-danger bg-light color-secondary">
                                    <i class="fa fa-trash mr-2" aria-hidden="true"></i>
                                    Delete</button>
                            </b>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- end menu list item -->
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <div class="checkout-modal-sum">
                    <h4 class='mb-0 total'>TOTAL:
                        <span class='ml-2 color-secondary font-weight-bold totalPrice'>
                            <?php echo number_format($total, 2, '.', ''); ?>
                        </span>€
                    </h4>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary bg-primary mr-1">Save</button>
                    <a <?php if(!$this->session->userdata('tickets')){ echo 'href="#"';} ?> href="<?php echo base_url(); ?>events/pay" class="btn btn-secondary bg-secondary">Go to Pay</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<!-- SECTION ORDER -->
<section class="order-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 px-0 d-flex flex-column banner__cta">
                <h6 class='py-3 px-4 px-md-4 font-weight-bold text-uppercase color-secondary'>Order by Phone</h6>
                <div
                    class='px-4 py-5 rounded-right d-flex align-items-left justify-content-center flex-grow-1 flex-column'>
                    <a href="tel:" class='text-white font-weight-bold py-3 d-block'>999-999-999</a>
                </div>
            </div>
            <!-- end col -->
            <div class="col-12 col-md-9 px-0 pr-0 d-flex flex-column text-left mt-4 mt-md-0">
                <h6 class='py-3 px-4 px-md-5 font-weight-bold text-muted text-uppercase'>Don't miss out</h6>
                <div
                    class='order-section__latest py-5 px-4 px-md-5 d-flex align-items-left justify-content-center flex-grow-1 flex-column'>
                    <h4 class='font-weight-bold'>Lorem Ipsum</h4>
                    <p class='latest__exceprtion'><span class='latest__meta'>December 12, 2020</span>Excepteur sint
                        occaecat cupidatat non proident, sunt in culpa ut aliquid ex ea commodi consequatur? Quis
                        autem vel eum iure reprehenderit qui in ea voluptate.</p>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>
</section>
<!-- END SECTION ORDER -->

<footer class='footer bg-light-gray'>
    <div class="container text-center">
        <div class="row footer__row">
            <div class="col-12 col-md-6 text-center">
                TIQS <?php echo date('Y'); ?>, All rights reserved
            </div>
        </div>

    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/eventShop.js"></script>
<script>

</script>


<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<?php //include_once FCPATH . 'application/views/includes/customJs.php'; ?>

</body>

</html>
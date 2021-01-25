<!-- BANNER SECTION -->

<?php if($this->session->tempdata('tickets')):
        $tickets = $this->session->tempdata('tickets'); ?>

<section class="mt-5">
    <div class="container">
        <div class="row row-menu">
            <div class="col-12 col-md-4">
                <h2 class="color-primary mb-5"></h2>
                <ul class="items-gallery">
                    <li>
                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $this->session->userdata('eventImage'); ?>"
                            alt="">
                    </li>
                </ul>
            </div>
            <!-- end col -->
            <input type="hidden" class="current_time" name="current_time">
            <div class="col-12 col-md-8 pl-md-5">
                <h4 class="color-primary font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4">
                    <?php echo $this->session->userdata('event_date'); ?></h4>
                <?php if (!empty($tickets)) : ?>
                <div class="menu-list">
                    <?php foreach ($tickets as $ticket): ?>
                    <div class="menu-list__item ticket_<?php echo $ticket['id']; ?>">
                        <div class="menu-list__name">

                            <div>
                                <p class="menu-list__ingredients">Description: <?php echo $ticket['descript']; ?></p>
                                <p class="menu-list__ingredients">Quantity: <?php echo $ticket['quantity']; ?></p>
                                <p class="menu-list__ingredients">Amount:
                                    €<?php echo number_format($ticket['amount'], 2, '.', ''); ?></p>
                            </div>
                        </div>

                    </div>
                    <?php endforeach; ?>
                    <!-- end menu list item -->
                    <div class="w-100 quantity-section text-right">
                        <div class="w-100 text-right">
                            <a href="<?php echo base_url(); ?>events/pay"
                                class="btn btn-danger btn-lg bg-danger px-3 px-md-4 text-center"><span
                                    class="d-lg-inline">NEXT</span></a>
                        </div>
                    </div>

                </div>
                <?php endif; ?>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
</section>
<?php endif; ?>
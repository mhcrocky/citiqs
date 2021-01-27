<form id="my-form" action="<?php echo base_url(); ?>events/your_tickets" method="POST">
    <section id="tickets">
        <div class="container">
            <div class="row row-menu">
                <div class="col-12 col-md-4">
                    <h2 class="color-primary mb-5"><?php echo $eventName; ?></h2>
                    <ul class="items-gallery">
                        <li>
                            <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $eventImage; ?>" alt="">
                        </li>
                    </ul>
                </div>
                <!-- end col -->
                <input type="hidden" class="current_time" name="current_time">
                <div class="col-12 col-md-8 pl-md-5">
                    <h4 class="font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4">Tickets</h4>
                    <?php if (!empty($tickets)) : ?>
                    <div class="menu-list">
                        <?php 
                        $checkout_tickets = [];
                        if($this->session->tempdata('tickets')){
                            $checkout_tickets = array_values(array_keys($this->session->tempdata('tickets')));
                        }
                         foreach ($tickets as $ticket): 
                              $ticketId = $ticket['ticketId'];
                              if(in_array($ticketId,$checkout_tickets)){ continue; } ?>
                        <input type="hidden" id="quantity_<?php echo $ticketId; ?>" name="quantity[]" value="0">
                        <input type="hidden" name="id[]" value="<?php echo $ticketId; ?>">
                        <input type="hidden" name="descript[]" value="<?php echo $ticket['ticketDescription']; ?>">
                        <input type="hidden" name="price[]" value="<?php echo $ticket['ticketPrice']; ?>">
                        <div class="menu-list__item">
                            <div class="menu-list__name">
                                <b class="menu-list__title">Description</b>
                                <div>
                                    <p class="menu-list__ingredients descript_<?php echo $ticketId; ?>">
                                        <?php echo $ticket['ticketDescription']; ?></p>
                                </div>
                            </div>
                            <div class="menu-list__right-col ml-auto">
                                <div class="menu-list__price">
                                    <b class="menu-list__price--discount"><?php echo $ticket['ticketPrice']; ?>€</b>
                                </div>
                                <b class="menu-list__type">quantity</b>
                                <div class="quantity-section">
                                    <button type="button" class="quantity-button"
                                        onclick="removeTicket('<?php echo $ticketId; ?>','<?php echo $ticket['ticketPrice']; ?>','totalBasket')">-</button>
                                    <input type="number" min="1" id="ticketQuantityValue_<?php echo $ticketId; ?>" value="0"
                                        onkeyup="absVal(this);" placeholder="0" class="quantity-input" disabled>
                                    <button type="button" class="quantity-button"
                                        onclick="addTicket('<?php echo $ticketId; ?>', '<?php echo $ticket['ticketQuantity']; ?>', '<?php echo $ticket['ticketPrice']; ?>','totalBasket')">+</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!-- end menu list item -->


                    </div>
                    <?php endif; ?>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->


        </div>
    </section>
</form>
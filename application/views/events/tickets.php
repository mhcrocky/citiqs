<form id="my-form" action="<?php echo base_url(); ?>events/your_tickets" method="POST">
    <section id="tickets">
        <div class="container">
            <div class="row row-menu">
                <div class="col-12 col-md-4">
                    <h2 id="selected_event_text" class="color-primary mb-5 selected_event_text"><?php echo $eventName; ?></h2>
                    <ul class="items-gallery">
                        <li>
                            <img 
                            <?php if($eventImage == ''): ?>
                            src="<?php echo base_url(); ?>assets/home/images/logo1.png"
                            <?php else: ?>
                            src="<?php echo base_url(); ?>assets/images/events/<?php echo $eventImage; ?>"
                            <?php endif; ?>
                            alt="<?php echo $eventName; ?>">
                        </li>
                    </ul>
                </div>
                <!-- end col -->
                <input type="hidden" class="current_time" name="current_time">
                <div class="col-12 col-md-8 pl-md-5">
                    <h4 class="font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4"><?php echo ucfirst($eventTitle); ?></h4>
                    <p class="text-dark mb-5" style="font-size: 15px;">
                        <strong><?php echo $eventDescription; ?></strong>
                    </p>
                    <?php if (!empty($tickets)) : ?>
                    <div class="menu-list">
                        <?php 
                        $checkout_tickets_id = array_values(array_keys($checkout_tickets));
                         foreach ($tickets as $ticket): 
                              $ticketId = $ticket['ticketId'];
                         ?>
                        <div class="menu-list__item">

                            <div class="menu-list__name">
                                <b class="menu-list__title"><?php echo ($ticket['descriptionTitle'] == null) ? 'description' : $ticket['descriptionTitle']; ?></b>
                                <div>
                                    <p class="menu-list__ingredients">
                                        <?php echo $ticket['ticketDescription']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="menu-list__right-col menu-list_right-col ml-auto ">
                                <?php if($ticket['soldOut']): ?>
                                    <div class="menu-list__price">
                                    <b class="menu-list__price--discount">&nbsp</b>
                                </div>
                                <b class="menu-list__type text-danger">&nbsp</b>

                                <div class="quantity-section text-danger">
                                    &nbsp
                                </div>

                                <b class="menu-list__price--discount excluding_fee excluding_fee_text text-danger"><?php echo ($ticket['soldOutWhenExpired'] == '') ? $this->language->tLine('SOLD OUT') : $this->language->tLine($ticket['soldOutWhenExpired']); ?></b>
                                <?php else: ?>
                                <div class="menu-list__price">
                                    <b class="menu-list__price--discount ticket_price"><?php echo $ticket['ticketPrice']; ?>€</b>
                                </div>
                                <b class="menu-list__type"><?php echo $this->language->tline('quantity'); ?></b>

                                <div class="quantity-section">
                                    
                                    <button type="button" class="quantity-button"
                                        onclick="removeTicket('<?php echo $ticketId; ?>','<?php echo $ticket['ticketPrice']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket')">-</button>
                                    <input type="number" min="1" 
                                        data-bundlemax="<?php echo $ticket['bundleMax']; ?>"
                                        data-groupid="<?php echo $ticket['ticketGroupId']; ?>"
                                        data-available="<?php echo $ticket['ticketAvailable']; ?>"
                                        data-maxbooking="<?php echo $ticket['maxBooking']; ?>"
                                        <?php if(in_array($ticketId,$checkout_tickets_id)){?>
                                        value="<?php echo $checkout_tickets[$ticketId]['quantity']; ?>"
                                        <?php } else { ?> 
                                        value="0"  
                                        <?php } ?> 
                                        onkeyup="absVal(this);" placeholder="0"
                                        id="ticketQuantityValue_<?php echo $ticketId; ?>"
                                        class="quantity-input quantity-input_<?php echo $ticket['ticketGroupId']; ?> ticketQuantityValue_<?php echo $ticketId; ?>" disabled>
                                    <button type="button" class="quantity-button"
                                    
                                        onclick="addTicket('<?php echo $ticketId; ?>', '<?php echo $ticket['ticketAvailable']; ?>', '<?php echo $ticket['ticketPrice']; ?>', '<?php echo $ticket['ticketFee']; ?>','totalBasket', '<?php echo $ticket['bundleMax']; ?>')">+</button>
                                </div>
                                <?php if(!$vendor_cost_paid): ?>
                                <b style="font-size: min(1.2vw, 14px);" class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee €<?php echo number_format($ticket['ticketFee'], 2, ',', ''); ?> and min pay fee €0,50</b>
                                <?php else: ?>
                                <b style="font-size: min(1.2vw, 14px);" class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee €<?php echo number_format($ticket['ticketFee'], 2, ',', ''); ?> </b>
                                <?php endif; ?>
                                <?php endif; ?>
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

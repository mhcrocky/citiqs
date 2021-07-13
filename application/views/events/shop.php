<!-- HERO SECTION -->

<input type="hidden" id="shop" value="shop">

<?php if(isset($closedShopMessage)):?>

<div style="height: calc(100% - 330px)" class="container d-flex align-items-center justify-content-center">
    <?php echo $closedShopMessage; ?>
</div>


<?php endif; ?>



<?php if(count($events) > 1 || (isset($events[0]) && $events[0]['showBackgroundImage'] == 1)): ?>
<!-- HERO SECTION -->
<section id="main-content" class="hero-section position-relative <?php if(count($events) == 1){ ?> pb-0 pt-2 <?php } ?>"
    <?php if(isset($closedShopMessage)){?> style="display:none" <?php } ?>>
    <div <?php if(isset($events[0])) { ?> style="clip-path: none !important;width: 100%;max-width: 65%; height: auto !important;
    <?php if(isset($events[0]) ){ ?> visibility: hidden; <?php } ?>" <?php } ?>
        class="d-none d-md-flex px-0 hero__background">
        <?php if(isset($events[0]) && $events[0]['backgroundImage'] != ''): ?>
        <img id="background-image" style="max-height: 750px;"
            src="<?php echo base_url(); ?>assets/images/events/<?php echo $events[0]['backgroundImage']; ?>" alt="">
        <?php else: ?>
        <img style="max-height: 750px;" id="background-image"
            src="<?php echo base_url(); ?>assets/images/events/default_background.webp" alt="">
        <?php endif; ?>
    </div>

    <!-- end col -->
    <div class="container">
        <!--        <div class="row">-->
        <!--            <div class="col-12 col-md-6">-->
        <!--                <h1 id="event-title" class="event-title">Our Events</h1>-->
        <!--                <p id="event_text_descript" class="text-muted mt-4 mb-5">Get your tickets here.</p>-->
        <!---->
        <!--            </div>-->
        <!-- end col -->
        <!--        </div>-->
        <input type="hidden" id="exp_time" name="exp_time" value="1">
        <!-- end row -->
        <?php if (!empty($events)): ?>

        <div id="events" style="box-shadow: 0 0 70px 30px #00000014;background: #00000014;padding: 0px 0px;"
            class="row single-item__grid <?php if(count($events) == 1){ ?> invisible <?php } ?>">
            <?php foreach ($events as $key => $event): 
                if(!$get_by_event_id && $event['visibleToShop'] == '0'){
                    unset($events[$key]);
                    continue;
                }
                  $event_start =  date_create($event['StartDate'] . " " . $event['StartTime']);
                  $eventDate = date_format($event_start, "d M - H:i");
                  if($key == array_key_first($events)):
            ?>

            <input type="hidden" id="first_element" value="<?php echo $event['id']; ?>">
            <?php endif; ?>
            <h5 class="text-dark mb-4 mt-5 h-div"><?php echo ucwords($event['eventVenue']) .' ' . $eventDate; ?></h5>

            <input type="hidden" id="background_img_<?php echo $event['id']; ?>"
                data-isShowed="<?php echo $event['showBackgroundImage']; ?>"
                data-isSquared="<?php echo $event['isSquared']; ?>" value="<?php echo $event['backgroundImage']; ?>">
            <div style="display: grid !important;" id="event_<?php echo $event['id']; ?>"
                class="col-12 col-sm-6 col-md-3 single-item mb-4 mb-md-0 bg-white p-4 m-2 d-table-cell event-card">
                <a href="#tickets" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                    class="single-item btn-ticket">
                    <div class="single-item__image">
                        <img <?php if($event['eventImage'] == ''): ?> style="object-fit: ;min-height: auto;"
                            src="<?php echo base_url(); ?>assets/home/images/logo1.png" <?php else: ?>
                            src="<?php echo base_url(); ?>assets/images/events/<?php echo $event['eventImage']; ?>"
                            <?php endif; ?> alt="<?php echo $event['eventname']; ?>">
                        <p class='single-item__promotion'>Order Now</p>
                        <p class='single-item__bottom'>
                            <?php echo (date('Y-m-d') == $event['StartDate']) ? $this->language->tLine('TODAY') : date('d/m/Y', strtotime($event['StartDate'])); ?>
                        </p>
                    </div>
                </a>
                <a href="#tickets" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                    class="single-item btn-ticket">
                    <div class="single-item__content">
                        <p class='mb-0'><?php echo $event['eventname']; ?></p>
                        <div class="scroll-descript">
                            <span class='single-item__price'>
                                <?php //echo (strlen($event['eventdescript']) > 57) ? substr($event['eventdescript'], 0, 54) . '...' : $event['eventdescript']; ?>

                            </span>
                        </div>
                    </div>
                </a>
                <div style="align-items: end;background: transparent !important;"
                    class="w-100 mt-4 bg-white pr-4 text-center">
                    <button type="button" onclick="getTicketsView('<?php echo $event['id']; ?>')" class="btn btn-primary mb-1 show-info">
                        <?php echo $this->language->tLine('Go To Shop'); ?>
                    </button>
                </div>
            </div>
            <!-- Button trigger modal -->


            <!-- Modal -->
            <div class="modal fade" id="eventModal<?php echo $event['id']; ?>" tabindex="-1" role="dialog"
                aria-labelledby="eventModal<?php echo $event['id']; ?>Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModal<?php echo $event['id']; ?>Label">
                                <?php echo $event['eventname']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div style="min-height: 100px" class="modal-body">
                            <?php echo $event['eventdescript']; ?>
                        </div>
                        <div class="modal-footer">
                            <button style="border-radius: 0px !important; background: #3b82f6;" type="button"
                                class="btn btn-primary" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                                data-dismiss="modal"><?php echo $this->language->tLine('BOOK NOW'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <!-- end row -->
    </div>
</section>
<!-- END HERO SECTION -->
<?php elseif(isset($events[0])): ?>
<input type="hidden" id="first_element" value="<?php echo $events[0]['id']; ?>">

<input type="hidden" id="background_img_<?php echo $events[0]['id']; ?>"
    data-isShowed="<?php echo $events[0]['showBackgroundImage']; ?>"
    data-isSquared="<?php echo $events[0]['isSquared']; ?>" value="<?php echo $events[0]['backgroundImage']; ?>">

<?php endif; ?>

<?php if(isset($eventTickets)): ?>
<!-- TICKETS -->
<form id="my-form" action="<?php echo base_url(); ?>events/your_tickets" method="POST">
    <section id="tickets">
        <div class="container">
            <div class="row row-menu">
                <div class="col-12 col-md-4">
                    <h2 id="selected_event_text" class="color-primary mb-5 selected_event_text">
                        <?php echo $eventTickets['eventName']; ?></h2>
                    <ul class="items-gallery">
                        <li>
                            <img <?php if($eventTickets['eventImage'] == ''): ?>
                                src="<?php echo base_url(); ?>assets/home/images/logo1.png" <?php else: ?>
                                src="<?php echo base_url(); ?>assets/images/events/<?php echo $eventTickets['eventImage']; ?>"
                                <?php endif; ?> alt="<?php echo $eventTickets['eventName']; ?>">
                        </li>
                    </ul>
                </div>
                <!-- end col -->
                <input type="hidden" class="current_time" name="current_time">
                <div class="col-12 col-md-8 pl-md-5">
                    <h4 class="font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4"><?php echo $eventTickets['eventTitle']; ?></h4>
                    <p class="text-dark mb-5" style="font-size: 15px;">
                        <strong><?php echo $eventTickets['eventDescription']; ?></strong>
                    </p>
                    <?php if (!empty($eventTickets['tickets'])) : ?>
                    <div class="menu-list">
                        <?php 
                        $checkout_tickets = $eventTickets['checkout_tickets'];
                        $tickets = $eventTickets['tickets'];
                        $checkout_tickets_id = array_values(array_keys($checkout_tickets));
                         foreach ($tickets as $ticket): 
                              $ticketId = $ticket['ticketId'];
                         ?>
                        <div class="menu-list__item">

                            <div class="menu-list__name">
                                <b
                                    class="menu-list__title"><?php echo ($ticket['descriptionTitle'] == null) ? 'description' : $ticket['descriptionTitle']; ?></b>
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

									<!--<b class="menu-list__price--discount excluding_fee excluding_fee_text text-danger">--><?php //echo ($ticket['soldOutWhenExpired'] == '') ? $this->language->tLine('SOLD OUT') : $this->language->tLine($ticket['soldOutWhenExpired']); ?><!--</b>-->
									<b class="menu-list__price--discount excluding_fee excluding_fee_text text-danger"><?php echo ($ticket['soldOutWhenExpired'] == '') ? $this->language->tLine('SOLD OUT') : $ticket['soldOutWhenExpired']; ?></b>
                                <?php else: ?>
                                <div class="menu-list__price">
                                    <b
                                        class="menu-list__price--discount ticket_price"><?php echo $ticket['ticketPrice']; ?>€</b>
                                </div>
                                <b class="menu-list__type"><?php echo $this->language->tline('quantity'); ?></b>

                                <div class="quantity-section">

                                    <button type="button" class="quantity-button"
                                        onclick="removeTicket('<?php echo $ticketId; ?>','<?php echo $ticket['ticketPrice']; ?>', '<?php echo $ticket['ticketFee']; ?>', 'totalBasket')">-</button>
                                    <input type="number" min="1" data-bundlemax="<?php echo $ticket['bundleMax']; ?>"
                                        data-groupid="<?php echo $ticket['ticketGroupId']; ?>"
                                        data-available="<?php echo $ticket['ticketAvailable']; ?>"
                                        data-maxbooking="<?php echo $ticket['maxBooking']; ?>"
                                        <?php if(in_array($ticketId,$checkout_tickets_id)){?>
                                        value="<?php echo $checkout_tickets[$ticketId]['quantity']; ?>"
                                        <?php } else { ?> value="0" <?php } ?> onkeyup="absVal(this);" placeholder="0"
                                        id="ticketQuantityValue_<?php echo $ticketId; ?>"
                                        class="quantity-input quantity-input_<?php echo $ticket['ticketGroupId']; ?> ticketQuantityValue_<?php echo $ticketId; ?>"
                                        disabled>
                                    <button type="button" class="quantity-button"
                                        onclick="addTicket('<?php echo $ticketId; ?>', '<?php echo $ticket['ticketAvailable']; ?>', '<?php echo $ticket['ticketPrice']; ?>', '<?php echo $ticket['ticketFee']; ?>','totalBasket', '<?php echo $ticket['bundleMax']; ?>')">+</button>
                                </div>
                                <?php if(!$eventTickets['vendor_cost_paid']): ?>
                                <b style="font-size: min(1.2vw, 14px);"
                                    class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee
                                    €<?php echo number_format($ticket['ticketFee'], 2, ',', ''); ?> and min pay fee
                                    €0,50</b>
                                <?php else: ?>
                                <b style="font-size: min(1.2vw, 14px);"
                                    class="menu-list__price--discount excluding_fee text-dark mt-2">Excluding fee
                                    €<?php echo number_format($ticket['ticketFee'], 2, ',', ''); ?> </b>
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


<button type="button" id="backToTop"></button>

<!-- END TICKETS -->
<?php endif; ?>

<script>
(function() {
    changeTextContent();
}());

var btn = $('#backToTop');

$(window).scroll(function() {
  if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.4) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});


</script>

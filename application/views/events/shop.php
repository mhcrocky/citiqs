<!-- HERO SECTION -->
<?php if($this->session->flashdata('expired')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><?php echo ucfirst($this->session->flashdata('expired')); ?></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<input type="hidden" id="shop" value="shop">

<?php if(isset($closedShopMessage)):?> 

<div style="height: calc(100% - 330px)" class="container d-flex align-items-center justify-content-center">
<?php echo $closedShopMessage; ?>
</div>


<?php endif; ?>



<section id="main-content" class='hero-section position-relative' <?php if(isset($closedShopMessage)){?> style="display:none" <?php } ?> >
    <div <?php if(isset($events[0])) { ?> style="clip-path: none !important;width: 100%;max-width: 65%; height: auto !important;
    <?php if(isset($events[0]) ){ ?> visibility: hidden; <?php } ?>" <?php } ?>
        class="d-none d-md-flex px-0 hero__background">
        <?php if(isset($events[0]) && $events[0]['backgroundImage'] != ''): ?>
        <img id="background-image" style="max-height: 750px;"
            src="<?php echo base_url(); ?>assets/images/events/<?php echo $events[0]['backgroundImage']; ?>" alt="">
        <?php else: ?>
        <img style="max-height: 750px;" id="background-image" src="<?php echo base_url(); ?>assets/images/events/default_background.webp" alt="">
        <?php endif; ?>
    </div>

    <!-- end col -->
    <div class="container"  >
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
            class="row single-item__grid">
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

            <input type="hidden" id="background_img_<?php echo $event['id']; ?>" data-isShowed="<?php echo $event['showBackgroundImage']; ?>"
                data-isSquared="<?php echo $event['isSquared']; ?>" value="<?php echo $event['backgroundImage']; ?>">
            <div style="display: grid !important;" id="event_<?php echo $event['id']; ?>"
                class="col-12 col-sm-6 col-md-3 single-item mb-4 mb-md-0 bg-white p-4 d-table-cell">
                <a href="#tickets" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                    class="single-item btn-ticket">
                    <div class="single-item__image">
                        <img <?php if($event['eventImage'] == ''): ?> style="object-fit: ;min-height: auto;"
                            src="<?php echo base_url(); ?>assets/home/images/logo1.png" <?php else: ?>
                            src="<?php echo base_url(); ?>assets/images/events/<?php echo $event['eventImage']; ?>"
                            <?php endif; ?> alt="<?php echo $event['eventname']; ?>">
                        <p class='single-item__promotion'>Order Now</p>
                        <p class='single-item__bottom'><?php echo (date('Y-m-d') == $event['StartDate']) ? $this->language->tLine('TODAY') : date('d/m/Y', strtotime($event['StartDate'])); ?></p>
                    </div>
                </a>
                <a href="#tickets" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                    class="single-item btn-ticket">
                    <div class="single-item__content">
                        <p class='mb-0'><?php echo $event['eventname']; ?></p>
                        <div class="scroll-descript">
                            <span class='single-item__price'>
                                <?php echo (strlen($event['eventdescript']) > 57) ? substr($event['eventdescript'], 0, 54) . '...' : $event['eventdescript']; ?>
                                
                            </span>
                        </div>
                    </div>
                </a>
                <div style="align-items: end;background: transparent !important;" class="w-100 mt-4 bg-white pr-4 text-center">
                    <button style="background: #60a5fa !important;" type="button" class="btn btn-info mb-1 show-info" data-toggle="modal"
                        data-target="#eventModal<?php echo $event['id']; ?>">
                        <?php echo $this->language->tLine('Show Info'); ?>
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
                            <h5 class="modal-title" id="eventModal<?php echo $event['id']; ?>Label"><?php echo $event['eventname']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div style="min-height: 100px" class="modal-body">
                            <?php echo $event['eventdescript']; ?>
                        </div>
                        <div class="modal-footer">
                            <button style="border-radius: 0px !important; background: #3b82f6;" type="button" class="btn btn-primary" onclick="getTicketsView('<?php echo $event['id']; ?>')" data-dismiss="modal"><?php echo $this->language->tLine('BOOK NOW'); ?></button>
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

<script>
(function() {
    changeTextContent();
}());
</script>
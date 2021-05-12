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
<section id="main-content" class='hero-section position-relative'>
    <div class="d-none d-md-flex col-6 px-0 hero__background">
    <?php if(isset($events[0]) && $events[0]['backgroundImage'] != ''): ?>
        <img id="background-image" src="<?php echo base_url(); ?>assets/images/events/<?php echo $events[0]['backgroundImage']; ?>"
            alt="">
    <?php else: ?>
        <img id="background-image" src="<?php echo base_url(); ?>assets/images/events/default_background.webp"
            alt="">
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
            class="row single-item__grid">
            <?php foreach ($events as $key => $event): 
                  $event_start =  date_create($event['StartDate'] . " " . $event['StartTime']);
                  $eventDate = date_format($event_start, "d M - H:i");
                  if($key == array_key_first($events)):
            ?>
            
            <input type="hidden" id="first_element" value="<?php echo $event['id']; ?>">
            <?php endif; ?>
            <h5 class="text-dark mb-4 mt-5 h-div"><?php echo ucwords($event['eventVenue']) .' ' . $eventDate; ?></h5>
            
            <input type="hidden" id="background_img_<?php echo $event['id']; ?>" value="<?php echo $event['backgroundImage']; ?>">
            <div id="event_<?php echo $event['id']; ?>"
                class="col-12 col-sm-6 col-md-3 single-item mb-4 mb-md-0 bg-white p-4">
                <a href="#tickets" onclick="getTicketsView('<?php echo $event['id']; ?>')"
                    class="single-item btn-ticket">
                    <div class="single-item__image">
                        <img 
                        <?php if($event['eventImage'] == ''): ?>
                        style="object-fit: ;min-height: auto;"
                        src="<?php echo base_url(); ?>assets/home/images/logo1.png"
                        <?php else: ?>
                        src="https://tiqs.com/alfred/assets/images/events/<?php echo $event['eventImage']; ?>"
                        <?php endif; ?>
                        alt="<?php echo $event['eventname']; ?>">
                        <p class='single-item__promotion'>Order Now</p>
                    </div>
                    <div class="single-item__content">
                        <p class='mb-0'><?php echo $event['eventname']; ?></p>
                        <div>
                            <span class='single-item__price'><?php echo $event['eventdescript']; ?></span>
                        </div>
                    </div>
                </a>
            </div>

            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <!-- end row -->
    </div>
</section>
<!-- END HERO SECTION -->

<script>
(function(){
    changeTextContent();
}());
</script>

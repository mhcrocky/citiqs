<!-- HERO SECTION -->
<section class='hero-section position-relative'>
    <div class="d-none d-md-flex col-6 px-0 hero__background">
        <img src="<?php echo base_url(); ?>assets/images/bf82f6956a32819af48c2572243e8286.jpg" alt="">
    </div>

    <?php if($this->session->flashdata('expired')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('expired'); ?>
        </div>
        <?php endif; ?>
    <!-- end col -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1>Our Events</h1>
                <p class='text-muted mt-4 mb-5'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sagittis
                    at est ut facilisis. Suspendisse eu luctus mauris.</p>
                <div class='d-flex flex-column flex-sm-row align-items-start flex-wrap'>
                    <a href="#events" class="btn btn-primary btn-lg bg-primary px-4 mr-sm-3 mt-3">Events</a>
                    <a href="#event" class="btn btn-secondary btn-lg bg-secondary px-4 mt-3">Order Now</a>
                </div>
            </div>
            <!-- end col -->

        </div>
        <!-- end row -->
        <?php if (!empty($events)): ?>
  
        <div id="events" class="row single-item__grid">
        <?php foreach ($events as $event): ?>
            <div class="col-12 col-sm-6 col-md-3 single-item mb-4 mb-md-0">
                <a href="<?php echo base_url(); ?>events/tickets/<?php echo $event['id']; ?>" class='single-item'>
                    <div class="single-item__image">
                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event['eventImage']; ?>" alt="">
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
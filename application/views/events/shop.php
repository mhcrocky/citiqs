<main class="main-wrapper-nh" style="text-align:center;height: auto;">
    <div class="background-apricot-blue height-100 designBackgroundImage" id="selectTypeBody"
        style="width:100vw; height:100vh">

        <div id="img-header" class="form-group has-feedback">
            <img src="<?php echo base_url(); ?>assets/home/images/tiqslogowhite.png" alt="tiqs" width="250"
                height="auto" />
        </div><!-- /.login-logo -->



        <!-- EMXAMPLE HOW TO ADD CSS PROPETY TO ELEMENT IN DESIGN -->
        <h1 style="text-align:center" id="selectTypeH1"><?php //echo $vendor['vendorName'] ?></h1>


        <div class="selectWrapper height-100 mb-35">
            <?php if (!empty($events)): ?>
            <div class="middle">
                <?php foreach ($events as $event): ?>
                <div class="col-md-4 places" style="background-color: none;margin-bottom: 10px !important;">
                    <div class="card mb-4 shadow-sm">
                        <!-- <img src="--><?php //echo $directory['image']; ?>
                        <!--" class="bd-placeholder-img card-img-top" -->

                        <img src="<?php echo base_url(); ?>assets/images/events/<?php echo $event['eventImage']; ?>"
                            class="bd-placeholder-img card-img-top card-img-top-2" height="220px" width="100%"
                            alt="<?php echo $event['eventname']; ?>" />

                        <div class="card-body card-body-2 card-body-color card-b text-center" style="background-color: #0d173b">

                            <p class="pb-2 font-weight-bold text-size" style="font-size: 24px;color: antiquewhite;">
                                <?php echo $event['eventname']; ?></p>
                            <p id="description" class="pb-2 font-weight-bold distance" style="font-size: 24px;color: antiquewhite;">
                                <?php echo $event['eventdescript']; ?></p>
                            <span style="color: antiquewhite;"></span>
                            <div class="social-links align-items-center pt-3">
                                <a class="contact-link"
                                    href="<?php echo base_url(); ?>events/tickets/<?php echo $event['id']; ?>"
                                    >
                                    <button data-brackets-id="2918" type="submit" class="button button-orange">ORDER
                                        HERE</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>

</main>
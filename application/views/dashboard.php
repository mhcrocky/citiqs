<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-suitcase" aria-hidden="true"></i> Lost & Found
        <small>Control panel</small>
      </h1>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3><?php echo 150 ?></h3> <!--- need to put record count here from tlabel  -->
                  <p>My bag-tags & stickers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pricetags"></i>
                </div>

                <a href="<?php echo base_url(); ?>/lostandfoundlist" class="small-box-footer">Lost something go here! <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal-active">
                    <div class="inner">
                        <h3>€ 3.75</h3>
                        <p>For advanced search</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-card"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>/bountyhunt" class="small-box-footer">top up - More info <i class="fa fa-arrow-circle-right"></i></a>

                    <!--                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>23<sup style="font-size: 20px">%</sup></h3>
                  <p>lost</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo base_url(); ?>../start/lostaid" class="small-box-footer">More info to get your stuff found <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                    <h3>77<sup style="font-size: 20px">%</sup></h3>
                  <p>found</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                  <a href="<?php echo base_url(); ?>../start/findaid" class="small-box-footer">Congratulations <i class="fa fa-arrow-circle-right"></i></a>

                  <!--                <a href="--><?php //echo base_url(); ?><!--userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
              </div>
            </div><!-- ./col -->

          </div>
    </section>
</div>

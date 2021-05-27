<div class="main-wrapper" style="text-align:center">
    <div class="col-half  background-orange-light timeline-content">
    <div style="text-align: left">
            <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left" style="font-size:48px; color:white"></i></a>
        </div>
        <form id="checkItem" action="<?php echo $this->baseUrl; ?>booking_agenda/pay?order=<?php echo $orderRandomKey; ?>" method="post"
              >
            <div class="login-box background-orange-light">
                <?php foreach ($reservations as $key => $reservation): ?>
                    <div class="pricing-block-body">
                        <div class="pricing-first" style="font-family: caption-bold">
                            <h2 style="font-family: caption-bold">
                                <?php if ($key == 0): ?>
                                    <?php echo ($this->language->Line("FINAL-0001", "YOUR FIRST RESERVATION")) ? $this->language->Line("FINAL-0001", "YOUR FIRST RESERVATION") : "YOUR FIRST RESERVATION"; ?>
                                <?php else: ?>
                                    <?php echo ($this->language->Line("FINAL-0002", "YOUR NEXT RESERVATION")) ? $this->language->Line("FINAL-0002", "YOUR NEXT RESERVATION") : "YOUR NEXT RESERVATION"; ?>
                                <?php endif; ?>
                            </h2>
                            <img src="<?php echo $this->baseUrl . $logoUrl; ?>" alt="tiqs" width="250" height="auto"/>
                            <p style="font-family: caption-bold"><?php echo $reservation->Spotlabel; ?> </p>
                            <p style="font-family:caption-bold "><?php echo ($this->language->Line("FINAL-0003", "Price")) ? $this->language->Line("FINAL-0003", "Price") : "Price"; ?>
                                € <?php echo $reservation->price; ?></p>
                            <p style="font-family: caption-light"><?php echo ($this->language->Line("FINAL-0004", "FROM")) ? $this->language->Line("FINAL-0004", "FROM") : "FROM"; ?> <?php echo date('H:i', strtotime($reservation->timefrom)); ?></p>
                            <p style="font-family: caption-light"><?php echo ($this->language->Line("FINAL-0005", "TO")) ? $this->language->Line("FINAL-0005", "TO") : "TO" ; ?> <?php echo date('H:i', strtotime($reservation->timeto)); ?></p>
                            <p style="font-family: caption-light"><?php echo ($this->language->Line("FINAL-0006", "MAX NUMBER OF PERSONS")) ? $this->language->Line("FINAL-0006", "MAX NUMBER OF PERSONS") : "MAX NUMBER OF PERSONS"; ?>: <?php echo $reservation->numberofpersons; ?></p>
                        </div>
                    </div><!-- end pricing block body -->
                <?php endforeach; ?>

                <h2 style="font-family: caption-bold"><?php echo ($this->language->Line("FINAL-0007", "NAME")) ? $this->language->Line("FINAL-0007", "NAME") : "NAME"; ?></h2>
                <div class="form-group has-feedback" style="margin-left: 30px;margin-right: 30px;" >
                    <input type="text" id="username" name="username" required class="form-control"
                           style="font-family:'caption-light'; border-radius: 50px;"
                           placeholder="<?php echo ($this->language->Line("FINAL-0009", 'Your Name')) ? $this->language->Line("FINAL-0009", 'Your Name') : 'Your Name'; ?>"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <h2 style="font-family: caption-bold"><?php echo ($this->language->Line("FINAL-0008", "E-MAIL")) ? $this->language->Line("FINAL-0008", "E-MAIL") : "E-MAIL"; ?></h2>
				<div class="form-group has-feedback" style="margin-left: 30px;margin-right: 30px;" >
                    <input type="email" id="email" name="email" required class="form-control"
                           style="font-family:'caption-light'; border-radius: 50px;"
                           placeholder="<?php echo ($this->language->Line("FINAL-0010", "Your E-mail")) ? $this->language->Line("FINAL-0010", "Your E-mail") : "Your E-mail"; ?>"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <h2 style="font-family: caption-bold"><?php echo ($this->language->Line("FINAL-0011", "MOBILE")) ? $this->language->Line("FINAL-0011", "MOBILE") : "MOBILE"; ?></h2>
				<div class="form-group has-feedback" style="margin-left: 30px;margin-right: 30px;" >
                    <input name="mobile" id="mobile" type="tel" class="form-control" minlength="10"
                           style="font-family:'caption-light'; border-radius: 50px;"
                           placeholder="<?php echo ($this->language->Line("FINAL-0012", "Your Phone Number")) ? $this->language->Line("FINAL-0012", "Your Phone Number") : "Your Phone Number"; ?>" required/>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>
                <div class="pricing-first" style="font-family: caption-bold ;margin-left: 30px;margin-right: 30px">
                    <h2 style="font-family: caption-bold"><?php echo ($this->language->Line("FINAL-0013", "THE CONDITIONS")) ? $this->language->Line("FINAL-0013", "THE CONDITIONS") : "THE CONDITIONS"; ?></h2>
                    <p style="font-family: caption-bold"><?php echo ($this->language->Line("FINAL-0013", "BY PAYING YOU EXPRESSLY AGREE TO THE FOLLOWING CONDITIONS")) ? $this->language->Line("FINAL-0013", "BY PAYING YOU EXPRESSLY AGREE TO THE FOLLOWING CONDITIONS") : "BY PAYING YOU EXPRESSLY AGREE TO THE FOLLOWING CONDITIONS"; ?></p>
                    <p style="font-family: caption-light">
                    <?php echo strip_tags($termsofuse->body); ?>
                    </p>
                </div>
                <div class="pricing-block-footer" style="height: 200px">
                    <button data-brackets-id="2918" type="submit"
                            class="button button-orange">
                            <?php echo ($this->language->Line("FINAL-AAA0017", "BOOK NOW")) ? $this->language->Line("FINAL-AAA0017", "BOOK NOW") : "BOOK NOW"; ?>
                    </button>
                </div>
            </div><!-- end pricing block -->
        </form>
    </div>
    <div class="col-half  background-orange timeline-content">

    </div>

</div>
<script>
    $(document).ready(function () {
        if ($(document).width() <= 768) {
            var pricing_details_button = $('.pricing-details-button');
            $('.pricing-details-list').hide();
            $(document).width();
            $(pricing_details_button).click(function () {
                $(this).parents('.pricing-component-body').find('.pricing-details-list').toggle('300');
            })
        }
    })
</script>

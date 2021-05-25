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
        <?php if(isset($agendas[0]) && $agendas[0]->backgroundImage != ''): ?>
        <img id="background-image" class="d-none"
            src="<?php echo base_url(); ?>assets/home/images/<?php echo $agendas[0]->backgroundImage ; ?>" alt="">
        <?php else: ?>
        <img id="background-image" class="d-none" src="<?php echo base_url(); ?>assets/images/events/default_background.webp" alt="">
        <?php endif; ?>

    </div>




    <!-- end col -->
    <div class="w-100">
        <div class="row">
            <div class="col-12 col-md-6">
                <h1 id="event-title" class="event-title"></h1>
                <p id="event_text_descript" class="text-muted mt-4 mb-5"></p>

            </div>
            <!-- end col -->


        </div>
        <div class="container-body mb-5">
            <div class="cal-modal-container">
                <div style="width: 100%" class="cal-modal">
                    <h3>UPCOMING EVENTS</h3>
                    <div id="calendar">
                        <div class="placeholder"></div>
                        <div class="calendar-events"></div>
                    </div>
                </div>
            </div>
        </div>

        
        

        <div class="swiper-container mySwiper d-none">
      <div class="swiper-wrapper">
        <div class="swiper-slide">Slide 1</div>
        <div class="swiper-slide">Slide 2</div>
        <div class="swiper-slide">Slide 3</div>
        <div class="swiper-slide">Slide 4</div>
        <div class="swiper-slide">Slide 5</div>
        <div class="swiper-slide">Slide 6</div>
        <div class="swiper-slide">Slide 7</div>
        <div class="swiper-slide">Slide 8</div>
        <div class="swiper-slide">Slide 9</div>
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
    </div>





        
        <input type="hidden" id="exp_time" name="exp_time" value="1">
        <!-- end row -->


        <?php if (!empty($agendas)): ?>

        <div id="events" style="box-shadow: 0 0 70px 30px #00000014 !important;background: #00000014;padding: 0px 0px;"
            class="row single-item__grid d-none">
            <?php foreach ($agendas as $key => $agenda):
            $date = $agenda->ReservationDateTime;
            $unixTimestamp = strtotime($date);
            $dayOfWeek = date("N", $unixTimestamp);
            $dayOfWeekWords = date("l", $unixTimestamp);
                  if($key == array_key_first($agendas)):
            ?>
            <input type="hidden" id="first_element" value="<?php echo $agenda->id; ?>"
                data-date="<?php echo date('Ymd', strtotime($agenda->ReservationDateTime)); ?>">
            <?php endif; ?>
            <input type="hidden" id="background_img_<?php echo $agenda->id; ?>"
                value="<?php echo $agenda->backgroundImage; ?>">
            <div id="event_<?php echo $agenda->id; ?>"
                class="col-12 col-sm-6 col-md-3 single-item mb-4 mb-md-0 bg-white p-4">
                <a href="#spots"
                    onclick="getSpotsView('<?php echo $agenda->id; ?>', <?php echo date('Ymd', strtotime($agenda->ReservationDateTime)); ?>)"
                    class="single-item btn-ticket">
                    <div class="single-item__image">
                        <img <?php if($dayOfWeek): ?> style="object-fit: ;min-height: auto;"
                            src="<?php echo base_url(); ?>assets/home/images/logo1.png" <?php else: ?>
                            src="<?php echo $this->baseUrl; ?>assets/home/images/<?php echo $dayOfWeek; ?>.png"
                            <?php endif; ?> alt="<?php echo $agenda->ReservationDescription; ?>">
                        <p class='single-item__promotion'>Book Now</p>
                    </div>
                    <div class="single-item__content">
                        <p class='mb-0'><?php echo $agenda->ReservationDescription; ?></p>
                        <div>
                            <span
                                class='single-item__price'><?php echo date("d.m.Y", strtotime($agenda->ReservationDateTime)); ?></span>
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
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
(function() {
    changeTextContent();
    
    
    



}());


</script>


<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>
<script>
// generate events
var agendas  = '<?php echo json_encode($agendas); ?>';
agendas = JSON.parse(agendas);
console.log(agendas);

var eventDates = {};

if(agendas.length > 0){
  $.each(agendas, function(index, agenda) {
    let dateTime = agenda.ReservationDateTime.split(' ');
    let day = dateTime[0];
    eventDates[day] = [
    agenda.id
  ];
  });
}



// set maxDates
var maxDate = {
    1: new Date(new Date().setMonth(new Date().getMonth() + 11)),
    2: new Date(new Date().setMonth(new Date().getMonth() + 10)),
    3: new Date(new Date().setMonth(new Date().getMonth() + 9))
};


var flatpickr = $('#calendar .placeholder').flatpickr({
    inline: true,
    minDate: 'today',
    maxDate: maxDate[3],

    showMonths: 1,
    enable: Object.keys(eventDates),
    disableMobile: "true",
    onChange: function(date, str, inst) {
        let agendaId = '';
        if (date.length) {
            console.log(eventDates[str].length);
            for (i = 0; i < eventDates[str].length; i++) {
                if (typeof window.CP !== 'undefined' && window.CP.shouldStopExecution(0)) break;
                agendaId = eventDates[str][i];
                
                return getSpotsView(agendaId);
            }
        }
    },
    locale: {
        weekdays: {
            shorthand: ["S", "M", "T", "W", "T", "F", "S"],
            longhand: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ]
        }
    }
});





eventCaledarResize($(window));
$(window).on('resize', function() {
    eventCaledarResize($(this));
});

function eventCaledarResize($el) {
    var width = $el.width();
    console.log(width);
    if (flatpickr.selectedDates.length) {
        flatpickr.clear();
    }
    if (width >= 992 && flatpickr.config.showMonths !== 3) {
        flatpickr.set('showMonths', 1);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
    if (width < 992 && width >= 768 && flatpickr.config.showMonths !== 2) {
        flatpickr.set('showMonths', 1);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
    if (width < 768 && flatpickr.config.showMonths !== 1) {
        flatpickr.set('showMonths', 1);
        flatpickr.set('maxDate', maxDate[1]);
        $('.flatpickr-calendar').css('width', '');
    }
}

function formatDate(date) {
    let d = date.getDate();
    let m = date.getMonth() + 1; //Month from 0 to 11
    let y = date.getFullYear();
    return '' + y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
}
</script>
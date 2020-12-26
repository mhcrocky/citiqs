<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/design.css">
<style>
.form-control {
    display: block;
    width: 200px;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600,300);

body {
    font-family: 'Open Sans', sans-serif;
    background-color: #FFFAF6;
}

/*Basic Phone styling*/

.phone {
    border: 40px solid #ddd;
    border-width: 55px 7px;
    border-radius: 40px;
    margin: 50px auto;
    overflow: hidden;
    transition: all 0.5s ease;
}

input[type=color] {
    width: 150px;
}

.phone iframe {
    border: 0;
    width: 100%;
    height: 100%;
}

/*Different Perspectives*/

.phone.view_1 {
    transform: rotateX(50deg) rotateY(0deg) rotateZ(-50deg);
    box-shadow: -3px 3px 0 #BBB, -6px 6px 0 #BBB, -9px 9px 0 #BBB, -12px 12px 0 #BBB, -14px 10px 20px #666;
}

.phone.view_2 {
    transform: rotateX(0deg) rotateY(-60deg) rotateZ(0deg);
    box-shadow: 5px 1px 0 #BBB, 9px 2px 0 #BBB, 12px 3px 0 #BBB, 15px 4px 0 #BBB, 0 7px 20px #999;
}

.phone.view_3 {
    transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);
    box-shadow: 0px 3px 0 #BBB, 0px 4px 0 #BBB, 0px 5px 0 #BBB, 0px 7px 0 #BBB, 0px 10px 20px #666;
}

/*Controls*/

#controls {

    top: 20px;
    left: 20px;
    font-size: 0.9em;
    color: #333;
}

#controls div {
    margin: 10px;
}

#controls div label {
    width: 120px;
    display: block;
    float: left;
}

#views {

    top: 20px;
    right: 20px;
    width: 200px;
}

#views button {
    width: 198px;
    border: 1px solid #bbb;
    background-color: #fff;
    height: 40px;
    margin: 10px 0;
    color: #666;
    transition: all 0.2s;
}

#views button:hover {
    color: #444;
    background-color: #eee;
}

@media (max-width:900px) {
    #wrapper {
        transform: scale(0.8, 0.8);
    }
}

@media (max-width:700px) {
    #wrapper {
        transform: scale(0.6, 0.6);
    }
}

@media (max-width:500px) {
    #wrapper {
        transform: scale(0.4, 0.4);
    }
}

.wrapper {
    margin-top: 200px;
}
</style>
<main class="w-100 container" style="margin-top:20px">


    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#design">Design</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#iframeSettings">Iframe</a>
        </li>
    </ul>
    <div class="tab-content">

        <div id="design" class="container tab-pane active" style="background: none;">
            <div class="row">
                <h3 class="col-lg-12" style="margin:15px 0px">Set booking view style</h3>
                <div class="col-lg-6">
                    <form method="post" id="<?php echo $id; ?>" action="<?php echo base_url(); ?>agenda_booking/savedesign">
                        <?php 
                                include_once FCPATH . 'application/views/new_bookings/design/generalView.php';
                                include_once FCPATH . 'application/views/new_bookings/design/shortUrlView.php';
                                include_once FCPATH . 'application/views/new_bookings/design/spotsView.php';
                                /*
                                
                                include_once FCPATH . 'application/views/new_bookings/design/timeslots.php';
                                include_once FCPATH . 'application/views/new_bookings/design/nextTimeslots.php';
                                include_once FCPATH . 'application/views/new_bookings/design/payment.php';
                                */
                            ?>
                          <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="submit" />
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div style="margin:auto; width:100%;">
                        <!--The Main Thing-->
                        <div id="wrapper">
                            <div class="phone view_3" id="phone_1">
                                <iframe src="https://codepen.io" id="frame_1"></iframe>
                            </div>
                        </div>

                        <!--Controls etc.-->

                    </div>
                </div>
            </div>
        </div>
        <div id="iframeSettings" class="container tab-pane" style="background: none;">
            <?php include_once FCPATH . 'application/views/new_bookings/design/iframeSettings.php'; ?>
        </div>
    </div>


</main>
<script>
/*Only needed for the controls*/
var phone = document.getElementById("phone_1"),
    iframe = document.getElementById("frame_1");

/*View*/
function updateView(view) {
    if (view) {
        phone.className = "phone view_" + view;
    }
}

/*Controls*/
function updateIframe() {
    iframe.src = document.getElementById("iframeURL").value;

    phone.style.width = document.getElementById("iframeWidth").value + "px";
    phone.style.height = document.getElementById("iframeHeight").value + "px";

    /*Idea by /u/aerosole*/
    document.getElementById("wrapper").style.perspective = (
        document.getElementById("iframePerspective").checked ? "1000px" : "none"
    );
}
updateIframe();

/*Events*/
document.getElementById("controls").addEventListener("change", function() {
    updateIframe();
});

document.getElementById("views").addEventListener("click", function(evt) {
    updateView(evt.target.value);
});
</script>
<script>
var designGlobals = (function() {
    let globals = {
        'id': "<?php echo $id; ?>",
        'iframe': '<?php echo $iframeSrc; ?>',
        'iframeId': 'frame_1',
        'showClass': 'showFieldsets',
        'hideClass': 'hideFieldsets',
        'shortUrlView': 'shortUrlView',
        'spotsView': 'spotsView',
        'checkUrl': function(url) {
            if (url.includes('<?php echo $userShortUrl; ?>')) {
                return this['shortUrlView']
            }
            if (url.includes('spots')) {
                return this['spotsView']
            }
            if (url.includes('make_order?vendorid=') && url.includes('&typeid=') && !url.includes(
                    '&spotid=')) {
                return this['selectSpotView']
            }
            if (url.includes('make_order?vendorid=') && !url.includes('&typeid=') && url.includes(
                    '&spotid=')) {
                return this['selectedSpotView']
            }
            if (url.includes('checkout_order?order=')) {
                return this['checkoutOrderView']
            }
            if (url.includes('buyer_details?order=')) {
                return this['buyerDetailsView']
            }
            if (url.includes('pay_order?order=')) {
                return this['payOrderView']
            }
            return false;
        }
    }
    return globals;
}());
console.log(designGlobals.showClass);
</script>
<script src="<?php echo base_url(); ?>assets/cdn/js/jscolor.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/agenda_booking_design.js"></script>
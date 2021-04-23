<?php if ($this->view === 'found') { ?>
<link rel="stylesheet" type="text/css"  href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;; ?>assets/home/styles/hotel-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/found.css" />
<?php } elseif ($this->view === 'map') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/map.css" />
<?php } elseif ($this->view === 'login') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/login.css" />
<?php } elseif ($this->view === 'labels') { ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/flatpickr.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/labels.css">
<?php } elseif ($this->view === 'upload') { ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/upload.css">
<?php } elseif ($this->view === 'foundclaim') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/hotel-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/foundclaim.css">
<?php } elseif ($this->view === 'registerbusiness') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/hotel-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/registerbusiness.css">
<?php } elseif ($this->view === 'check') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/check.css">
<?php } elseif ($this->view === 'profile') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/profile.css">
<link rel="stylesheet" type="text/css"  href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl;; ?>assets/home/styles/hotel-page.css">
<?php } elseif ($this->view === 'employeenew') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/employeenew.css">
<?php } elseif ($this->view === 'appointmentNewView') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/appointmentNewView.css">
<?php } elseif ($this->view === 'claimcheckout' || strpos($this->view, 'claimcheckout') !== false) { ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/timeline-page.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/claimcheckout.css">
<?php } elseif ($this->view === 'contactform') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/contact-page.css" />
<?php } elseif ($this->view === 'userCalimedlisting') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/home/styles/flatpickr.css">
<?php } elseif ($this->view === 'send') { ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<?php } elseif ($this->view === 'sendbags') { ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<?php } elseif ($this->view === 'nolabels') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/nolabaels.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/sliderstyle.css">
<?php } elseif ($this->view === 'nolabelsconsumer') { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/hotel-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/timeline-page.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/nolabaels.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/sliderstyle.css">
<?php } elseif ($this->view === 'publicorders/makeOrder') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<!-- swipe slider -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/slick.css">    
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/slick-theme.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'warehouse/orders') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/sliderstyle.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/orderList.css">
<?php } elseif ($this->view === 'warehouse/warehouse') { ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.datetimepicker.min.css">
<?php } elseif ($this->view === 'warehouse/products') { ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/warehouseProducts.css">
<?php } elseif ($this->view === 'publicorders/checkoutOrder') { ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'publicorders/payOrder') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_theme.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_select2.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_style.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_customTwo.css">
<style>
    /* fix problem with prePaid and posPaid modal */
    .modal-backdrop {
        position: unset
    }
</style>
<?php } elseif ($this->view === 'customer_panel/spots') { ?>
<style>
.file {
    position: relative;
    display: inline-block;
    cursor: pointer;
    height: 2.5rem;
}

.file input {
    min-width: 14rem;
    margin: 0;
    filter: alpha(opacity=0);
    opacity: 0;
}

.file-custom {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: 2.5rem;
    padding: .5rem 1rem;
    line-height: 1.5;
    color: #555;
    background-color: #fff;
    border: .075rem solid #ddd;
    border-radius: .25rem;
    box-shadow: inset 0 .2rem .4rem rgba(0, 0, 0, .05);
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border-radius: 50px;
}

.file-custom:after {
    content: "Choose file...";
}

.file-custom:before {
    position: absolute;
    top: -.075rem;
    right: -.075rem;
    bottom: -.075rem;
    z-index: 6;
    display: block;
    content: "Browse";
    height: 2.5rem;
    padding: .5rem 1rem;
    line-height: 1.5;
    color: #555;
    background-color: #eee;
    border: .075rem solid #ddd;
    border-radius: 0 .25rem .25rem 0;
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
}

/* Focus */
.file input:focus~.file-custom {
    box-shadow: 0 0 0 .075rem #fff, 0 0 0 .2rem #0074d9;
}

.file-custom:after {
    content: attr(data-content);
}
</style>
<?php } elseif ($this->view === 'publicorders/selectSpot') { ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/form-list.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/selectSpot.css">
<?php } elseif ($this->view === 'warehouse/productCategories') { ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
<?php } elseif ($this->view === 'warehouse/spots') { ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<?php } elseif ($this->view === 'check424/selectVendor') { ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/checkin.css">
<?php  } elseif ($this->view === 'check424/registerVisitor') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/checkin.css">
<?php  } elseif ($this->view === 'bizdir/index') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/bizdirstyle.css">
<?php } elseif ($this->view === 'publicorders/selectType') { ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/selectSpot.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/bigsquare.css">
<?php } elseif ($this->view === 'publicorders/makeOrderNew') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/slick.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/slick-theme.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/shop-with-slider.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/order-popup.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/makeOrderUpdate.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/makeOrderItemSlider.css" />
<?php } elseif ($this->view === 'paysuccesslink') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'publicorders/buyerDetails') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'warehouse/design' || $this->view === 'booking/design' || $this->view === 'events/design') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/devices.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/design.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<?php } elseif ($this->view === 'publicorders/closed') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/closed.css">
<?php } elseif ($this->view === 'pos/pos') { ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl; ?>assets/cdn/css/bootstrap3.min.css" />  
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/slick.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/slick-theme.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/slickCss/shop-with-slider.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/order-popup.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">

<!-- <link rel="stylesheet" href="<?php #echo base_url(); ?>assets/home/styles/payorder_custom.css" />  -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_theme.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_select2.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_style.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/payorder_customTwo.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/pos.css">
<style>
    /* fix problem with prePaid and posPaid modal */
    .modal-backdrop {
        position: unset
    }
    body {
        background-color: #fff;
    }
</style>
<?php } elseif (strpos($this->view, 'paysuccesslink/') !== false) { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php }  elseif ($this->view  === 'blackbox/login') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/blackbox.css">
<?php } elseif ($this->view === 'publicorders/temporarilyClosed') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/temporarilyClosed.css">
<?php  } elseif ($this->view === 'voucher/create') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php  } elseif ($this->view === 'events/step-one' || $this->view === 'events/edit_event') { ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/main.jbox.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
<?php } elseif ($this->view === 'events/reports') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/query-builder.default.css" id="qb-theme"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/dashboard.css">
<?php  } elseif ($this->view === 'customer_panel/time_slots') { ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.css" integrity="sha512-2e0Kl/wKgOUm/I722SOPMtmphkIjECJFpJrTRRyL8gjJSJIP2VofmEbqyApMaMfFhU727K3voz0e5EgE3Zf2Dg==" crossorigin="anonymous" />
    <style>
    @font-face { 
     font-family: 'Glyphicons Halflings'; 
     src: url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.eot'); 
     src: url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), 
      url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.woff2') format('woff2'), 
      url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.woff') format('woff'), 
      url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.ttf') format('truetype'), 
      url('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular') format('svg'); } 
   </style>
<?php  } elseif ($this->view === 'pos/pos_login') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/posLogin.css">
<?php  } elseif ($this->view === 'businessreport/index' || $this->view === 'businessreport/reports' || $this->view === 'finance/reports' || $this->view === 'finance/clearing' || $this->view === 'marketing/targeting') { ?>
<?php   if($this->view === 'marketing/targeting'): ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/targetingstyle.css">
<?php endif; ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/query-builder.default.css" id="qb-theme"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/dashboard.css">
    <style>
        td.details-control {
		  background: url("<?php echo base_url('assets/images/datatables/details_open.png') ?>") no-repeat center center;
		  cursor: pointer;
	    }
        
        tr.shown td.details-control {
		  background: url("<?php echo base_url('assets/images/datatables/details_close.png') ?>") no-repeat center center;
        }
    </style> 
<?php  } elseif ($this->view === 'events/step-two') { ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <link href="<?php echo base_url();?>assets/css/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/file-uploader.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">
    <link href='https://css.gg/user-list.css' rel='stylesheet'>
<?php  } elseif ($this->view === 'events/events') { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/query-builder.default.css" id="qb-theme"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/dashboard.css">
    <link href='https://css.gg/arrow-right-r.css' rel='stylesheet'>
	<link href='https://css.gg/user-list.css' rel='stylesheet'>
	<link href='https://css.gg/pen.css' rel='stylesheet'>
    <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0px !important;
    }
    input[type="search"]{
        width: auto !important;
    }
    tr td {
        text-align: left !important;
        vertical-align: middle !important;
    }
    .dataTables_empty {
        text-align: center !important; 
    }

    .btn-success, .btn-primary, .btn-danger{
        border-radius: 0px !important;
    }

    </style>
    <?php  } elseif ($this->view === 'video/index') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.min.css">
<?php  } elseif ($this->view === 'events/shop' || $this->view === 'events/tickets' || $this->view === 'booking_agenda/shop') { ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/pay-main.css" />
    <style> 
    @media only screen and (min-width: 500px) {
        .login100-form {
            padding: 43px 10px 100px 100px !important;
        }
    }
    </style>
<?php  } elseif ($this->view === 'events/selectpayment') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/select-pay.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/pay-main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style> 
    .header__checkout{
		position: sticky;
		position: fixed;
		right: 0;
		top: 10px;
		z-index: 99999;
	}
	
	.header__checkout span{
		display: none !important;
	}
</style>
<?php  } elseif ($this->view === 'bookings/select_payment_type' || $this->view === 'new_bookings/select_payment_type' || $this->view === 'booking_agenda/select_payment_type') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/select-pay.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/pay-main.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style> 
    .header__checkout{
		position: sticky;
		position: fixed;
		right: 0;
		top: 10px;
		z-index: 99999;
	}
	
	.header__checkout span{
		display: none !important;
	}

    .text-center.yellow {
        font-size: 24px !important;
    }
</style>
<?php  } elseif ($this->view === 'events/pay') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/pay-main.css" />
<?php  } elseif ($this->view === 'email_designer') { ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emaildesigner/css/colpick.css" rel="stylesheet"  type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/emaildesigner/css/themes/default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/emaildesigner/css/template.editor.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/emaildesigner/css/responsive-table.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">
    <style>
    body {
        margin-left: 0px;
        padding-top: 0px;
    }
    </style>
<?php } elseif ($this->view === 'marketing/selection') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
    <style> div.dataTables_wrapper div.dataTables_length select { width: 76px !important; } </style>
<?php  } elseif ($this->view === 'new_bookings/agenda_booking_design') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/home/styles/design.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/home/styles/agenda_booking_design.css"/>
<?php  } elseif ($this->view === 'new_bookings/spots_booking') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/css/card-style.css">
<?php  } elseif ($this->view === 'new_bookings/index') { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/home/styles/agendaCalendar.css">
<?php } elseif ($this->view === 'templates/listTemplates') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<?php  } elseif ($this->view === 'voucher/index') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/file-uploader.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<?php } elseif ($this->view === 'templates/addTemplate') { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">

<?php } elseif ($this->view === 'templates/updateTemplate') { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">
<?php } elseif ($this->view === 'voucher/templates/updateTemplate') { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/tiny_a4_format.css">

<?php  } elseif ($this->view === 'voucher/send') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<?php  } elseif ($this->view === 'customer_panel/manual_reservations') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<?php  } elseif ($this->view === 'events/guestlist') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/file-uploader.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<?php  } elseif ($this->view === 'qrcodeview/index') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/events.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<?php  } elseif ($this->view === 'translation-table') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<?php  } elseif ($this->view === 'events/index') { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/query-builder.default.css" id="qb-theme"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/dashboard.css">
<?php } elseif ($this->view === 'businessreport/paymentMethods') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<?php }  elseif ($this->view === 'ladnigPages/template') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/landingPages.css" />
<?php } elseif ($this->view === 'publicorders/makeOrder2021') { ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/slickCss/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/slickCss/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/slickCss/shop-with-slider.css"/>
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/styles/order-popup.css"/>
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/styles/makeOrderUpdate.css" />
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/styles/makeOrderItemSlider.css" />
    -->
    <link rel="stylesheet" type="text/css" href="<?php #echo base_url() ?>assets/home/styles/makeOrder2021.css" />
<?php } elseif('events/financial_report'){ ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/query-builder.default.css" id="qb-theme"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/dashboard.css">
    
<?php } ?>

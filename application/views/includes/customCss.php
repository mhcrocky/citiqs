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
<?php } elseif ($this->view === 'paysuccesslink') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'publicorders/buyerDetails') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/makeOrder.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/slickCss/custom.css">
<?php } elseif ($this->view === 'warehouse/design' || $this->view === 'booking/design') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/design.css">
<style>
    .form-control {
        display: block;
        width: 100%;
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
    }
</style>
<?php } elseif ($this->view === 'publicorders/closed') { ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/closed.css">
<?php } elseif ($this->view === 'pos/pos') { ?>
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
<?php  } elseif ($this->view === 'pos/pos_login') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/styles/posLogin.css">
<?php  } elseif ($this->view === 'businessreport/index' || $this->view === 'businessreport/reports' || $this->view === 'marketing/reports') { ?>
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
<?php } ?>

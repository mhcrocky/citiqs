<script src="<?php echo $this->baseUrl; ?>assets/home/js/utility.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/ajax.js"></script>
<?php if ($this->view === 'labels') { ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/labels.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/flatpickr.js"></script>
<?php } elseif ($this->view === 'home') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/slider.js"></script>
<?php } elseif ($this->view === 'homenew') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/slider.js"></script>
<?php } elseif ($this->view === 'found') { ?>
<script src="https://player.vimeo.com/api/player.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/found.js"></script>
<?php } elseif ($this->view === 'map') { ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI" async defer></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/map.js"></script>
<?php } elseif ($this->view === 'upload') { ?>
<?php } elseif ($this->view === 'foundclaim') { ?>
<script src="https://player.vimeo.com/api/player.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/foundclaim.js"></script>
<?php } elseif ($this->view === 'registerbusiness') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/registerbusiness.js"></script>
<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
<?php } elseif ($this->view === 'check') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/check.js"></script>
<?php } elseif ($this->view === 'profile') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/editUser.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/profile.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/found.js"></script>
<?php } elseif ($this->view === 'employeenew') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/employeenew.js"></script>
<?php } elseif ($this->view === 'appointmentNewView') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/appointmentNewView.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<?php } elseif ($this->view === 'claimcheckout' || strpos($this->view, 'claimcheckout') !== false) { ?>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/common.js" charset="utf-8"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/claimcheckout.js"></script>
<?php } elseif ($this->view === 'userCalimedlisting') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/flatpickr.js"></script>
<?php } elseif ($this->view === 'send') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/send.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<?php } elseif ($this->view === 'sendbags') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/send.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<?php } elseif ($this->view === 'pay') { ?>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/pay.js"></script>
<?php } elseif ($this->view === 'nolabels') { ?>
	<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/nolabels.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/slidertogo.js"></script>
<?php } elseif ($this->view === 'nolabelsconsumer') { ?>
	<script src='https://www.google.com/recaptcha/api.js' async defer ></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/nolabels.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/slidertogo.js"></script>
<?php } elseif ($this->view === 'warehouse/productCategories') { ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/productCategories.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>    
<?php } elseif ($this->view === 'warehouse/products') { ?>	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/jquery.datetimepicker.full.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/products.js"></script>
<?php } elseif ($this->view === 'publicorders/makeOrder') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/makeOrder.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/slick.js"></script>
<?php }  elseif ($this->view === 'warehouse/orders') { ?>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/slidertogo.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/orders.js"></script>
<?php } elseif ($this->view === 'warehouse/printers') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/printers.js"></script>
<?php } elseif ($this->view === 'warehouse/spots') { ?>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/spot.js"></script>
<?php } elseif ($this->view === 'warehouse/warehouse') {?>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/jquery.datetimepicker.full.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/reports.js"></script>
<?php } elseif ($this->view === 'publicorders/checkoutOrder') { ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>	
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/checkoutOrder.js"></script>
<?php } elseif ($this->view === 'warehouse/productTypes') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<?php } elseif ($this->view === 'publicorders/selectSpot') { ?>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/selectSpot.js"></script>
<?php } elseif ($this->view === 'check424/selectVendor') { ?>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/selectVendor.js"></script>
<?php } elseif ($this->view === 'publicorders/selectType') { ?>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/selectSpot.js"></script>
<?php } elseif ($this->view === 'publicorders/makeOrderNew') { ?>
	<script src="<?php echo $this->baseUrl ?>assets/home/slickJs/slick.min.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/makeOrderFunctions.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/makeOrderNew.js"></script>
<?php } elseif ($this->view === 'publicorders/payOrder') { ?>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/payOrderNew.js"></script>
<?php } elseif ($this->view === 'publicorders/buyerDetails') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/checkoutOrder.js"></script>
<?php } elseif ($this->view === 'bizdir/index') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/places.js"></script>
<?php } elseif ($this->view === 'warehouse/design') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jscolor.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/design.js"></script>
<?php } elseif ($this->view === 'pos/pos') { ?>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-url-hash@latest/dist/js/splide-extension-url-hash.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplan.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplanShow.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/manageFloorPlan.js"></script>

	<script src="<?php echo $this->baseUrl ?>assets/home/js/makeOrderFunctions.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/posWrapper.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/posSplide.js"></script>
	<?php if(!empty($posCheckoutOrder) || !empty($posBuyerDetails)) { ?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/checkoutOrder.js"></script>
	<?php } ?>
	<?php if (!empty($posPay)) { ?>	
		<script src="<?php echo $this->baseUrl ?>assets/home/js/payOrderNew.js"></script>
	<?php }	?>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/posPinCode.js"></script>
<?php } elseif ($this->view === 'profile/openandclose') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/editUser.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/profile.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/found.js"></script>
<?php } elseif ($this->view === 'profile/resetTimes') { ?>
<!--	<script src="--><?php //echo $this->baseUrl; ?><!--assets/home/js/editUser.js"></script>-->
<!--	<script src="--><?php //echo $this->baseUrl; ?><!--assets/home/js/profile.js"></script>-->
<!--	<script src="--><?php //echo $this->baseUrl; ?><!--assets/home/js/found.js"></script>-->
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/resetTimes.js"></script>
<?php } elseif ($this->view === 'events/step-one' || $this->view === 'events/edit_event') { ?>
    <script src="<?php echo $this->baseUrl; ?>assets/js/quill.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/main.jbox.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/js/jbox.min.js"></script>
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/events.js"></script>
	<!--
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI&callback=initAutocomplete&libraries=places&v=weekly" async></script>
	<script src="<?php //echo $this->baseUrl; ?>assets/home/js/googleAddressAutocomplete.js"></script>
	-->
<?php } elseif ($this->view === 'businessreport/index') { ?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/dashboard.js"></script>
	<script src="https://www.google.com/jsapi"></script>
<?php } elseif ($this->view === 'businessreport/reports') { ?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/dashboardDataTable.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/businessReports.js"></script>
<?php } elseif ($this->view === 'events/step-two') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jscolor.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/quill.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/events.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
	<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/import_guestlist.js"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/templates.js'></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/ticketsDataTable.js"></script>
<?php } elseif ($this->view === 'events/events') { ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/eventsDataTable.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript"  src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/eventsReportDataTable.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
	<script src="https://mpryvkin.github.io/jquery-datatables-row-reordering/1.2.2/jquery.dataTables.rowReordering.js"></script>

<?php } elseif ($this->view === 'finance/clearing') { ?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script type="text/javascript"  src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/home/js/clearingDataTable.js"></script>
<?php } elseif ($this->view === 'finance/reports') { ?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script type="text/javascript"  src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/home/js/financeDataTable.js"></script>
<?php } elseif ($this->view === 'profile/api') { ?>

	<script src="<?php echo $this->baseUrl; ?>assets/home/js/api.js"></script>
<?php } elseif ($this->view === 'events/design') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jscolor.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/shopdesign.js"></script>
<?php } elseif ($this->view === 'video/index') { ?>
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/videoDataTable.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
<?php } elseif ($this->view === 'events/tickets') { ?>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/select-tickets.js"></script>
	
<?php } elseif ($this->view === 'marketing/selection') { ?>
	<script src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/home/js/selectionDataTable.js"></script>
<?php } elseif ($this->view === 'new_bookings/agenda_booking_design') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/cdn/js/jscolor.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/agenda_booking_design.js"></script>
<?php } elseif ($this->view === 'bookings/index') { ?>
	<script>
	var fp = flatpickr(document.querySelector('#eventdate'), {
		dateFormat: "d/m/Y",
		minDate: "today",
		disableMobile: true,
  //inline: true,
  //enableTime: true,
  //mode: "multiple",
  onChange: function(selectedDates, dateStr, instance) {
    console.log('date: ', dateStr);
  }
});
	</script>
<?php } elseif ($this->view === 'templates/addTemplate') { ?>
<!--	<script src='--><?php //echo $this->baseUrl; ?><!--assets/home/js/tinymce.min.js?apiKey=pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu'></script>-->
	 <script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/templates.js'></script>
<?php } elseif ($this->view === 'templates/listTemplates') { ?>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/listTemplates.js'></script>
<?php } elseif ($this->view === 'templates/updateTemplate') { ?>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/templates.js'></script>
<?php } elseif ($this->view === 'voucher/templates/updateTemplate') { ?>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/voucherTemplates.js'></script>
<?php } elseif ($this->view === 'appsettings/index') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/appSettingsDataTable.js'></script>
<?php } elseif ($this->view === 'events/tags') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/tagsDataTable.js'></script>
<?php } elseif ($this->view === 'events/inputs') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/eventInputsDataTable.js'></script>
<?php } elseif ($this->view === 'voucher/index') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/voucherTemplates.js'></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/vouchersDataTable.js"></script>
<?php } elseif ($this->view === 'voucher/send') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/voucherSendDataTable.js"></script>
<?php } elseif ($this->view === 'customer_panel/manual_reservations') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/reservationsDataTable.js"></script>
<?php } elseif ($this->view === 'events/guestlist') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
	<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/import_guestlist.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/guestlistDataTable.js"></script>
<?php } elseif ($this->view === 'qrcodeview/index') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/qrcodeDataTable.js"></script>
<?php } elseif ($this->view === 'translation-table') { ?>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/translationDataTable.js"></script>
<?php } elseif ($this->view === 'events/reports') { ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript"  src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/home/js/ticketsReportDataTable.js"></script>
<?php } elseif ($this->view === 'events/email_designer') { ?>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo $this->baseUrl; ?>assets/home/js/templates.js'></script>
<?php } elseif ($this->view === 'profile/paynlMerchant') { ?>
	<script src="https://cdn.tiny.cloud/1/pcevs107srjcf31ixiyph3zij2nlhhl6fd10hxmer5lyzgsu/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
	<script src='<?php echo base_url(); ?>assets/home/js/paynlMerchant.js'></script>
<?php } elseif ($this->view === 'businessreport/allPaymentMethods') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/allPaymentMethods.js'></script>
<?php } elseif ($this->view === 'businessreport/paymentMethods') { ?>
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src='<?php echo base_url(); ?>assets/home/js/paymentMethods.js'></script>
<?php } elseif ($this->view === 'registerAmbasador') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/registerAmbasador.js'></script>
<?php } elseif ($this->view === 'warehouse/areas') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/areas.js'></script> 
<?php } elseif ($this->view === 'publicorders/makeOrder2021') { ?>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-url-hash@latest/dist/js/splide-extension-url-hash.min.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/makeOrder2021.js"></script>
	<!--
		<script src="<?php #echo $this->baseUrl ?>assets/home/slickJs/slick.min.js"></script>
		<script src="<?php #echo $this->baseUrl ?>assets/home/js/makeOrderFunctions.js"></script>
		<script src="<?php #echo $this->baseUrl ?>assets/home/js/makeOrderNew.js"></script>
	-->
<?php } elseif($this->view === 'events/financial_report'){ ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/ticketingFinancialDataTable.js"></script>
<?php } elseif($this->view === 'customer_panel/financial_report'){ ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>assets/js/jquery.table2excel.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/query-builder.standalone.js"></script>
	<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/reservationsFinancialDataTable.js"></script>
<?php } elseif ($this->view === 'warehouse/productsOrder') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/sortProducts.js'></script>
<?php } elseif ($this->view === 'scanner/scanner') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/scanner.js'></script>
<?php }  elseif ($this->view === 'profile/reportsSettings') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/reportsSettings.js'></script>
<?php } elseif ($this->view === 'events/selectpayment') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/payOrderNew.js'></script>
<?php  } elseif ($this->view === 'booking_agenda/shop') { ?>
	<script src="https://unpkg.com/izitoast@1.4.0/dist/js/iziToast.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.6/dist/js/splide.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>
	<script src='<?php echo base_url(); ?>assets/home/js/flatpickrCalendar.js'></script>
<?php  } elseif ($this->view === 'booking_agenda2/shop') { ?>
	<script src="https://unpkg.com/izitoast@1.4.0/dist/js/iziToast.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.6/dist/js/splide.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/flatpickr'></script>
	<script src='<?php echo base_url(); ?>assets/home/js/flatpickrCalendar.js'></script>
<?php } elseif ($this->view === 'bookings/timeslot_booking') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/timeslotBooking.js'></script>
<?php } elseif ($this->view === 'bookings/changeReservation') { ?>
	<script src='<?php echo base_url(); ?>assets/home/js/changeReservation.js'></script>
<?php }  elseif ($this->view === 'floorplans/addFloorplan') { ?>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/floorplan/assets/js/fabric_v4.0.0-beta.8.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorplan.js"></script>
	<script src="<?php echo base_url(); ?>assets/floorplan/assets/js/floorEditor.js"></script>
<script>

	var floorplan;
	$(document).ready(function () {
		$('#occupied_color').colorpicker({format: "rgb", useAlpha: false});
		$('#free_color').colorpicker({format: "rgb", useAlpha: false});
		$('#unavailable_color').colorpicker({format: "rgb", useAlpha: false});
		$('#label_color').colorpicker({format: "rgb", useAlpha: false});

		//Show images for active category
        var active_cat = $('#images_category').val();
        $('#cat_'+active_cat).show();

		floorplan = new FloorEditor({
            floorElementID: 'canvas',
            imgEl: $('#floor_image'),
            <?php #if ($floorplan_images) { ?>
                // objectsImages: $.parseJSON('<?php #echo json_encode($floorplan_images); ?>'),
            <?php #} ?>

			<?php if (isset($floorplan) AND $floorplan) { ?>
				floorplanID: <?php echo $floorplan->id; ?>,
                imageUploaded: <?php echo $floorplan->file_name ? 'true' : 'false'; ?>,
				floor_name: '<?php echo $floorplan->floor_name; ?>',
				areas: $.parseJSON('<?php echo json_encode($areas); ?>'),
				canvasJSON: '<?php echo $floorplan->canvas;?>'
			<?php } ?>
		});

		fabric.Object.prototype.transparentCorners = true;
		fabric.Object.prototype.cornerColor = 'red';
		fabric.Object.prototype.cornerStyle = 'circle';

		fabric.Object.prototype.controls.deleteControl = new fabric.Control({
			position: {x: 0.5, y: -0.5},
			offsetY: -8,
			offsetX: 8,
			cursorStyle: 'pointer',
			mouseUpHandler: (eventData, target) => {
				floorplan.deleteObject(eventData, target)
			},
			render: floorplan.renderIcon(floorplan.deleteImg),
			cornerSize: 24
		});

		$('#uploadImageField').change(function () {
			floorplan.addImage($(this).prop('files')[0]);
		});

		$('#drawning_mode').click(function () {
			floorplan.drawningModeToggle($(this))
		});

		$('#save').click(function () {
			floorplan.saveFloor();
		})

		$('#floor_plan_name').change(function () {
			floorplan.floor_name = $(this).val();
		});

		$('#save_area_options_btn').click(function () {
			// floorplan.canvas.getActiveObject().options.unavailable_color = $('#unavailable_color input').val();
			// floorplan.canvas.getActiveObject().options.free_color        = $('#free_color input').val();
			// floorplan.canvas.getActiveObject().options.occupied_color    = $('#occupied_color input').val();
			// floorplan.canvas.getActiveObject().options.label_color       = $('#label_color input').val();
			// floorplan.canvas.getActiveObject().options.area_label        = $('#area_label').val();
			// floorplan.canvas.getActiveObject().options.opacity           = $('#opacity').val();
			// floorplan.canvas.getActiveObject().options.area_count        = parseInt($('#area_count').val()) < 2 ? 1 : parseInt($('#area_count').val());
			var options = {
                unavailable_color: $('#unavailable_color input').val(),
                free_color: $('#free_color input').val(),
                occupied_color: $('#occupied_color input').val(),
                label_color: $('#label_color input').val(),
                area_label: $('#area_label').val(),
                opacity: $('#opacity').val(),
                area_count: parseInt($('#area_count').val()) < 2 ? 1 : parseInt($('#area_count').val())
            };
			floorplan.updateArea(options);
			$('#area_options').modal('hide');
		});

		$('#add_image').click(function () {
		    if (!floorplan.drawning_mode) {
		        return false;
            }
            var active_cat = $('#images_category').val();
		    var object_image = $('#cat_'+active_cat + ' .images_list').val();
            floorplan.addObjectImage(active_cat, object_image);
        })


	});

	$(window).resize(function () {
        floorplan.scaleAndPositionCanvas();
	});
</script>
<?php } ?>

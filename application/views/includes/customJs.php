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
	<script src="<?php echo $this->baseUrl ?>assets/home/js/payOrder.js"></script>
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
	<script src="<?php echo $this->baseUrl ?>assets/home/js/makeOrderFunctions.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/posWrapper.js"></script>
	<script src="<?php echo $this->baseUrl ?>assets/home/js/posSplide.js"></script>
	<?php if(!empty($posCheckoutOrder) || !empty($posBuyerDetails)) { ?>
		<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
		<script src="<?php echo $this->baseUrl; ?>assets/home/js/checkoutOrder.js"></script>
	<?php } ?>
	<?php if (!empty($posPay)) { ?>	
		<script src="<?php echo $this->baseUrl ?>assets/home/js/payOrder.js"></script>
	<?php }	?>
<?php } elseif ($this->view === 'profile/openandclose') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/editUser.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/profile.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/found.js"></script>
<?php } elseif ($this->view === 'events/step-one' || $this->view === 'events/edit_event') { ?>
    <script src="<?php echo $this->baseUrl; ?>assets/js/quill.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/main.jbox.min.js"></script>
    <script src="<?php echo $this->baseUrl; ?>assets/js/jbox.min.js"></script>
    <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js" integrity="sha512-0fcCRl828lBlrSCa8QJY51mtNqTcHxabaXVLPgw/jPA5Nutujh6CbTdDgRzl9aSPYW/uuE7c4SffFUQFBAy6lg==" crossorigin="anonymous"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/events.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI&callback=initAutocomplete&libraries=places&v=weekly" async></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/googleAddressAutocomplete.js"></script>
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
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	<script src="<?php #echo $this->baseUrl ?>assets/home/slickJs/slick.min.js"></script>
	<script src="<?php #echo $this->baseUrl ?>assets/home/js/makeOrderFunctions.js"></script>
	<script src="<?php #echo $this->baseUrl ?>assets/home/js/makeOrderNew.js"></script> -->
<?php }?>

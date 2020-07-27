<script src="<?php echo base_url(); ?>assets/home/js/utility.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/ajax.js"></script>
<?php if ($this->view === 'labels') { ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCst0EJ-LFVj3q0a6NHGFDU6HQ10H84HTI"></script>
<script src="<?php echo base_url(); ?>assets/home/js/edit-grid-item.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/labels.js"></script>
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
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/orders.js"></script>
<?php } elseif ($this->view === 'warehouse/printers') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<?php } elseif ($this->view === 'warehouse/spots') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<?php } elseif ($this->view === 'warehouse/warehouse') {?>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/js/jquery.datetimepicker.full.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/reports.js"></script>
<?php } elseif ($this->view === 'publicorders/checkoutOrder') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/checkoutOrder.js"></script>
<?php } elseif ($this->view === 'warehouse/productTypes') { ?>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/edit-grid-item.js"></script>
<?php } elseif ($this->view === 'publicorders/selectSpot') { ?>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="<?php echo $this->baseUrl; ?>assets/home/js/selectSpot.js"></script>
<?php } ?>

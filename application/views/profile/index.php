<div class="main-wrapper" style="text-align:center">
	<?php if($this->session->userdata('dropoffpoint')==1) { ?>
		<div class="col-half background-apricot-blue timeline-content">
			<h2>Shop url</h2>
			<a href="<?php echo base_url() . 'make_order?vendorid=' . $user->id; ?>" target='_blank' >
				<?php echo base_url() . 'make_order?vendorid=' . $user->id; ?>
			</a>
			<h2>Booking url</h2>
			<a href="<?php echo base_url() . 'check424/' . $user->id; ?>" target='_blank' >
				<?php echo base_url() . 'check424/' . $user->id; ?>
			</a>
			<h2>Agenda Booking url</h2>
			<a href="<?php echo base_url() . 'agenda_booking/' . $user->username; ?>" target='_blank' >
				<?php echo base_url() . 'agenda_booking/' . $user->username; ?>
			</a>
			<h2>Booking Agenda url</h2>
			<a href="<?php echo base_url() . 'booking_agenda/' . $user->username; ?>" target='_blank' >
				<?php echo base_url() . 'booking_agenda/' . $user->username; ?>
			</a>
			<h2>Set public design</h2>
			<a href="<?php echo base_url() . 'viewdesign'; ?>">
				Design
			</a>
			<h2>Visma Accounting</h2>
			<a href="<?php echo base_url() . 'visma/config'; ?>">
				Visma
			</a>
		</div>
	<?php } ?>
</div>



<script>
	function getUserAjax() {
		return "<?php echo base_url('index.php/ajax/users/'); ?>";
	}
	var baseURL = "<?php echo $this->baseUrl; ?>";
</script>

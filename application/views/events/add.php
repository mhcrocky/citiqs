<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
	.circle {
		border-radius: 50%;
		width: 128px;
		height: 32px;
		padding: 10px;
		background: #f9fcb0;
		border: 3px solid #000;
		color: #000;
		text-align: center;
		font: 32px Arial bold, sans-serif;
	}
</style>
<main class="main-content" style="margin-top:20px; border-width: 0px">
	<ul class="nav nav-tabs mb-35 container" style="border-bottom: none" role="tablist">
		<li class="nav-item" style="margin: 20px">
			<a style="border-radius: 50px; " class="nav-link active" data-toggle="tab" href="#info">INFO</a>
		</li>
		<li class="nav-item" style="margin: 20px">
			<a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#tickets">TICKETS</a>
		</li>
		<li class="nav-item" style="margin: 20px">
			<a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#design">DESIGN</a>
		</li>
		<li class="nav-item" style="margin: 20px">
			<a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#e-mail">E-MAIL/NOTIFICATION</a>
		</li>
		<li class="nav-item" style="margin: 20px">
			<a style="border-radius: 50px" class="nav-link" data-toggle="tab" href="#payment">PAYMENT METHODS</a>
		</li>
	</ul>

	<div class="tab-content" style="border-radius: 50px; margin-left: -10px">
		<div id="info" class="container tab-pane active" style="background: none;">
			<div class="row">
				<div class="col-lg-6">

					<label for="defaultdesignid">Create your event</label>

					<?php $this->load->helper("form"); ?>
					<form role="form" id="addEvent" action="<?php echo base_url() ?>event/add" method="post" role="form">
					<div style="margin-top: 30px">
							Userid :
							<input type="text" name="userid" value="<?php echo $this->input->post('userid'); ?>" />
						</div>
						<div>
							EventName :
							<input type="text" name="EventName" value="<?php echo $this->input->post('EventName'); ?>" />
						</div>
						<div>
							EventDescription :
							<input type="text" name="EventDescription" value="<?php echo $this->input->post('EventDescription'); ?>" />
						</div>
						<div>
							MinimalAge :
							<input type="text" name="MinimalAge" value="<?php echo $this->input->post('MinimalAge'); ?>" />
						</div>
						<div>
							EventType :
							<input type="text" name="EventType" value="<?php echo $this->input->post('EventType'); ?>" />
						</div>
						<div>
							Venue :
							<input type="text" name="Venue" value="<?php echo $this->input->post('Venue'); ?>" />
						</div>
						<div>
							VenueAddress :
							<input type="text" name="VenueAddress" value="<?php echo $this->input->post('VenueAddress'); ?>" />
						</div>
						<div>
							VenueCity :
							<input type="text" name="VenueCity" value="<?php echo $this->input->post('VenueCity'); ?>" />
						</div>
						<div>
							VenueZipcode :
							<input type="text" name="VenueZipcode" value="<?php echo $this->input->post('VenueZipcode'); ?>" />
						</div>
						<div>
							VenueCountry :
							<input type="text" name="VenueCountry" value="<?php echo $this->input->post('VenueCountry'); ?>" />
						</div>
						<div>
							StartDateTime :
							<input type="text" name="StartDateTime" value="<?php echo $this->input->post('StartDateTime'); ?>" />
						</div>
						<div>
							EndDateTime :
							<input type="text" name="EndDateTime" value="<?php echo $this->input->post('EndDateTime'); ?>" />
						</div>

						<button type="submit">Save</button>
						</div>
					</form>
			</div>

		</div>
		<div id="tickets" class="container tab-pane" style="background: none;">
<!--			--><?php //include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
		</div>
		<div id="design" class="container tab-pane" style="background: none;">
<!--			--><?php //include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
		</div>
		<div id="e-mail" class="container tab-pane" style="background: none;">
<!--			--><?php //include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
		</div>
		<div id="payments" class="container tab-pane" style="background: none;">
<!--			--><?php //include_once FCPATH . 'application/views/warehouse/includes/design/iframeSettings.php'; ?>
		</div>

	</div>
</main>

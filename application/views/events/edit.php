<?php echo form_open('events/edit/'.$tbl_event['id']); ?>

	<div>
		Userid : 
		<input type="text" name="userid" value="<?php echo ($this->input->post('userid') ? $this->input->post('userid') : $tbl_event['userid']); ?>" />
	</div>
	<div>
		EventName : 
		<input type="text" name="EventName" value="<?php echo ($this->input->post('EventName') ? $this->input->post('EventName') : $tbl_event['EventName']); ?>" />
	</div>
	<div>
		EventDescription : 
		<input type="text" name="EventDescription" value="<?php echo ($this->input->post('EventDescription') ? $this->input->post('EventDescription') : $tbl_event['EventDescription']); ?>" />
	</div>
	<div>
		MinimalAge : 
		<input type="text" name="MinimalAge" value="<?php echo ($this->input->post('MinimalAge') ? $this->input->post('MinimalAge') : $tbl_event['MinimalAge']); ?>" />
	</div>
	<div>
		EventType : 
		<input type="text" name="EventType" value="<?php echo ($this->input->post('EventType') ? $this->input->post('EventType') : $tbl_event['EventType']); ?>" />
	</div>
	<div>
		Venue : 
		<input type="text" name="Venue" value="<?php echo ($this->input->post('Venue') ? $this->input->post('Venue') : $tbl_event['Venue']); ?>" />
	</div>
	<div>
		VenueAddress : 
		<input type="text" name="VenueAddress" value="<?php echo ($this->input->post('VenueAddress') ? $this->input->post('VenueAddress') : $tbl_event['VenueAddress']); ?>" />
	</div>
	<div>
		VenueCity : 
		<input type="text" name="VenueCity" value="<?php echo ($this->input->post('VenueCity') ? $this->input->post('VenueCity') : $tbl_event['VenueCity']); ?>" />
	</div>
	<div>
		VenueZipcode : 
		<input type="text" name="VenueZipcode" value="<?php echo ($this->input->post('VenueZipcode') ? $this->input->post('VenueZipcode') : $tbl_event['VenueZipcode']); ?>" />
	</div>
	<div>
		VenueCountry : 
		<input type="text" name="VenueCountry" value="<?php echo ($this->input->post('VenueCountry') ? $this->input->post('VenueCountry') : $tbl_event['VenueCountry']); ?>" />
	</div>
	<div>
		StartDateTime : 
		<input type="text" name="StartDateTime" value="<?php echo ($this->input->post('StartDateTime') ? $this->input->post('StartDateTime') : $tbl_event['StartDateTime']); ?>" />
	</div>
	<div>
		EndDateTime : 
		<input type="text" name="EndDateTime" value="<?php echo ($this->input->post('EndDateTime') ? $this->input->post('EndDateTime') : $tbl_event['EndDateTime']); ?>" />
	</div>
	
	<button type="submit">Save</button>
	
<?php echo form_close(); ?>
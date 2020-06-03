<?php echo form_open('tbl_restaurantbooking_table/edit/'.$tbl_restaurantbooking_table['id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="width" class="col-md-4 control-label">Width</label>
		<div class="col-md-8">
			<input type="text" name="width" value="<?php echo ($this->input->post('width') ? $this->input->post('width') : $tbl_restaurantbooking_table['width']); ?>" class="form-control" id="width" />
		</div>
	</div>
	<div class="form-group">
		<label for="height" class="col-md-4 control-label">Height</label>
		<div class="col-md-8">
			<input type="text" name="height" value="<?php echo ($this->input->post('height') ? $this->input->post('height') : $tbl_restaurantbooking_table['height']); ?>" class="form-control" id="height" />
		</div>
	</div>
	<div class="form-group">
		<label for="top" class="col-md-4 control-label">Top</label>
		<div class="col-md-8">
			<input type="text" name="top" value="<?php echo ($this->input->post('top') ? $this->input->post('top') : $tbl_restaurantbooking_table['top']); ?>" class="form-control" id="top" />
		</div>
	</div>
	<div class="form-group">
		<label for="left" class="col-md-4 control-label">Left</label>
		<div class="col-md-8">
			<input type="text" name="left" value="<?php echo ($this->input->post('left') ? $this->input->post('left') : $tbl_restaurantbooking_table['left']); ?>" class="form-control" id="left" />
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-md-4 control-label">Name</label>
		<div class="col-md-8">
			<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $tbl_restaurantbooking_table['name']); ?>" class="form-control" id="name" />
		</div>
	</div>
	<div class="form-group">
		<label for="seats" class="col-md-4 control-label">Seats</label>
		<div class="col-md-8">
			<input type="text" name="seats" value="<?php echo ($this->input->post('seats') ? $this->input->post('seats') : $tbl_restaurantbooking_table['seats']); ?>" class="form-control" id="seats" />
		</div>
	</div>
	<div class="form-group">
		<label for="minimum" class="col-md-4 control-label">Minimum</label>
		<div class="col-md-8">
			<input type="text" name="minimum" value="<?php echo ($this->input->post('minimum') ? $this->input->post('minimum') : $tbl_restaurantbooking_table['minimum']); ?>" class="form-control" id="minimum" />
		</div>
	</div>
	<div class="form-group">
		<label for="userid" class="col-md-4 control-label">Userid</label>
		<div class="col-md-8">
			<input type="text" name="userid" value="<?php echo ($this->input->post('userid') ? $this->input->post('userid') : $tbl_restaurantbooking_table['userid']); ?>" class="form-control" id="userid" />
		</div>
	</div>
	<div class="form-group">
		<label for="floorplanimage" class="col-md-4 control-label">Floorplanimage</label>
		<div class="col-md-8">
			<input type="text" name="floorplanimage" value="<?php echo ($this->input->post('floorplanimage') ? $this->input->post('floorplanimage') : $tbl_restaurantbooking_table['floorplanimage']); ?>" class="form-control" id="floorplanimage" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>
	
<?php echo form_close(); ?>
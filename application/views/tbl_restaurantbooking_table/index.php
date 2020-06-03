<div class="main-wrapper">
	<section class="content">
		<div class="row">
			<table class="table table-hover">
				<tr>
					<th>ID</th>
					<th>Width</th>
					<th>Height</th>
					<th>Top</th>
					<th>Left</th>
					<th>Name</th>
					<th>Seats</th>
					<th>Minimum</th>
					<th>imageid</th>
					<th>Actions</th>
				</tr>
				<?php foreach($tbl_restaurantbooking_tables as $t){ ?>
					<tr>
						<td><?php echo $t['id']; ?></td>
						<td><?php echo $t['width']; ?></td>
						<td><?php echo $t['height']; ?></td>
						<td><?php echo $t['top']; ?></td>
						<td><?php echo $t['left']; ?></td>
						<td><?php echo $t['name']; ?></td>
						<td><?php echo $t['seats']; ?></td>
						<td><?php echo $t['minimum']; ?></td>
						<td><?php echo $t['imageid']; ?></td>
						<td>
							<a href="<?php echo site_url('tbl_restaurantbooking_table/edit/'.$t['id']); ?>" class="btn btn-info btn-xs">Edit</a>
							<a href="<?php echo site_url('tbl_restaurantbooking_table/remove/'.$t['id']); ?>" class="btn btn-danger btn-xs">Delete</a>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</section>
</div>

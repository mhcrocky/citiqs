<table border="1" width="100%">
    <tr>
		<th>ID</th>
		<th>Userid</th>
		<th>EventName</th>
		<th>EventDescription</th>
		<th>MinimalAge</th>
		<th>EventType</th>
		<th>Venue</th>
		<th>VenueAddress</th>
		<th>VenueCity</th>
		<th>VenueZipcode</th>
		<th>VenueCountry</th>
		<th>StartDateTime</th>
		<th>EndDateTime</th>
		<th>Actions</th>
    </tr>
	<?php foreach($tbl_events as $t){ ?>
    <tr>
		<td><?php echo $t['id']; ?></td>
		<td><?php echo $t['userid']; ?></td>
		<td><?php echo $t['EventName']; ?></td>
		<td><?php echo $t['EventDescription']; ?></td>
		<td><?php echo $t['MinimalAge']; ?></td>
		<td><?php echo $t['EventType']; ?></td>
		<td><?php echo $t['Venue']; ?></td>
		<td><?php echo $t['VenueAddress']; ?></td>
		<td><?php echo $t['VenueCity']; ?></td>
		<td><?php echo $t['VenueZipcode']; ?></td>
		<td><?php echo $t['VenueCountry']; ?></td>
		<td><?php echo $t['StartDateTime']; ?></td>
		<td><?php echo $t['EndDateTime']; ?></td>
		<td>
            <a href="<?php echo site_url('events/edit/'.$t['id']); ?>">Edit</a> | 
            <a href="<?php echo site_url('events/remove/'.$t['id']); ?>">Delete</a>
        </td>
    </tr>
	<?php } ?>
</table>

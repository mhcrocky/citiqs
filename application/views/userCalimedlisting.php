<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
        <div class="grid-list">
            <div class="grid-list-header row">
                <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                    <h2>Filter Options</h2>
                </div><!-- end col 4 -->
                <div class="col-lg-4 col-md-4 col-sm-12 date-picker-column">
                    <div>
                        <!--                        From:-->
                        <div class='date-picker-content'>
                            <input type="text" placeholder="Select from.." data-input class="flatpickr" /> <!-- input is mandatory -->
                        </div>
                    </div>
                    <div>
                        <!--                        To:-->
                        <div class='date-picker-content'>
                            <input type="text" placeholder="Select to.." data-input class="flatpickr-to" /> <!-- input is mandatory -->
                        </div>
                    </div>
                </div><!-- end date picker -->
                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                    <!--                    Search by name:-->
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0 button grid-button" type="submit">Search</button>
                    </form>
                </div>
            </div><!-- end grid header -->
            <?php
            if(!empty($claimedLabels))
			{
				foreach ($claimedLabels as $record)
				{
				?>
				<div class="grid-item" <?php if (intval($record->userclaimId)){ ?>style="background-color:rgba(226, 95, 42)" <?php } ?>>
					<div class="item-header">
						<p class="item-date">
							<?php echo $record->createdDtm ?>
						</p>
						<p class="item-code">
							<?php echo $record->code ?>
						</p>
						<div class='grid-image'>
							<?php if (!empty($record->image)) { ?>
								<?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image)) { ?>
									<a class="image-link" href="<?php echo base_url() . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" >
								<?php } ?>
								<img
									id="image_<?php echo $record->code; ?>" src="<?php echo $this->baseUrl . 'uploads/LabelImages/' . $record->userId . '-' . $record->code . '-' . $record->image; ?>" alt=""
								/>
								<?php if (file_exists(FCPATH . 'uploads/LabelImagesBig/' . $record->userId . '-' . $record->code . '-' . $record->image )) { ?>
									</a>
								<?php } ?>
							<?php } else { ?>
								<img src="<?php echo $this->baseUrl; ?>uploads/default.jpg" alt="">
							<?php } ?>
						</div>
						<p class='item-description'>
							<span>Description: </span>
							<?php echo $this->language->line($record->descript, $record->descript); ?>
						</p>
						<p class='item-category'>
							<span>Category: </span>
							<?php echo $record->categoryname; ?>
						</p>
					</div>

				</div>
				<!-- end grid item -->
					<?php
				}
			} else {
				echo '<p>No claimed items</p>';
			}
			?>
        </div>
        <!-- end grid list -->
    </div>
    <!-- end grid wrapper -->
</div>
<script>
	$(document).ready(function() {
		if ($('.image-link').length > 0) {
			$('.image-link').magnificPopup({type:'image'});
		}
	});
</script>
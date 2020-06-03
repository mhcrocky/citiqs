<?php
$id = $userInfo->id;
$userId = $userInfo->userId;
//$code = $userInfo->code;
$categoryid = $userInfo->categoryid;
$descript = $userInfo->descript;
?>

<div class="main-wrapper">

	<script src="<?php echo base_url(); ?>assets/home/js/vanilla-picker.js"></script>
		<div class="edit-signle-item-container">
			<h3>Item Heading</h3>
			<form role="form" action="<?php echo base_url() ?>editUserlabel" method="post" id="editUserlabel" >
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<!--                                        <label for="code">Unique label code</label>-->
								<!--                                        <input type="text" class="form-control" id="code" placeholder="Unique label code" name="code" value="--><?php //echo $code; ?><!--" maxlength="128">-->
								<label for="categoryid">Category</label>
								<select class="form-control" id="categoryid" placeholder="Category" name="categoryid" value="" maxlength="128">
									<?php
									foreach ($categories as $row)
									{
										if ($categoryid == $row['id'])
											echo '<option selected value="'.$row['id'].'">';
										else
											echo '<option value="'.$row['id'].'">';
										echo($row['description'].'</option>');
									}
									?>
								</select>
								<!--                                        <input type="hidden" value="--><?php //echo $userId; ?><!--" name="userId" id="userId" />-->
								<input type="hidden" value="<?php echo $id; ?>" name="id" id="id" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="descript">Description</label>
								<input type="text" required class="form-control" id="descript" placeholder="Description" name="descript" value="<?php echo $descript; ?>" maxlength="128">
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->

				<div class="box-footer">
					<input type="submit" class="btn btn-info" value="Submit" />
					<input type="reset" class="btn btn-default" value="Reset" />
				</div>
			</form>
		</div>
	</div>

                        <h3 class="box-title">Bag-tag details</h3>


                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } 
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>

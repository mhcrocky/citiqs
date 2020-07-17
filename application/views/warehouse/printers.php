<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
			<div class="item-editor theme-editor" id='add-printer'>
				<div class="theme-editor-header d-flex justify-content-between" >
					<div>
						<img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
					</div>
					<div class="theme-editor-header-buttons">
						<input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addPrinter')" value="Submit" />
						<button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-printer', 'display')">Cancel</button>
					</div>
				</div>
				<div class="edit-single-user-container">
					<form class="form-inline" id="addPrinter" method="post" action="<?php echo $this->baseUrl . 'warehouse/addPrinter'; ?>">
                        <legend>Add printer</legend>
						<input type="text" readonly name="userId" required value="<?php echo $userId ?>" hidden />
                        <input type="text" readonly name="active" required value="1" hidden />
						<div>
							<label for="printer">Printer: </label>
							<input type="text" class="form-control" id="printer" name="printer" required />
						</div>
                        <div>
							<label for="macNumber">MAC number: </label>
							<input type="text" class="form-control" id="macNumber" name="macNumber" required />
						</div>
						<div>
							<label for="numberOfCopies">Number of copies: </label>
							<input type="integer" min="1" value="1" step="1" class="form-control" id="numberOfCopies" name="numberOfCopies" required />
						</div>
					</form>
				</div>
			</div>
			<div class="grid-list-header row">
				<div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
					<h2>Printers</h2>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<!-- <div class="form-group">
						<label for="filterCategories">Filter printers:</label>						
					</div> -->
				</div>

				<div class="col-lg-4 col-md-4 col-sm-12 search-container">
					<button
                        class="btn button-security my-2 my-sm-0 button grid-button"
                        onclick="toogleElementClass('add-printer', 'display')">Add printer</button>
				</div>
			</div><!-- end grid header -->
			<!-- SINGLE GIRD ITEM -->
            <?php if (is_null($printers)) { ?> 
				<p>No printers.</p>
            <?php } else { ?>
                <?php foreach ($printers as $printer) { ?>
					<div class="grid-item" style="background-color:<?php echo $printer['active'] === '1' ? '#99ff66' : '#ff4d4d'; ?>">
						<div class="item-header">
							<p class="item-description">Name: <?php echo $printer['printer']; ?></p>
                            <p class="item-description">MAC number: <?php echo $printer['macNumber']; ?></p>
							<p class="item-category">Status:
								<?php echo $printer['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
							</p>
							<p class="item-description">Number of copies: <?php echo $printer['numberOfCopies']; ?></p>							
						</div><!-- end item header -->
						<div class="grid-footer">
							<div class="iconWrapper">
								<span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editPrinterPrinterId<?php echo $printer['id']; ?>', 'display')">
									<i class="far fa-edit"></i>
								</span>
							</div>
							<?php if ($printer['active'] === '1') { ?>
								<div title="Click to block printer" class="iconWrapper delete-icon-wrapper">
									<a href="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id'] .'/0'; ?>" >
										<span class="fa-stack fa-2x delete-icon">
											<i class="fas fa-times"></i>
										</span>
									</a>
								</div>
							<?php } else { ?>
								<div title="Click to activate printer" class="iconWrapper delete-icon-wrapper">
									<a href="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id'] .'/1'; ?>" >
										<span class="fa-stack fa-2x" style="background-color:#0f0">
											<i class="fas fa-check"></i>
										</span>
									</a>
								</div>
							<?php } ?>
						</div>
						<!-- ITEM EDITOR -->
						<div class="item-editor theme-editor" id="editPrinterPrinterId<?php echo  $printer['id']; ?>">
							<div class="theme-editor-header d-flex justify-content-between">
								<div class="theme-editor-header-buttons">
									<input type="button" onclick="submitForm('editPrinter<?php echo $printer['id']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
									<button
                                        class="grid-button-cancel button theme-editor-header-button"
                                        onclick="toogleElementClass('editPrinterPrinterId<?php echo  $printer['id']; ?>', 'display')">Cancel</button>
								</div>
							</div>
							<div class="edit-single-user-container">
								<form
                                    class="form-inline"
                                    id="editPrinter<?php echo $printer['id']; ?>"
                                    method="post"
                                    action="<?php echo $this->baseUrl . 'warehouse/editPrinter/' . $printer['id']; ?>"
                                    >
									<input type="text" name="userId" value="<?php echo $userId; ?>" readonly required hidden />
									<h3>Printer details</h3>
									<div>
										<label for="printer<?php echo $printer['id']; ?>">Name:</label>
										<input type="text" class="form-control" id="printer<?php echo $printer['id']; ?>" name="printer" required value="<?php echo $printer['printer']; ?>" />
									</div>
                                    <div>
										<label for="printerMac<?php echo $printer['macNumber']; ?>">MAC number:</label>
										<input type="text" class="form-control" id="printerMac<?php echo $printer['macNumber']; ?>" name="macNumber" required value="<?php echo $printer['macNumber']; ?>" />
									</div>
									<div>
										<label for="numberOfCopies<?php echo $printer['numberOfCopies']; ?>">Number of copies:</label>
										<input type="number" min="1" step="1" class="form-control" id="numberOfCopies<?php echo $printer['numberOfCopies']; ?>" name="numberOfCopies" required value="<?php echo $printer['numberOfCopies']; ?>" />
									</div>
								</form>
							</div>
						</div>
						<!-- END EDIT FOR NEW USER -->
					</div>
                <?php } ?>
            <?php } ?>
			
		</div>
		<!-- end grid list -->
	</div>
</div>

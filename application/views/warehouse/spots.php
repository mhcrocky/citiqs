<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
		<div class="grid-list">
            <?php if (is_null($printers)) { ?> 
				<p>No printers. <a href="<?php echo $this->baseUrl . 'printers'; ?>">Add printer</a></p>
            <?php } else { ?>
                <div class="item-editor theme-editor" id='add-spot'>
                    <div class="theme-editor-header d-flex justify-content-between" >
                        <div>
                            <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                        </div>
                        <div class="theme-editor-header-buttons">
                            <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addSpot')" value="Submit" />
                            <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-spot', 'display')">Cancel</button>
                        </div>
                    </div>
                    <div class="edit-single-user-container">
                        <form class="form-inline" id="addSpot" method="post" action="<?php echo $this->baseUrl . 'warehouse/addSpot'; ?>">
                            <legend>Add spot</legend>
                            <input type="text" readonly name="active" required value="1" hidden />
                            <div>
                                <label for="addPrinterId">Spot printer: </label>
                                <select class="form-control" id="addPrinterId" name="printerId">
                                    <option value="">Select</option>
                                    <?php foreach ($printers as $printer) { ?>
                                        <option value="<?php echo $printer['id']; ?>">
                                            <?php echo $printer['printer']; ?>
                                            (<?php echo $printer['active'] === '1' ? '<span style="color:#009933">ACTIVE</span>' : '<span style="color:#ff3333">BLOCKED</span>'; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <label for="spotName">Spot name: </label>
                                <input type="text" class="form-control" id="spotName" name="spotName" required />
                            </div>
                            <div>
                                <label for="addSpotTypeId">Spot type: </label>
                                <select class="form-control" id="addSpotTypeId" name="spotTypeId">
                                    <option value="">Select</option>
                                    <?php foreach ($spotTypes as $type) { ?>
                                        <option value="<?php echo $type['id']; ?>">
                                            <?php echo $type['type']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="grid-list-header row">
                    <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                        <h2>Spots</h2>
                    </div>
                    <?php if (!empty($spots)) { ?>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group col-lg-6">
                                <label for="filterSpots">Filter by spot name:</label>
                                <select class="form-control selectSpots" multiple="multiple" id="filterSpots" onchange="toogleSpots(this, 'allSpots')">
                                    <option value="all">Select</option>
                                    <?php foreach ($spots as $spot) { ?>
                                        <option value="spotElementId<?php echo $spot['spotId']; ?>"><?php echo $spot['spotName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                        <button
                            class="btn button-security my-2 my-sm-0 button grid-button"
                            onclick="toogleElementClass('add-spot', 'display')">Add spot</button>
                    </div>
                </div><!-- end grid header -->
                <!-- SINGLE GIRD ITEM -->
                <?php if (is_null($spots)) { ?>
                    <p>No spot(s)</p>
                <?php } else { ?>
                    <?php foreach ($spots as $spot) { ?>

                        <div class="grid-item allSpots" id="spotElementId<?php echo $spot['spotId']; ?>" style="background-color:<?php echo $spot['spotActive'] === '1' ? '#99ff66' : '#ff4d4d'; ?>">
                            <div class="item-header">
                                <p class="item-description">Name: <?php echo $spot['spotName']; ?></p>
                                <!-- <p class="item-description">Spot ID: <?php #echo $spot['spotId']; ?></p> -->
                                <p class="item-category">Spot status:
                                    <?php echo $spot['spotActive'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
                                </p>
                                <p class="item-description">Printer: <span><?php echo $spot['printer']; ?><span></p>
                                <p class="item-category">Printer status:
                                    <?php echo $spot['printerActive'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
                                </p>
                                <p class="item-description">Spot type: <span><?php echo $spot['spotType']; ?><span></p>
                            </div><!-- end item header -->
                            <!-- END EDIT FOR NEW USER -->
                            <div class="grid-footer">
                                <div class="iconWrapper">
                                    <span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editSpotSpotId<?php echo $spot['spotId']; ?>', 'display')">
                                        <i class="far fa-edit"></i>
                                    </span>
                                </div>
                                <?php if ($spot['spotActive'] === '1') { ?>
                                    <div title="Click to block spot" class="iconWrapper delete-icon-wrapper">
                                        <a href="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId'] .'/0'; ?>" >
                                            <span class="fa-stack fa-2x delete-icon">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div title="Click to activate spot" class="iconWrapper delete-icon-wrapper">
                                        <a href="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId'] .'/1'; ?>" >
                                            <span class="fa-stack fa-2x" style="background-color:#0f0">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- ITEM EDITOR -->
                            <div class="item-editor theme-editor" id="editSpotSpotId<?php echo  $spot['spotId']; ?>">
                                <div class="theme-editor-header d-flex justify-content-between">
                                    <div class="theme-editor-header-buttons">
                                        <input type="button" onclick="submitForm('editSpot<?php echo $spot['spotId']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
                                        <button
                                            class="grid-button-cancel button theme-editor-header-button"
                                            onclick="toogleElementClass('editSpotSpotId<?php echo  $spot['spotId']; ?>', 'display')">Cancel</button>
                                    </div>
                                </div>
                                <div class="edit-single-user-container">
                                    <form
                                        class="form-inline"
                                        id="editSpot<?php echo $spot['spotId']; ?>"
                                        method="post"
                                        action="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId']; ?>"
                                        >
                                        <h3>Spot details</h3>
                                        <div>
                                            <label for="spotName<?php echo $spot['spotId']; ?>">Name:</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="spotName<?php echo $spot['spotId']; ?>"
                                                name="spotName"
                                                required
                                                value="<?php echo $spot['spotName']; ?>" />
                                        </div>
                                        <div>
                                            <label for="editPrinterId<?php echo $spot['spotId']; ?>">Spot printer: </label>
                                            <select class="form-control" id="editPrinterId<?php echo $spot['spotId']; ?>" name="printerId">
                                                <option value="">Select</option>
                                                <?php foreach ($printers as $printer) { ?>
                                                    <option
                                                        value="<?php echo $printer['id']; ?>"
                                                        <?php if ($spot['spotPrinterId'] === $printer['id']) echo 'selected'; ?>
                                                        >
                                                        <?php echo $printer['printer']; ?>
                                                        (<?php echo $printer['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>)
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="editSpotTypeId<?php echo $spot['spotId']; ?>">Spot type: </label>
                                            <select class="form-control" id="editSpotTypeId<?php echo $spot['spotId']; ?>" name="spotTypeId">
                                                <option value="">Select</option>
                                                <?php foreach ($spotTypes as $type) { ?>
                                                    <option
                                                        value="<?php echo $type['id']; ?>"
                                                        <?php if ($spot['spotTypeId'] === $type['id']) echo 'selected'; ?>                                                        
                                                        >
                                                        <?php echo $type['type']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php
                }
            ?>
		</div>
		<!-- end grid list -->
	</div>
</div>
<script>
    function toogleSpots(element, className) {
        let allProducts = document.getElementsByClassName(className)
        let allProductsLength = allProducts.length;
        let i;

        let selected = element.selectedOptions;
        let selectedLength = selected.length;
        let j;

        let selectedIds = [];
        let spot;

        for (j = 0; j < selectedLength; j++) {
            selectedIds.push(selected[j].value);
        }

        if (selectedIds.includes('all')) {
            $('.' + className).css("display", "initial");
            return;
        }

        for (i = 0; i < allProductsLength; i++) {
            spot = allProducts[i];
            if (selectedIds.includes(spot.id)) {
                spot.style.display = 'initial';
            } else {
                spot.style.display = 'none';
            }
        }
    }
</script>
<?php if (!empty($spots)) { ?>
    <script>
        $(document).ready(function() {
            $('.selectSpots').select2();
        });
    </script>
<?php } ?>
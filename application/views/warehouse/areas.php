<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="margin-top: 0;" class="main-wrapper theme-editor-wrapper">
    <div style="background: none;" class="grid-wrapper">
        <div class="grid-list">
            <?php if (is_null($printers)) { ?>
                <p>No printers. <a href="<?php echo $this->baseUrl . 'printers'; ?>">Add printer</a></p>
            <?php } elseif (is_null($spots)) { ?>
                <p>No spots. <a href="<?php echo $this->baseUrl . 'spots'; ?>">Add spot</a></p>
            <?php } else { ?>
                <div class="grid-list-header row">
                    <div class="col-lg-12 col-md-4 col-sm-12 grid-header-heading">
                        <h2>Areas</h2>
                        <br/>
                    </div>
                    <div class="col-lg-12 col-md-4 col-sm-12 search-container">
                        <button type="button" class="btn button-security my-2 my-sm-0 button grid-button"
                            data-toggle="modal" data-target="#addArea">Add area
                        </button>
                    </div>
                </div>
                <?php
                    if (!empty($areas)) {
                        foreach($areas as $area) {
                            ?>
                                <div class="grid-item allSpots" id="area<?php echo $area['areaId']; ?>">
                                    <div class="item-header" style="width:100%">
                                        <p class="item-description" style="white-space: initial;">Name: <?php echo $area['area']; ?></p>
                                        <p class="item-description" style="white-space: initial;">Printer: <?php echo $area['printerName']; ?></p>
                                    </div>
                                    <div class="grid-footer">
                                        <div class="iconWrapper">
                                            <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#editArea<?php echo $area['areaId']; ?>">
                                                <i class="far fa-edit"></i>
                                            </span>
                                        </div>
                                        <div title="Click to block spot" class="iconWrapper delete-icon-wrapper">
                                            <a href="<?php echo $this->baseUrl . 'delete_area/' . $area['areaId']; ?>">
                                                <span class="fa-stack fa-2x delete-icon">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- start area modal -->
                                <div class="modal" id="editArea<?php echo $area['areaId']; ?>" tabindex="-1" role="dialog" aria-labelledby="editArea<?php echo $area['areaId']; ?>Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">            
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editArea<?php echo $area['areaId']; ?>Label">Edit area</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form
                                                    method="post"
                                                    id="editAreaForm<?php echo $area['areaId']; ?>"
                                                    action="<?php echo base_url() . 'edit_area' . DIRECTORY_SEPARATOR . $area['areaId']; ?>"
                                                >
                                                    <div class="form-group">
                                                        <label for="area<?php echo $area['areaId']; ?>">Area name:</label>
                                                        <input
                                                            type="text"
                                                            id="area<?php echo $area['areaId']; ?>"
                                                            name="area[area]"
                                                            class="form-control"
                                                            data-form-check="1"
                                                            data-error-message='Area name is required'
                                                            data-min-length="1"
                                                            value="<?php echo $area['area']; ?>"
                                                        />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="printer<?php echo $area['areaId']; ?>">Select printer</label>
                                                        <select
                                                            class="form-control"
                                                            id="printer<?php echo $area['areaId']; ?>"
                                                            name="area[printerId]"
                                                            data-form-check="1"
                                                            data-error-message='Printer not selected'
                                                            data-min-length="1"
                                                        >
                                                            <option value="">Select:</option>
                                                            <?php foreach ($printers as $printer) { ?>
                                                                <option
                                                                    value="<?php echo $printer['id']; ?>"
                                                                    <?php if ($area['printerId'] === $printer['id']) echo 'selected'; ?>
                                                                >
                                                                    <?php
                                                                        echo ($printer['masterMac']) ? $printer['printer'] . ' (SLAVE PRINTER)' : $printer['printer'];
                                                                    ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <lable>Select area spots:</label>
                                                        <br/>
                                                        <?php foreach ($spots as $spot) { ?>
                                                            <div class="form-check form-check-inline">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="areaSpots[]"
                                                                    value="<?php echo $spot['spotId']; ?>"
                                                                    id="spotid_<?php echo $spot['spotId']; ?>_<?php echo $area['areaId']; ?>"
                                                                    <?php
                                                                        if ($spot['areaId'] === $area['areaId'] && $spot['spotPrinterId'] === $area['printerId']) echo 'checked';
                                                                    ?>
                                                                />
                                                                <label
                                                                    class="form-check-label"
                                                                    for="spotid_<?php echo $spot['spotId']; ?>_<?php echo $area['areaId']; ?>"
                                                                >
                                                                    <?php echo $spot['spotName']; ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a
                                                        href="javascript:void(0)"
                                                        class="btn button-security my-2 my-sm-0 button grid-button"
                                                        onclick="submitAreaForm('editAreaForm<?php echo $area['areaId']; ?>')"
                                                    >
                                                        Edit
                                                    </a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end area modal -->
                            <?php
                        }
                    }
                ?>
            <?php } ?>
        </div>
    </div>
</div>


<div class="modal" id="addArea" tabindex="-1" role="dialog" aria-labelledby="addAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">            
                <div class="modal-header">
                    <h5 class="modal-title" id="addAreaModalLabel">Add area</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="post" id ="addAreaForm" action="<?php echo base_url(); ?>addarea">
                    <div class="form-group">
                        <label for="area">Area name:</label>
                        <input
                            type="text"
                            id="area"
                            name="area[area]"
                            class="form-control"
                            data-form-check="1"
							data-error-message='Area name is required'
							data-min-length="1"
                        />
                    </div>
                    <div class="form-group">
                        <label for="printer">Select printer</label>
                        <select
                            class="form-control"
                            id="printer"
                            name="area[printerId]"
                            data-form-check="1"
							data-error-message='Printer not selected'
							data-min-length="1"
                        >
                            <option value="">Select:</option>
                            <?php foreach ($printers as $printer) { ?>
                                <option value="<?php echo $printer['id']; ?>">
                                    <?php
                                        echo ($printer['masterMac']) ? $printer['printer'] . ' (SLAVE PRINTER)' : $printer['printer'];
                                    ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable>Select area spots:</label>
                        <br/>
                        <?php foreach ($spots as $spot) { ?>
                            <div class="form-check form-check-inline">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="areaSpots[]"
                                    value="<?php echo $spot['spotId']; ?>"
                                    id="spotid_<?php echo $spot['spotId']; ?>"
                                >
                                <label class="form-check-label" for="spotid_<?php echo $spot['spotId']; ?>"><?php echo $spot['spotName']; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a
                        href="javascript:void(0)"
                        class="btn button-security my-2 my-sm-0 button grid-button"
                        onclick="submitAreaForm('addAreaForm')"
                    >
                        Add
                    </a>
                </div>
        </div>
    </div>
</div>

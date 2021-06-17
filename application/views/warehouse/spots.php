<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.1/tagify.min.css" integrity="sha512-1CG2eaZ3B/p7OqthY2eBpVCD2A+0b2T7aEXfMnr4FqZFoKddxURdxcD8EcKI66qthtkGAWA/Hnwy7ceNHcHJKw==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.23.1/jQuery.tagify.min.js" integrity="sha512-rTGB6PwoLTbBh7iZQhaJIn8LpSohPzRTIi3Eejb6moBVgDSm37Sne0LfQ9VFg5AQloJn7Vd/5rVIbnLjDVjViw==" crossorigin="anonymous"></script>
<div style="margin-top: 0;" class="main-wrapper theme-editor-wrapper">
    <div style="background: none;" class="grid-wrapper">
        <div class="grid-list">
            <?php if (is_null($printers)) { ?>
            <p>No printers. <a href="<?php echo $this->baseUrl . 'printers'; ?>">Add printer</a></p>
            <?php } else { ?>
            <!-- Add Spot Modal -->
            <div class="modal fade" id="addSpotModal" tabindex="-1" role="dialog" aria-labelledby="addSpotModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <legend>Add spot</legend>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="item-editor">
                                <div class="edit-single-user-container">
                                    <form class="form-inline" id="addSpot" method="post"
                                        action="<?php echo $this->baseUrl . 'warehouse/addSpot'; ?>">

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
                                            <input type="text" class="form-control" id="spotName" name="spotName"
                                                required />
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
                        </div>
                        <div class="modal-footer">
                            <input style="width:100px;" type="button"
                                class="grid-button button theme-editor-header-button" onclick="submitForm('addSpot')"
                                value="Submit" />
                            <button style="width:100px;" type="button"
                                class="grid-button-cancel button theme-editor-header-button"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
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
                        <select class="form-control selectSpots" multiple="multiple" id="filterSpots"
                            onchange="toogleSpots(this, 'allSpots')">
                            <option value="all">Select</option>
                            <?php foreach ($spots as $spot) { ?>
                            <option value="spotElementId<?php echo $spot['spotId']; ?>"><?php echo $spot['spotName']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>

                <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                    <button type="button" class="btn button-security my-2 my-sm-0 button grid-button"
                        data-toggle="modal" data-target="#addSpotModal">Add spot
                    </button>
                    <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                        <p>
                            Legend:&nbsp;
                            <?php foreach($colors as $type => $color) { ?>
                            <?php echo $type; ?>&nbsp;&nbsp;<span
                                style="display:inline-block; width:20px; height: 12px; background-color:<?php echo $color; ?>"></span>&nbsp;&nbsp;
                            <?php } ?>
                            not active&nbsp;&nbsp;<span
                                style="display:inline-block; width:20px; height: 12px; background-color:<?php echo $notActiveColor; ?>"></span>&nbsp;&nbsp;
                        </p>
                    </div>
                </div>
            </div><!-- end grid header -->
            <!-- SINGLE GIRD ITEM -->
            <?php if (is_null($spots)) { ?>
            <p>No spot(s)</p>
            <?php } else { ?>
            <?php foreach ($spots as $spot) { ?>

            <div class="grid-item allSpots" id="spotElementId<?php echo $spot['spotId']; ?>" <?php
                                if ($spot['spotActive'] === '1') {
                                    $spotTypedId = intval($spot['spotTypeId']);
                                    if ($spotTypedId === $localTypeId) {
                                        $backgroundColor = $colors['local'];
                                    } elseif ($spotTypedId === $deliveryTypeId) {
                                        $backgroundColor = $colors['delivery'];
                                    } elseif ($spotTypedId === $pickupTypeId) {
                                        $backgroundColor = $colors['pickup'];
                                    }
                                } else {
                                    $backgroundColor = $notActiveColor;
                                }
                            ?> style="background-color:<?php echo $backgroundColor; ?>">
                <div class="item-header" style="width:100%">
                    <p class="item-description" style="white-space: initial;">Name: <?php echo $spot['spotName']; ?></p>
                    <!-- <p class="item-description">Spot ID: <?php #echo $spot['spotId']; ?></p> -->
                    <p class="item-category" style="white-space: initial;">Spot status:
                        <?php echo $spot['spotActive'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
                    </p>
                    <p class="item-description" style="white-space: initial;">Printer:
                        <span><?php echo $spot['printer']; ?><span></p>
                    <p class="item-category" style="white-space: initial;">Printer status:
                        <?php echo $spot['printerActive'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>
                    </p>
                    <p class="item-description">Spot type: <span><?php echo $spot['spotType']; ?><span></p>
                    <?php #if ($activePos === '1' && $spot['spotActive'] === '1') { ?>
                    <!-- <a href="<?php #echo base_url() . 'pos?spotid=' . $spot['spotId'];  ?>">
                        <p class="item-description">
                            Go to POS
                        </p>
                    </a> -->
                    <?php #} ?>
                </div><!-- end item header -->
                <!-- END EDIT FOR NEW USER -->
                <div class="grid-footer">
                    <div class="iconWrapper">
                        <span class="fa-stack fa-2x edit-icon btn-edit-item"
                            onclick="editSpot('<?php echo $spot['spotId']; ?>')">
                            <i class="far fa-edit"></i>
                        </span>
                    </div>
                    <div class="iconWrapper">
                        <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal"
                            data-target="#timeModal<?php echo $spot['spotId']; ?>" title="Click to add time">
                            <i class="far fa-clock-o"></i>
                        </span>
                    </div>
                    <?php if ($spot['spotActive'] === '1') { ?>
                    <div title="Click to block spot" class="iconWrapper delete-icon-wrapper">
                        <a href="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId'] .'/0'; ?>">
                            <span class="fa-stack fa-2x delete-icon">
                                <i class="fas fa-times"></i>
                            </span>
                        </a>
                    </div>
                    <?php } else { ?>
                    <div title="Click to activate spot" class="iconWrapper delete-icon-wrapper">
                        <a href="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId'] .'/1'; ?>">
                            <span class="fa-stack fa-2x" style="background-color:#0f0">
                                <i class="fas fa-check"></i>
                            </span>
                        </a>
                    </div>
                    <?php } ?>
                </div>

                <button id="btn-<?php echo  $spot['spotId']; ?>" style="display:none" type="button" data-toggle="modal"
                    data-target="#editSpotSpotId<?php echo  $spot['spotId']; ?>">Edit</button>
                <!-- Edit Spot Modal -->
                <div class="modal fade" id="editSpotSpotId<?php echo  $spot['spotId']; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="editSpotModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <legend>Edit Spot</legend>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">

                                <div class="item-editor">
                                    <div class="edit-single-user-container">
                                        <form class="form-inline" id="editSpot<?php echo $spot['spotId']; ?>"
                                            method="post"
                                            action="<?php echo $this->baseUrl . 'warehouse/editSpot/' . $spot['spotId']; ?>">

                                            <div>
                                                <label for="spotName<?php echo $spot['spotId']; ?>">Name:</label>
                                                <input type="text" class="form-control"
                                                    id="spotName<?php echo $spot['spotId']; ?>" name="spotName" required
                                                    value="<?php echo $spot['spotName']; ?>" />
                                            </div>
                                            <div>
                                                <label for="editPrinterId<?php echo $spot['spotId']; ?>">Spot printer:
                                                </label>
                                                <select class="form-control"
                                                    id="editPrinterId<?php echo $spot['spotId']; ?>" name="printerId">
                                                    <option value="">Select</option>
                                                    <?php foreach ($printers as $printer) { ?>
                                                    <option value="<?php echo $printer['id']; ?>"
                                                        <?php if ($spot['spotPrinterId'] === $printer['id']) echo 'selected'; ?>>
                                                        <?php echo $printer['printer']; ?>
                                                        (<?php echo $printer['active'] === '1' ? '<span>ACTIVE</span>' : '<span>BLOCKED</span>'; ?>)
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="editSpotTypeId<?php echo $spot['spotId']; ?>">Spot type:
                                                </label>
                                                <select class="form-control"
                                                    id="editSpotTypeId<?php echo $spot['spotId']; ?>" name="spotTypeId">
                                                    <option value="">Select</option>
                                                    <?php foreach ($spotTypes as $type) { ?>
                                                    <option value="<?php echo $type['id']; ?>"
                                                        <?php if ($spot['spotTypeId'] === $type['id']) echo 'selected'; ?>>
                                                        <?php echo $type['type']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input style="width:100px;" type="button"
                                    onclick="submitForm('editSpot<?php echo $spot['spotId']; ?>')"
                                    class="grid-button button theme-editor-header-button" value="Submit" />
                                <button style="width:100px;" type="button"
                                    class="grid-button-cancel button theme-editor-header-button"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php
                            $spotTimes = explode(',', $spot['spotTimes']);
                            $spotTimes = array_map(function($data){
                                return explode('|', $data);
                            }, $spotTimes);

                            $fineSpotDays = [
                                'Mon' => [],
                                'Tue' => [],
                                'Wed' => [],
                                'Thu' => [],
                                'Fri' => [],
                                'Sat' => [],
                                'Sun' => [],
                            ];

                            foreach($spotTimes as $time) {
                                if (!empty($time[0])) {
                                    array_push($fineSpotDays[$time[0]], $time);
                                }
                            }
                        ?>
            <!--TIME MODAL -->
            <div class="modal" id="timeModal<?php echo $spot['spotId']; ?>" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form method="post" action="warehouse/addSpotTimes/<?php echo $spot['spotId']; ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">
                                    Set availability days and time for spot "<?php echo $spot['spotName']; ?>"
                                </h4>
                            </div>
                            <div class="modal-body">
                                <?php foreach($dayOfWeeks as $day) { ?>
                                <div class="from-group">
                                    <label class="checkbox-inline" for="<?php echo $day . $spot['spotId']; ?>">
                                        <input type="checkbox" id="<?php echo $day . $spot['spotId']; ?>"
                                            value="<?php echo $day; ?>"
                                            onchange="showDay(this,'<?php echo $day . '_'.  $spot['spotId']; ?>')"
                                            name="<?php echo $day; ?>[day][]" <?php                                                                    
                                                                if (!empty($fineSpotDays[$day])) {
                                                                    $first = array_shift($fineSpotDays[$day]);                                                                        
                                                                    echo 'checked';
                                                                } else {
                                                                    $first = null;
                                                                }
                                                            ?> />
                                        <?php echo ucfirst($day); ?>
                                    </label>
                                    <br />
                                    <div id="<?php echo $day . '_'.  $spot['spotId']; ?>"
                                        <?php if (empty($first)) echo 'style="display:none"'; ?>>
                                        <label for="from<?php echo $day . $spot['spotId']; ?>">From:
                                            <input type="time" id="from<?php echo $day . $spot['spotId']; ?>"
                                                name="<?php echo $day; ?>[timeFrom][]"
                                                class="<?php echo $day . '_'.  $spot['spotId']; ?>" <?php
                                                                    if (isset($first[1])) {
                                                                        echo 'value="' . date('H:i', strtotime($first[1])) . '"';
                                                                    } else {
                                                                        echo 'disabled';
                                                                    }
                                                                ?> />
                                        </label>
                                        <Label for="to<?php echo $day . $spot['spotId']; ?>">To:
                                            <input type="time" id="to<?php echo $day . $spot['spotId']; ?>"
                                                name="<?php echo $day; ?>[timeTo][]"
                                                class="<?php echo $day . '_'.  $spot['spotId']; ?>" <?php
                                                                    if (isset($first[2])) {
                                                                        echo 'value="' . date('H:i', strtotime($first[2])) . '"';
                                                                    } else {
                                                                        echo 'disabled';
                                                                    }
                                                                ?> />
                                        </label>
                                        <button type="button" class="btn btn-default"
                                            onclick="addTimePeriod('<?php echo $day . $spot['spotId']; ?>Times','<?php echo $day; ?>')">Add
                                            time</button>
                                        <div id="<?php echo $day . $spot['spotId']; ?>Times">
                                            <?php
                                                                if (!empty($fineSpotDays[$day])) {
                                                                    foreach($fineSpotDays[$day] as $dayData) {
                                                                        ?>
                                            <div>
                                                <label>From
                                                    <input type="time"
                                                        class="<?php echo $day . '_'.  $spot['spotId']; ?>"
                                                        name="<?php echo $day; ?>[timeFrom][]"
                                                        value="<?php echo date('H:i', strtotime($dayData[1])); ?>" />
                                                </label>
                                                <label>To:
                                                    <input type="time"
                                                        class="<?php echo $day . '_'.  $spot['spotId']; ?>"
                                                        name="<?php echo $day; ?>[timeTo][]"
                                                        value="<?php echo date('H:i', strtotime($dayData[2])); ?>" />
                                                </label>
                                                <span class="fa-stack fa-2x" onclick="removeParent(this)">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </div>
                        </div>
                    </form>
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
$(document).ready(function(){
    $('[name=qrcodes]').tagify();
});
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

<script src="<?php echo base_url(); ?>assets/home/js/spot.js"></script>
<script>
function editSpot(spotId) {
    $("#btn-" + spotId).click();
}
</script>
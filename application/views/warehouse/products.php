<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
    var productGloabls = {};
</script>

<!-- ADD Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- FILTER AND ADD NEW -->
                <div class="item-editor addEditForm" id='add-product'>
                    <div style="width:100%;">
                        <form
                            id="addProdcut"
                            method="post"
                            action="<?php echo $this->baseUrl . 'warehouse/addProdcut'; ?>"
                            class="form-inline"
                            enctype="multipart/form-data"
                            >
                            <input type="text" name="product[active]" value="1" required readonly hidden />
                            <legend>Product basic data</legend>
                            <!-- PRODUCT EXTENDED DATA -->
                            <div class="col-lg-4 col-sm-12 form-group">
                                <label for="name">Name: </label>
                                <input type="text" name="productExtended[name]" id="name" class="form-control" required />
                            </div>
                            <div class="col-lg-4 col-sm-12  form-group">
                                <label for="shortDescription">Short description: </label>
                                <input type="text" name="productExtended[shortDescription]" id="shortDescription" class="form-control" />                         
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="longDescription">Long description: </label>
                                <textarea
                                    name="productExtended[longDescription]"
                                    id="longDescription"
                                    class="form-control"
                                    rows="1"></textarea>
                            </div>
                            <div class="col-lg-4 col-sm-12  form-group">
                                <label for="preparationTime">Preparation time in minutes: </label>
                                <input type="number" min="0" value="0" max="255" name="product[preparationTime]" id="preparationTime" class="form-control" />                         
                            </div>
                            <?php if (in_array($localTypeId, $vendorTypes)) { ?>
                                <div class="col-lg-4 col-sm-12">
                                <label for="vatInsert">VAT: </label>
                                    <select class="form-control" name="productExtended[vatpercentage]" id="vatInsert" class="form-control" >
                                        <option value="">Select</option>
                                        <?php foreach ($taxRates as $tax) { ?>
                                            <option value="<?php echo $tax; ?>">
                                                <?php echo $tax; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if (in_array($deliveryTypeId, $vendorTypes)) { ?>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="deliveryVatEdit">Delivery VAT: </label>
                                    <select class="form-control" name="productExtended[deliveryVatpercentage]" id="deliveryVatEdit" class="form-control" >
                                        <option value="">Select</option>
                                        <?php foreach ($taxRates as $tax) { ?>
                                            <option value="<?php echo $tax; ?>">
                                                <?php echo $tax; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <?php if (in_array($pickupTypeId, $vendorTypes)) { ?>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="pickupVatEdit">Pickup VAT: </label>
                                    <select class="form-control" name="productExtended[pickupVatpercentage]" id="pickupVatEdit" class="form-control" >
                                        <option value="">Select</option>
                                        <?php foreach ($taxRates as $tax) { ?>
                                            <option value="<?php echo $tax; ?>">
                                                <?php echo $tax; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <!-- PRODUCT DATA -->
                            <div class="col-lg-4 col-sm-12">
                                <label for="dateTimeFrom">Availabe from: </label>
                                <input type="text" id="dateTimeFrom" name="product[dateTimeFrom]" class="form-control productTimePickers" required />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="dateTimeTo">Availabe to: </label>
                                <input type="text" id="dateTimeTo" name="product[dateTimeTo]" class="form-control productTimePickers" required />
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label for="addCategoryId">Product category: </label>
                                <select class="form-control" id="addCategoryId" name="product[categoryId]" required>
                                    <option value="">Select</option>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['categoryId']; ?>">
                                            <?php echo $category['category']; ?> (<?php echo $category['active'] === '1' ? 'active' : 'blocked'; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                            <!-- PRINTERS -->
                                <label>Printers: </label>
                                <div class="col-lg-4 col-sm-12">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" checked />
                                            &nbsp;&nbsp;Default printing
                                        </label>
                                    </div>
                                <?php foreach ($printers as $printer) { ?>
                                    <div class="col-lg-4 col-sm-12">
                                        <label class="checkbox-inline" for="printerId<?php echo $printer['id']; ?>">
                                            <input
                                                type="checkbox"
                                                id="printerId<?php echo $printer['id']; ?>"
                                                name="productPrinters[]"
                                                value="<?php echo $printer['id']; ?>"
                                            />
                                            &nbsp;&nbsp;<?php echo $printer['printer']; ?> (<?php echo $printer['active'] === '1' ? 'active' : 'blocked'; ?>)
                                        </label>
                                    </div>
                                <?php } ?>                             
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>Only one (for main type): </label>
                                <label class="radio-inline">
                                    <input type="radio" name="product[onlyOne]" value="1" />
                                    &nbsp;&nbsp;Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="product[onlyOne]" value="0" checked />
                                    &nbsp;&nbsp;No
                                </label>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <label>Add remark (for main type): </label>
                                <label class="radio-inline">
                                    <input type="radio" name="product[addRemark]" value="1" />
                                    &nbsp;&nbsp;Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="product[addRemark]" value="0" checked />
                                    &nbsp;&nbsp;No
                                </label>
                            </div>
                            <!-- PRODUCT TYPES -->
                            <legend>Select product types</legend>
                            <?php foreach ($productTypes as $type) { ?>
                
                                <div class="col-lg-4 col-sm-12">
                                    <h3>
                                        <?php
                                            echo $type['productType'];
                                            if ($type['isBoolean'] === '1') echo '&nbsp;&nbsp;(only yes or no)';
                                        ?>
                                    </h3>
                                    <label class="checkbox-inline" for="productType<?php echo $type['id']; ?>">
                                        <input
                                            type="checkbox"
                                            id="productType<?php echo $type['id'];; ?>"
                                            name="productTypes[<?php echo $type['id']; ?>][check]"
                                            value="<?php echo $type['id']; ?>"
                                            />
                                        Select <?php echo '"' . $type['productType'] . '"'; if ($type['isMain'] === '1') echo ' (main)'; ?>
                                    </label>
                                    <?php if (in_array($localTypeId, $vendorTypes)) { ?>
                                        <label for="price<?php echo $type['id']; ?>">Price: </label>
                                        <input
                                            type="number"
                                            required
                                            value="0"
                                            step="0.01"
                                            name="productTypes[<?php echo $type['id']; ?>][price]"
                                            id="price<?php echo $type['id']; ?>"
                                            min="0"
                                            class="form-control"
                                        />
                                    <?php } ?>

                                    <?php if (in_array($deliveryTypeId, $vendorTypes)) { ?>
                                        <label for="deliveryPrice<?php echo $type['id']; ?>">Delivery price: </label>
                                        <input
                                            type="number"
                                            required
                                            step="0.01"
                                            name="productTypes[<?php echo $type['id']; ?>][deliveryPrice]"
                                            id="deliveryPrice<?php echo $type['id']; ?>"
                                            min="0"
                                            class="form-control"
                                            value="0"
                                        />
                                    <?php } ?>
                                    <?php if (in_array($pickupTypeId, $vendorTypes)) { ?>
                                        <label for="pickupPrice<?php echo $type['id']; ?>">Pickup price: </label>
                                        <input
                                            type="number"
                                            required
                                            step="0.01"
                                            name="productTypes[<?php echo $type['id']; ?>][pickupPrice]"
                                            id="pickupPrice<?php echo $type['id']; ?>"
                                            min="0"
                                            class="form-control"
                                            value="0"
                                        />
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <legend>Upload product image</legend>
                            <div class="form-group has-feedback">
                                <input type="file" name="productImage" id="productImage" class="form-control" accept="image/png" />
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                        </form>
                    </div>
                </div>
      </div>
      <div class="modal-footer">
        <input style="width: 100px;" type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addProdcut')" value="Submit" />
        <button style="width: 100px;" type="button" class="grid-button-cancel button theme-editor-header-button" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div style="margin-top: 0" class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper"  style="background: #f3d0b1 !important;">
        <?php if (is_null($categories) || is_null($printers) || is_null($productTypes) || is_null($userSpots)) { ?>
            <p style="margin-left:15px;"> No categories, product types, printers  and / or spots.
                <?php if (is_null($categories)) { ?>
                    <a href="<?php echo $this->baseUrl . 'product_categories'; ?>">
                        Add category  
                    </a>
                <?php } ?>
                <?php if (is_null($productTypes)) { ?>
                    <a href="<?php echo $this->baseUrl . 'product_types'; ?>">
                        Add product type(s)  
                    </a>
                <?php } ?>
                <?php if (is_null($printers)) { ?>
                <a href="<?php echo $this->baseUrl . 'printers'; ?>">
                    Add printer
                </a>
                <?php } ?>
                <?php if (is_null($userSpots)) { ?>
                <a href="<?php echo $this->baseUrl . 'spots'; ?>">
                    Add spot
                </a>
                <?php } ?>
            </p>
        <?php } else { ?>
            <div class="grid-list">
                
                <div class="grid-list-header row">
                    <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                        <h2>Products</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="filterCategories">Filter products:</label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    value="products/all"
                                    <?php if ($active === 'all' || $active === '') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                All products
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="products/active"
                                    <?php if ($active === 'active') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                    Active products
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="products/archived"
                                    <?php if ($active === 'archived') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                    Archived products
                            </label>
                        </div>
                        <?php if ($products) { ?>
                            <form method="post" action="<?php echo base_url() ?>products" >
                                <div class="form-group col-lg-6">
                                    <label for="filterProducts">Filter by product name:</label>
                                    <select class="form-control selectProducts" multiple="multiple" id="filterProducts" name="names[]" required>
                                        <?php if (!empty($productNames)) { ?>
                                            <?php foreach ($productNames as $name) { ?>
                                                <option value="<?php echo $name['productId']; ?>"><?php echo $name['name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                                <div class="form-group col-lg-6">
                                    <input class="btn btn-primary" type="submit" value="Filter" />
                                    <a class="btn btn-secondary" href="<?php echo base_url(); ?>products">Show all</a>
                                </div>
                            </form>
                        <?php } ?>                            
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                        <button type="button" class="btn button-security my-2 my-sm-0 button grid-button" data-toggle="modal" data-target="#addProductModal">Add product</button>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <a class="btn button-security bg-primary my-2 my-sm-0 button grid-button text-light" style="text-decoration:none;" href="<?php echo base_url('productsorder');?>">Sort</a>
                        <button class="btn button-security bg-primary my-2 my-sm-0 button grid-button text-light" onclick="downloadPricelist()" >Download price list</button>
                    </div>
                </div>
                
                <!-- LIST -->
                <?php if (is_null($products)) { ?>
                    <p>No products in list.
                <?php } else {
                        foreach ($products as $productId => $product) {
                            $isMain = false;
                            $product = reset($product);
                            $productDetailsIds = [];
                            $productDetailsString =  '<dl>';
                            $productDetailsString .=      '<dt>Product types:</dt>';

                            foreach($product['productDetails'] as $details) {
                                array_push($productDetailsIds, $details['productTypeId']);
                                $string = 'Name: ' . $details['productType'];
                                if ($details['productTypeIsMain'] === '1') {
                                    $isMain = true;
                                    $string .= ' <span style="background-color: #72b19f">(MAIN)</span> ';
                                } else {
                                    $string .= ' <span>(NOT MAIN</span>) ';
                                }

                                if ($details['showInPublic'] === '1') {
                                    $string .= ' <span style="background-color: #72b19f">(ACTIVE)</span> ';
                                } else {
                                    $string .= ' <span style="background-color: #ff0000">(BLOCKED)</span> ';
                                }

                                $productDetailsString .= '<dd>' . $string . '</dd>';
                            }

                            $productDetailsString .=  '</dl>';
                        ?>
                            <div
                                class="grid-item"
                                style="background-color:<?php echo $product['productActive'] === '1' ? '#72b19f' : '#ff0000'; ?>"
                                id="<?php echo 'product_' . str_replace('\'', ' ', $details['name']) . '_' . $details['productExtendedId']; ?>"
                                >
                                <div class="item-header" style="width:100%">
                                    <p class="item-description" style="white-space: initial;">Name: <?php echo $details['name']; ?></p>
                                    <p class="item-description" style="white-space: initial;">Category: 
                                        <?php
                                            echo $product['category'];
                                            echo $product['categoryActive'] === '1' ? ' (<span>ACTIVE</span>)' : ' (<span>"BLOCKED</span>)'
                                        ?>
                                    </p>
                                    <p class="item-description" style="white-space: initial;">VAT: <?php echo floatval($details['vatpercentage']); ?></p>
                                    <p class="item-description" style="white-space: initial;">From: 
                                        <?php echo ($product['dateTimeFrom']) ? $product['dateTimeFrom'] : 'All time'; ?>
                                    </p>
                                    <p class="item-description" style="white-space: initial;">To: 
                                        <?php echo ($product['dateTimeTo']) ? $product['dateTimeTo'] : 'All time'; ?>
                                    </p>
                                    <?php
                                        if ($product['printers']) {
                                            $printerIds = [];
                                            $productPrinters = explode(',', $product['printers']);
                                            
                                            echo '<dl>';
                                            echo    '<dt>Printers:</dt>';
                                            foreach($productPrinters as $printer) {
                                                $printer = explode($concatSeparator, $printer);
                                                if (!in_array($printer[0], $printerIds)) {
                                                    array_push($printerIds, $printer[0]);
                                                    $string = $printer[1];
                                                    $string .= $printer[2] === '1' ? ' (<span>ACTIVE</span>)' : ' (<span>BLOCKED</span>)';
                                                    echo '<dd>' . $string . '</dd>';
                                                }
                                                
                                            }
                                            echo '</dl>';
                                        }
                                        
                                        echo $productDetailsString;
                                    ?>
                                </div>
                                <?php if ($product['productImage']) { ?>
                                    <figure>
                                        <img src="<?php echo base_url() . 'assets/images/productImages/' . $product['productImage']; ?>" alt="<?php echo $details['name']; ?>" width="auto" height="auto" />
                                    </figure>
                                <?php } ?>
                                <div class="grid-footer">
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="editProduct('<?php echo $product['productId']; ?>', 'display')" title="Click to edit" >
                                            <i class="far fa-edit"></i>
                                        </span>
                                    </div>
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#timeModal<?php echo $product['productId']; ?>"  title="Click to add time">
                                            <i class="far fa-clock-o"></i>
                                        </span>
                                    </div>
                                    <?php if ($isMain) { ?>
                                        <div class="iconWrapper">
                                            <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#addOnsModal<?php echo $product['productId']; ?>"  title="Click to add addon(s)">
                                                <i class="far fa-tag"></i>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#productSpots<?php echo $product['productId']; ?>"  title="Click to select product spot(s)">
                                            <i class="fa fa-anchor"></i>
                                        </span>
                                    </div>
                                    <?php if ($showAllergies === '1') { ?>
                                        <div class="iconWrapper">
                                            <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#allergies<?php echo $product['productId']; ?>"  title="Click to select allergie(s)">
                                                <i class="fa fa-exclamation-triangle"></i>
                                            </span>
                                        </div>
                                    <?php } ?>
                                    <?php if ($product['productActive'] === '1') { ?>
                                        <div title="Click to block product" class="iconWrapper delete-icon-wrapper">
                                            <a href="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId'] .'/0'; ?>" >
                                                <span class="fa-stack fa-2x delete-icon">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div title="Click to activate product" class="iconWrapper delete-icon-wrapper">
                                            <a href="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId'] .'/1'; ?>" >
                                                <span class="fa-stack fa-2x" style="background-color:#0f0">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="iconWrapper">
                                        <span
                                            class="fa-stack fa-2x edit-icon btn-edit-item"
                                            title="Click to delete product"
                                            onclick="deleteProduct('<?php echo $product['productId']; ?>', '<?php echo $details['name']; ?>')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </div>
                                </div>
                                <!--TIME MODAL -->
                                <div class="modal" id="timeModal<?php echo $product['productId']; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <form method="post" action="<?php echo $this->baseUrl . 'warehouse/addProductTimes/' . $product['productId']; ?>">
                                            <input type="text" value="<?php echo $details['name']; ?>" name="productName"  hidden readonly />;
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">
                                                        Set availability days and time for product "<?php echo $details['name']; ?>"
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php foreach($dayOfWeeks as $day) { ?>
                                                        <div class="from-group">
                                                            <label class="checkbox-inline" for="<?php echo $day . $product['productId']; ?>">
                                                                <input
                                                                    type="checkbox"
                                                                    id="<?php echo $day . $product['productId']; ?>"
                                                                    value="<?php echo $day; ?>"
                                                                    onchange="showDay(this,'<?php echo $day . '_'.  $product['productId']; ?>')"
                                                                    name="productTime[<?php echo $day; ?>][day][]"
                                                                    <?php                                                                    
                                                                        if (isset($product['productTimes'][$day])) {
                                                                            $first = array_shift($product['productTimes'][$day]);                                                                        
                                                                            echo 'checked';
                                                                        }
                                                                    ?>
                                                                    />
                                                                    <?php echo ucfirst($day); ?>
                                                            </label>
                                                            <br/>
                                                            <div id="<?php echo $day . '_'.  $product['productId']; ?>" <?php if (!isset($first)) echo 'style="display:none"'; ?>>
                                                                <label for="from<?php echo $day . $product['productId']; ?>">From:
                                                                    <input
                                                                        type="time"
                                                                        id="from<?php echo $day . $product['productId']; ?>"
                                                                        name="productTime[<?php echo $day; ?>][from][]"
                                                                        <?php
                                                                            if (isset($first[2])) {
                                                                                echo 'value="' . date('H:i', strtotime($first[2])) . '"';
                                                                            }
                                                                        ?>
                                                                        />
                                                                </label>
                                                                <Label for="to<?php echo $day . $product['productId']; ?>">To:
                                                                    <input
                                                                        type="time"
                                                                        id="to<?php echo $day . $product['productId']; ?>"
                                                                        name="productTime[<?php echo $day; ?>][to][]"
                                                                        <?php
                                                                            if (isset($first[3])) {
                                                                                echo 'value="' . date('H:i', strtotime($first[3])) . '"';
                                                                            }
                                                                            unset($first);
                                                                        ?>
                                                                        />
                                                                </label>
                                                                <button type="button" class="btn btn-default" onclick="addTimePeriod('<?php echo $day . $product['productId']; ?>Times','<?php echo $day; ?>')">Add time</button>
                                                                <div id="<?php echo $day . $product['productId']; ?>Times">
                                                                    <?php
                                                                        if (isset($product['productTimes'][$day]) && $product['productTimes'][$day]) {
                                                                            foreach($product['productTimes'][$day] as $dayData) {
                                                                                ?>
                                                                                    <div>
                                                                                        <label>From
                                                                                            <input type="time" name="productTime[<?php echo $day; ?>][from][]" value="<?php echo date('H:i', strtotime($dayData[2])); ?>" />
                                                                                        </label>
                                                                                        <label>To:
                                                                                            <input type="time" name="productTime[<?php echo $day; ?>][to][]" value="<?php echo date('H:i', strtotime($dayData[3])); ?>"/>
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
                                <!-- PRODUCT SPOT MODAL -->
                                <div class="modal" id="productSpots<?php echo $product['productId']; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">
                                                    Set spot(s) for product "<?php echo $details['name']; ?>"
                                                </h4>
                                            </div>
                                            <div class="modal-body row">
                                                <!-- Modal content-->
                                                <?php
                                                    foreach ($product['productSpots'] as $spot) {
                                                        $spot = reset($spot);
                                                    ?>
                                                    <div class="col-lg-4 col-sm-12 form-group">
                                                        <label>Set status for spot "<?php echo $spot['spotName']; ?>" :&nbsp;&nbsp;&nbsp;</label>
                                                        <label class="radio-inline" for="active<?php echo $spot['productSpotId']; ?>">Active</label>
                                                        <input
                                                            type="radio"
                                                            id="active<?php echo $spot['productSpotId']; ?>"
                                                            name="showInPublic<?php echo $spot['productSpotId']; ?>"
                                                            value="1"
                                                            <?php if ($spot['showInPublic'] === '1') echo 'checked'; ?>
                                                            data-spot-product-id="<?php echo $spot['productSpotId']; ?>"
                                                            onchange="updateProductSpotStatus(this)"                                                            
                                                            />
                                                        <label class="radio-inline" for="blocked<?php echo $spot['productSpotId']; ?>">&nbsp;&nbsp;&nbsp;No</label>
                                                        <input
                                                            type="radio"
                                                            id="blocked<?php echo $spot['productSpotId']; ?>"
                                                            name="showInPublic<?php echo $spot['productSpotId']; ?>"
                                                            value="0"
                                                            <?php if ($spot['showInPublic'] === '0') echo 'checked'; ?>
                                                            data-spot-product-id="<?php echo $spot['productSpotId']; ?>"
                                                            onchange="updateProductSpotStatus(this)"
                                                            />
                                                    </div>
                                                
                                                    <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!--ADDONS MODAL -->
                                <?php if ($isMain) { ?>
                                    <div class="modal" id="addOnsModal<?php echo $product['productId']; ?>" role="dialog">
                                    
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <form method="post" action="<?php echo $this->baseUrl . 'warehouse/addProductAddons/' . $product['productId']; ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">
                                                            Select addon(s) for product "<?php echo $details['name']; ?>"
                                                            <?php
                                                                $addonsHtmlData = [];
                                                                if (!is_null($product['addons'])) {
                                                                    foreach($product['addons'] as $data) {
                                                                        ?>
                                                                            <script>
                                                                                if (!productGloabls.hasOwnProperty('<?php echo $data[0] ?>')) {
                                                                                    productGloabls['<?php echo $data[0] ?>'] = {};
                                                                                }
                                                                                productGloabls['<?php echo $data[0] ?>']['<?php echo $data[2] ?>'] = '<?php echo $data[3] ?>';
                                                                            </script>
                                                                        <?php
                                                                        array_push($addonsHtmlData, $data[2]);
                                                                    }
                                                                }
                                                            ?>
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div
                                                        class="addOns"
                                                        data-addons=<?php echo implode(",", $addonsHtmlData); ?>
                                                        data-product-id = <?php echo $product['productId']; ?>
                                                        >
                                                        
                                                    </div>
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
                                <!-- ALLERGIES MODAL -->
                                <?php if ($showAllergies === '1') { ?>
                                    <div class="modal" id="allergies<?php echo $product['productId']; ?>" role="dialog">
                                        <div class="modal-dialog">

                                            <form method="post" action="<?php echo $this->baseUrl . 'warehouse/addProductAllergies/' . $details['productExtendedId']; ?>">
                                                <div class="modal-content">
                                                <?php
                                                $product['allergies'] = unserialize($product['allergies']);
                                            ?>
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">
                                                            Set allergie(s) for product "<?php echo $details['name']; ?>"
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body row" style="margin-left:5px">
                                                        <!-- Modal content-->
                                                        <?php foreach ($allergies as $allergy) {?>
                                                                <label class="checkbox-inline" >
                                                                    <input
                                                                        type="checkbox"
                                                                        name="productAllergies[]"
                                                                        value="<?php echo $allergy; ?>"
                                                                        <?php
                                                                            if (!empty($product['allergies']['productAllergies']) && in_array($allergy, $product['allergies']['productAllergies'])) {
                                                                                echo 'checked';
                                                                            }
                                                                        ?>
                                                                    />
                                                                    <?php echo ucfirst($allergy); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </label>
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
                                <button style="display:none;" id="btn-<?php echo  $product['productId']; ?>" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProductProductId<?php echo  $product['productId']; ?>">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade"  id="editProductProductId<?php echo  $product['productId']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 style="text-align:left;">Edit product "<?php echo $details['name']; ?>"</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <!-- ITEM EDITOR -->
                                                <div class="item-editor addEditForm">
                                                    <div style="width:100%">
                                                        <form id="editProduct<?php echo $product['productId']; ?>" method="post" action="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId']; ?>"  class="form-inline"  enctype="multipart/form-data">
                                                            <input type="text" name="productExtended[productId]" value="<?php echo $product['productId']; ?>" readonly required hidden />
                                                            <input
                                                                type="text"
                                                                name="productExtended[updateCycle]"
                                                                value="<?php echo (intval($details['productUpdateCycle']) + 1); ?>"
                                                                readonly required hidden
                                                            />
                                                            <legend style="text-align:left;">Product basic data</legend>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="name<?php echo $product['productId'] ?>">Name: </label>
                                                                <input type="text" name="productExtended[name]" id="name<?php echo $product['productId'] ?>" class="form-control" required value="<?php echo $details['name']; ?>" />
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="shortDescription<?php echo $product['productId'] ?>">Short description: </label>
                                                                <input type="text" name="productExtended[shortDescription]" id="shortDescription<?php echo $product['productId'] ?>" class="form-control" value="<?php echo  $details['shortDescription']; ?>" />
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="longDescription<?php echo $product['productId'] ?>">Long description: </label>
                                                                <textarea name="productExtended[longDescription]" id="longDescription<?php echo $product['productId'] ?>" rows="1" class="form-control"><?php if($details['longDescription']) echo  $details['longDescription']; ?></textarea>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12  form-group">
                                                                <label for="preparationTime<?php echo $product['productId'] ?>">Preparation time in minutes: </label>
                                                                <input type="number" min="0" value="<?php echo $product['preparationTime']; ?>" max="255" name="product[preparationTime]" id="preparationTime<?php echo $product['productId'] ?>" class="form-control" />
                                                            </div>
                                                            <?php if (in_array($localTypeId, $vendorTypes)) { ?>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label for="vatEdit<?php echo $product['productId'] ?>">Local VAT: </label>
                                                                    <select
                                                                        class="form-control"
                                                                        name="productExtended[vatpercentage]"
                                                                        id="vatEdit<?php echo $product['productId'] ?>"
                                                                        class="form-control"
                                                                    >
                                                                        <option value="">Select</option>
                                                                        <?php foreach ($taxRates as $tax) { ?>
                                                                            <option
                                                                                value="<?php echo $tax; ?>"
                                                                                <?php if ($tax === intval($details['vatpercentage'])) { echo 'selected'; } ?>
                                                                            >
                                                                                <?php echo $tax; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (in_array($deliveryTypeId, $vendorTypes)) { ?>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label for="deliveryVatEdit<?php echo $product['productId'] ?>">Delivery VAT: </label>
                                                                    <select
                                                                        class="form-control"
                                                                        name="productExtended[deliveryVatpercentage]"
                                                                        id="deliveryVatEdit<?php echo $product['productId'] ?>"
                                                                        class="form-control"
                                                                    >
                                                                        <option value="">Select</option>
                                                                        <?php foreach ($taxRates as $tax) { ?>
                                                                            <option
                                                                                value="<?php echo $tax; ?>"
                                                                                <?php if ($tax === intval($details['deliveryVatpercentage'])) { echo 'selected'; } ?>
                                                                            >
                                                                                <?php echo $tax; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (in_array($pickupTypeId, $vendorTypes)) { ?>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label for="pickupVatEdit<?php echo $product['productId'] ?>">Pickup VAT: </label>
                                                                    <select
                                                                        class="form-control"
                                                                        name="productExtended[pickupVatpercentage]"
                                                                        id="pickupVatEdit<?php echo $product['productId'] ?>"
                                                                        class="form-control"
                                                                    >
                                                                        <option value="">Select</option>
                                                                        <?php foreach ($taxRates as $tax) { ?>
                                                                            <option
                                                                                value="<?php echo $tax; ?>"
                                                                                <?php if ($tax === intval($details['pickupVatpercentage'])) { echo 'selected'; } ?>
                                                                            >
                                                                                <?php echo $tax; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="dateTimeFrom<?php echo $product['productId'] ?>">Availabe from: </label>
                                                                <input
                                                                    type="text"
                                                                    id="dateTimeFrom<?php echo $product['productId'] ?>"
                                                                    name="product[dateTimeFrom]"
                                                                    class="form-control productTimePickers"
                                                                    <?php if ($product['dateTimeFrom']) { ?>
                                                                        value="<?php echo date('Y/m/d H:i:s', strtotime($product['dateTimeFrom'])); ?>"
                                                                    <?php } ?>
                                                                    required
                                                                />
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="dateTimeTo<?php echo $product['productId'] ?>">Availabe to: </label>
                                                                <input
                                                                    type="text"
                                                                    id="dateTimeTo<?php echo $product['productId'] ?>"
                                                                    name="product[dateTimeTo]"
                                                                    class="form-control productTimePickers"
                                                                    <?php if ($product['dateTimeTo']) { ?>
                                                                        value="<?php echo date('Y/m/d H:i:s', strtotime($product['dateTimeTo'])); ?>"
                                                                    <?php } ?>
                                                                    required
                                                                />
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label for="editCategoryId<?php echo $product['productId'] ?>">Product category: </label>
                                                                <select class="form-control" id="editCategoryId<?php echo $product['productId'] ?>" name="product[categoryId]" required>
                                                                    <option value="">Select</option>
                                                                    <?php foreach ($categories as $category) { ?>
                                                                        <option
                                                                            <?php if ($category['categoryId'] === $product['categoryId']) echo 'selected'; ?>
                                                                            value="<?php echo $category['categoryId']; ?>"
                                                                            >
                                                                            <?php echo $category['category']; ?> (<?php echo $category['active'] === '1' ? 'active' : 'blocked'; ?>)
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label>Printers</label>
                                                                <label class="checkbox-inline">
                                                                    <input
                                                                        type="checkbox"
                                                                        <?php if (is_null($product['printers'])) echo 'checked'; ?>
                                                                    />
                                                                    &nbsp;&nbsp;Default printing
                                                                </label>
                                                                <?php foreach ($printers as $printer) {?>
                                                                        <label class="checkbox-inline" for="printerId<?php echo $product['productId']; ?><?php echo $printer['id']; ?>">
                                                                            <input
                                                                                type="checkbox"
                                                                                id="printerId<?php echo $product['productId']; ?><?php echo $printer['id']; ?>"
                                                                                name="productPrinters[]"
                                                                                value="<?php echo $printer['id']; ?>"
                                                                                <?php
                                                                                    if (isset($printerIds) && in_array($printer['id'], $printerIds)  && !is_null($product['printers'])) echo 'checked';
                                                                                ?>
                                                                            />
                                                                            &nbsp;&nbsp;<?php echo $printer['printer']; ?> (<?php echo $printer['active'] === '1' ? 'active' : 'blocked'; ?>)
                                                                        </label>
                                                                <?php } ?>
                                                            </div>

                                                            <?php if ($isMain) { ?>
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label>Only one</label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="product[onlyOne]" value="1" <?php if ($product['onlyOne'] === '1') echo  'checked'; ?> />
                                                                        &nbsp;&nbsp;Yes
                                                                    </label>
                                                                    <label class="radio-inline">
                                                                        <input type="radio" name="product[onlyOne]" value="0" <?php if ($product['onlyOne'] === '0') echo  'checked'; ?> />
                                                                        &nbsp;&nbsp;No
                                                                    </label>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-lg-4 col-sm-12">
                                                                <label>Add remark</label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="product[addRemark]" value="1" <?php if ($product['addRemark'] === '1') echo  'checked'; ?> />
                                                                    &nbsp;&nbsp;Yes
                                                                </label>
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="product[addRemark]" value="0" <?php if ($product['addRemark'] === '0') echo  'checked'; ?> />
                                                                    &nbsp;&nbsp;No
                                                                </label>
                                                            </div>
                                                            <legend style="text-align:left;">Select product types</legend>
                                                            <?php
                                                                foreach ($productTypes as $type) {
                                                                    $localPrice = 0;
                                                                    $deliveryPrice = 0;
                                                                    $pickupPrice = 0;
                                                                    $checked = '';
                                                                    $showInPublic = '';

                                                                    if (in_array($type['id'], $productDetailsIds)) {
                                                                        $checked = 'checked';
                                                                        $showInPublic = 'checked';
                                                                        foreach($product['productDetails'] as $details) {
                                                                            if ($details['productTypeId'] === $type['id']) {
                                                                                if ($details['showInPublic'] === '0') {
                                                                                    $showInPublic = '';
                                                                                }
                                                                                $localPrice = $details['price'];
                                                                                $deliveryPrice = $details['deliveryPrice'];
                                                                                $pickupPrice = $details['pickupPrice'];
                                                                                $productExtendedId = $details['productExtendedId'];
                                                                            }
                                                                        }
                                                                    }
                                                                ?>
                                                                    <div class="col-lg-4 col-sm-12">
                                                                        <?php
                                                                            if (isset($productExtendedId)) {
                                                                            ?>
                                                                                <input type="number" value="<?php echo $productExtendedId; ?>" name="productTypes[<?php echo $type['id']; ?>][oldExtendedId]" readonly required hidden />
                                                                            <?php
                                                                                unset($productExtendedId);
                                                                            }
                                                                        ?>
                                                                        <h3>
                                                                            <?php
                                                                                echo $type['productType'];
                                                                                if ($type['isBoolean'] === '1') echo '&nbsp;&nbsp;(only yes or no)';
                                                                            ?>
                                                                        </h3>
                                                                        <label class="checkbox-inline" for="productType<?php echo $type['id'] . $product['productId']; ?>">
                                                                            <input
                                                                                type="checkbox"
                                                                                id="productType<?php echo $type['id'] . $product['productId']; ?>"
                                                                                name="productTypes[<?php echo $type['id']; ?>][check]"
                                                                                value="<?php echo $type['id']; ?>"
                                                                                <?php echo $checked; ?>
                                                                                />
                                                                            Select <?php echo '"' . $type['productType'] . '"'; if ($type['isMain'] === '1') echo ' (main)'; ?>
                                                                        </label>
                                                                        <label class="checkbox-inline" for="productActive<?php echo $type['id'] . $product['productId']; ?>" style="margin-bottom:10px">
                                                                            <input
                                                                                type="checkbox"
                                                                                id="productActive<?php echo $type['id'] . $product['productId']; ?>"
                                                                                name="productTypes[<?php echo $type['id']; ?>][showInPublic]"
                                                                                value="<?php echo $type['id']; ?>"
                                                                                <?php echo ($showInPublic && $checked) ? $showInPublic : ''; ?>
                                                                            />
                                                                            <input
                                                                                type="text"
                                                                                name="productTypes[<?php echo $type['id']; ?>][isMain]"
                                                                                value="<?php echo ($type['isMain'] === '1') ? '1' : '0'; ?>"
                                                                                reaconly required hidden
                                                                            />
                                                                            <?php if ($checked) { ?>
                                                                                Active status <?php echo ($showInPublic) ? '<span style="background-color: #72b19f">(ACTIVE)</span>' : '<span style="background-color: #f2622f">(BLOCKED)</span> '; ?>
                                                                            <?php } else { ?>
                                                                                Active status
                                                                            <?php } ?>
                                                                        </label>
                                                                        <?php if (in_array($localTypeId, $vendorTypes)) { ?>
                                                                            <label for="price<?php echo $type['id'] . $product['productId']; ?>">Local price: </label>
                                                                            <input
                                                                                type="number"
                                                                                required
                                                                                step="0.01"
                                                                                name="productTypes[<?php echo $type['id']; ?>][price]"
                                                                                id="price<?php echo $type['id'] . $product['productId']; ?>"
                                                                                min="0" class="form-control"
                                                                                value = "<?php echo $localPrice; ?>"
                                                                            />
                                                                        <?php } ?>
                                                                        <?php if (in_array($deliveryTypeId, $vendorTypes)) { ?>
                                                                            <label for="deliveryPrice<?php echo $type['id'] . $product['productId']; ?>">Delivery price: </label>
                                                                            <input
                                                                                type="number"
                                                                                required
                                                                                step="0.01"
                                                                                name="productTypes[<?php echo $type['id']; ?>][deliveryPrice]"
                                                                                id="deliveryPrice<?php echo $type['id'] . $product['productId']; ?>"
                                                                                min="0" class="form-control"
                                                                                value = "<?php echo $deliveryPrice; ?>"
                                                                            />
                                                                        <?php } ?>
                                                                        <?php if (in_array($pickupTypeId, $vendorTypes)) { ?>
                                                                        <label for="pickupPrice<?php echo $type['id'] . $product['productId']; ?>">Pickup price: </label>
                                                                        <input
                                                                            type="number"
                                                                            required
                                                                            step="0.01"
                                                                            name="productTypes[<?php echo $type['id']; ?>][pickupPrice]"
                                                                            id="pickupPrice<?php echo $type['id'] . $product['productId']; ?>"
                                                                            min="0" class="form-control"
                                                                            value = "<?php echo $pickupPrice; ?>"
                                                                        />
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php
                                                                }
                                                            ?>

                                                            <!--
                                                                <div class="col-lg-4 col-sm-12">
                                                                    <label for="orderNo<?php #echo $product['productId'] ?>">Order number: </label>
                                                                    <input
                                                                        type="text"
                                                                        id="orderNo<?php #echo $product['productId'] ?>"
                                                                        name="product[orderNo]"
                                                                        class="form-control"
                                                                        value="<?php #echo intval($product['orderNo']); ?>"
                                                                        required
                                                                        />
                                                                </div>
                                                            -->
                                                            <legend>Upload product image</legend>
                                                            <div class="form-group has-feedback">
                                                                <input type="file" name="productImage" id="uploadProductImage" class="form-control" accept="image/png" />
                                                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input style="width: 100px;" type="button" onclick="submitForm('editProduct<?php echo $product['productId']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
                                                <button
                                                    style="width: 100px;"
                                                    class="grid-button-cancel button theme-editor-header-button"
                                                    type="button"
                                                    data-dismiss="modal"
                                                >
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                
                                <!-- END EDIT -->

                            </div>
                        <?php
                        }
                    ?>
                    <div id="paginationLinks">
                        <?php echo $pagination; ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
		<!-- end grid list -->
	</div>
</div>
<script src="<?php echo $this->baseUrl; ?>assets/home/js/products.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?php echo $this->baseUrl; ?>assets/js/jquery.datetimepicker.full.min.js"></script>
<script>
function editProduct(productId){
    $('#btn-'+productId).click();
}
</script>
<?php if (!empty($productNames)) { ?>
    <script>
        $(document).ready(function() {
            $('.selectProducts').select2();
        });
    </script>
<?php } ?>

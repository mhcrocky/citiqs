<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="main-wrapper theme-editor-wrapper">
	<div class="grid-wrapper">
        <?php if (is_null($categories) || is_null($printers)) { ?>
            <p style="margin-left:15px;"> No categories and / or printers.
                <a href="<?php echo $this->baseUrl . 'product_categories'; ?>">
                    Add category
                </a>
                <a href="<?php echo $this->baseUrl . 'printers'; ?>">
                    Add printer
                </a>
            </p>
        <?php } else { ?>
            <div class="grid-list">
                <!-- FILTER AND ADD NEW -->
                <div class="item-editor theme-editor" id='add-product'>
                    <div class="theme-editor-header d-flex justify-content-between" >
                        <div>
                            <img src="<?php echo $this->baseUrl; ?>assets/home/images/tiqslogonew.png" alt="">
                        </div>
                        <div class="theme-editor-header-buttons">
                            <input type="button" class="grid-button button theme-editor-header-button" onclick="submitForm('addProdcut')" value="Submit" />
                            <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('add-product', 'display')">Cancel</button>
                        </div>
                    </div>
                    <div class="edit-single-user-container">
                        <form id="addProdcut" method="post" action="<?php echo $this->baseUrl . 'warehouse/addProdcut'; ?>">
                            <input type="text" name="product[active]" value="1" required readonly hidden />
                            <fieldset class="row">
                                <legend>Add product</legend>
                                <!-- PRODUCT EXTENDED DATA -->
                                <div class="col-lg-4 col-sm-12">
                                    <label for="name">Name: </label>
                                    <input type="text" name="productExtended[name]" id="name" class="form-control" requried />
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="price">Price: </label>
                                    <input type="number" requried value="0" step="0.01" name="productExtended[price]" id="price" min="0" class="form-control" />
                                </div>
                                <div class="col-lg-4 col-sm-12">
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
                                <div class="col-lg-4 col-sm-12">
                                    <label for="addons">Addons: </label>
                                    <input type="text" name="productExtended[addons]" id="addons" class="form-control" requried />
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="options">Options: </label>
                                    <input type="text" name="productExtended[options]" id="options" class="form-control" requried />
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="vatInsert">VAT: </label>
                                    <input type="number" requried value="0" step="0.01" min="0" name="productExtended[vatpercentage]" id="vatInsert" class="form-control" />
                                </div>
                                <!-- PRODUCT DATA -->
                                <div class="col-lg-4 col-sm-12">
                                    <label for="dateTimeFrom">Availabe from: </label>
                                    <input type="text" id="dateTimeFrom" name="product[dateTimeFrom]" class="form-control productTimePickers" requried />
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="dateTimeTo">Availabe to: </label>
                                    <input type="text" id="dateTimeTo" name="product[dateTimeTo]" class="form-control productTimePickers" requried />
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <label for="addCategoryId">Product category: </label>
                                    <select type="text" class="form-control" id="addCategoryId" name="product[categoryId]" required>
                                        <option value="">Select</option>
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?php echo $category['categoryId']; ?>">
                                                <?php echo $category['category']; ?> (<?php echo $category['active'] === '1' ? 'active' : 'archived'; ?>)
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- PRINTERS -->
                                <div class="col-lg-4 col-sm-12">
                                    <label for="printer">Printers: </label>
                                    <?php foreach ($printers as $printer) { ?>
                                        <label class="checkbox-inline" for="printerId<?php echo $printer['id']; ?>">
                                            <input
                                                type="checkbox"
                                                id="printerId<?php echo $printer['id']; ?>"
                                                name="productPrinters[]"
                                                value="<?php echo $printer['id']; ?>"
                                                />
                                            <?php echo $printer['printer']; ?> (<?php echo $printer['active'] === '1' ? 'active' : 'archived'; ?>)
                                        </label>
                                    <?php } ?>                                
                                </div>

                                <!-- <div class="col-lg-4 col-sm-12">
                                    <label for="printer">Product spot(s): </label>
                                    <?php #foreach ($userSpots as $spot) { ?>
                                        <label class="checkbox-inline" for="spotId<?php #echo $spot['spotId']; ?>">
                                            <input
                                                type="checkbox"
                                                id="spotId<?php #echo $spot['spotId']; ?>"
                                                name="userSpots[]"
                                                value="<?php #echo $spot['spotId']; ?>"
                                                />
                                            <?php #echo $spot['spotName']; ?> (<?php #echo $spot['spotActive'] === '1' ? 'active' : 'archived'; ?>)
                                        </label>
                                    <?php #} ?>                                
                                </div> -->
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="grid-list-header row">
                    <div class="col-lg-4 col-md-4 col-sm-12 grid-header-heading">
                        <h2>Products</h2>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- <div class="form-group">
                            <label for="filterCategories">Filter products:</label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="<?php #echo $this->baseUrl . 'product_categories'; ?>"
                                    <?php #if (!isset($_GET['active'])) echo 'checked'; ?>
                                    onclick="redirect(this)"
                                    />
                                All categories
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="<?php #echo $this->baseUrl . 'product_categories?active=1'; ?>"
                                    <?php #if (isset($_GET['active']) && $_GET['active'] === '1') echo 'checked'; ?>
                                    onclick="redirect(this)"
                                    />
                                    Active categories
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="<?php #echo $this->baseUrl . 'product_categories?active=0'; ?>"
                                    <?php #if (isset($_GET['active']) && $_GET['active'] === '0') echo 'checked'; ?>
                                    onclick="redirect(this)"
                                    />
                                    Archived categories
                            </label>
                        </div> -->
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 search-container">
                        <button class="btn button-security my-2 my-sm-0 button grid-button" onclick="toogleElementClass('add-product', 'display')">Add product</button>
                    </div>
                </div>
                <!-- LIST -->
                <?php if (is_null($products)) { ?>
                    <p>No products in list.
                <?php } else { ?>
                    <?php
                        foreach ($products as $product ) {
                            $product = reset($product);
                        ?>
                            <div class="grid-item">
                                <div class="item-header">
                                    <p class="item-description">Category: 
                                        <?php
                                            echo $product['category'];
                                            echo $product['categoryActive'] === '1' ? ' (<span style="color:#009933">active</span>)' : ' (<span style="color:#ff3333">archived</span>)'
                                        ?>
                                    </p>
                                    <p class="item-description">Name: <?php echo $product['name']; ?></p>
                                    <p class="item-description">Description: <?php echo $product['shortDescription']; ?></p>
                                    <p class="item-description">Price: <?php echo $product['price']; ?></p>
                                    <p class="item-description">VAT: <?php echo floatval($product['productVat']); ?></p><!-- 6) SHOW VAT IN DETAILS -->
                                    <p class="item-category">Status:
                                        <?php echo $product['productActive'] === '1' ? '<span style="color:#009933">Active</span>' : '<span style="color:#ff3333">Archived</span>'; ?>
                                    </p>
                                    <p class="item-description">From: 
                                        <?php echo ($product['dateTimeFrom']) ? $product['dateTimeFrom'] : 'All time'; ?>
                                    </p>
                                    <p class="item-description">To: 
                                        <?php echo ($product['dateTimeTo']) ? $product['dateTimeTo'] : 'All time'; ?>
                                    </p>
                                    <?php
                                        if ($product['printers']) {
                                            $printerIds = [];
                                            $productPrinters = explode(',', $product['printers']);
                                            echo '<dl>';
                                            echo    '<dt>Printers:</dt>';
                                            foreach($productPrinters as $printer) {
                                                $printer = explode('|', $printer);
                                                array_push($printerIds, $printer[0]);
                                                $string = $printer[1];
                                                $string .= $printer[2] === '1' ? ' (<span style="color:#009933">active</span>)' : ' (<span style="color:#ff3333">archived</span>)';
                                                echo '<dd>' . $string . '</dd>';
                                            }
                                            echo '</dl>';
                                        }
                                    ?>
                                    <?php
                                        // if ($product['spotProductData']) {
                                        //     $productSpots = explode(',', $product['spotProductData']);
                                        //     echo '<dl>';
                                        //     echo    '<dt>Available on spot(s):</dt>';
                                        //     // $formSpotData = '';
                                        //     foreach($productSpots as $spot) {
                                        //         // porduct data
                                        //         $spot = explode('|', $spot);
                                        //         $string = $spot[3];
                                        //         $string .= $spot[2] === '1' ? ' (<span style="color:#009933">active</span>)' : ' (<span style="color:#ff3333">archived</span>)';
                                        //         echo '<dd>' . $string . '</dd>';

                                        //         $formSpotData .= '<label class="checkbox-inline" for="tbl_shop_spot_products' . $spot[0] . '">';
                                        //         $formSpotData .= '<input ';
                                        //         $formSpotData .= 'type="checkbox" ';
                                        //         $formSpotData .= 'id=tbl_shop_spot_products' . $spot[0] . ' ';
                                        //         $formSpotData .= 'name="productSpots[]" ';
                                        //         $formSpotData .= 'value="' . $spot[0] . '" ';
                                        //         if ($spot[2] === '1') {
                                        //             $formSpotData .= 'checked';
                                        //         }
                                        //         $formSpotData .= '/>';
                                        //         $formSpotData .=  $spot[3] . ' ';
                                        //         $formSpotData .=  $spot[2] === '1' ? ' (<span style="color:#009933">active</span>)' : ' (<span style="color:#ff3333">archived</span>)';
                                        //         $formSpotData .= '</label>';
                                        //     }
                                        //     echo '</dl>';
                                        // }
                                    ?>
                                </div><!-- end item header -->
                                <div class="grid-footer">
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editProductProductId<?php echo $product['productId']; ?>', 'display')" title="Click to edit" >
                                            <i class="far fa-edit"></i>
                                        </span>
                                    </div>
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" data-toggle="modal" data-target="#timeModal<?php echo $product['productId']; ?>"  title="Click to add time">
                                            <i class="far fa-clock-o"></i>
                                        </span>
                                    </div>
                                    <?php if ($product['productActive'] === '1') { ?>
                                        <div title="Click to archive category" class="iconWrapper delete-icon-wrapper">
                                            <a href="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId'] .'/0'; ?>" >
                                                <span class="fa-stack fa-2x delete-icon">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div title="Click to activate category" class="iconWrapper delete-icon-wrapper">
                                            <a href="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId'] .'/1'; ?>" >
                                                <span class="fa-stack fa-2x" style="background-color:#0f0">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!--TIME MODAL -->
                                <div class="modal" id="timeModal<?php echo $product['productId']; ?>" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <form method="post" action="warehouse/addProductTimes/<?php echo $product['productId']; ?>">
                                            <input type="text" name="productName" value="<?php echo $product['name']; ?>" readonly requried hidden />
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">
                                                        Set availability days and time for product "<?php echo $product['name']; ?>"
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                        $dayOfWeeks = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                                        foreach($dayOfWeeks as $day) {
                                                            
                                                    ?>
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
                                                                            echo 'value="' . $first[2] . '"';
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
                                                                            echo 'value="' . $first[3] . '"';
                                                                        }
                                                                        unset($first)
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
                                                                                        <input type="time" name="productTime[<?php echo $day; ?>][from][]" value="<?php echo $dayData[2]; ?>" />
                                                                                    </label>
                                                                                    <label>To:
                                                                                        <input type="time" name="productTime[<?php echo $day; ?>][to][]" value="<?php echo $dayData[3]; ?>"/>
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
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- ITEM EDITOR -->
                                <div class="item-editor theme-editor" id="editProductProductId<?php echo  $product['productId']; ?>">
                                    <div class="theme-editor-header d-flex justify-content-between">
                                        <div class="theme-editor-header-buttons">
                                            <input type="button" onclick="submitForm('editProduct<?php echo $product['productId']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
                                            <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('editProductProductId<?php echo  $product['productId']; ?>', 'display')">Cancel</button>
                                        </div>
                                    </div>
                                    <div class="edit-single-user-container">
                                        <form id="editProduct<?php echo $product['productId']; ?>" method="post" action="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId']; ?>" >
                                            <input type="text" name="productExtended[productId]" value="<?php echo $product['productId']; ?>" readonly required hidden />
                                            <fieldset  class="row">
                                                <legend>Product details</legend>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="name<?php echo $product['productId'] ?>">Name: </label>
                                                    <input type="text" name="productExtended[name]" id="name<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['name']; ?>" />
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="editCategoryId<?php echo $product['productId'] ?>">Product category: </label>
                                                    <select type="text" class="form-control" id="editCategoryId<?php echo $product['productId'] ?>" name="product[categoryId]" required>
                                                        <option value="">Select</option>
                                                        <?php foreach ($categories as $category) { ?>
                                                            <option
                                                                <?php if ($category['categoryId'] === $product['categoryId']) echo 'selected'; ?>
                                                                value="<?php echo $category['categoryId']; ?>"
                                                                >
                                                                <?php echo $category['category']; ?> (<?php echo $category['active'] === '1' ? 'active' : 'archived'; ?>)
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="vatEdit<?php echo $product['productId'] ?>">VAT: </label>
                                                    <input
                                                        type="number"
                                                        requried
                                                        value="<?php echo floatval($product['productVat']); ?>"
                                                        step="0.01"
                                                        min="0"
                                                        name="productExtended[vatpercentage]"
                                                        id="vatEdit<?php echo $product['productId'] ?>"
                                                        class="form-control"
                                                        />
                                                </div>
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
                                                        requried
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
                                                        requried
                                                        />
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="price<?php echo $product['productId'] ?>">Price: </label>
                                                    <input
                                                        type="number"
                                                        requried
                                                        value="<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>"
                                                        step="0.01"
                                                        name="productExtended[price]"
                                                        id="price<?php echo $product['productId'] ?>"
                                                        class="form-control"
                                                        />
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="shortDescription<?php echo $product['productId'] ?>">Short description: </label>
                                                    <input type="text" name="productExtended[shortDescription]" id="shortDescription<?php echo $product['productId'] ?>" class="form-control" value="<?php echo $product['shortDescription']; ?>" />
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="longDescription<?php echo $product['productId'] ?>">Long description: </label>
                                                    <textarea name="productExtended[longDescription]" id="longDescription<?php echo $product['productId'] ?>" rows="1" class="form-control"><?php echo $product['longDescription']; ?></textarea>
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="addons<?php echo $product['productId'] ?>">Addons: </label>
                                                    <input type="text" name="productExtended[addons]" id="addons<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['addons']; ?>" />
                                                </div>
                                                <div class="col-lg-4 col-sm-12">
                                                    <label for="options<?php echo $product['productId'] ?>">Options: </label>
                                                    <input type="text" name="productExtended[options]" id="options<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['options']; ?>" />
                                                </div>
                                                <div class="col-lg-4 col-sm-12"> 
                                                    <label>Printers</label>
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
                                                                <?php echo $printer['printer']; ?> (<?php echo $printer['active'] === '1' ? 'active' : 'archived'; ?>)
                                                            </label>
                                                    <?php } ?>
                                                </div>

                                                <!-- <div class="col-md-6 col-sm-12"> 
                                                    <label>Available on spot(s)</label>
                                                    <?php #echo $formSpotData; ?>
                                                </div> -->
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                                <!-- END EDIT -->
                            </div>
                        <?php
                        }
                    ?>
                <?php } ?>
            </div>
        <?php } ?>
		<!-- end grid list -->
	</div>
</div>
<script>
	'use strict';
	function redirect(element) {
		if (element.value !== window.location.href) {
			window.location.href = element.value;
		}
    }
    function showDay(element, day) {
        if (element.checked) {
            document.getElementById(day).style.display = "initial";
        } else {
            document.getElementById(day).style.display = "none";
        }
    }

    function addTimePeriod(timeDiv, day) {
        let element = '';
        element +=  '<div>';
        element +=      '<label>From: ';
        element +=          '<input type="time" name="productTime[' + day + '][from][]" />';
        element +=      '</label>';
        element +=      '<label>To: ';
        element +=          '<input type="time" name="productTime[' + day + '][to][]" />';
        element +=      '</label>';
        element +=      '<span class="fa-stack fa-2x" onclick="removeParent(this)">';
        element +=          '<i class="fa fa-times"></i>';
        element +=      '</span>';
        element +=  '</div>';
        $( "#" + timeDiv).append(element);
    }
</script>

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
                        <form class="form-inline" id="addProdcut" method="post" action="<?php echo $this->baseUrl . 'warehouse/addProdcut'; ?>">
                            <input type="text" name="product[active]" value="1" required readonly hidden />
                            <legend>Add product</legend>
                            <!-- PRODUCT EXTENDED DATA -->
                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input type="text" name="productExtended[name]" id="name" class="form-control" requried />
                            </div>
                            <div class="form-group">
                                <label for="price">Price: </label>
                                <input type="number" requried value="0" step="0.01" name="productExtended[price]" id="price" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="shortDescription">Short description: </label>
                                <input type="text" name="productExtended[shortDescription]" id="shortDescription" class="form-control" />                         
                            </div>
                            <div class="form-group">
                                <label for="longDescription">Long description: </label>
                                <textarea name="productExtended[longDescription]" id="longDescription" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="addons">Addons: </label>
                                <input type="text" name="productExtended[addons]" id="addons" class="form-control" requried />
                            </div>
                            <div class="form-group">
                                <label for="options">Options: </label>
                                <input type="text" name="productExtended[options]" id="options" class="form-control" requried />
                            </div>
                            <!-- PRODUCT DATA -->
                            <div class="form-group">
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
                            <div class="form-group"><!--5) ADD PROPERTY IN INSERT FORM -->
                                <label for="vatInsert">VAT: </label>
                                <input type="number" requried value="0" step="0.01" min="0" name="product[vatpercentage]" id="vatInsert" class="form-control" />
                            </div>
                            <!-- PRINTERS -->
                            <div class="form-group">
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
                                    <?php
                                        if ($product['printers']) {
                                            $printerIds = array_keys($product['printers']);
                                            echo '<dl>';
                                            echo    '<dt>Printers:</dt>';
                                            foreach($product['printers'] as $printer) {
                                                $printer = reset($printer);
                                                $string = $printer['printer'];
                                                $string .= $printer['printerActive'] === '1' ? ' (<span style="color:#009933">active</span>)' : ' (<span style="color:#ff3333">archived</span>)';
                                                echo '<dd>' . $string . '</dd>';
                                            }
                                            echo '</dl>';
                                        }
                                    ?>
                                </div><!-- end item header -->
                                <div class="grid-footer">
                                    <div class="iconWrapper">
                                        <span class="fa-stack fa-2x edit-icon btn-edit-item" onclick="toogleAllElementClasses('editProductProductId<?php echo $product['productId']; ?>', 'display')">
                                            <i class="far fa-edit"></i>
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
                                <!-- ITEM EDITOR -->
                                <div class="item-editor theme-editor" id="editProductProductId<?php echo  $product['productId']; ?>">
                                    <div class="theme-editor-header d-flex justify-content-between">
                                        <div class="theme-editor-header-buttons">
                                            <input type="button" onclick="submitForm('editProduct<?php echo $product['productId']; ?>')" class="grid-button button theme-editor-header-button" value="Submit" />
                                            <button class="grid-button-cancel button theme-editor-header-button" onclick="toogleElementClass('editProductProductId<?php echo  $product['productId']; ?>', 'display')">Cancel</button>
                                        </div>
                                    </div>
                                    <div class="edit-single-user-container">
                                        <form class="form-inline" id="editProduct<?php echo $product['productId']; ?>" method="post" action="<?php echo $this->baseUrl . 'warehouse/editProduct/' . $product['productId']; ?>" >
                                            <input type="text" name="productExtended[productId]" value="<?php echo $product['productId']; ?>" readonly required hidden />
                                            <legend>Product details</legend>
                                            <div class="form-group">
                                                <label for="name<?php echo $product['productId'] ?>">Name: </label>
                                                <input type="text" name="productExtended[name]" id="name<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['name']; ?>" />
                                            </div>
                                            <div class="form-group">
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
                                            <div class="form-group"><!--5) ADD PROPERTY IN INSERT FORM -->
                                                <label for="vatEdit<?php echo $product['productId'] ?>">VAT: </label><!-- 7) SHOW IN UPDATE -->
                                                <input
                                                    type="number"
                                                    requried
                                                    value="<?php echo floatval($product['productVat']); ?>"
                                                    step="0.01"
                                                    min="0"
                                                    name="product[vatpercentage]"
                                                    id="vatEdit<?php echo $product['productId'] ?>"
                                                    class="form-control"
                                                    />
                                            </div>
                                            <div class="form-group">
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
                                            <div class="form-group">
                                                <label for="shortDescription<?php echo $product['productId'] ?>">Short description: </label>
                                                <input type="text" name="productExtended[shortDescription]" id="shortDescription<?php echo $product['productId'] ?>" class="form-control" value="<?php echo $product['shortDescription']; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="longDescription<?php echo $product['productId'] ?>">Long description: </label>
                                                <textarea name="productExtended[longDescription]" id="longDescription<?php echo $product['productId'] ?>" class="form-control"><?php echo $product['longDescription']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="addons<?php echo $product['productId'] ?>">Addons: </label>
                                                <input type="text" name="productExtended[addons]" id="addons<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['addons']; ?>" />
                                            </div>
                                            <div class="form-group">
                                                <label for="options<?php echo $product['productId'] ?>">Options: </label>
                                                <input type="text" name="productExtended[options]" id="options<?php echo $product['productId'] ?>" class="form-control" requried value="<?php echo $product['options']; ?>" />
                                            </div>
                                            <div class="form-group">
                                            
                                            <?php foreach ($printers as $printer) { ?>
                                                    <label class="checkbox-inline" for="printerId<?php echo $product['productId']; ?><?php echo $printer['id']; ?>">
                                                        <input
                                                            type="checkbox"
                                                            id="printerId<?php echo $product['productId']; ?><?php echo $printer['id']; ?>"
                                                            name="productPrinters[]"
                                                            value="<?php echo $printer['id']; ?>"
                                                            <?php
                                                                if ($product['printers'] && isset($printerIds) && in_array($printer['id'], $printerIds)) echo 'checked';
                                                            ?>
                                                            />
                                                        <?php echo $printer['printer']; ?> (<?php echo $printer['active'] === '1' ? 'active' : 'archived'; ?>)
                                                    </label>
                                            <?php } ?>
                                            </div>
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
</script>

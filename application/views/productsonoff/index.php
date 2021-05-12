<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
    var productGloabls = {};
</script>

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
                                    value="productsonoff/all"
                                    <?php if ($active === 'all' || $active === '') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                All products <?php echo $active;?>
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="productsonoff/active"
                                    <?php if ($active === 'active') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                    Active products
                            </label>
                            <label class="radio-inline">
                                <input
                                    type="radio"
                                    name="locationHref"
                                    value="productsonoff/archived"
                                    <?php if ($active === 'archived') echo 'checked'; ?>
                                    onclick="redirectToNewLocation(this.value)"
                                    />
                                    Archived products
                            </label>
                        </div>
                        <?php if ($products) { ?>
                            <form method="post" action="<?php echo base_url() ?>productsonoff" >
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
                </div>
                
                <!-- LIST -->
                <?php if (is_null($products)) { ?>
                    <p>No products in list.
                <?php } else { ?>
                    <?php
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

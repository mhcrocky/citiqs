<main class="container" style="text-align:left">
    <?php if (!empty($categoryProducts) ) { ?>
        <h1>Make an order</h1>
        <div class="main-slider container" style='overflow-x:hidden; overflow-y: hidden; margin-top: 20px; margin-bottom: 20px'>
            <?php
                $form = '';
                $productsHtml = '';
                foreach($categoryProducts as $category => $products) {
                ?>
	    		<!-- single book -->
                <div class="item-category">
                    <div class="filter-sidebar">
                    <a href="javascript:void(0);" data-categorie-id="7" class="go-category left-side selected"><?php echo $category;?></a>
                    </div>
                    <?php foreach ($products as $product) { ?>
                        <div class="product__list">
                            <div class="product">
                                <div class="product__img">
                                    <img src="https://tiqs.com/shop/attachments/shop_images/Heinikentap.jpg" alt="Heineken tap (25cl)">
                                </div>
                                <div class="product__actions">
                                    <div class="product__actions-box">
                                        <div class="pab pab-1">
                                            <div class="product__name">
                                                <?php echo $product['name']; ?>
                                            </div>
                                            <div>
                                                <span class="solo_price">&euro; <?php echo $product['price']; ?></span>
                                            </div>
                                            <!-- <div class="button">
                                                <a href="#">Options <i class="fa fa-list"></i></a>
                                            </div> -->
                                        </div>
                                        <div class="pab pab-2">
                                            <a
                                                class="pab-minus"
                                                href="javascript:void(0);"
                                                onclick="addToOrder(
                                                    'amount<?php echo  $product['productExtendedId']; ?>',
                                                    'quantity<?php echo  $product['productExtendedId']; ?>',                            
                                                    '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                                                    'class<?php echo $product['productExtendedId']; ?>',
                                                    'orderAmount<?php echo $product['productExtendedId'] ?>',
                                                    'orderQuantity<?php echo $product['productExtendedId'] ?>',
                                                    'category<?php echo  $product['productExtendedId']; ?>',
                                                    'name<?php echo  $product['productExtendedId']; ?>',
                                                    'shortDescription<?php echo  $product['productExtendedId']; ?>',
                                                    false
                                                )"
                                                >
                                                <i class="fa fa-minus"></i>
                                            </a>
                                            <a
                                                class="pab-plus refresh-me add-to-cart"
                                                style="margin-top: 4px"
                                                data-id="7"
                                                href="javascript:void(0);"
                                                onclick="addToOrder(
                                                    'amount<?php echo  $product['productExtendedId']; ?>',
                                                    'quantity<?php echo  $product['productExtendedId']; ?>',
                                                    '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                                                    'class<?php echo $product['productExtendedId']; ?>',
                                                    'orderAmount<?php echo $product['productExtendedId'] ?>',
                                                    'orderQuantity<?php echo $product['productExtendedId'] ?>',
                                                    'category<?php echo  $product['productExtendedId']; ?>',
                                                    'name<?php echo  $product['productExtendedId']; ?>',
                                                    'shortDescription<?php echo  $product['productExtendedId']; ?>',
                                                    true
                                                )"
                                                >
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            $form .= '<input type="number" value="0" min="0" step="0.01" ';
                            $form .= 'name="' . $product['productExtendedId'] . '[amount][]" ';
                            $form .= 'id="amount' . $product['productExtendedId'] . '" class="hideInput" disabled />';
                            $form .= '<input type="number" value="0" min="0" step="1" ';
                            $form .= 'name="' . $product['productExtendedId'] . '[quantity][]" ';
                            $form .= 'id="quantity' . $product['productExtendedId'] . '" class="hideInput" disabled />';
                            $form .= '<input type="text" min="0" step="0.01" ';
                            $form .= 'name="' . $product['productExtendedId'] . '[category][]" ';
                            $form .= 'id="category' . $product['productExtendedId'] . '" ';
                            $form .= 'value="' . $product['category'] . '" class="hideInput" disabled />';
                            $form .= '<input type="text" min="0" step="0.01" ';
                            $form .= 'name="' . $product['productExtendedId'] . '[name][]" ';
                            $form .= 'id="name' . $product['productExtendedId'] . '" ';
                            $form .= 'value="' . $product['name'] . '" class="hideInput" disabled />';
                            $form .= '<input type="text" min="0" step="0.01" ';
                            $form .= 'name="' . $product['productExtendedId'] . '[shortDescription][]" ';
                            $form .= 'id="shortDescription' . $product['productExtendedId'] . '" ';
                            $form .= 'value="' . $product['shortDescription'] . '" class="hideInput" disabled />';

                            $productsHtml .= '<div class="col-lg-6 hideElement class'. $product['productExtendedId'] . '"><p>Product: ' . $product['name'] . '</p></div>';
                            // $productsHtml .= '<div class="col-lg-3"><p>Description: ' . $product['shortDescription'] . '</p></div>';
                            // $productsHtml .= '<div class="col-lg-3"><p>Category: ' . $product['category'] . '</p></div>';
                            $productsHtml .= '<div class="col-lg-2 hideElement class'. $product['productExtendedId'] . '">';
                            $productsHtml .= '<p>Price: ';
                            $productsHtml .= ' <span id="orderAmount'. $product['productExtendedId']. '"></span>';
                            $productsHtml .= ' &euro;</p></div>';
                            $productsHtml .= '<div class="col-lg-2 hideElement class'. $product['productExtendedId'] . '">';
                            $productsHtml .= '<p>Quantity: ';
                            $productsHtml .= ' <span id="orderQuantity'. $product['productExtendedId']. '"></span>';
                            $productsHtml .= '</p></div>';
                        ?>


                    <?php } ?>
                </div>
                <?php
                }
            ?>
	    </div>
    <?php } ?>
    <div class="row">
        <h3>Ordered</h3>
        <?php echo $productsHtml; ?>
    </div>
    <form method="post" action="<?php echo base_url() . 'checkout_order' ?>"> 
        <?php echo $form; ?>
        <input type="submit" value="Make order" class="btn btn-primary"/>
    </form>
</main>
<?php if (!empty($categories) && !empty($products) ) { ?>
<script>
    var orderGlobals = (function(){
        return {
            'categories' : JSON.parse('<?php echo json_encode($categories);?>'),
            'products' : JSON.parse('<?php echo json_encode($products);?>'),
        }
    }())
</script>
<?php } ?>
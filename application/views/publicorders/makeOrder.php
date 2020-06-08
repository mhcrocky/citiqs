<style>
    main {
        margin-bottom:30px;
    }
    .makeOrder:hover {
        cursor: pointer;
    }
    .hideElement, .hideInput {
        visibility: hidden;
        height: 0px;
    }
    .showOrders {
        visibility: show;
        height: 20px;
        padding: 10px;
        margin-bottom: 5px;
    }
</style>
<main class="container" style="text-align:left">
    <h1>Make an order</h1>
    <div class="col-sm-12">
        <h2>Select category: </h2>
        <div class="form-group">            
            <select id="category" class="form-control" onchange="toogleCategories(this)">
                <option value="0">All</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="category_<?php echo $category['categoryId']?>"><?php echo $category['category']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    
    <h2>Products: </h2>
    <?php
        $form = '';
        $productsHtml = '';
        foreach ($products as $product) {
            $product = reset($product);
            
        ?>
            <div class="row category_<?php echo $product['categoryId']; ?>">
                
                <h4 class="col-lg-3">Name: <?php echo $product['name']; ?></h4>
                <div class="col-lg-3">Description: <?php echo $product['shortDescription']; ?></div>
                <div class="col-lg-3">Category: <?php echo $product['category']; ?></div>
                <div class="col-lg-1">Price: <?php echo $product['price']; ?> &euro;</div>
                <div class="col-lg-2">
                    <span
                        class="fa-stack makeOrder"
                        onclick="addToOrder(
                            'amount<?php echo  $product['productExtendedId']; ?>',
                            'quantity<?php echo  $product['productExtendedId']; ?>',
                            '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                            'class<?php echo $product['productExtendedId']; ?>',
                            'orderAmount<?php echo $product['productExtendedId'] ?>',
                            'orderQuantity<?php echo $product['productExtendedId'] ?>',
                            true
                        )"
                        >
                        <i class="fa fa-plus"></i>
                    </span>                        
                    <span
                        class="fa-stack makeOrder"
                        onclick="addToOrder(
                            'amount<?php echo  $product['productExtendedId']; ?>',
                            'quantity<?php echo  $product['productExtendedId']; ?>',
                            '<?php echo filter_var($product['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); ?>',
                            'class<?php echo $product['productExtendedId']; ?>',
                            'orderAmount<?php echo $product['productExtendedId'] ?>',
                            'orderQuantity<?php echo $product['productExtendedId'] ?>',
                            false
                        )"
                        >
                        <i class="fa fa-minus"></i>
                    </span>
                </div>                    
            </div>
            <?php
                $form .= '<input type="number" value="0" min="0" step="0.01" ';
                $form .= 'name="amount[' . $product['productExtendedId'] . ']" ';
                $form .= 'id="amount' . $product['productExtendedId'] . '" class="hideInput" disabled />';
                $form .= '<input type="number" value="0" min="0" step="1" ';
                $form .= 'name="quantity[' . $product['productExtendedId'] . ']" ';
                $form .= 'id="quantity' . $product['productExtendedId'] . '" class="hideInput" disabled />';

                $productsHtml .= '<div class="col-lg-6 hideElement class'. $product['productExtendedId'] . '""><p>Product: ' . $product['name'] . '</p></div>';
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
        <?php
        }
    ?>
    
    
    
    <div class="row">
        <h3>Ordered</h3>
        <?php echo $productsHtml; ?>
    </div>
    <form method="post" action="<?php echo base_url() . 'confirm_order' ?>"> 
        <?php echo $form; ?>
        <input type="submit" value="Make order" class="btn btn-primary"/>
    </form>
</main>


<script>
    var orderGlobals = (function(){
        return {
            'categories' : JSON.parse('<?php echo json_encode($categories);?>'),
            'products' : JSON.parse('<?php echo json_encode($products);?>'),
        }
    }())

    function toogleCategories(element) {
        let categories = orderGlobals.categories;
        let i;
        let categorieslength = categories.length;
        if (element.value === '0') {
            for (i = 0; i < categorieslength; i++) {            
            let elementClass = 'category_' + categories[i]['categoryId'];
                $('.' + elementClass).show();
            }
            return;
        }

        for (i = 0; i < categorieslength; i++) {            
            let elementClass = 'category_' + categories[i]['categoryId'];
            if (elementClass === element.value) {
                $('.' + elementClass).show();
            } else {
                $('.' + elementClass).hide();
            }
        }
        return;
    }

    function addToOrder(amountId, quantiyId, price, className, orderAmountId, orderQuantityId, plus) {
        let amountElement = document.getElementById(amountId);
        let amountValue = parseFloat(amountElement.value);

        let quantityElement = document.getElementById(quantiyId);
        let quantityValue = parseFloat(quantityElement.value);

        let orderAmountElement = document.getElementById(orderAmountId);
        let orderQuantityElement = document.getElementById(orderQuantityId);

        if (amountValue >= 0) {
            amountValue = (plus) ? (amountValue + parseFloat(price)) : amountValue > 0 ? (amountValue - parseFloat(price)) : 0;
            amountElement.value = amountValue;
        }

        if (quantityValue >= 0) {
            quantityValue = (plus) ? (quantityValue + 1) : quantityValue > 0 ? (quantityValue - 1) : 0;
            quantityElement.value = quantityValue;
        }

        if (amountValue > 0 && quantityValue > 0) {
            $('.' + className).removeClass('hideElement').addClass('showOrders');
            amountElement.disabled = false;
            quantityElement.disabled = false;
        } else {
            $('.' + className).removeClass('showOrders').addClass('hideElement');
            amountElement.disabled = true;
            quantityElement.disabled = true;
        }

        orderAmountElement.innerHTML = amountValue;
        orderQuantityElement.innerHTML = quantityValue;

        return;
    }


</script>

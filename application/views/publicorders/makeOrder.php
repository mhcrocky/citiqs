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
        foreach ($products as $product) {
            $product = reset($product);
        ?>
            <div class="row category_<?php echo $product['categoryId']; ?>" style="margin-bottom:15px;">
                
                <h4 class="col-lg-3">Name: <?php echo $product['name']; ?></h4>
                <div class="col-lg-3">Description: <?php echo $product['shortDescription']; ?></div>
                <div class="col-lg-3">Category: <?php echo $product['category']; ?></div>
                <div class="col-lg-1">Price: <?php echo $product['price']; ?> &euro;</div>
                <div class="col-lg-2">
                    <span class="fa-stack">
                        <i class="fa fa-plus"></i>
                    </span>                        
                    <span class="fa-stack">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>                    
            </div>
        <?php
        }
    ?>
    <div class="row" id="orders">
    </diV>
    

</main>


<script>
    var orderGlobals = (function(){
        return {
            'categories' : JSON.parse('<?php echo json_encode($categories);?>'),
            'products' : JSON.parse('<?php echo json_encode($products);?>'),
        }
    }())
    console.dir(orderGlobals.products);

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

</script>

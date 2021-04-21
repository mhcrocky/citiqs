<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- HEADER -->
<header class='header'>
	<nav class="navbar navbar-expand-lg container">
		<a class="navbar-brand" href="#">
			<img src="<?php echo base_url() . 'assets/images/2021/';  ?>tiqslogonew.png" alt="">
		</a>
		<button class="navbar-toggler py-2 px-3 px-md-4 bg-secondary" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></button>

		<div class="collapse navbar-collapse pl-md-4" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active pt-2 pt-md-0">
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
			</ul>
		</div>
		<button
			class="btn btn-primary btn-lg bg-primary px-3 px-md-4 text-center header__checkout"
			id='open-checkout'
		>
			<i class="fa fa-shopping-basket mr-md-3"></i>
			<span class='d-none d-lg-inline'>CHECKOUT</span>
		</button>
	</nav>
</header>
<!-- END HEADER -->
<!-- CATEGORIES SECTION -->
<section class='hero-section position-relative' style='display: none'>
	<div class="d-none d-md-flex col-6 px-0 hero__background">
		<img src="<?php echo base_url() . 'assets/images/2021/';  ?>food.jpg" alt="">
	</div>
	<div class="container">
		<!-- <div class="row">
			<div class="col-12 col-md-6">
				<h1>Our Menu</h1>
				<p class='text-muted mt-4 mb-5'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sagittis at est ut facilisis. Suspendisse eu luctus mauris.</p>
				<div class='d-flex flex-column flex-sm-row align-items-start flex-wrap'>
					<a href="#" class="btn btn-primary btn-lg bg-primary px-4 mr-sm-3 mt-3">Breakfast</a>
					<a href="#" class="btn btn-secondary btn-lg bg-secondary px-4 mt-3">Lunch & Dinner</a>
				</div>
			</div>
		</div> -->
		<!--<div class="row">
			<div class="col-lg-8 col-sm-12 col-xs-12">
				<div class="splide"  id="splideCategories">
					<div class="splide__track">
						<div class="splide__list">
							<?php
								$i = 0;
								foreach ($categories as $category) {
									$i++
									?>
										<div
											class="splide__slide"
											data-splide-hash="slide0<?php echo $i; ?>"
										>
											<div class="single-item__image">
												<?php if(isset($categoriesImages[$category])) { ?>
													<img src="<?php echo $categoriesImagesRelPath . $categoriesImages[$category][0]['image']; ?>" alt="" />
												<?php } ?>
												<p class='single-item__promotion'><?php echo $category; ?></p>
											</div>
										</div>
									<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>-->
	</div>
</section>
<!-- END CATEGORIES SECTION -->

<!-- hero section -->
<section class='hero-wrapper' style="background-image: url('https://images.unsplash.com/photo-1574126154517-d1e0d89ef734?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHx8&w=1000&q=80')">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-6">
				<div class="hero-content">
					<h1>Title of The restaurant </h1>
					<p>Location Address</p>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- category slider -->
<section class='category-slider pt-5 mt-3'>
	<div class="container">
		<div class="row">
			<div class="splide"  id="primary-category-slider">
				<div class="splide__track">
					<ul class="splide__list">
						<?php
							$i = 0;
							foreach ($categories as $category) {
								$i++
								?>
									<li
										class="splide__slide"
										data-splide-hash="slide0<?php echo $i; ?>"
										
									>
										<div class="slide__image">
											<?php if(isset($categoriesImages[$category])) { ?>
												<img src="<?php echo $categoriesImagesRelPath . $categoriesImages[$category][0]['image']; ?>" alt="" />
											<?php } ?>
											<p class='single-item__promotion'><?php echo $category; ?></p>
										</div>
									</li>
								<?php
							}
						?>

					</ul>
				</div>
			</div>
			<div class="splide"  id="secondary-category-slider">
				<div class="splide__track">
					<ul class="splide__list">
						<?php
							$i = 0;
							foreach ($categories as $category) {
								$i++
								?>
									<li
										class="splide__slide"
										data-splide-hash="slide0<?php echo $i; ?>"
										data-scroll='<?php echo $category; ?>'
									>
										<a href='#<?php echo $category; ?>' class="slide__image">
											<?php if(isset($categoriesImages[$category])) { ?>
												<img src="<?php echo $categoriesImagesRelPath . $categoriesImages[$category][0]['image']; ?>" alt="" />
											<?php } ?>
											<p><?php echo $category; ?></p>
										</a>
									</li>
								<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end category slider -->



<!-- MAIN SECTION -->
<section class='test'>
	<div class="container">
		<div class="row row-menu">
			<div class="col-12 col-lg-7">
				<?php foreach ($mainProducts as $category => $products) { ?>
				
				<div class="row mb-5" id='<?php echo $category; ?>'>
					<div class="col-12 w-100">
						<h2 class='mb-4'><?php echo $category; ?></h2>
					</div>
						<!-- <h4 class='font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4'>Salad & Snack</h4> -->
							<?php
								foreach ($products as $product) {
									$productDetails = reset($product['productDetails']);
									include FCPATH . 'application/views/publicorders/includes/makeOrderProduct2021.php';
								}
							?>
				<?php } ?>
				</div>
				<!-- end product grid -->
				<div class="col-12 col-lg-5 pl-md-4">
					<div class="checkout">
						<div class="checkout__header text-center mb-3">
							<h3 class="font-weight-bold">Your Order</h3>
							<div class="checkout__features mt-2">
								<div>
									<img src="https://cdn4.iconfinder.com/data/icons/logistics-and-shipping-5/85/delivery_man_boy_courier-512.png" alt="">
									<span>30'</span>
								</div>
								<div>
									<img src="https://cdn4.iconfinder.com/data/icons/logistics-and-shipping-5/85/delivery_man_boy_courier-512.png" alt="">
									<span>$55</span>
								</div>
							</div>
							<!-- end checkout features -->
							<div class="checkout-hide">×</div>
						</div>
						<!-- end checkout header -->
						<div class="checkout__list">
						<!--	<div class="checkout__item">
								<div class="checkout__item--qty">
									1x
								</div>
								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese</div>
								</div>
								<div class="checkout__item--price">
									999,88£
								</div>
								<div class="checkout__item--buttons mt-2">
									<button href="" class="btn single-product__button--edit">Edit</button>
									<div class="d-flex">
										<button href="" class="btn single-product__button mr-3">-</button>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>-->
							<!-- end checkout item -->
							<!--<div class="checkout__item">
								<div class="checkout__item--qty">
									1x
								</div>
								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese</div>
								</div>
								<div class="checkout__item--price">
									999,88£
								</div>
								<div class="checkout__item--buttons mt-2">
									<button href="" class="btn single-product__button--edit">Edit</button>
									<div class="d-flex">
										<button href="" class="btn single-product__button mr-3">-</button>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>-->
							<!-- end checkout item -->
							<div class="checkout__item checkout__item--second">

								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese<button href="" class="btn single-product__button--edit ml-1">Edit</button></div>
									<div class="checkout__item--delete">
										×
									</div>
								</div>
								<div class="checkout__item--buttons mt-3 align-items-center">
									<div class="checkout__item--price">
										999,88£
									</div>
									<div class="d-flex align-items-center justify-content-center">
										<button href="" class="btn single-product__button">-</button>
										<div class="checkout__item--qty mx-2 text-center">1x</div>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>
							<!-- end checkout item -->
							<div class="checkout__item checkout__item--second">

								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese<button href="" class="btn single-product__button--edit ml-1">Edit</button></div>
									<div class="checkout__item--delete">
										×
									</div>
								</div>
								<div class="checkout__item--buttons mt-3 align-items-center">
									<div class="checkout__item--price">
										999,88£
									</div>
									<div class="d-flex align-items-center justify-content-center">
										<button href="" class="btn single-product__button">-</button>
										<div class="checkout__item--qty mx-2 text-center">1x</div>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>
							<!-- end checkout item -->
							<div class="checkout__item checkout__item--second">

								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese<button href="" class="btn single-product__button--edit ml-1">Edit</button></div>
									<div class="checkout__item--delete">
										×
									</div>
								</div>
								<div class="checkout__item--buttons mt-3 align-items-center">
									<div class="checkout__item--price">
										999,88£
									</div>
									<div class="d-flex align-items-center justify-content-center">
										<button href="" class="btn single-product__button">-</button>
										<div class="checkout__item--qty mx-2 text-center">1x</div>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>
							<!-- end checkout item -->
							<div class="checkout__item checkout__item--second">

								<div class="checkout__item--title">
									Margarita
									<div class="checkout__item--addons">32cm, extra cheese, pepperones, mayonese<button href="" class="btn single-product__button--edit ml-1">Edit</button></div>
									<div class="checkout__item--delete">
										×
									</div>
								</div>
								<div class="checkout__item--buttons mt-3 align-items-center">
									<div class="checkout__item--price">
										999,88£
									</div>
									<div class="d-flex align-items-center justify-content-center">
										<button href="" class="btn single-product__button">-</button>
										<div class="checkout__item--qty mx-2 text-center">1x</div>
										<button href="" class="btn single-product__button">+</button>
									</div>
								</div>
							</div>
							<!-- end checkout item -->
						</div>
						<!-- end checkout list -->
						<div class="checkout__order">
							<div class="d-flex justify-content-between mt-3">
								<h6 class="pr-3 font-weight-bold">Total Price:</h6>
								<h6 class="font-weight-bold">555,55$</h6>
							</div>
							<div class="text-center mt-3">
								<button class="btn btn-primary order-button">Checkout</button>
							</div>	
						</div>
					</div>
				</div>
				<!-- end sidebar -->
			</div>
		</div>
	</div>
</section>
<!-- END MAIN SECTION -->


<!-- BANNER SECTION -->
<!-- <section class="banner px-3 px-md-0">
	<div class="container">
		<div class="row align-items-center pl-lg-4">
			<div class="col-12 col-md-4 mb-2 mb-md-0 py-4 pl-md-5 py-md-5 px-4 px-md-2 px-lg-3">
				<h2 class='font-weight-bold color-secondary'>Order Now</h2>
				<p class='font-weight-bold mb-0'>From Your favourite <span class='color-secondary'>delivery service</span></p>
			</div>
			
			<div class="col-12 col-md-4 py-4 py-md-0 px-4  px-md-2 px-lg-3 bg-white text-left text-md-center rounded">
				<img src="<?php #echo base_url() . 'assets/images/2021/';  ?>ubar.png" alt="" class='pr-2'>
				<img src="<?php #echo base_url() . 'assets/images/2021/';  ?>ubar.png" alt="" class='pr-2'>
				<img src="<?php #echo base_url() . 'assets/images/2021/';  ?>ubar.png" alt="" class='pr-2'>
			</div>
			<div class="col-12 col-md-4 banner__image align-self-stretch position-relative px-0">
				<img src="<?php #echo base_url() . 'assets/images/2021/';  ?>food.jpg" alt="" class='w-100 h-100 position-md-absolute'>
			</div>
		</div>
	</div>
</section> -->
<!-- END BANNER SECTION -->

<!-- SECTION ORDER -->
<!-- <section class="order-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-3 px-0 d-flex flex-column banner__cta">
				<h6 class='py-3 px-4 px-md-4 font-weight-bold text-uppercase color-secondary'>Order by Phone</h6>
				<div class='px-4 py-5 rounded-right d-flex align-items-left justify-content-center flex-grow-1 flex-column'>
					<a href="tel:" class='text-white font-weight-bold py-3 d-block'>999-999-999</a>
				</div>
			</div>
			<div class="col-12 col-md-9 px-0 pr-0 d-flex flex-column text-left mt-4 mt-md-0">
				<h6 class='py-3 px-4 px-md-5 font-weight-bold text-muted text-uppercase'>Don't miss out</h6>
				<div class='order-section__latest py-5 px-4 px-md-5 d-flex align-items-left justify-content-center flex-grow-1 flex-column'>
					<h4 class='font-weight-bold'>Lorem Ipsum</h4>
					<p class='latest__exceprtion'><span class='latest__meta'>December 12, 2020</span>Excepteur sint occaecat cupidatat non proident, sunt in culpa ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate.</p>
				</div>
			</div>
		</div>
	</div>
</section> -->
<!-- END SECTION ORDER -->
	
<!-- NEW ADDITIONALS MODAL -->
<!--style='display: block; opacity:1 '-->
<div class="modal modal-additional fade" tabindex="-1" role="dialog" id="modal-additional" aria-labelledby="modal-additional" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header d-flex flex-column">
			<h3 class="single-product__title">Pizza Margarita</h3>
			<p class='single-product__ingredients mb-2'>Lorem ipsum, Lorem </p>
			<p class='single-product__price mb-0'>9,00$</p>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form action="" class='modal-form'>
				<div class=''>
					<div class='modal-form__title'>
						<h6>Size</h6>
						<p class='mb-0'>Choose one size <span>(*Required)</span></p>
					</div>
					<div class="form-group active">
						<label for="exampleInputPassword1">Pepperoni</label>
						<div class="d-flex align-items-center justify-content-center">
							<button class="btn single-product__button single-product__button--plus" type='button'>-</button>
							<input type="number" class="form-control" id="" placeholder="0">
							<button class="btn single-product__button single-product__button--minus" type='button'>+</button>
						</div>
					</div>
					<!-- end single form input -->
					<div class="form-group ">
						<label for="exampleInputPassword1">Pepperoni</label>
						<div class="d-flex align-items-center justify-content-center">
							<button class="btn single-product__button single-product__button--plus" type='button'>-</button>
							<input type="number" class="form-control" id="" placeholder="0">
							<button class="btn single-product__button single-product__button--minus" type='button'>+</button>
						</div>
					</div>
					<!-- end single form input -->
					<div class="form-group ">
						<label for="exampleInputPassword1">Pepperoni</label>
						<div class="d-flex align-items-center justify-content-center">
							<button class="btn single-product__button single-product__button--plus" type='button'>-</button>
							<input type="number" class="form-control" id="" placeholder="0">
							<button class="btn single-product__button single-product__button--minus" type='button'>+</button>
						</div>
					</div>
					<!-- end single form input -->
					<div class="form-group ">
						<label for="exampleInputPassword1">Pepperoni</label>
						<div class="d-flex align-items-center justify-content-center">
							<button class="btn single-product__button single-product__button--plus" type='button'>-</button>
							<input type="number" class="form-control" id="" placeholder="0">
							<button class="btn single-product__button single-product__button--minus" type='button'>+</button>
						</div>
					</div>
					<!-- end single form input -->
				</div>
				<!-- additional group -->
				<div class=''>
					<div class='modal-form__title'>
						<h6>Addons single choice</h6>
						<p class='mb-0'>Choose one size <span>(*Required)</span></p>
					</div>
					<div class="form-group ">		
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="customRadio" name="example1">
							<label class="custom-control-label" for="customRadio">Custom radio</label>
						</div>    			
					</div>
					<!-- end single form input -->
					<div class="form-group ">		
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="customRadio1" name="example1">
							<label class="custom-control-label" for="customRadio1">Custom radio</label>
						</div>    			
					</div>
					<!-- end single form input -->
				</div>
				<!-- additional group -->
				<div class=''>
					<div class='modal-form__title'>
						<h6>Addons multiple choice</h6>
						<p class='mb-0'>Choose one size <span>(*Required)</span></p>
					</div>
					<div class="form-group ">		
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
							<label class="custom-control-label" for="customCheck">Custom checkbox</label>
						</div>  			
					</div>
					<!-- end single form input -->
					<div class="form-group ">		
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck1" name="example1">
							<label class="custom-control-label" for="customCheck1">Custom checkbox</label>
						</div>  			
					</div>
					<!-- end single form input -->
					<div class="form-group ">		
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck2" name="example1">
							<label class="custom-control-label" for="customCheck2">Custom checkbox</label>
						</div>  			
					</div>
					<!-- end single form input -->
				</div>
				<!-- additional group -->
				<div class=''>
					<div class='modal-form__title'>
						<h6>Add a remark</h6>
					</div>				
					<input type="textarea" class="form-control" id="" name="" rows='4' placeholder='Maximum 50 char'>
				</div>
				<!-- additional group -->
			</form>
		  </div>
		  <div class="modal-footer pt-3 pb-3">
			<button type="button" class="btn btn-primary add-to-cart">Add to Cart</button>
		  </div>
		</div>
	</div>
</div>


<!-- MODAL CHECKOUT -->
<!-- MODAL ADDITIONAL OPTIONS -->
<div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout-modal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Your Cart</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="checkout-modal-list" class="menu-list"></div>
			</div>
			<div class="modal-footer">
				<div class="checkout-modal-sum">
					<h4 class='mb-0'>TOTAL:<span class='ml-2 color-secondary font-weight-bold' id="totalAmount"></span></h4>
				</div>
				<div>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Payment</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->

<script>
	const makeOrder2021 = (function(){
		let globals = {
			'checkoutProductListId'	: 'checkout-modal-list',
			'checkoutProductList'	: document.getElementById('checkout-modal-list'),
			'totalAmount'			: document.getElementById('totalAmount')
		}

		Object.freeze(globals);
		return globals;
	}());
</script>

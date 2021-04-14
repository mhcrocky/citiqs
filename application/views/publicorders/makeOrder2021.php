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
		<a
			href="#"
			class="btn btn-primary btn-lg bg-primary px-3 px-md-4 text-center header__checkout"
			data-toggle="modal"
			data-target="#checkout-modal"
			style="z-index:3000; position: fixed; top:5%; right: 5%"
		>
			<i class="fa fa-shopping-basket mr-md-3"></i>
			<span class='d-none d-lg-inline'>CHECKOUT</span>
		</a>
	</nav>
</header>
<!-- END HEADER -->

<!-- CATEGORIES SECTION -->
<section class='hero-section position-relative'>
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
		<div class="row">
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
		</div>
	</div>
</section>
<!-- END CATEGORIES SECTION -->

<!-- MAIN SECTION -->
<section>
	<div class="container">
		<div class="row row-menu">
			<?php foreach ($mainProducts as $category => $products) { ?>
				<div class="col-12 col-md-4">
					<h2 class='color-primary mb-5'><?php echo $category; ?></h2>
					<?php if ($vendor['showProductsImages'] === '1') { ?>
						<!-- show images -->
						<ul class="items-gallery">
							<?php
								$count = 1;
								foreach ($products as $product) {
									if ($count > 5) break;
									$productDetails = reset($product['productDetails']);
									?>
									<li>
										<img
											<?php if ($product['productImage'] && file_exists($uploadProductImageFolder . $product['productImage'])) { ?>
												src="<?php echo base_url() . 'assets/images/productImages/' . $product['productImage']; ?>"
											<?php } else { ?>
												src="<?php echo base_url() . 'assets/images/defaultProductsImages/' . $vendor['defaultProductsImage']; ?>"
											<?php } ?>
												alt="<?php echo $productDetails['name']; ?>"
										/>
									</li>
									<?php
									$count++;
								}
							?>
						</ul>
						<!-- end show images -->
					<?php } ?>
				</div>
				<div class="col-12 col-md-8 pl-md-5">
					<!-- <h4 class='font-weight-bold mt-4 mt-md-3 mb-2 mb-md-4'>Salad & Snack</h4> -->
					<div class='menu-list'>
						<?php
                            foreach ($products as $product) {
                                $productDetails = reset($product['productDetails']);
								include FCPATH . 'application/views/publicorders/includes/makeOrderProduct2021.php';
                            }
						?>
					</div>
				</div>
			<?php } ?>
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
				<div id="checkout-modal-list" class="menu-list">
					
					<!-- <div class="menu-list__item">
						<div class="menu-list__name">
							<b class="menu-list__title">Name</b>

						</div>
						<div class="menu-list__right-col">
							<div class="menu-list__price">
								<b class="menu-list__price--regular">6.00$ </b>
							</div>
							<div class="quantity-section">
								<button class="quantity-button quantity-button--minus">-</button>
								<input type="number" value="0" placeholder="0" class="quantity-input">
								<button type="button" class="quantity-button quantity-button--plus">+</button>
							</div>
							<button type='button' class='btn checkout-modal-edit' data-toggle="modal" data-target="#modal-additional-options" ><i class="fa fa-pencil-square-o mr-2"></i>EDIT</button>
						</div>
					</div> -->
				</div>
			</div>
			<div class="modal-footer">
				<div class="checkout-modal-sum">
					<h4 class='mb-0'>TOTAL:<span class='ml-2 color-secondary font-weight-bold'>55$</span></h4>
				</div>
				<div>
					<button type="button" class="btn btn-primary">Payment</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->

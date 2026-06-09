<section class="hero-bannerdetails" id="home" style="">
	<div class="owl-carousel owl-theme">
		<div class="item details" style="">

			<img src="{{ setting('breadcrumb_url') }}" class="hidden-xs" alt="White Transportation LLC" loading="lazy">
			<img src="{{ setting('image2_url') }}" class="visible-xs" alt="White Transportation LLC" loading="lazy">

			<div class="hero-content-wrapper">
				<div class="container">
					<div class="row align-items-center">
						<h1 class="hero-titledetails text-center hidden-xs">  {{ $pageTitle ?? 'Page Title' }} <br> <b style="font-size: 26px!important;"></b></h1>
						<h1 class="hero-title text-center visible-xs text-light">  {{ $pageTitle ?? 'Page Title' }} <br> <b style="font-size: 19px!important;"></b></h1>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>

<style type="text/css">
	.abtip {
		padding: 60px;
	}

	@media only screen and (max-width: 767px) {
		.abtip {
			padding: 10px!important;
		}
	}
</style>
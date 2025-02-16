<div class="container">
	<div class="row">
		<div class="col mb-2">
			<H1>Style Guide</H1>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col mb-2">
		<h2>Variables</h2>
		$primary is used for the navbar hover and active color, link color and btn-primary background color.  You can set these individually using the following variables:
		<br>$navbar-light-hover-color
		<br/>$navbar-light-active-color
		<br>$link-color
		<br>
		<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-4">
			<h2>Text</h2>
			<hr/>
			<h1>H1 text</h1>
			<h2>H2 text</h2>
			<h3>H3 text</h3>
			<h4>H4 text</h4>
			<h5>H5 text</h5>
			<hr/>
			<div class="display-1">display-1 text</div>
			<div class="display-2">display-2 text</div>
			<div class="display-3">display-3 text</div>
			<div class="display-4">display-4 text</div>
			<div class="display-5">display-5 text</div>
			<div class="display-6">display-6 text</div>
			<hr/>
			<div class="fs-1">fs-1 text</div>
			<div class="fs-2">fs-2 text</div>
			<div class="fs-3">fs-3 text</div>
			<div class="fs-4">fs-4 text</div>
			<div class="fs-5">fs-5 text</div>
			<div class="fs-6">fs-6 text</div>
			<hr/>
			<p class="fw-bold">.fw-bold Bold text.</p>
			<p class="fw-bolder">.fw-bolder Bolder weight text (relative to the parent element).</p>
			<p class="fw-semibold">.fw-semibold Semibold weight text.</p>
			<p class="fw-medium">.fw-medium Medium weight text.</p>
			<p class="fw-normal">Normal weight text.</p>
			<p class="fw-light">.fw-light Light weight text.</p>
			<p class="fw-lighter">.fw-lighter Lighter weight text (relative to the parent element).</p>
			<p class="fst-italic">.fst-italic Italic text.</p>
			<p class="fst-normal">.fst-normal Text with normal font style</p>
			<div class="my-3">
				<div id="readMoreDiv" class="readMore mb-2">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
				<button id="readMoreBtn" class="btn btn-white btn-sm readMoreButton" hx-on:click="htmx.toggleClass(htmx.find('#readMoreDiv'), 'readMoreExpanded'); htmx.toggleClass(htmx.find('#readMoreBtn'), 'readMoreButtonExpanded');" aria-label="Read More / Less"></button>
			</div>
		</div>
		<div class="col-4">
			<h2>Links</h2>
			<hr/>
			<a href="#">Text Link</a>
			<hr/>
			<button type="button" class="btn btn-primary">Primary</button>
			<button type="button" class="btn btn-secondary">Secondary</button>
			<button type="button" class="btn btn-light">Light</button>
			<button type="button" class="btn btn-dark">Dark</button>

		</div>
		<div class="col-4">
			<h2>Backgrounds</h2>
			<hr/>
			<div class="bg-body-primary p-5 my-5">.bg-body-primary</div>
			<div class="bg-body-secondary p-5 my-5">.bg-body-secondary</div>
			<div class="bg-body-tertiary p-5 my-5">.bg-body-tertiary</div>
			<div class="bg-dark text-light p-5 my-5">.bg-dark</div>
			<div class="bg-light p-5 my-5">.bg-light</div>
			<hr/>
			<div class="shadow p-5 my-5">.shadow</div>
			<div class="shadow-sm p-5 my-5">.shadow-sm</div>
			<div class="shadow-lg p-5 my-5">.shadow-lg</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<hr/>
			<H2>Description List with vertical centered link text</H2>
			<dl class="row">
				<dt class="col-12 mt-3 mb-2">Related People</dt>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person<br/>second link</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
				<dt class="col-12 mt-3 mb-2">Related People</dt>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person<br/>second link</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd>
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><a href="#" class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">Person</a></dd> 	
			</dl>
		</div>
	</div>
	<div class="row align-items-center mb-5">
		<div class="col-md-6">
			<H2>Vertically centered columns</H2>
			Assign row class .align-items-center
		</div>
		<div class="col-md-6 img-fluid">
			<?= caGetThemeGraphic($this->request, 'hero_1.jpg', array("alt" => "example image")); ?>
		</div>
	</div>
</div>
<div class="container text-center my-3">
    <h2 class="font-weight-light">Bootstrap Multi Slide Carousel</h2>
    <div class="row mx-auto my-auto justify-content-center">
        <div id="multiCarousel" class="carousel slide multiSlideCarousel"><!-- add  data-bs-ride="multiSlideCarousel" to div for auto advance -->
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-img">
                                <?= caGetThemeGraphic($this->request, 'hero_1.jpg', array("class" => "img-fluid", "alt" => "example image")); ?>
                            </div>
                            <div class="card-img-overlay">Slide 3</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-img">
                                <?= caGetThemeGraphic($this->request, 'hero_1.jpg', array("class" => "img-fluid", "alt" => "example image")); ?>
                            </div>
                            <div class="card-img-overlay">Slide 4</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-img">
                                <?= caGetThemeGraphic($this->request, 'hero_1.jpg', array("class" => "img-fluid", "alt" => "example image")); ?>
                            </div>
                            <div class="card-img-overlay">Slide 5</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-img">
                                <?= caGetThemeGraphic($this->request, 'hero_1.jpg', array("class" => "img-fluid", "alt" => "example image")); ?>
                            </div>
                            <div class="card-img-overlay">Slide 6</div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev bg-transparent" href="#multiCarousel" role="button" data-bs-slide="prev" aria-label="previous slide">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next bg-transparent" href="#multiCarousel" role="button" data-bs-slide="next" aria-label="next slide">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>
<script>
let items = document.querySelectorAll('.carousel.multiSlideCarousel .carousel-item')

items.forEach((el) => {
    const minPerSlide = 4
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true)
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
});
</script>
<style>
	@media (max-width: 767px) {
		.multiSlideCarousel .carousel-inner .carousel-item > div {
			display: none;
		}
		.multiSlideCarousel .carousel-inner .carousel-item > div:first-child {
			display: block;
		}
	}
	.card-img{
		height:300px;
	}
	.multiSlideCarousel .carousel-inner .carousel-item.active,
	.multiSlideCarousel .carousel-inner .carousel-item-next,
	.multiSlideCarousel .carousel-inner .carousel-item-prev {
		display: flex;
	}
	
	/* medium and up screens */
	@media (min-width: 768px) {
		
		.multiSlideCarousel .carousel-inner .carousel-item-end.active,
		.multiSlideCarousel .carousel-inner .carousel-item-next {
			transform: translateX(25%);
		}
		
		.multiSlideCarousel .carousel-inner .carousel-item-start.active, 
		.multiSlideCarousel .carousel-inner .carousel-item-prev {
			transform: translateX(-25%);
		}
	}
	
	.multiSlideCarousel .carousel-inner .carousel-item-end,
	.multiSlideCarousel .carousel-inner .carousel-item-start { 
		transform: translateX(0);
	}
</style>
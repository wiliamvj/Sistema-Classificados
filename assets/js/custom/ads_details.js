function sliderControls(){
	var sliderHeight = $("#ap-i-slider").height();
	var controls = $(".ap-images .ap-i-controls");

	controls.css('margin-bottom', '-'+sliderHeight+'px');
	controls.children('.ap-ic-btn').height(sliderHeight);
}

$(document).ready(function() {

	/* images slider - begin */
	var sliderImages = $("#ap-i-slider");

	sliderImages.owlCarousel({
		autoPlay: 7000,
		items : 4,
		itemsDesktopSmall: [979,4],
		itemsTablet: [768,3],
		itemsMobile: [479,2],
		afterInit: function(){
			sliderControls();
		},
		afterUpdate: function(){
			sliderControls();
		}
	});

	$(".ap-images").on('click', '#ap-ic-prev', function(event) {
		sliderImages.data('owlCarousel').prev();
	});

	$(".ap-images").on('click', '#ap-ic-next', function(event) {
		sliderImages.data('owlCarousel').next();
	});
	/* images slider - end */
});

$(window).load(function() {
	sliderControls();

	/* gallery - begin */
	$("#ap-i-slider").on('click', '.item', function(event) {
		var image = $(this).attr('data-image');

		$(".ap-images .ap-i-master .img-item").removeClass('active');
		$(".ap-images .ap-i-master .img-item[data-image='"+image+"']").addClass('active');
	});
	/* gallery - end */
});

$(window).resize(function() {
	sliderControls();
});
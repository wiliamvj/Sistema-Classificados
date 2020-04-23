$(document).ready(function() {
	/* Inputs Completes */
	setTimeout(function() {
		/* select categories - begin */
		var categoryPrimary = $("#ai-category-parent").val();
		var categorySecondary = $("#ai-category").val();
		var ads_code = $("#ai-ads-code").val();

		$("#ai-f-c-parent li[data-id='"+categoryPrimary+"']").addClass('active');

		selectCategoryPrimary(categoryPrimary, categorySecondary, ads_code);
		/* select categories - end */

		/* complete price - begin */
		settingPrice($("#ai-no-price"), 'service');
		/* complete price - end */

		/* complete user info - begin */
		settingAddress($("#ai-use-info"));
		/* complete user info - end */
	}, 500);

	/* images - begin */
	$(".dropzone .dz-image-db .dz-remove-file").on('click', 'span', function(event) {
		var image = $(this).attr('data-image');
		var obj = $(this).parent('.dz-remove-file').parent(".dz-image-db");

		obj.hide();

		$.ajax({
			url: base_url+'/announce/images_remove',
			type: 'POST',
			data: { image: image },
		})
		.done(function() {
			console.clear();
                        obj.remove();
                        if($('.dz-image').length == 1){
                            $('#publish-button').prop('disabled', true); 
                        }
			
		})
		.fail(function() {
			console.log("image delete: error");

			obj.show();
		});
	});
});
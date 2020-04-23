function getAds(status){
	var content = $(".profile-dashboard .pd-content");
	content.html('<div class="pd-c-loader"><i class="fa fa-spin fa-cog"></i></div>');

	if(status){
		var url = base_url+'/profile/ads/'+status;
	}else{
		var url = base_url+'/profile/ads/';
	}

	$.get(url, function(data) {
		/* nothing */
	}).done(function(data){
		content.html(data);
	}).error(function() {
		content.html('<p">Ocorreu um erro. Recarregue a página e tente novamente.</p>');
	}).always(function(){
		console.clear();
	});
}

$(document).ready(function() {
	getAds();

	/* tabs */
	$(".profile-dashboard").on('click', '.pd-tabs > div', function(event) {
		var status = $(this).attr('data-status');
		
		$(".pd-tabs > div").removeClass('active');
		$(this).addClass('active');

		getAds(status);
	});
});
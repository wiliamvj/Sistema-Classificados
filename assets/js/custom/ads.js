function pagination(){
	var perPage = 10;
	var paginationBox = $('.pagination-box');
	var totalRecords = $('#ads-listing').children('.al-page').length;

	paginationBox.paginate({
		count: totalRecords,
		start: 1,
		display: 5,
		onChange: function(page){
			$("#ads-listing .al-page").removeClass('active');
			$("#ads-listing .al-page[data-page='"+page+"']").addClass('active');
		}
	});
}

function filter(){
	var string = $("#as-s-input").val().toLowerCase();
	var category = $("#as-b-categories > li > a.active").attr('data-value');
	var category_string = $("#as-b-categories > li > a.active").attr('data-string');
	var price = $("#as-b-price > li.active").attr('data-value');
	var price_string = $("#as-b-price > li.active").html();
	var type = $("#as-b-type > li.active").attr('data-value');
	var state = $("#ads-states .as-item.active").attr('data-value');
	var state_string = $("#ads-states .as-item.active").attr('data-string');
	var region = $("#ads-region .as-item.active").attr('data-value');
	var region_string = $("#ads-region .as-item.active").attr('data-string');
	var city = $("#ads-city .as-item.active").attr('data-value');
	var city_string = $("#ads-city .as-item.active").attr('data-string');

	var filter_status = "";
	var filter = "";

	$(".al-item").hide();

	if(string){
		filter += "[data-name*='"+string+"']";
		filter_status += "<span><strong>Pesquisa:</strong> "+string+"</span>";
	}

	if(category){
		filter += "[data-category='"+category+"']";
		filter_status += "<span><strong>Categoria:</strong> "+category_string+"</span>";
	}

	if(price){
		if(price != "0"){
			filter += "[data-price='"+price+"']";
			filter_status += "<span><strong>Preço:</strong> "+price_string+"</span>";
		}
	}

	if(type){
		if(type == "service"){
			filter += "[data-service='1']";
			filter_status += "<span><strong>Tipo:</strong> Apenas Serviços</span>";
		}

		if(type == "trade"){
			filter += "[data-trade='1']";
			filter_status += "<span><strong>Tipo:</strong> Aceita Troca</span>";
		}
	}

	if(state){
		filter += "[data-state='"+state+"']";
		filter_status += "<span><strong>Estado:</strong> "+state_string+"</span>";
	}

	if(region){
		filter += "[data-region='"+region+"']";
		filter_status += "<span><strong>Região:</strong> "+region_string+"</span>";
	}

	if(city){
		filter += "[data-city='"+city+"']";
		filter_status += "<span><strong>Cidade:</strong> "+city_string+"</span>";
	}

	if(filter){
		$('.al-page').contents().unwrap();

		$(".ads-filter").show();

		$(".pagination-box").remove();
	}else{
		window.location.reload(true);
	}

	$(".ads-filter .af-l").html(filter_status);
	$(".al-item"+filter).show();
}

$(document).ready(function() {
	pagination();

	/* filter - begin */
	$("#as-s-button").on('click', function(event) {
		filter();
	});

	$("#as-s-input").keypress(function(e) {
	    if(e.which == 13) {
	        filter();
	    }
	});

	$("#as-b-categories > li > a").on('click', function(event) {
		$("#as-b-categories > li > a").removeClass('active');
		$(this).addClass('active');

		filter();
	});

	$("#as-b-price > li").on('click', function(event) {
		$("#as-b-price > li").removeClass('active');
		$(this).addClass('active');

		filter();
	});

	$("#as-b-type > li").on('click', function(event) {
		$("#as-b-type > li").removeClass('active');
		$(this).addClass('active');

		filter();
	});

	$("#ads-states .as-item").on('click', function(event) {
		$("#ads-states .as-item").removeClass('active');
		$(this).addClass('active');

		var state = $("#ads-states .as-item.active").attr('data-value');
		var action = 'https://www.panamerico.com.br/address/filter';
		$.post(action, {state: state}, function(data) {

			if(data.regions != null){
				$(".tabs-panel").removeClass('is-active');
				$(".tabs-title").removeClass('is-active');
				$("#panel2").addClass('is-active');
				$("#tab-region").show().addClass('is-active');
    			$("#ads-region").html('');
  
        		$.each(data.regions, function (index, value) {
    				$('#ads-region').append('<div class="small-12 medium-6 large-6 end columns"><div class="as-item" data-value="'+value.region_id+'" data-string="'+value.name+'"><b>'+value.name+'</b></div></div>');
        		});
    		}

		});

		filter();
	});

	$("body").on("click", "#ads-region .as-item", function(event) {
		$("#ads-region .as-item").removeClass('active');
		$(this).addClass('active');

		var region = $("#ads-region .as-item.active").attr('data-value');
		var action = 'https://www.panamerico.com.br/address/filter';
		$.post(action, {region: region}, function(data) {
			
			if(data.cities != null){

				$(".tabs-panel").removeClass('is-active');
				$(".tabs-title").removeClass('is-active');
				$("#panel3").addClass('is-active');
				$("#tab-city").show().addClass('is-active');
    			$("#ads-city").html('');
  
        		$.each(data.cities, function (index, value) {
    				$('#ads-city').append('<div class="small-6 medium-3 large-3 end columns"><div class="as-item" data-value="'+value.city_id+'" data-string="'+value.name+'" data-close="" aria-label="Close reveal">'+value.name+'</div></div>');
        		});
    		}
    		

		});

		filter();
	});

	$("body").on("click", "#ads-city .as-item", function(event) {
		$("#ads-city .as-item").removeClass('active');
		$(this).addClass('active');

		filter();
	});
	
	/* filter - end */

	/* states count - begin */
	$("#ads-states .as-item").each(function(index, el) {
		var item = $(this);
		var state = $(this).attr('data-value');

		$("#ads-listing .al-item[data-state='"+state+"']").each(function(index, el) {
			item.children('span.b').html((index + 1));
		});
		
	});
	/* states count - end */

	/* filter category - begin */
	var filterCategory = $("#as-filter-category").val();

	if(filterCategory){
		$("#as-b-categories > li > a[data-value='"+filterCategory+"']").addClass('active');

		filter();
	}
	/* filter category - end */

	/* filter state - begin */
	var filterState = $("#as-filter-state").val();

	if(filterState){
		$("#ads-states .as-item[data-value='"+filterState+"']").addClass('active');

		filter();
	}
	/* filter category - end */
});
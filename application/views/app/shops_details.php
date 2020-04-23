<script>
    $(function(){
    var jElement = $('#shops-fixed');
    var tam = $(window).width();
   
    if(tam < 1300){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 980 ){
            jElement.css({
                'position':'fixed',
                'top':'50px',
                'width': '266px',
            });
        }else{
            jElement.css({
                'position':'static',
                'top':'auto'
            });
        }
    });
    }
    
    });
</script>

<div class="row">
	<div class="medium-4 large-3 columns">
		<?php include_once('shops_sidebar.php'); ?>
            <div class="hide-for-small-only"><?=$this->main_model->advertisingBox('side', '266px', '600px')?></div>
	</div>
	<div class="medium-8 large-9 columns">
		<?=$this->main_model->advertisingBox('top', '100%', '90px')?>
		
		<?php
			echo $this->shops_model->shop_page($shop);
		?>
	</div>
</div>
<script>
    $(".shophover").hover(function() {
    $(this).find('h3').css("text-decoration", "underline");

}, function() {
    $(this).find('h3').css("text-decoration", "none");
});

</script>
<script type="text/javascript">
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

	$(window).load(function() {
		//pagination();
	});
</script>
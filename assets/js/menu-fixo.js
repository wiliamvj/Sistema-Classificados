<script>
    $(function(){
    var jElement = $('#fixo');
    var tam = $(window).width();
   
    if(tam <= 1024){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 1250 ){
            jElement.css({
                'position':'fixed',
                'top':'90px',
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


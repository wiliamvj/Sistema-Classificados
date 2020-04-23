<script>
    $(function(){
    var jElement = $('#fixed-dashboard');
    var tam = $(window).width();
   
    if(tam <= 1024){
        $(".medium-6 columns").show();
    }else{
        $(window).scroll(function(){
        if ( $(this).scrollTop() > 1022 ){
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

<div class="row">
	<div class="medium-3 columns">
		<nav class="profile-menu"  id="fixed-dashboard">
			<ul>
				<li>
					<a href="<?=base_url('cliente/painel')?>" <?=(($page == "dashboard") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-fw fa-tags"></i></span>
						<span>Meus Anúncios</span>
					</a>
				</li>
					<li>
					<a href="<?=base_url('chat')?>" <?=(($page == "chat") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-comments"></i></span>
						<span>Chat</span>
					</a>
                </li>
				<li>
					<a href="<?=base_url('cliente/detalhes')?>" <?=(($page == "details") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-fw fa-cogs"></i></span>
						<span>Meu Cadastro</span>
					</a>
				</li>
				<li>
					<a href="<?=base_url('cliente/loja')?>" <?=(($page == "shop" || $page == "shop_denied" || $page == "shop_create") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-fw fa-shopping-cart"></i></span>
						<span>Minha Loja</span>
					</a>
				</li>
				<li>
					<a href="<?=base_url('cliente/favoritos')?>" <?=(($page == "favorites") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-fw fa-heart"></i></span>
						<span>Favoritos</span>
					</a>
				</li>
				<li>
					<a href="<?=base_url('cliente/sair')?>" target="_self">
						<span><i class="fa fa-fw fa-times"></i></span>
						<span>Sair</span>
					</a>
				</li>
			</ul>
		</nav>
		
		<div class="text-center">
            		<a href="<?= base_url('anunciar') ?>" class="btn btn-success desapegarMain" style="width:100%;">desapegar</a>
	        </div>
		<br>
		<div class="profile-infos hide-for-small-only">
			<?php
				$products_published = $this->user_model->adsCount(2);
				$evaluating_products = $this->user_model->adsCount(1);
				$products_sold = $this->user_model->info('use_ads_sales');
			?>
			<ul>
				<li><strong><div class="account-dash-user"><?=$products_published?></div></strong> publicados</li>
				<li><strong><div class="account-dash-user"><?=$evaluating_products?></div></strong> aprovação pendente</li>
				<li><strong><div class="account-dash-user"><?=$products_sold?></div></strong> vendidos</li>
			</ul>
		</div>
		
		<div class="hide-for-small-only">
		<?=$this->main_model->advertisingBox('side', '266px', '600px')?>
		</div>
	</div>
	<div class="medium-9 columns">
		<?=$this->main_model->advertisingBox('top', '100%', '90px')?>
		
		<?php
			$subFolder = 'profile/';
			if($page == 'chat'){
				$subFolder = '';
			}
			include_once($subFolder.$page.".php");
		?>
	</div>
</div>
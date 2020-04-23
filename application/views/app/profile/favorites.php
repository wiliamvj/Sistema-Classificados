<div class="profile-favorites">
	<h1>Favoritos</h1>

	<?php
		if($favorites){
			echo '<div class="ads-listing ads-listing-intern">';

			foreach ($favorites as $key => $favorite) {
				echo '<div class="pf-timestamp">Adicionado em: '.string_date_time($favorite->use_fav_timestamp).'</div>';
				echo $this->ads_model->ads_item($favorite);
			}

			echo '</div>';
		}else{
			$anunci = base_url('anuncios');
			echo '<div class="alert">Você não possui nenhum favorito no momento.<p>Que tal buscar algo para comprar?<p></div>';
			echo '<div class="text-center"><a href="'.$anunci.'" class="btn btn-success"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>Comprar algo</a></div>';
		}
	?>	
</div>
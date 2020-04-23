<div class="ads-sidebar">
	<div class="as-search-shops">
		<div class="as-ss-title"> <i class="fa fa-search" aria-hidden="true"></i> BUSQUE UMA LOJA</div>
		<div class="as-ss-form">
			<form method="get" action="<?=base_url('shops')?>">
				<input type="text" name="string" placeholder="Pesquisar pelo nome" value="<?=((@$search_string) ? $search_string : '')?>">

				<select name="state">
					<option value="0">Pesquise pelo estado</option>
					<?php
						foreach ($states as $key => $sta) {
							echo '<option '.((@$search_state == $sta->sta_id) ? 'selected' : '').' value="'.$sta->sta_id.'">'.$sta->sta_name.'</option>';
						}
					?>
				</select>

				<select name="category">
					<option value="0">Pesquise pela categoria</option>
					<?php
						foreach ($categories as $key => $cat) {
							echo '<option '.((@$search_category == $cat->ads_cat_id) ? 'selected' : '').' value="'.$cat->ads_cat_id.'">'.$cat->ads_cat_name.'</option>';
						}
					?>
				</select>

				<button type="submit" class="btn btn-primary btn-full"><i class="fa fa-search"></i> Buscar</button>
			</form>
		</div>
	</div>
</div>
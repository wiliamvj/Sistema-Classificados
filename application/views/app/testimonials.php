<div class="row">
	<div class="medium-12 columns">
		<div class="simple-page">
		<?= $this->main_model->advertisingBox('top', '95%', '300px') ?>
			<h1>Depoimentos</h1>

			<p>Todos os dias, recebemos depoimentos de usuários satisfeitos. Nesta página, compartilhamos as experiências destes usuários.</p>

			<br>

			<h5>Como são enviados os depoimentos?</h5>
			<p>Toda vez que um anunciante exclui o seu anúncio, ele pode enviar um depoimento. É só utilizar a caixa de elogios/críticas.</p>
			
			

			<?php
				if($testimonials){
					echo '<div class="testimonials-listing">';

					$i = 1;

					echo '<div class="row">';

					foreach ($testimonials as $key => $t) {
						
			
						echo '
							<div class="medium-4 end columns">
								<div class="tl-item">
									<div class="a">
										<div class="desc">
											<p class="text">'.$t->tes_text.'</p>

											<p><strong>'.$t->tes_name.'</strong> em '.string_date($t->tes_timestamp).'</p>
										</div>

										<div class="product">'.$t->tes_category.' <i class="fa fa-fw fa-angle-right"></i> <strong>'.$t->tes_ad.'</strong></div>
									</div>

									<div class="b"><div class="image"><img alt="" src="'.thumbnail($t->tes_ad_image, 'ads', 100, 100, 2).'"></div></div>
								</div>
							</div>
						';
						
						if($i % 3 == 0) { echo '</div><div class="row">'; }

                  		$i++;
					}

					echo '</div>';

					echo paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total), 'testimonials', $total, FALSE);

					echo '</div>';
				}else{
					echo "<p>Nenhum depoimento encontrado.</p>";
				}
			?>
		</div>
	</div>
</div>
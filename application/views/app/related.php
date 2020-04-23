                    <?php

    if ($relatedHome) {
                        echo '
							<div id="rel" class="row">
								<div id="rel2"class="medium-12 columns">
									<div class="ap-ads-related"">
										<h2 id="titleRel"> Alguns anúncios</h2>
										<div class="row">
							';

                        foreach ($relatedHome as $key => $rel) {
                            $related_images = $this->ads_model->images($rel->ad_id);
                            $related_image = thumbnail(@$related_images[0]->ads_img_file, "ads", 170, 170, 2);

                            $textoCorte = substr($rel->ad_name, 0, 30);
                            $textoLimitado = substr($textoCorte, 0, strrpos($textoCorte, ' '));

                            echo '
									<div id="itemRel" class="small-6 medium-3 end columns">
										<a href="' . base_url('anuncio/' . $rel->ad_slug) . '" title="' . $rel->ad_name . '" class="item">
											<div id="imageRel" class="image"><img alt="' . $rel->ad_name . '" src="' . $related_image . '"></div>

											<p>' . $textoLimitado . '</p>

											<div id="priceRel" class="price">' . (($rel->ad_service) ? 'Doação' : string_money($rel->ad_price)) . '</div>

										</a>
									</div>
								';
                        }
                        echo '
										</div>
									</div>	
								</div>
							</div>
							';
                    }
    
?>
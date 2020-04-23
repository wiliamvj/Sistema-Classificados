<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shops_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function listing()
	{
		$this->db->where('shops.shop_status', 1);

		$this->db->join('ads_categories', 'shops.ads_cat_id = ads_categories.ads_cat_id', 'LEFT');
		$this->db->join('users', 'shops.use_id = users.use_id', 'LEFT');

		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query;
		}else{
			return false;
		}
	}

	public function search($string = false, $state = false, $category = false)
	{
		$this->db->where('shops.shop_status', 1);

		if($category){
			$this->db->where('shops.ads_cat_id', $category);
		}

		if($state){
			$this->db->where('shops.shop_state', $state);
		}

		if($string){
			$this->db->like('shops.shop_name', $string);
			$this->db->or_like('shops.shop_id', $string);
		}		

		$this->db->join('ads_categories', 'shops.ads_cat_id = ads_categories.ads_cat_id', 'LEFT');
		$this->db->join('users', 'shops.use_id = users.use_id', 'LEFT');

		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query;
		}else{
			return false;
		}
	}

	public function searchCategory($category){
		$this->db->where('shops.shop_status', 1);
		$this->db->where('shops.ads_cat_id', $category);

		$this->db->join('ads_categories', 'shops.ads_cat_id = ads_categories.ads_cat_id', 'LEFT');
		$this->db->join('users', 'shops.use_id = users.use_id', 'LEFT');

		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query;
		}else{
			return false;
		}
	}

	public function details($code, $status = 1, $user = false)
	{
		$this->db->limit(1);
		
		if($code){ $this->db->where('shops.shop_id', $code); }
		if($status){ $this->db->where('shops.shop_status', $status); }
		if($user){ $this->db->where('shops.use_id', $this->session->userdata('login')); }

		$this->db->join('ads_categories', 'shops.ads_cat_id = ads_categories.ads_cat_id', 'LEFT');
		$this->db->join('users', 'shops.use_id = users.use_id', 'LEFT');

		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query[0];
		}else{
			return false;
		}
	}

	public function insert($data)
	{
		$this->db->insert('shops', $data);

		return $this->db->insert_id();
	}

	public function update($code, $data)
	{
		$this->db->where('shop_id', $code);
		$this->db->update("shops", $data);
	}

	public function slug($code){
		$this->db->limit(1);
		$this->db->where('use_id', $code);
		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query[0]->shop_slug;
		}else{
			return false;
		}
	}

	public function ads($user){
		$this->db->order_by('ads.ad_name', 'ASC');

		$this->db->where('ads.ad_status', 2);
		$this->db->where('ads.use_id', $user);

		$this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
		$this->db->join("users", "ads.use_id = users.use_id", "INNER");

		$query = $this->db->get("ads");
		$query = $query->result();

		if($query){
			return $query;
		}else{
			return false;
		}
	}

	public function shop_item($data)
	{
		$image = thumbnail(@$data->shop_img_file, "shops", 200, 200, 2);
		$ads = count($this->ads($data->use_id));

		if($data->shop_user_info){
			$phone = $data->use_phone;
			$city = $this->main_model->citiesDetails($data->use_city);
			$state = $this->main_model->statesDetails($data->use_state);
		}else{
			$phone = $data->shop_phone;
			$city = $this->main_model->citiesDetails($data->shop_city);
			$state = $this->main_model->statesDetails($data->shop_state);
		}

		$city = @$city->cit_name;
		$state = @$state->sta_initials;

		$object = '
			<div class="as-item">
				<div class="row">
					<div class="medium-3 columns">
						<div class="cover">
							<img alt="'.$data->shop_name.'" src="'.$image.'">
						</div>
					</div>
					<div class="medium-9 columns">
						<div class="row">
							<div class="medium-12 columns">
								<a title="'.$data->shop_name.'" href="'.base_url('loja/'.$data->shop_slug).'">
									<h3 class="title">'.$data->shop_name.'</h3>
								</a>
							</div>
						</div>

						<div class="row">
							<div class="medium-12 columns">
								<div class="desc">
									<p>'.resume($data->shop_desc, 190).'</p>
									<p class="category">'.$data->ads_cat_name.'</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="medium-9 columns">
								<ul class="infos">
									'.(($city && $state) ? '<li><i class="fa fa-map-marker"></i>'.$city.' - '.$state.'</li>' : '').'
									'.(($phone) ? '<li><i class="fa fa-phone"></i>'.$phone.'</li>' : '').'
									<li data-original-title="Total de anúncios na loja" data-toggle="tooltip" data-placement="bottom" title=""><i class="fa fa-cube"></i>'.$ads.'</li>
									<li><i class="fa fa-calendar"></i>'.string_date_time($data->shop_date_update).'</li>
									
								</ul>
							</div>
							<div class="medium-3 columns">
								<span class="id"><strong>ID da Loja:</strong> '.$data->shop_id.'</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		';

		return $object;
	}

	public function shop_page($data, $intern = false)
	{
		// echo "<pre>"; print_r($data); echo "</pre>";exit;
		$image = thumbnail(@$data->shop_img_file, "shops", 330, 330, 2);
		$link = base_url('loja/'.$data->shop_slug);

		$ads = $this->ads($data->use_id);

		if($data->shop_user_info){
			$phone = $data->use_phone;
			$address = $data->use_address;
			$city = $this->main_model->citiesDetails($data->use_city);
			$state = $this->main_model->statesDetails($data->use_state);
		}else{
			$phone = $data->shop_phone;
			$address = $data->shop_address;
			$city = $this->main_model->citiesDetails($data->shop_city);
			$state = $this->main_model->statesDetails($data->use_state);
		}

		$city = @$city->cit_name;
		$state = @$state->sta_initials;

		$max = 30;
		if($data->use_facebook):
			$limit_face = substr_replace($data->use_facebook, (strlen($data->use_facebook) > $max ? '...' : ''), $max);
		endif;

		if($data->use_mercado_livre):
			$limit_merc = substr_replace($data->use_mercado_livre, (strlen($data->use_mercado_livre) > $max ? '...' : ''), $max);
		endif;

		if($data->use_elo7):
			$limit_elo7 = substr_replace($data->use_elo7, (strlen($data->use_elo7) > $max ? '...' : ''), $max);
		endif;
	
		// if(!empty($data->use_email)):
		// 	//$emailCorte    = substr($data->use_email, 0, 20);
		// 	if(strlen($data->use_email) <= 34){
		// 		$emailLimitado = substr($data->use_email, 0, 34);		
		// 	}else{
		// 		$emailLimitado = substr($data->use_email, 0, 34)."...";
		// 	}	
		
		// else:
		// 	$emailLimitado = "";
		// endif;
		
		//'.(($data->use_email) ? '<li><strong><i class="fa fa-fw fa-mail-forward"></i> E-mail:&nbsp;</strong>'.$emailLimitado.' <i data-link="'.$data->use_email.'" class="fa fa-fw fa-clipboard copy-link"></i></li>' : '').'
		
		$object = '
			<div class="shop-page '.(($intern) ? 'shop-page-intern' : '').'">
				<div class="sp-header">
					<div class="row">
						<div class="medium-8 columns">
							<h1>'.$data->shop_name.'</h1>
						</div>
						<div class="medium-4 columns">
							<span><strong>ID da Loja:</strong> '.$data->shop_id.'</span>
						</div>
					</div>
				</div>

				<div class="sp-basic-info">
					<div class="row">
						<div class="medium-5 columns">
							<img alt="'.$data->shop_name.'" src="'.$image.'">
						</div>
						<div class="medium-7 columns">
							<h3 style="margin-bottom: 10px; margin-top: 10px;" class="show-for-small-only" id="show-descri-js">Descrição <small style="font-size: 10px;">Exibir conteúdo</small></h3>
							<div class="hide-for-small-only" id="mobile-descri-js">
								<div class="sp-bi-desc">
									<p>'.nl2br($data->shop_desc).'</p>
								</div>

								<div class="sp-bi-share">
									<h4>Compartilhe</h4>

									<ul>
										<li><a href="https://www.facebook.com/sharer/sharer.php?u='.$link.'" class="window-open" title="Facebook" target="_blank" id="ap-s-facebook"><i class="fa fa-facebook"></i></a></li>
										<li><a href="#" data-modal="'.base_url('shops/email_share/'.$data->shop_id).'" title="Enviar E-mail" class="modal-open" id="ap-s-mail"><i class="fa fa-envelope"></i></a></li>
										<li class="show-for-small-only"><a href="whatsapp://send?text='.$data->shop_name.' '.$link.'" data-modal="" title="Compartilhe no WhatsApp" target="_blank" id="ap-s-mail"><i style="font-size: 22px;" class="fa fa-whatsapp"></i></a></li>
										<li class="hide-for-small-only"><a href="https://twitter.com/home?status=Olhem%20essa%20loja%3A%20'.$link.'" class="window-open" target="_blank" title="Twitter" id="ap-s-twitter"><i class="fa fa-twitter"></i></a></li>
										<li class="hide-for-small-only"><a href="https://www.linkedin.com/shareArticle?mini=true&url='.$link.'&title='.$data->shop_name.'&summary='.resume($data->shop_desc, 100).'&source=Panam%C3%A9rico" class="window-open" target="_blank" title="Linkedin" id="ap-s-linkedin"><i class="fa fa-linkedin"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="sp-details">
					<div class="row">
						<div class="medium-6 columns">

							<ul>

								'.(($phone) ? '<li>ddddd<strong><i class="fa fa-fw fa-phone"></i> Telefone:</strong> '.$phone.'</li>' : '').'
								'.(($data->ads_cat_name) ? '<li><strong><i class="fa fa-fw fa-tag"></i> Categoria:</strong> '.$data->ads_cat_name.'</li>' : '').'
								'.(($data->use_website) ? '<li><strong><i class="fa fa-fw fa-globe"></i> Website:</strong> <a target="_blank" href="'.$data->use_website.'">'.$data->use_website.'</a></li>' : '').'
								'.(($data->use_mercado_livre) ? '<li><strong><i class="fa fa-fw fa-external-link"></i> Mercado Livre:</strong> <a target="_blank" href="'.$data->use_mercado_livre.'">'.$limit_merc.'</a></li>' : '').'
							</ul>
						</div>
						<div class="medium-6 columns">
							<ul>

								'.(($city && $state) ? '<li><strong><i class="fa fa-fw fa-street-view"></i> Localização:</strong> '.$city.' - '.$state.'</li>' : '').'
								'.(($data->use_celular) ? '<li><strong><i class="fa fa-fw fa-mobile"></i> Celular:</strong> '.$data->use_celular.'</li>' : '').'
								'.(($data->use_whatsapp) ? '<li><strong><i class="fa fa-fw fa-whatsapp"></i> WhatsApp:</strong> '.$data->use_whatsapp.'</li>' : '').'
								'.(($data->use_facebook) ? '<li><strong><i class="fa fa-fw fa-facebook"></i> Facebook:</strong> <a target="_blank" href="http://www.facebook.com/'.$data->use_facebook.'">facebook.com/'.$limit_face.'</a></li>' : '').'
								'.(($data->use_elo7) ? '<li><strong><i class="fa fa-fw fa-external-link"></i> Elo7:</strong> <a target="_blank" href="http://www.elo7.com.br/'.$data->use_elo7.'">elo7.com.br/'.$limit_elo7.'</a></li>' : '').'
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="medium-12 columns">
							<p class="sp-d-link">
								<strong><i class="fa fa-fw fa-link"></i> Link do Anúncio:</strong> <a href="'.$link.'" title="'.$data->shop_name.'" target="_blank">'.$link.'</a> <i data-link="'.$link.'" class="fa fa-fw fa-clipboard copy-link"></i>
							</p>
						</div>
					</div>
				</div>

		';

		if($ads){

			$per_page = 10;

			$object .= '
				<div class="sp-ads">
					<h1 class="sp-a-title"><i class="fa fa-cubes"></i>Anúncios</h1>

					<div class="ads-listing ads-listing-intern" id="ads-listing">
			';

			$i = 1;

			$object .= '<div class="al-page active" data-page="1">';

			foreach ($ads as $key => $ad) {
				$object .= $this->ads_model->ads_item($ad);

				if($i % $per_page == 0) { $object .= '</div><div class="al-page" data-page="'.(($i/$per_page)+1).'">'; }

				$i++;
			}

			$object .= '</div>';

			$object .= '
					</div>
				</div>
			';

			$object .= '<div class="pagination-box"></div>';
		}

		$object .= '
			</div>
		';

		return $object;
	}

	public function getBySlug($slug){
		$this->db->limit(1);
		$this->db->where("shop_slug", $slug);
		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query[0];
		}else{
			return false;
		}
	}

	public function shopsCount($status = 1){
		$this->db->where("shop_status", $status);
		return $this->db->count_all_results("shops");
	}

	public function slugVerify($string, $code){
		$this->db->where("shop_id <>", $code);
		$this->db->where("shop_slug", $string);
		$query = $this->db->get("shops");
		$query = $query->result();

		if($query){
			return $query;
		}else{
			return false;
		}
	}

}

/* End of file Shops_model.php */
/* Location: ./application/models/Shops_model.php */
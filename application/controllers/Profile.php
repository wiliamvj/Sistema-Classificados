<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->seo_title = "Perfil";
	}

	public function index()
	{
		redirect("profile/dashboard");
	}

	public function dashboard()
	{
		/* Breadcrumbs */
		$data['breadcrumbs'][] = array('name' => $this->seo_title);
		$data['breadcrumbs'][] = array('name' => 'Dashboard');

		/* SEO */
		$data['seo_title'] = "Dashboard - ".$this->seo_title;

		/* View */
		$data['page'] = 'dashboard';
		$this->template->load('app', 'profile', $data);
	}

	public function ads($statu = false)
	{
                paginacao()->config(20); 
		$ads = $this->user_model->ads($this->input->get('status'), paginacao()->getQtd(), paginacao()->getInicio());
                $total_ads = $this->user_model->countAds($this->input->get('status'));
		if($ads){
			echo '<div class="ads-listing ads-listing-intern">';

			foreach ($ads as $key => $ad) {
				echo '<table class="table-order">';
				echo $this->ads_model->ads_item($ad, true, $ad->ad_status);
                                echo '<script>shopHover();</script>';
				echo '
					<div class="pd-item-actions">
						<div class="row">
							<div class="small-4 medium-3 columns"><strong>ID:</strong> '.$ad->ad_id.'</div>
							<div class="small-8 medium-3 columns">'.label_ads_status($ad->ad_status).'</div>
							<div class="small-12 medium-6 columns" align="right">
								
								'.(($ad->ad_status == 2) ? '<a data-modal="'.base_url('profile/ads_action/modal/pause/'.$ad->ad_id).'" class="btn btn-warning btn-label modal-open"><i class="fa fa-pause"></i>Pausar</a>' : '').'

								'.(($ad->ad_status == 3) ? '<a data-modal="'.base_url('profile/ads_action/modal/play/'.$ad->ad_id).'" class="btn btn-info btn-label modal-open"><i class="fa fa-play"></i>Continuar</a>' : '').'

								'.(($ad->ad_status != 4) ? '<a href="'.base_url('profile/ad_edit/form/'.$ad->ad_id).'" class="btn btn-primary btn-label"><i class="fa fa-edit"></i>Editar</a>' : '').'

								<a data-modal="'.base_url('profile/ads_action/modal/delete/'.$ad->ad_id).'" class="btn btn-danger btn-label modal-open"><i class="fa fa-trash"></i>Excluir</a>
							</div>
						</div>
					</div>
				';
				echo '</table>';
				
			}
                        echo paginacao()->exibirPaginacao(paginacao()->getPagina(), paginacao()->getTotalPagina($total_ads), 'profile/ads', $total_ads, true, 'interna');
			echo '</div>';
		}else{
			$anunci = base_url('anunciar');
			echo '<div class="alert">Nenhum anúncio encontrado.</div>';
			echo '<div class="text-center"><a href="'.$anunci.'" class="btn btn-success"><i class="fa fa-money" aria-hidden="true"></i>Vender o que não uso</a></div>';
		}
	}

	public function ad_edit($view = "form", $code)
	{
		if($view == "form"){
			/* Ad Details */
			$data['ad'] = $this->ads_model->details($code, false);

			if($data['ad']->ad_use_info){
				$state = $this->main_model->statesDetails($data['ad']->use_state);
				$regions = $this->main_model->regionsDetails($data['ad']->use_region);
				$city = $this->main_model->citiesDetails($data['ad']->use_city);

				$city = @$city->cit_name;
				$regions = @$regions->regiao_nome;
				$state = @$state->sta_name;

				$data['state'] = $state;
				$data['region'] = $regions;
				$data['city'] = $city;
				$data['neighborhood'] = $data['ad']->use_neighborhood;
				$data['address'] = $data['ad']->use_address;
			}else {
				$state = $this->main_model->statesDetails($data['ad']->ad_state);
				$regions = $this->main_model->regionsDetails($data['ad']->ad_region);
				$city = $this->main_model->citiesDetails($data['ad']->ad_city);

				$city = @$city->cit_name;
				$regions = @$regions->regiao_nome;
				$state = @$state->sta_name;

				$data['state'] = $state;
				$data['region'] = $regions;
				$data['city'] = $city;
				$data['neighborhood'] = $data['ad']->ad_neighborhood;
				$data['address'] = $data['ad']->ad_address;
			}


			$data['category_parent'] = $this->ads_model->categoriesDetails($data['ad']->ads_cat_parent);
			$data['images'] = $this->ads_model->images($code);

			/* Categories */
			$data['categories'] = $this->ads_model->categories(0);

			/* Areas */
			$data['areas'] = $this->ads_model->areas();

			/* Hash */
			$ip = $_SERVER['REMOTE_ADDR'];
			$data['hash'] = md5($ip.rand(1,99999));

			/* Breadcrumbs */
			$data['breadcrumbs'][] = array('name' => $this->seo_title);
			$data['breadcrumbs'][] = array('name' => 'Meus Anúncios', 'link' => base_url('cliente/painel'));
			$data['breadcrumbs'][] = array('name' => 'Editar Anúncio');

			/* SEO */
			$data['seo_title'] = "Editar Anúncio - ".$this->seo_title;

			/* View */
			$data['page'] = 'ad_edit';
			$this->template->load('app', 'profile', $data);
		}elseif ($view == "save") {
			$hash = $this->input->post("hash");

			$category = (int) $this->input->post("category");
			$title = $this->input->post("title");
			$desc = $this->input->post("desc");
			$price = $this->input->post("price");
			$service = $this->input->post("no-price");
			$trade = $this->input->post("yes-trade");
			$video = $this->input->post("video");
			$areas = $this->input->post("area");
			$mercado_livre = $this->input->post("mercado_livre");
			$elo7 = $this->input->post("elo7");
			$cep = $this->input->post("cep");
			$state = $this->input->post("state");
			$region = $this->input->post("region");
			$city = $this->input->post("city");
			$neighborhood = $this->input->post("neighborhood");
			$address = validate_name($this->input->post("address"));
			$use_info = $this->input->post("use-info");
			$custom = $this->input->post("custom[]");
			$custom_checkbox = $this->input->post("custom_checkbox[]");
			$images = $this->input->post("images[]");
			$imgs_deleted = $this->input->post('img-deleted[]');
                         $adote = $this->input->post("adote");

			$data = array(
                                'adote' => (($adote) ? 1 : 0),
				'ads_cat_id' 		=> $category,
				'ad_name' 			=> $title,
				'ad_desc' 			=> $desc,
				'ad_price' 			=> db_money($price),
				'ad_service' 		=> (($service) ? 1 : 0),
				'ad_trade' 			=> (($trade) ? 1 : 0),
				'ad_video' 			=> $video,
				'ad_mercado_livre' 	=> $mercado_livre,
				'ad_elo7' 			=> $elo7,
				'ad_cep' 			=> (($cep) ? $cep : ""),
				'ad_state' 			=> (($state) ? $state : ""),
				'ad_region' 		=> (($region) ? $region : ""),
				'ad_city' 			=> (($city) ? $city : ""),
				'ad_neighborhood' 	=> (($neighborhood) ? $neighborhood : ""),
				'ad_address' 		=> (($address) ? $address : ""),
				'ad_use_info' 		=> (($use_info) ? 1 : 0),
				'ad_slug'			=> url_title($title),
				'ad_status'			=> 1
			);

			$this->ads_model->update($data, $code);

			$this->ads_model->areasDelete($code);

			if($areas){
				foreach ($areas as $key => $area) {
					$this->ads_model->insertAreaAnnounce($area, $code);
				}
			}

			/* Set Images */
			$this->ads_model->imagesSetAds($hash, $code);
			$this->ads_model->cleanImagesHashs($code);

			$this->ads_model->cleanCustomFields($code);

			if($custom){
				foreach ($custom as $key => $custom_item) {
					$custom_data = array(
						'ad_id' => $code, 
						'cat_fie_id' => $key, 
						'ads_cus_value' => $custom_item
					);

					$this->ads_model->insertCustomField($custom_data);
				}
			}

			$this->ads_model->cleanCustomCheckbox($code);

			if($custom_checkbox){
				foreach ($custom_checkbox as $key_1 => $checkbox_item) {
					foreach ($checkbox_item as $key_2 => $custom_item) {
						$custom_data = array(
							'ad_id' => $code, 
							'cat_fie_id' => $key_1, 
							'che_opt_id' => $key_2
						);

						$this->ads_model->insertCustomCheckbox($custom_data);
					}
				}
			}

			$this->session->set_flashdata('return', 'announce_insert_success');

			redirect("cliente/painel");
		}
	}

	public function ads_action($view, $action, $code)
	{
		$ad = $this->ads_model->details($code, false);

		if($view == "modal"){
			if($action == "sell"){ /* Sell */
				$data['modal_title'] = "Vender Anúncio";

				$data['text'] = 'Você tem certeza que deseja marcar como vendido o anúncio "<strong>'.$ad->ad_name.'</strong>"?';

				$data['button'] = array('type' => 'success', 'text' => 'Vendido');
			}elseif ($action == "resell") { /* Resell */
				$data['modal_title'] = "Revender Anúncio";

				$data['text'] = 'Você tem certeza que deseja revender o anúncio "<strong>'.$ad->ad_name.'</strong>"?';

				$data['button'] = array('type' => 'secondary', 'text' => 'Revender');
			}elseif ($action == "pause") { /* Pause */
				$data['modal_title'] = "Pausar Anúncio";

				$data['text'] = 'Você tem certeza que deseja pausar por enquanto o anúncio "<strong>'.$ad->ad_name.'</strong>"? O anúncio deixará de ser exibido para os outros usuários.';

				$data['button'] = array('type' => 'warning', 'text' => '<i class="fa fa-pause"></i> Pausar');
			}elseif ($action == "play") { /* Play */
				$data['modal_title'] ="Continuar Anúncio";

				$data['text'] = 'Você tem certeza que deseja continuar com o anúncio "<strong>'.$ad->ad_name.'</strong>"? O anúncio vai voltar a ser exibido para os outros usuários.';

				$data['button'] = array('type' => 'info', 'text' => '<i class="fa fa-play"></i> Continuar');
			}elseif ($action == "delete") { /* Delete */
				$data['modal_title'] = "Apagar Anúncio";

				$data['text'] = 'Você tem certeza que deseja apagar o anúncio "<strong>'.$ad->ad_name.'</strong>"?<br>O anúncio e seus dados e imagens vão ser apagados permanentemente.';

				$data['button'] = array('type' => 'danger', 'text' => '<i class="fa fa-trash" aria-hidden="true"></i>Apagar');
			}

			$data['link'] = base_url('profile/ads_action/action/'.$action.'/'.$code);

			$data['modal_size'] = "small";

			$this->template->load('modal', 'profile_ads_action', $data);
		}elseif($view == "action") {
			if($action == "sell"){ /* Sell */
				$user_ads_sales = (int) $this->user_model->info('use_ads_sales');

				$data = array( 'use_ads_sales' => ($user_ads_sales + 1) );

				$this->user_model->update($data);

				$this->ads_model->status($code, 4);
				
				$this->session->set_flashdata('return', 'ads_action_sell');

				$this->session->set_userdata("temp", $code);

				redirect("profile/testimony/");
			}elseif ($action == "resell") { /* Resell */
				$this->ads_model->status($code, 2);
				
				$this->session->set_flashdata('return', 'ads_action_resell');
			}elseif ($action == "pause") { /* Pause */
				$this->ads_model->status($code, 3);
				
				$this->session->set_flashdata('return', 'ads_action_pause');
			}elseif ($action == "play") { /* Play */
				$this->ads_model->status($code, 2);
				
				$this->session->set_flashdata('return', 'ads_action_play');
			}elseif ($action == "delete") { /* Delete */
				
				$this->ads_model->status($code, 5);
				
				$this->session->set_flashdata('return', 'ads_action_delete');

				$this->session->set_userdata("temp", $code);

				redirect("profile/testimony/");
                                
			}

			redirect("profile/dashboard");
		}
	}

	public function details($action = "form")
	{
		if($action == "form"){ /* Form View */
			/* User Details */
			$data['user'] = $this->user_model->info();

			
			$regions = $this->main_model->regionsDetails($data['user']->use_region);
			$regions = @$regions->regiao_nome;
			$data['region'] = $regions;
			/* Localization */
			$data['states'] = $this->main_model->states();

			/* Breadcrumbs */
			$data['breadcrumbs'][] = array('name' => $this->seo_title);
			$data['breadcrumbs'][] = array('name' => 'Meu Cadastro');

			/* SEO */
			$data['seo_title'] = "Meu Cadastro - ".$this->seo_title;

			/* View */
			$data['page'] = 'details';
			$this->template->load('app', 'profile', $data);
		}elseif ($action == "save") { /* Save Data */
			
			/* Post */
			$name = validate_name($this->input->post("name"));
			$password = $this->input->post("password");
			$phone = $this->input->post("phone");
			$celular = $this->input->post("celular");
			$whatsapp = $this->input->post("whatsapp");
			$website = ($this->input->post("website")) ? ("http://".str_replace(array("http://", "https://"), "", $this->input->post("website"))) : ('');
			$facebook = str_replace("https://www.facebook.com/", "", $this->input->post("facebook"));
			$instagram = str_replace("https://www.instagram.com/", "", $this->input->post("instagram"));
			$elo7 = str_replace("http://www.elo7.com.br/", "", $this->input->post("elo7"));
			$mercado_livre = $this->input->post("mercado_livre");
			$cep = $this->input->post("cep");
			$address = validate_name($this->input->post("address"));
			$city = (int) $this->input->post("city");
			$state = (int) $this->input->post("state");
			$region = $this->input->post("region");
			$neighborhood = $this->input->post("neighborhood");

			$data = array(
				'use_name' => $name,
				'use_phone' => $phone,
				'use_celular' => $celular,
				'use_whatsapp' => $whatsapp,
				'use_website' => $website,
				'use_facebook' => $facebook,
				'use_instagram' => $instagram,
				'use_elo7' => $elo7,
				'use_mercado_livre' => $mercado_livre,
				'use_cep' => $cep,
				'use_region' => $region,
				'use_neighborhood' => $neighborhood,
				'use_address' => $address,
				'use_city' => $city,
				'use_state' => $state
			);

			$this->user_model->update($data);

			if($password){
				$data = array('use_password' => md5($password));

				$this->user_model->update($data);
			}

			$this->session->set_flashdata('return', 'profile_details_save');

			redirect('profile/details');
		}else{
			redirect("profile/details");
		}

	}

	public function shop($view = "edit")
	{
		/* Breadcrumbs */
		$data['breadcrumbs'][] = array('name' => $this->seo_title);
		$data['breadcrumbs'][] = array('name' => 'Minha Loja');

		/* SEO */
		$data['seo_title'] = "Minha Loja - ".$this->seo_title;

		if($view == "edit"){
			/* Verify Shop */
			$data['shop'] = $this->shops_model->details(false, false, true);

			$regions = $this->main_model->regionsDetails($data['shop']->shop_region);
			$regions = @$regions->regiao_nome;
			$data['region'] = $regions;

			if($data['shop']){
				/* Categories */
				$data['categories'] = $this->ads_model->categories(0);

				/* Localization */
				$data['states'] = $this->main_model->states();

				/* View */
				$data['page'] = 'shop';
			}else{
				/* Verify Qty Ads */
				$ads = $ads = $this->user_model->adsCount(2);

				if($ads >= 5){
					redirect("profile/shop/create");
				}else{
					redirect("profile/shop/denied");
				}
			}			
		}elseif ($view == "update") {

			$shop = $this->input->post('shop');
			$name = $this->input->post('name');
			$desc = $this->input->post('desc');
			$category = (int) $this->input->post('category');
			$slug = $this->input->post('slug');
			$image = $this->input->post('image');
			$user_info = $this->input->post('user_info');
			$phone = $this->input->post('phone');
			$city = $this->input->post('city');
			$state = $this->input->post('state');
			$region = $this->input->post('region');
			$cep = $this->input->post('cep');

			if($this->input->post('slug') == ''):
				$data = array(
					'ads_cat_id' => $category,
					'shop_name' => $name,
					'shop_desc' => $desc,
					'shop_user_info' => (($user_info) ? 1 : 0),
					'shop_phone' => $phone,
					'shop_cep' => $cep,
					'shop_city' => $city,
					'shop_state' => $state,
					'shop_region' => $region,
				);
			else:
				$data = array(
					'ads_cat_id' => $category,
					'shop_name' => $name,
					'shop_desc' => $desc,
					'shop_slug' => $slug,
					'shop_user_info' => (($user_info) ? 1 : 0),
					'shop_phone' => $phone,
					'shop_address' => $address,
					'shop_cep' => $cep,
					'shop_city' => $city,
					'shop_state' => $state,
					'shop_region' => $region,
					'shop_neighborhood' => $neighborhood
				);
			endif;		

			$this->shops_model->update($shop, $data);

			if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
				$upload_img = @$this->main_model->uploadImage("image", "shops");

				if($upload_img['file_name']){
					$img_data = array(
						"shop_img_path" => $upload_img['full_path'],
						"shop_img_file" => $upload_img['file_name']
					);

					$this->shops_model->update($shop, $img_data);
				}
			}

			$this->session->set_flashdata('return', 'profile_shop_update');

			redirect('profile/shop/edit');
		}elseif ($view == "create") {
			$data['categories'] = $this->ads_model->categories(0);

			/* View */
			$data['page'] = 'shop_create';
		}elseif ($view == "open") {
			$name = $this->input->post('name');
			$desc = $this->input->post('desc');
			$category = (int) $this->input->post('category');
			$image = $this->input->post('image');
			$slug = $this->input->post('slug');

			$data = array(
				'use_id' => $this->session->userdata('login'),
				'ads_cat_id' => $category,
				'shop_name' => $name,
				'shop_desc' => $desc,
				'shop_slug' => $slug
			);			

			$shop = $this->shops_model->insert($data);

			if($shop){
				if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
					$upload_img = @$this->main_model->uploadImage("image", "shops");

					if($upload_img['file_name']){
						$img_data = array(
							"shop_img_path" => $upload_img['full_path'],
							"shop_img_file" => $upload_img['file_name']
						);

						$this->shops_model->update($shop, $img_data);
					}
				}

				/* Email Variables */
				$user = $this->user_model->info();
				$user_name = $user->use_name;
				$user_email = $user->use_email;
				$shop_name = $name;
				$shop_link = base_url('loja/'.$slug);
				$datetime = date('d/m/Y H:i:s');

				/* Email Details */
				$email_details = $this->main_model->emailsDetails(9);

				/* Message */
				$content = $email_details->email_content;

				if (preg_match_all('/({\$+\w+})/', $content, $matches)){

					foreach ($matches[0] as $key => $value) {
						$variable = str_replace('{', '', $value);
						$variable = str_replace('}', '', $variable);
						$string = eval('return '. $variable . ';');

						$content = str_replace($value, $string, $content);
					}

				}

				$email_message = $content;

				/* Subject */
				$email_subject = $email_details->email_subject;

				/* To */
				$email_to = $user_email;

				/* Send Email */
				$this->main_model->email($email_to, $email_subject, $email_message);

				/* Return Msg */
				$this->session->set_flashdata('return', 'profile_shop_open');
			}

			redirect('profile/shop/edit');
		}elseif ($view == "denied") {
			/* View */
			$data['page'] = 'shop_denied';
		}

		$this->template->load('app', 'profile', $data);
	}

	public function favorites()
	{
		/* Ads Listing */
		$data['favorites'] = $this->user_model->favorites();

		/* Breadcrumbs */
		$data['breadcrumbs'][] = array('name' => $this->seo_title);
		$data['breadcrumbs'][] = array('name' => 'Favoritos');

		/* SEO */
		$data['seo_title'] = "Favoritos - ".$this->seo_title;

		/* View */
		$data['page'] = 'favorites';
		$this->template->load('app', 'profile', $data);
	}

	public function testimony($view = "page")
	{
		if($view == "page"){
			$code = $this->session->userdata('temp');

			/* Ad Details */
			$data['ad'] = $this->ads_model->details($code, false);

			if($data['ad']){
				/* Breadcrumbs */
				$data['breadcrumbs'][] = array('name' => $this->seo_title);
				$data['breadcrumbs'][] = array('name' => 'Deixar Depoimento');

				/* SEO */
				$data['seo_title'] = "Deixar Depoimento - ".$this->seo_title;

				/* View */
				$data['page'] = 'testimony';
				$this->template->load('app', 'profile', $data);
			}else{
				redirect('/');
			}
		}elseif ($view == "save") {
			$text = $this->input->post('text');
			$code = $this->input->post('code');

			$ad = $this->ads_model->details($code, false);
			$ad_images = $this->ads_model->images($code);

			$data = array(
				'tes_name' 		=> $ad->use_name, 
				'tes_text' 		=> $text, 
				'tes_category' => $ad->ads_cat_name, 
				'tes_ad' 		=> $ad->ad_name,
				'tes_ad_image' => $ad_images[0]->ads_img_file,
				'tes_status' 	=> 2
			);

			$this->main_model->testimonyInsert($data);

			$this->session->set_flashdata('return', 'testimony_insert');

			redirect('cliente/painel');
		}
	}

	public function chat($ad_id){

        /* Breadcrumbs */
        $data['breadcrumbs'][] = array('name' => $this->seo_title);
        $data['breadcrumbs'][] = array('name' => 'Chat');

        /* SEO */
        $data['seo_title'] = "Chat - ".$this->seo_title;

        /* View */
        $data['page'] = 'chat';
        $data['ad_id'] = $ad_id;
        $this->template->load('app', 'profile', $data);
    }

}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
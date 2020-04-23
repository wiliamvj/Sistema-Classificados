<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		/* Categories */
		$data['ads_categories'] = $this->ads_model->categories(0);

		/* Count Ads */
		$data['count_ads'] = $this->ads_model->adsCount();
		
		$data['relatedHome'] = $this->ads_model->relatedHome(4, $code);

		/* Count Shops */
		$data['count_shops'] = $this->shops_model->shopsCount();

		/* View */
		$this->template->load('app', 'main', $data);
	}

	public function cities()
	{
		/* Post */
		$state = $this->input->post("state");
		$type = $this->input->post("type");

		/* Cities */
		$cities = $this->main_model->cities($state);

		if($type == "options"){ /* for select input */
			echo '<option hidden value="">Selecione sua cidade</option>';
			
			foreach ($cities as $key => $city) {
				echo '<option value="'.$city->cit_id.'">'.$city->cit_name.'</option>';
			}
		}
	}

	public function map(){
		$states = $this->main_model->states('sta_map_order', 'ASC');

		// SVG - begin
		echo '<svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 465 475" preserveAspectRatio="xMidYMid meet" id="map">';

		// G - begin
		echo '<g class="model-green">';

		// title
		echo '<desc>Brasil</desc>';

		// states
		foreach ($states as $key => $s) {
			$name = $s->sta_name;
			$initials = $s->sta_initials;

			echo '
			<a href="'.base_url('anuncios/?estado='.$s->sta_id).'" class="ms-m-item">
				<desc id="description_'.strtolower($initials).'">'.$name.'</desc>
				'.(($s->sta_map_path_d) ? '<path d="'.$s->sta_map_path_d.'" class="shape" id="shape-'.strtolower($initials).'"/>' : '').'
				'.(($s->sta_map_circle_cy) ? '<circle cy="'.$s->sta_map_circle_cy.'" cx="'.$s->sta_map_circle_cx.'" r="12" class="icon-state" id="icon-'.strtolower($initials).'"/>' : '').'
				<text y="'.$s->sta_map_label_icon_y.'" x="'.$s->sta_map_label_icon_x.'" class="label-icon-state" id="label-icon-state-'.strtolower($initials).'">'.$initials.'</text>
				<text y="'.$s->sta_map_label_y.'" x="'.$s->sta_map_label_x.'" class="label-state" id="label-state-'.strtolower($initials).'">'.$name.'</text>
			</a>
			';
		}

		// G - end
		echo '</g>';

		// SVG - end
		echo '</svg>';
	}

	public function category_fields(){
		$category = $this->input->post('category');
		$ads_fields = $this->input->post('ads_fields');

		$fields = $this->main_model->customFields($category);

		if($fields){
			foreach ($fields as $key => $f) {
				$id = $f->cat_fie_id;
				$label = $f->cat_fie_name;
				$type = $f->cat_fie_type;
				$required = $f->cat_fie_required;
				$placeholder = $f->cat_fie_placeholder;

				if($ads_fields){
					$value = $this->ads_model->customFieldValue($ads_fields, $id);
				}
				if($type == "checkbox"):
					echo '
						<div class="row">
							<div class="hide-for-small-only medium-2 columns">
								<label class="text-right middle">'.$label.':'.(($required) ? '<span class="required">*</span>' : '').'</label>
							</div>
							<div class="small-12 medium-10 large-10 end columns">
								<label class="show-for-small-only">'.$label.':'.(($required) ? '<span class="required">*</span>' : '').'</label>
					';
				else:
					echo '
						<div class="row">
							<div class="hide-for-small-only medium-2 columns">
								<label class="text-right middle">'.$label.':'.(($required) ? '<span class="required">*</span>' : '').'</label>
							</div>
							<div class="small-12 medium-4 large-4 end columns">
								<label class="show-for-small-only">'.$label.':'.(($required) ? '<span class="required">*</span>' : '').'</label>
					';
				endif;

				if($type == "text"){
					$mask = $f->cat_fie_text_mask;

					echo '<input maxlength="30" type="text" '.(($required) ? 'required' : '').' '.(($mask) ? 'class="input-'.$mask.'"' : '').' name="custom['.$id.']" placeholder="'.$placeholder.'" '.((@$value) ? 'value="'.$value.'"' : '').'>';
				}

				if($type == "textarea"){
					$rows = $f->cat_fie_textarea_rows;

					echo '<textarea '.(($required) ? 'required' : '').' name="custom['.$id.']" rows="'.$rows.'" placeholder="'.$placeholder.'">'.(($value) ? $value : '').'</textarea>';
				}

				if($type == "select"){
					$option_default = $f->cat_fie_select_default;
					$options = $this->main_model->customSelectOptions($id);

					echo '<select '.(($required) ? 'required' : '').' name="custom['.$id.']">';

					if($option_default){
						echo '<option value="">'.$option_default.'</option>';
					}

					foreach ($options as $key => $opt) {
						echo '<option '.(($value && $value == $opt->sel_opt_id) ? 'selected' : '').' value="'.$opt->sel_opt_id.'">'.$opt->sel_opt_name.'</option>';
					}

					echo '</select>';
				}

				if($type == "checkbox"){
					$options = $this->main_model->customCheckboxOptions($id);

					echo '<input type="hidden" name="custom['.$id.']" value="1">'; 
					echo '<div class="row">';
					foreach ($options as $key => $opt) {
						if($ads_fields){
							$value = $this->ads_model->checkCustomCheckbox($ads_fields, $opt->che_opt_id);
						}

						echo '
							<div class="small-12 medium-6 end columns">
								<div class="checkbox-custom cc-m-bottom-xsmall">
								   <input type="checkbox" '.(($value && $value == $opt->che_opt_id) ? 'checked' : '').' name="custom_checkbox['.$id.']['.$opt->che_opt_id.']" id="custom_'.$id.'_'.$opt->che_opt_id.'">
								   <label for="custom_'.$id.'_'.$opt->che_opt_id.'">'.$opt->che_opt_name.'</label>
								</div>
							</div>
						';
					}
					echo '</div>';
					echo '<div style="height: 20px"></div>';
				}

				echo '
						</div>
					</div>
				';
			}
		}else{
			return false;
		}
	}

}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
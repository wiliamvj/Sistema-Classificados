<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fields extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function campos() {
        $category = $this->input->get('categoria');
        $ads_fields = $this->input->get('ad_id');

        $fields = $this->main_model->customFields($category);

        if ($fields) {
            echo '<div class="row">
                        <div class="col-md-6">';
            $div = 0;
            foreach ($fields as $key => $f) {
                $div++;
                $id = $f->cat_fie_id;
                $label = $f->cat_fie_name;
                $type = $f->cat_fie_type;
                $required = $f->cat_fie_required;
                $placeholder = $f->cat_fie_placeholder;
               
                if ($ads_fields) {
                    $value = $this->main_model->customFieldValue($ads_fields, $id);
                }

                if ($type == "checkbox"):
                    echo '
						
                                                        
                                                                    <label class="text-right middle">' . $label . ':' . (($required) ? '<span class="required">*</span>' : '') . '</label>
                                                        
                                                        
						<label class="show-for-small-only">' . $label . ':' . (($required) ? '<span class="required">*</span>' : '') . '</label>
					';
                else:
                    echo '
						
								<label class="text-right middle">' . $label . ':' . (($required) ? '<span class="required">*</span>' : '') . '</label>
							
							
								<label class="show-for-small-only">' . $label . ':' . (($required) ? '<span class="required">*</span>' : '') . '</label>
					';
                endif;

                if ($type == "text") {
                    $mask = $f->cat_fie_text_mask;

                    echo '<input maxlength="30" class="form-control" type="text" ' . (($required) ? 'required' : '') . ' ' . (($mask) ? 'class="input-' . $mask . '"' : '') . ' name="custom[' . $id . ']" placeholder="' . $placeholder . '" ' . ((@$value) ? 'value="' . $value . '"' : '') . '>';
                }

                if ($type == "textarea") {
                    $rows = $f->cat_fie_textarea_rows;

                    echo '<textarea ' . (($required) ? 'required' : '') . ' class="form-control" name="custom[' . $id . ']" rows="' . $rows . '" placeholder="' . $placeholder . '">' . (($value) ? $value : '') . '</textarea>';
                }

                if ($type == "select") {
                    $option_default = $f->cat_fie_select_default;
                    $options = $this->main_model->customSelectOptions($id);

                    echo '<select ' . (($required) ? 'required' : '') . ' class="form-control" name="custom[' . $id . ']">';

                    if ($option_default) {
                        echo '<option value="">' . $option_default . '</option>';
                    }

                    foreach ($options as $key => $opt) {
                        echo '<option ' . (($value && $value == $opt->sel_opt_id) ? 'selected' : '') . ' value="' . $opt->sel_opt_id . '">' . $opt->sel_opt_name . '</option>';
                    }

                    echo '</select>';
                }
               
                if ($div == 13) {
                     echo '</div>';
                    echo '<div class="col-md-6">';
                }
                if ($type == "checkbox") {
                    $options = $this->main_model->customCheckboxOptions($id);

                    echo '<input type="hidden"  name="custom[' . $id . ']" value="1">';

                    foreach ($options as $key => $opt) {
                        if ($ads_fields) {
                            $value = $this->main_model->checkCustomCheckbox($ads_fields, $opt->che_opt_id);
                        }

                        echo '
						<div class="col-md-6">	
								
								   <input  type="checkbox" ' . (($value && $value == $opt->che_opt_id) ? 'checked' : '') . ' name="custom_checkbox[' . $id . '][' . $opt->che_opt_id . ']" id="custom_' . $id . '_' . $opt->che_opt_id . '">
								   <label for="custom_' . $id . '_' . $opt->che_opt_id . '">' . $opt->che_opt_name . '</label>
								
						</div>	
						';
                    }
                    // echo '</div>';
                    //echo '<div style="height: 20px"></div>';
                }
            }
            echo '</div>';
            echo '</div>';
        } else {
            return false;
        }
    }

}

/* End of file Pages.php */
/* Location: ./application/controllers/Fields.php */
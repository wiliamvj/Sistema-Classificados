<?php

$return = $this->session->flashdata('return');

if(@$return){

	$ret = $this->main_model->returnDetails($return);

	if($ret){
		echo '
			<div id="alert-box" class="row">
				<div class="medium-12 columns">
					<div class="alert alert-'.$ret->ret_type.'"><i class="fa fa-fw '.$ret->ret_icon.'"></i>'.$ret->ret_text.'</div>
				</div>
			</div>
		';
	}
}
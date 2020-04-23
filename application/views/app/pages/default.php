<h1><?php echo $p->page_name ?></h1>

<?php
	echo $p->page_content;

	if($faq){
		echo '<div class="faq-accordion">';

		foreach ($faq as $key => $item) {
			echo '
				<div class="fa-item" data-id="'.$item->page_faq_id.'" data-status="0">
					<div class="fa-i-question">
						<span>'.$item->page_faq_question.'</span>
						<span><i class="fa fa-fw fa-plus"></i></span>
					</div>
					<div class="fa-i-answer">'.nl2br($item->page_faq_answer).'</div>
				</div>
			';
		}

		echo '</div>';
	}
?>
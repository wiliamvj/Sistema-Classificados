<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?=urldecode($modal_title);?></h4>
		</div>
		<?php
			echo $contents;
		?>
	</div>
</div>
<div class="row">
	<div class="medium-3 columns">
		<nav class="pages-menu">
			<ul>
				<?php
					$pages = $this->main_model->pages();

					foreach ($pages as $key => $pag) {
						echo '
						<li>
							<a href="'.base_url('ajuda/'.$pag->page_slug).'" '.((@$p && $pag->page_id == $p->page_id) ? 'class="active"' : '').' target="_self">
								<span><i class="fa fa-fw '.$pag->page_icon.'"></i></span>
								<span>'.$pag->page_name.'</span>
							</a>
						</li>
						';
					}
				?>
				<li>
					<a href="<?=base_url('contato')?>" <?=(($page == "contact") ? 'class="active"' : '')?> target="_self">
						<span><i class="fa fa-fw fa-comments"></i></span>
						<span>Fale Conosco</span>
					</a>
				</li>
			</ul>
		</nav>
		
		<div class="hide-for-small-only">
			<?=$this->main_model->advertisingBox('side', '266px', '600px')?>
		</div>
	</div>
	<div class="medium-9 columns">
		<?=$this->main_model->advertisingBox('top', '100%', '90px')?>

		<div class="simple-page">
		<?php
			include_once("pages/".$page.".php");
		?>
		</div>
	</div>
</div>
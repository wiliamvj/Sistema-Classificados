<div class="simple-page">
	<h1>Deixar Depoimento</h1>

	<p>Nos diga como foi sua negociação ou interação em nosso site!</p>
	
	<p> Os depoimentos são opcionais, mais ficamos felizes por receber sugestões ou críticas!<p>

	<ul>
		<li><strong>Anúncio:</strong> <?=$ad->ad_name?></li>
	</ul>

	<br>

	<form action="<?=base_url('profile/testimony/save')?>" method="POST">
		<input type="hidden" name="code" value="<?=$ad->ad_id?>">
		<div class="row">
			<div class="medium-12 columns">
				<textarea name="text" required placeholder="Deixe aqui seu depoimento" maxlength="140" rows="5"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="small-6 columns">
				<a href="<?=base_url('cliente/painel')?>" class="btn btn-default"><i class="fa fa-times"></i>Cancelar</a>
			</div>
			<div class="small-6 columns" align="right">
				<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i> Enviar</a>
			</div>
		</div>
	</form>
</div>
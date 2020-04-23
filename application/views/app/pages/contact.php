<h1>Fale Conosco</h1>

<form method="POST" action="<?=base_url('pages/contact/send')?>" id="contact-form" class="form form-simple contact-form">
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Nome:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-10 columns">
			<label class="show-for-small-only">Nome:<span class="required">*</span></label>
			<input type="text" required name="name" placeholder="Informe o seu nome completo">
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">E-mail:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-10 columns">
			<label class="show-for-small-only">E-mail:<span class="required">*</span></label>
			<input type="email" required name="email" placeholder="Informe o seu e-mail">
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Telefone:</label>
		</div>
		<div class="small-12 medium-10 columns">
			<label class="show-for-small-only">Telefone:</label>
			<input type="text" name="phone" class="input-phone" placeholder="Informe o seu telefone">
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Assunto:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-10 columns">
			<label class="show-for-small-only">Assunto:<span class="required">*</span></label>
			<select name="subject">
				<option value="Contato">Contato</option>
				<option value="Problemas com Anúncios">Problemas com Anúncios</option>
				<option value="Cadastro/Conta">Cadastro/Conta</option>
				<option value="Destaque">Destaque</option>
				<option value="Problemas Técnicos">Problemas Técnicos</option>
				<option value="Denúncia">Denúncia</option>
				<option value="Sugestão/Reclamação">Sugestão/Reclamação</option>
				<option value="Outros">Outros</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">
			<label class="text-right middle">Mensagem:<span class="required">*</span></label>
		</div>
		<div class="small-12 medium-10 columns">
			<label class="show-for-small-only">Mensagem:<span class="required">*</span></label>
			<textarea placeholder="Mensagem do contato" name="msg" required rows="5"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="hide-for-small-only medium-2 columns">&nbsp;</div>
		<div class="small-12 medium-10 columns">
			<button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Enviar</button>
		</div>
	</div>
</form>
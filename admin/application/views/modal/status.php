<div class="modal-body">
    <h4>Atenção!</h4>
    <p>Ao clicar no botão (<b><?= ($status_id == 0 and $status_atual == 5) ? 'Excluir em massa ': urldecode($modal_link_text).' todos os Anúncios' ?> </b>), esta ação será executada para todos os anúncios com status: <b><?php echo ads_status($status_atual);?></b></p>
    <br/>
    <?= urldecode($modal_text); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <a href="javascript:void(0);" onclick="enviaForm(<?php echo $status_id; ?>, <?php echo $status_atual; ?>);" class="btn btn-<?= $modal_link_type ?>"><?=($status_id == 0 and $status_atual == 5) ? 'Excluir Selecionados': urldecode($modal_link_text).' Selecionados' ?> </a>
    <a href="javascript:void(0);" onclick="acaoEmMassa(<?php echo $status_id; ?>, <?php echo $status_atual; ?>);" class="btn btn-danger"><?= ($status_id == 0 and $status_atual == 5) ? 'Excluir em massa': urldecode($modal_link_text).' todos os Anúncios'; ?></a>
</div>
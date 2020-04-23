var base_url = '';

$(document).ready(function() {
	$(".input-phone").foneMascara();
    $(".input-cpf").mask("000.000.000-00");
    $(".input-cep").mask("00000-000");
    $(".input-money").mask("0.000.000,00", {reverse: true});

	$(".table-order").dataTable({
		"order": [[ 0, 'desc' ]],
		"pageLength": 50,
		"lengthMenu": [ 50, 100, 200, 300],
		initComplete: function(){
			$(".dataTables_wrapper .dataTables_filter input").addClass('form-control');
			$(".dataTables_wrapper .dataTables_length select").addClass('form-control');
		}
	});

	tinymce.init({
		selector: '#textarea-editor',
		language: 'pt_BR',
		plugins: [
			'advlist autolink lists link image charmap print preview hr anchor pagebreak',
			'searchreplace visualblocks visualchars code fullscreen',
			'insertdatetime media nonbreaking save table contextmenu directionality',
			'emoticons template paste textcolor colorpicker textpattern imagetools'
		],
		menubar: false,
		toolbar1: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table | code preview',
		image_advtab: true
	});

	$("body").on('click', '*[data-toggle="modal"]', function(event) {
		var link = $(this).attr('data-modal');
		var modal = $("#modal");

		modal.html('<div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-loader"><i class="fa fa-spin fa-cog"></></div></div></div>');
	
		$.ajax({
			url: link,
			type: 'GET',
		})
		.done(function(data) {
			modal.html(data);
		})
		.fail(function() {
			console.log("modal: error");
		})
		.always(function() {
			/* nothing */
		});
		
	});	

	$("body").on('click', '.copy-link', function(event) {
	    var link = $(this).attr('data-link');

	    copyTextToClipboard(link);

	    alert("Link copiado para sua área de transferência!");
	});

	function copyTextToClipboard(text) {
	  var textArea = document.createElement("textarea");

	  textArea.style.position = 'fixed';
	  textArea.style.top = 0;
	  textArea.style.left = 0;
	  textArea.style.width = '2em';
	  textArea.style.height = '2em';
	  textArea.style.padding = 0;
	  textArea.style.border = 'none';
	  textArea.style.outline = 'none';
	  textArea.style.boxShadow = 'none';
	  textArea.style.background = 'transparent';
	  textArea.value = text;

	  document.body.appendChild(textArea);
	  textArea.select();

	  try {
	    var successful = document.execCommand('copy');
	    var msg = successful ? 'successful' : 'unsuccessful';
	    console.log('Copying text command was ' + msg);
	  } catch (err) {
	    console.log('Oops, unable to copy');
	    window.prompt("Copie para área de transferência: Ctrl+C e tecle Enter", text);
	  }

	  document.body.removeChild(textArea);
	}
});



$(window).load(function() {


	setTimeout(function() {
		$(".alert").hide();
	}, 3000);
});

$(window).resize(function() {

});
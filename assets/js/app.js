var base_url="";$(function(){$('[data-toggle="tooltip"]').tooltip()});$(document).foundation();function modal(url,param_1,param_2){var box=$("#app-modal");var boxContent=box.children('div');box.show();boxContent.html('<div class="am-box am-b-small"><div class="am-b-loader"><span class="fa fa-cog fa-spin"></span></div></div>');$.post(url,{param_1:param_1,param_2:param_2},function(data,textStatus,xhr){}).done(function(data){boxContent.html(data);console.clear();}).fail(function(){box.hide();boxContent.html("");});}function appSection(){var windowHeight=parseInt($(window).height());var minHeight=windowHeight-65;var footerHeight=($("footer").height())+75;$("section.app-section").css('padding-bottom',footerHeight+'px');}function copyTextToClipboard(text){var textArea=document.createElement("textarea");textArea.style.position='fixed';textArea.style.top=0;textArea.style.left=0;textArea.style.width='2em';textArea.style.height='2em';textArea.style.padding=0;textArea.style.border='none';textArea.style.outline='none';textArea.style.boxShadow='none';textArea.style.background='transparent';textArea.value=text;document.body.appendChild(textArea);textArea.select();try{var successful=document.execCommand('copy');var msg=successful?'successful':'unsuccessful';console.log('Copying text command was '+msg);}catch(err){console.log('Oops, unable to copy');window.prompt("Copie para área de transferência: Ctrl+C e tecle Enter",text);}document.body.removeChild(textArea);}$(document).ready(function(){$(".input-phone").foneMascara();$(".input-cpf").mask("000.000.000-00");$(".input-cep").mask("00000-000");$(".input-money").mask("0.000.000.000.000,00",{reverse:true});$(".tooltip").tooltipster({side:'right'});appSection();$('.h-mobile-menu > span').sidr({side:'right',source:'header .h-main-menu',onOpen:function(){$("#black-wall").show();$("#sidr .sidr-class-modal-open").each(function(index,el){$(this).addClass('modal-open').removeClass('sidr-class-modal-open');});},onClose:function(){$("#black-wall").hide();}});$('#show-filtros').click(function(){$('#show-filtros').hide();$('#mobile-filtros').removeClass('hide-for-small-only');$('#mobile-regiao').removeClass('hide-for-small-only');});$('#show-descri-js').click(function(){$('#mobile-descri-js').removeClass('hide-for-small-only');});$('#show-detalhes-js').click(function(){$('#mobile-detalhes-js').removeClass('hide-for-small-only');});$('#show-message').click(function(){$('#show-message').hide();$('#mobile-message').removeClass('hide-for-small-only');});$("#sidr > div a").click(function(){$.sidr('close','sidr');});$("#black-wall").click(function(){$.sidr('close','sidr');$("#black-wall").hide();});$("body").on('click',".modal-open",function(event){var url=$(this).attr('data-modal');$("body").addClass('modal-open');modal(url);return false;});$("body").on('click',".modal-close",function(event){$("#app-modal").hide().children('div').html("");$("body").removeClass('modal-open');});$("body").on('click','.window-open',function(event){var link=$(this).attr('href');window.open(link,'newwindow','width=600, height=400');return false;});$("body").on('click','.copy-link',function(event){var link=$(this).attr('data-link');copyTextToClipboard(link);alert("Link copiado para sua área de transferência!");});$(".faq-accordion").on('click','.fa-i-question',function(event){var item=$(this).parent('div');var status=item.attr('data-status');if(status=="0"){item.addClass('active');item.attr('data-status','1');}else{item.removeClass('active');item.attr('data-status','0');}});$(".table-order").dataTable({"pageLength":10,"lengthMenu":[10,30,50,100],initComplete:function(){$(".dataTables_wrapper .dataTables_filter input").addClass('form-control');$(".dataTables_wrapper .dataTables_length select").addClass('form-control');}});});$(window).load(function(){appSection();setTimeout(function(){$("#alert-box").remove();},4000);});$(window).resize(function(){appSection();});function isMobile(){var userAgent=navigator.userAgent.toLowerCase();if(userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!=-1)return true;}
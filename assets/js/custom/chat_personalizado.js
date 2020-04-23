function enviou(characterCode){
    
        console.log(characterCode.keyCode);
        if(characterCode.keyCode == 13){
                    $('#chatscroll').animate({ scrollTop: $('#chatscroll')[0].scrollHeight }, 500);
        }

     
}


function enviou_botao(){
        $('#chatscroll').animate({ scrollTop: $('#chatscroll')[0].scrollHeight }, 500);
}

function clicou(){
    
        
    $('#chatscroll').animate({ scrollTop: $('#chatscroll')[0].scrollHeight }, 200);
    

     
}
<style>

@media only screen and (max-width:872px){ /*orientation:landscape é quando o celular estiver deitado*/
    


    
    .box-body.left-list{display:block;width:100%;float:left;border-radius:3px 0px 0px 3px !important;border-right:0px solid rgb(237, 234, 234);overflow:auto; max-height:200px;}
    

    .box-body{background-color:rgb(237, 234, 234);
        border-radius:0px 3px 3px 0px;
        border:1px solid rgb(237, 234, 234);
        margin-bottom:20px;
        width:100%;
        height:100%;
        display: block;
        float:left;}
        
    
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-route.js"></script>
<script src="<?=base_url('assets/js/custom/chat_personalizado.js')?>"></script>
<script src="<?=base_url('assets/js/custom/chat.js')?>"></script>



<div class="row" data-ng-app="ChatApp" ng-cloak id="pai" >
    <div class="" data-ng-controller="ChatAppCtrl">
        <div class="container">
            <div class="box" ng-init="init(<?php echo isset($ad_id) ?  $ad_id : 0; ?>)">
                <div class="box-body left-list" id="lado">
                    <div onMouseUp="clicou()" class="chat" data-ng-repeat="chat in chats" ng-class="{'active': chat.chat_id == selectedChat}">
                           <img src="<?php
                                $img = '{{chat.ads_img_file}}';
                                $related_image = thumbnail(@$img, "ads", 60, 60, 2);

                                echo $related_image;
                            ?>"/>
                           <ul  ng-class="{ unread: chat.unread }"  ng-click="selectChat(chat);" >
                            
                            <li class="ad-title" >{{ chat.ad_name }} </li>
                            <li class="ad-owner">{{ chat.ad_owner }}</li>
                            
                            <li class="last-message">{{ chat.last_message }}</li>
                        </ul>
                    </div>
                    <div class="chat" ng-show="noMessages">
                        <center>Nenhuma conversa</center>
                    </div>
                </div> 

                <div class="box-body">
                    <div class="chat-header" style="background:#399be5; color:white;">
                        <i class="fa fa-comments"></i>
                        {{ad_title}}  <!-- vem da funcao $scope.selectChat do arquivo custom/chat.js -->
                        <!-- <a  style="float:right;color:white;"><i class="fa fa-cog"></i> Mais opções </a>
                           <span style="float:right;color:white;height:20px;"> | </span> -->
                           
                           <a class="hide-for-small-only" href="<?php $id='{{adcode}}'; 
                                        echo base_url("ads/details/$id");?>" style="float:right;color:white;"><i class="fa fa-eye"></i> Ver anúncio </a>
                                     
                    </div>

                    
                    <div class="chat-messages" id="chatscroll" >
                        <div class="chat-msg" data-ng-repeat="message in messages" >
                            <div class="chat-box" ng-class="{'pull-left':!message.me, 'pull-right':message.me}">
                                <div class="chat-info"  >
    
                                    <span class="chat-author"> {{ message.author }} </span>
                                    <span class="chat-timestamp"> {{ message.date_message }}</span>
                                </div>
                                <div class="chat-text" >
                                   <br> <span > {{ message.message_text }} </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <form>
                    <div class="box-footer">
                        <div ng-submit="sendMessage();">
                            <div class="container">
                                <div class="row">
                                
                                    <div class="medium-11 columns">
                                        <input type="text" id="campo_m" onkeydown ="return enviou(event)" placeholder="Digite sua mensagem"  autofocus="autofocus" class="form-control" ng-model="messageText" ng-enter="sendMessage()">
                                        
                                    </div>
                                    <div class="medium-1 columns">
                                        <button type="submit" class="btn  btn-flat" onClick="enviou_botao()" ng-click="sendMessage();" " >Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


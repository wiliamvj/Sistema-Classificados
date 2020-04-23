/**
* Created by Wiliam on 16/09/2016.
*/




var ChatApp = angular.module('ChatApp', ['ngRoute']);

ChatApp.controller('ChatAppCtrl', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {

    

    $scope.urlListMessages = base_url+'/chat/listMessages';
    $scope.urlListChats = base_url+'/chat/listChats';
    $scope.urlListChatsByAd = base_url+'/chat/listChatsByAd';
    $scope.urlSendMessage = base_url+'/chat/sendMessage';

    $scope.noMessages = false;

    $scope.adId = 0;
    $scope.selectedChat = 0;

    $scope.messages = [];
    $scope.chats = [];
    $scope.messageText = '';



    $scope.sendMessage = function(form, callback) {
        var chat_id =  $scope.selectedChat;
        var message_text =  $scope.messageText;
        var ad_id =  $scope.adId;
        var imageFile = document.getElementById('campo_m');
        var chatscroll = document.getElementById('chatscroll');
        

        

        return $http({
            method: 'POST',
            url: $scope.urlSendMessage,

            data: {
               chat_id: chat_id,
                message_text: message_text,
                ad_id: ad_id
            }
        }).success(function(data) {
            $scope.listMessages();
            imageFile.value = ' ';
     
             
              
                
          
               //Necessario para deixar o campo em branco novamente $rootScope.$apply()

               //chatscroll.setInterval ("chatscroll.scrollBy(5,50);", 50);
            
        });
    };


   

    $scope.replaceShortcodes = function(message) {
        var msg = '';
        msg = message.toString().replace(/(\[img])(.*)(\[\/img])/, "<img src='$2' />");
        msg = msg.toString().replace(/(\[url])(.*)(\[\/url])/, "<a href='$2'>$2</a>");
        return msg;
    };

    $scope.selectChat = function(chat){
        $scope.selectedChat = chat.chat_id;
        $scope.ad_title = chat.ad_owner;
        $scope.adcode   = chat.ad_id;
        

        return $scope.getMessages();
    };



    $scope.listMessages = function() {
        $timeout($scope.listMessages, 5000);
        return $scope.getMessages();
    };

    $scope.getMessages = function(){
        if(!$scope.selectedChat){
            return;
        }
        var url = $scope.urlListMessages + "\/" + $scope.selectedChat;

        return $http.get(url)
            .success(function(data) {
               
                $scope.messages = [];
                angular.forEach(data.messages, function(message) {
                    message.message_text = $scope.replaceShortcodes(message.message_text);
                    message.me = parseInt(message.sent_by_me);

                    $scope.messages.push(message);
                });
            })
     };

    $scope.listChats = function() {
        $timeout($scope.listChats, 10000);
        return $scope.getChats();

    };

    $scope.getChats = function(){
        url = $scope.urlListChats;

        if($scope.adId){
            url = $scope.urlListChatsByAd  + "\/" + $scope.adId;
        }

        return $http.get(url, {}).success(function(data) {
            $scope.chats = [];

            if(data.chats.length == 0){
                $scope.noMessages = true;
            }else{
                $('#chatscroll').animate({ scrollTop: $('#chatscroll')[0].scrollHeight }, 500);
                $scope.noMessages = false;

                angular.forEach(data.chats, function(chat) {
                    chat_id = parseInt(chat.chat_id);

                    if($scope.selectedChat == 0 && ($scope.adId == chat.ad_id || $scope.adId == 0) ){
                        $scope.selectedChat = chat_id;
                    }

                    if($scope.selectedChat == chat_id){
                        $scope.selectChat(chat);
                        chat.active = true;
                    }

                    $scope.chats.push(chat);


                });
            }
        });

    };


    $scope.init = function(adId) {
        if(adId){
            $scope.adId = adId;

        }
        $scope.listChats();
        $scope.listMessages();

    };
    
    scrollDown = function() {
        var pidScroll;
        
        pidScroll = window.setTimeout(function() {
            $('.direct-chat-messages').scrollTop(9999);
            window.clearInterval(pidScroll);
        }, 100);
    };
    
    $scope.openModal = function() {
        $('#choose-name').modal('show');
    };


}]);


ChatApp.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});

ChatApp.directive('ngClick', function () {
    return function (scope, element, attrs) {
        element.bind("onlick", function(event){
            scope.$apply(function (){
                scope.$eval(attrs.ngClick);
            });
            event.preventDefault();
        });
    };
});
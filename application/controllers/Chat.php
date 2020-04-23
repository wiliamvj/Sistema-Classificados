<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Class Chat
 *
 *
 * @property Template $template
 * @property Chat_model $chat_model
 * @property Ads_model $ads_model
 * @property Main_model $main_model
 * @property CI_Input $input
 */
class Chat extends MY_Controller
{
    /** @var array */
    private $requestData;

    public function __construct()
    {
        parent::__construct();
        $this->requestData = json_decode(file_get_contents('php://input'), TRUE);
    }

    public function index(){
        /* View */
        
        $this->template->load('app', 'chat');
    }

 
    public function novo_chat(){

        if($this->input->post('sender_id')){

            $dados['sender_id']           = $this->input->post('sender_id');
            $dados['recipient_id']        = $this->input->post('recipient_id'); 
            $dados['ad_id']               = $this->input->post('ad_id');
            $data['ad_name']              = $this->input->post('ad_name');
            $data['recebedor_email']      = $this->input->post('use_email');
            $data['recebedor_nome']       = $this->input->post('use_name');
            
            $this->load->model('Chat_model');

            //$this->chat_model->sendEmail($recebedor_email , $dados['sender_id']);
            $this->chat_model->novo_chat($dados , $data);
            
        }

    }

    /** Load View with ad_id selected
     * @param int $ad_id
     */
    public function getChatsByAd($ad_id){
        $this->template->load('app', 'chat',array('ad_id' => $ad_id));
    }

    /** Prints JSON data of all user chats, with ad_id = $ad_id as selected chat
     * IMPORTANT: if chat for $ad_id does not exits, create and artificial record,
     *    which will be created on database on first message sent
     *
     * @param  int $ad_id
     */
    
    public function listChatsByAd($ad_id){
        $chats['chats']  = $this->chat_model->getChatByAd($ad_id);

        $this->main_model->printJson($chats);
    }

    /** Prints JSON data for all existing conversations
     */
    public function listChats(){
        $chats['chats'] = $this->chat_model->getUserChats();
        
        $this->main_model->printJson($chats);
    }

    /** Prints JSON messages of a given conversation by $chat_id, with ad_id = $ad_id as selected chat
     * @param int $chat_id
     */
    public function listMessages($chat_id){

        $chat['messages'] = $this->chat_model->getMessages($chat_id);

        $this->main_model->printJson($chat);
    }



    /**
     *  Create message from $_POST data;
     *  if $_POST['chat_id'] is 0, creates new chat record before creating message
     *
     * @return bool true if inserted message successfully
     */
    public function sendMessage(){

        $chat_id = $this->requestData['chat_id'];

        if(!$chat_id){
            $chat_id = $this->createNewChat();
            $this->requestData['chat_id'] = $chat_id;
        }

        if($chat_id){
            $insertedMessage = $this->createNewMessage();
        }

        return $insertedMessage > 0;
    }

    /**
     * Creates a new chat record from $this->requestData (array from $_POST)
     * @uses $requestData
     *
     * @return int chat_id
     * @throws Exception
     */
    private function createNewChat(){
        $adDetails = $this->ads_model->details($this->requestData['ad_id']);
        if(!$this->requestData['ad_id'] || !$adDetails){
            throw new Exception('invalid data for new chat');
        }

        
        $adOwner = $adDetails->use_id;
        $newChatData = $this->requestData;
        unset($newChatData['message_text']);

        $insertedChatID = $this->chat_model->insertChat($newChatData,$adOwner);

        return $insertedChatID;
    }

    /**
     *
     * Creates a new chat record from  $this->requestData (plus chat_id if just created)
     * @uses $requestData
     * @return int chat_message_id
     * @throws Exception
     */
    private function createNewMessage(){

        if(!$this->requestData['chat_id'] || ($this->requestData['message_text'] == '')){
            throw new Exception('invalid data for new message');
        }

        $insertedMessageID = $this->chat_model->insertMessage($this->requestData);

        return $insertedMessageID;
    }



    

}
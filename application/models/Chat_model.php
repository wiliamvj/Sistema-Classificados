<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    /** @var  int  */
    private $user_id;

    /**
     * Chat_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->user_id  = $this->session->userdata("login");
    }

    public function config($column = false) {
        $this->db->limit(1);

        if ($column) {
            $this->db->select($column);
        }

        $query = $this->db->get('config');
        $query = $query->result();

        if ($query) {
            if ($column) {
                return $query[0]->$column;
            } else {
                return $query[0];
            }
        } else {
            return false;
        }
    }

    public function getUserChats(){
        return $this->getChats();
    }

    public function getChatByAd($ad_id){
        
        $this->db->where("(
            (chat_id IS NOT NULL AND {$this->user_id} IN (sender_id,recipient_id)) 
            OR (panamerico_ads.ad_id=$ad_id)
            )");

        $this->db->select("date_format(last_message, '%d/%c/%Y %H:%i:%s') as date_message,
            COALESCE(panamerico_chat.chat_id,0) as chat_id,COALESCE(panamerico_chat.ad_id,$ad_id) as ad_id,
            COALESCE(panamerico_chat.sender_id,{$this->user_id}) as sender_id, COALESCE(panamerico_chat.recipient_id,panamerico_users.use_id) as recipient_id,
            chat.last_message, chat.date_last_message,panamerico_ads.ad_name, panamerico_users.use_name as ad_owner,
            panamerico_ads_images.ads_img_file as ads_img_file");
        
        $this->db->join('ads', 'chat.ad_id = ads.ad_id','right');
        $this->db->join('users', 'ads.use_id = users.use_id','right');

        return $this->selectDB();
    }


    public function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    } 

    public function delete_existente(){
        $this->db->delete('chat', array('chat_id' => $_SESSION['chat_existente']));
    }

    public function getChats(){
        

        if(isset($_SESSION['id_chat_ativo'])){
            
            //$this->db->where("{$this->user_id} IN (sender_id,recipient_id)");
            $this->db->where("sender_id = {$this->user_id} OR recipient_id = {$this->user_id}");
            //$this->db->where("visivel " , NULL);
            //$this->db->or_where("visivel !=" , NULL );
            
            $this->db->select('chat.*,date_format(last_message, \'%d/%c/%Y %H:%i:%s\') as date_message,ads.ad_name, users.use_name as ad_owner,
              ');  
               $this->db->select('panamerico_ads_images.ads_img_file as ads_img_file'); 
            $this->db->join('ads',   'chat.ad_id = ads.ad_id');
            $this->db->join('users', 'ads.use_id = users.use_id');
            $this->db->order_by('chat_id','DESC');
            //$this->db->order_by('date_last_message','DESC');
    
            //$this->db->group_by('chat_id','DESC');
            //$this->db->join('ads_images', 'chat.ad_id = ads_images.ad_id','left');
            //$query = $this->db->get('chat')->result('array');
            //$query = array_map("unserialize", array_unique(array_map("serialize", $this->unique_multidim_array($query , 'chat_id'))));
            //return $query;
            unset($_SESSION['id_chat_ativo']);
            return $this->selectDB();

        }else{
            
            $this->db->where("{$this->user_id} IN (sender_id,recipient_id)");
            $this->db->where("visivel !=" , NULL );
            
            $this->db->select('chat.*,date_format(last_message, \'%d/%c/%Y %H:%i:%s\') as date_message,ads.ad_name, users.use_name as ad_owner,
               panamerico_ads_images.ads_img_file as ads_img_file ');  
            $this->db->join('ads',   'chat.ad_id = ads.ad_id');
            $this->db->join('users', 'ads.use_id = users.use_id');
            //$this->db->order_by('chat_id > 0','ASC',false);
            $this->db->order_by('data_last_acesso','DESC');
    
            //$this->db->group_by('chat_id','DESC');
            //$this->db->join('ads_images', 'chat.ad_id = ads_images.ad_id','left');

            //$query = $this->db->get('chat')->result('array');
            //$query = array_map("unserialize", array_unique(array_map("serialize", $this->unique_multidim_array($query , 'chat_id'))));
            //return $query;
            
            return $this->selectDB();
        }
        
    }

    public function getChatByID($chat_id){
        
        $this->db->where('chat_id',$chat_id);
        
        $chatData = $this->selectDB();

        return $chatData[0];
    }
    /*
    public function verifica_nulos(){ //Verifica se o chat está vazio e não é um novo chat ativo
            $id_ativo = $_SESSION['id_chat_ativo'];
            $this->db->where('date_last_messsage' , NULL);
            $this->db->delete();
            //$this->db->query("DELETE  FROM chat where date_last_message = NULL  ");
            return $id_ativo;
    }
   */
    private function selectDB()

    {   

        if(isset($_SESSION['chat_existente'])){
            $valor = $_SESSION['chat_existente'];
            $this->db->order_by('data_last_acesso','DESC');
            
        }else{
            //$this->db->order_by('chat_id > 0','ASC',false);
            $this->db->order_by('date_last_message','DESC');
        }

        
        //$this->db->group_by('chat_id','DESC');
        $this->db->join('ads_images', 'chat.ad_id = ads_images.ad_id','left');

        $query = $this->db->get('chat')->result('array');
        $query = array_map("unserialize", array_unique(array_map("serialize", $this->unique_multidim_array($query , 'chat_id'))));
        return $query;

        //return $query->result('array');
    }

    public function novo_chat($dados , $data){
        
        unset($_SESSION['chat_existente']);
        if($dados['recipient_id'] == $dados['sender_id']){
            redirect('Ads');
        }

        $sender = $dados['sender_id'];
        $ad_id  = $dados['ad_id'];
        //Query para pegar todos os chats visiveis
        $query = $this->db->query("SELECT * FROM panamerico_chat where sender_id = '$sender' AND ad_id = '$ad_id' AND visivel is NOT NULL ");
        //Query para pegar todos os chats não visiveis
        
        $dad['novo'] = $query->result();
        $contar = count($dad['novo']);
        

        
        if(($contar > 0)) {
            $_SESSION['chat_existente'] = $dados['ad_id'];
            $dados['data_last_acesso']  = date("Y-m-d H:i:s");
            $this->db->where('sender_id' ,$dados['sender_id']);
            $this->db->where('ad_id' ,    $_SESSION['chat_existente']);
            $this->db->update('chat' ,     $dados);
            redirect('chat');
       
        }else{

            $_SESSION['recebedor_email'] = $data['recebedor_email'];
            $_SESSION['sender_id'] = $dados['sender_id'] ;
            $_SESSION['recebedor_nome'] = $data['recebedor_nome'] ;
            $_SESSION['ad_name'] = $data['ad_name'] ;
            $_SESSION['primeira_mensagem'] = 1;

            $this->db->insert('chat', $dados);
            $_SESSION['id_chat_ativo'] =  $this->db->insert_id(); 
            redirect('chat');
        }
        
    }


    public function sendEmail($recipient , $id_sender , $name , $ad_name){
        
        $this->db->where('use_id' , intval($id_sender));
        $dados = $this->db->get('users')->result();
        $receiver = $recipient;
        
      
       
        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = $this->emailTemplate($name , $dados[0]->use_name , $ad_name);
        
        
        $this->load->library('email');
        $admin = $this->config();
        
		$config['protocol'] = 'smtp';
        $config['smtp_host'] = $admin->cfg_smtp_host;
        $config['smtp_user'] = $admin->cfg_smtp_user;
        $config['smtp_pass'] = $admin->cfg_smtp_pass;
        $config['smtp_port'] = $admin->cfg_smtp_port;
        $config['smtp_crypto'] = 'ssl';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;
        
      
        $from   = $admin->cfg_smtp_user;
       
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
        //send email

        $this->email->from($from , 'Panamérico Classificados');
        $this->email->to($receiver);
        $this->email->subject("Oba! Tem mensagem nova para você sobre: $ad_name");
        $this->email->message($message);
        
        if($this->email->send()){
            return true;
        }else{
            return false;
        }
        
        
    }


    public function emailTemplate($name , $sender_name , $ad_name) {
        $year = date("Y");

        $body = <<<BODY
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body style="font: 12px Arial, Verdana, sans-serif; margin: 0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="354" align="center" valign="top">
            <table width="768" border="0" cellpadding="0" cellspacing="0" style="border: #d2d5da thin solid;">
              <tr>
                <td align="center" valign="top">
                    <h1>{$name} , chegou mensagem para você! </h1><br> 
                    <strong>{$sender_name}</strong> te enviou uma mensagem por causa do item "{$ad_name}".
                    <br><br><a href="#" target="_blank">
                    </a>
                </td>
              </tr>
              <tr>
                <td width="768" align="left" valign="top" style="font: 12px Verdana, Geneva, sans-serif; padding: 10px;">
               <center> <a href="https://www.panamerico.com.br/chat"><button style="background:#FF8000;color:white;width:95%;height:50px;font: 25px Arial"> Responder </button> </a></center>
                </td>
              </tr>
              <tr>
                <td bgcolor="#1E2648" height="55" align="center" valign="middle">
                  <p>
                    <span style="font: 15px Arial, Verdana, sans-serif; font-weight: bold; color: #ffffff;"><strong>contato@panamerico.com.br</strong></span><br />
                    <span style="font: 12px Arial, Verdana, sans-serif; color: #ffffff;"></span>
                  </p>
                </td>
              </tr>
            </table>
            <p style="color: #666666; font: 10px Arial, Verdana, sans-serif; margin: 5px;">
                <a href="https://www.panamerico.com.br/" title="Tookad" target="_blank" style="color: #666666; text-decoration: none;">Panamérico | {$year}</a>
            </p>
            </td>
        </tr>
    </table>
</body>
</html>
                
BODY;

        return $body;
    }

    

    public function getMessages($chat_id){

        $this->db->order_by('date_message', 'ASC');

        $this->db->where('chat_id', $chat_id);
        $this->db->where("{$this->user_id} IN (sender_id,recipient_id)");
        $this->db->select("chat_message.*,date_format(date_message, '%d/%c/%Y %H:%i:%s') as date_message,(sender_id = {$this->user_id}) as sent_by_me, users.use_name as author");
        $this->db->join('users', 'chat_message.sender_id = users.use_id');

        $query = $this->db->get('chat_message');

        return $query->result();
    }

    


    public function insertChat($newChatData,$adOwnerID)
    {
        $newChatData['sender_id'] = $this->user_id;
        $newChatData['recipient_id'] = $adOwnerID;

        $this->db->insert('chat', $newChatData);

        return $this->db->insert_id();
    }


    public function insertMessage($newMessageData)
    {   


        $chatData = $this->getChatByID($newMessageData['chat_id']);

        $recipientId = $chatData['recipient_id'];
        if($chatData['recipient_id'] == $this->user_id){
            $recipientId = $chatData['sender_id'];
        }

        $dados['visivel'] = 1;
        $dados['data_last_acesso']  = date("Y-m-d H:i:s");
        $dados['last_message'] = $newMessageData['message_text'];
        $dados['date_last_message'] = date("Y-m-d H:i:s");
        $this->db->where('chat_id' , $chatData['chat_id'] );
        $this->db->update('chat' , $dados);

        $this->db->set('chat_id',$chatData['chat_id'],false);
        $this->db->set('sender_id',$this->user_id,false);
        $this->db->set('recipient_id',$recipientId,false);
        $this->db->set('message_text',$newMessageData['message_text']);
        $this->db->set('date_message','now()',false);

        if($_SESSION['primeira_mensagem'] == 1){
            $enviar = $this->sendEmail($_SESSION['recebedor_email'] ,
            $_SESSION['sender_id'] ,
            $_SESSION['recebedor_nome'],
            $_SESSION['ad_name']);
            $_SESSION['primeira_mensagem'] = 2;
        }

        unset($_SESSION['chat_existente']);
        return $this->db->insert('chat_message');
    }
}
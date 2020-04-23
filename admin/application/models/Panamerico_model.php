<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panamerico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function excluirAds(array $status, $status_id) {
        if (count($status) > 0 and $status_id == 0) {
            $ids = explode(',', $status);
            if (count($ids)) {
                foreach ($ids as $v) {
                    $this->checaDepoimento($v);
                    $this->delete('ads', 'ad_id', $v);
                    
                }
            }
        }
    }

    public function excluirAdsEmMassa($status_id, $status_atual) {
        if ($status_id == 0 and $status_atual == 5) {
            $this->db->where('ad_status', 5);
            $this->db->select('ad_id');
            $query = $this->db->get('ads');
            $ads = $query->result();
            if (count($ads) > 0) {
                foreach ($ads as $a) {
                    $this->checaDepoimento($a->ad_id);
                    $this->delete('ads', 'ad_id', $a->ad_id);
                   
                }
            }
        }
    }

    public function checaDepoimento($ad_id) {
        if ($ad_id > 0) {
            if (strlen($this->getImgPrincipal($ad_id)) > 0) {
                $this->db->where('tes_ad_image', $this->getImgPrincipal($ad_id));
                $this->db->select('tes_ad_image');
                $query = $this->db->get("testimonials");
                $depoimentos = $query->result();
                //verifica se tem depoimentos, caso tenha não exclua img principal.
                if (count($depoimentos) > 0) {
                    foreach ($depoimentos as $d) {
                        $this->excluirImagensAds($ad_id, $d->tes_ad_image);
                    }
                } else {
                    //se nao tem depoimentos deletas das imagens, da pasta, banco etc...
                    $this->excluirImagensAds($ad_id);
                }
            }
        }
    }

    public function excluirImagensAds($ad_id, $img_principal = FALSE) {
        if (strlen($img_principal) > 0) {
            $this->db->where('ads_img_file != ', $img_principal);
        }
        $this->db->where('ad_id', $ad_id);
        $query = $this->db->get("ads_images");
        $imagens = $query->result();
        if (count($imagens) > 0) {
            foreach ($imagens as $key => $i) {
                //deleta imagem da pasta...
                unlink($imagens[$key]->ads_img_path);
                $this->db->where("ads_img_id", $imagens[$key]->ads_img_id);
                $this->db->delete("ads_images");
            }
        }
    }

    public function getImgPrincipal($ad_id) {
        $this->db->limit(1);
        $this->db->order_by('ads_img_id', 'ASC');
        $this->db->select('ads_img_file');
        $this->db->where('ad_id', $ad_id);
        $query = $this->db->get("ads_images");
        $imagens = $query->result();
        if (count($imagens) > 0) {
            return $imagens[0]->ads_img_file;
        }
    }

    public function alteraStatus(array $status, $status_id, $status_atual) {
        if (count($status) > 0) {
            $ids = explode(',', $status);
            if (count($ids)) {
                foreach ($ids as $v) {
                    $this->update('ads', 'ad_id', $v, array('ad_status' => $status_id));
                    if($status_id == 2){
                        //dispara um email quando aprovar o anuncio..
                        $this->enviarEmail($v);
                    }else if($status_id == 5){
                        //dispara um email quando exclui o anuncio..
                        $this->enviarEmail($v, 10);
                    }
                }
            }
        }
    }

    public function alteraStatusEmMassa($status_id, $status_atual) {
        if ($status_id > 0) {
            if ($status_atual > 0) {
                $this->db->where('ad_status', $status_atual);
            } elseif ($status_id == 5 and $status_atual == 0) {
                $this->db->where('ad_status != ', $status_id);
            }
            $this->db->select('ad_id');
            $query = $this->db->get('ads');
            $ads = $query->result();
            if (count($ads) > 0) {
                foreach ($ads as $a) {
                    $this->update('ads', 'ad_id', $a->ad_id, array('ad_status' => $status_id));
                    if($status_id == 2){
                        //dispara um email quando aprovar o anuncio..
                        $this->enviarEmail($a->ad_id);
                    }else if($status_id == 5){
                        //dispara um email quando exclui o anuncio..
                        $this->enviarEmail($a->ad_id, 10);
                    }
                }
            }
        }
    }

    function get_search(array $busca = array()) {
        $busca = array_filter($busca);
        if (count($busca)) {
            foreach ($busca as $key => $value) {
                $q .= $this->db->like($key, $value);
                $q .= $this->db->or_like($key, $value);
            }
        }

        return $q;
    }

    function get_where(array $where = array()) {
        
        $where = (strlen($where['ads_cat_parent']) > 0) ? $where : array_filter($where);
        if (count($where)) {
            foreach ($where as $key => $value) {
                $q .= $this->db->where($key, $value);
            }
        }

        return $q;
    }

    public function listing($table, $order_by = false, $order_how = false, $limit = false, $offset = null, array $busca = array(), array $where = array()) {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($order_by && $order_how) {
            $this->db->order_by($order_by, $order_how);
        }
        $this->get_search($busca);
        $this->get_where($where);
        $query = $this->db->get($table);
        $query = $query->result();
       
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function contall($table, array $busca = array(), array $where = array()) {
        if (count($busca) > 0) {
            $this->get_search($busca);
            $this->get_where($where);
            $query = $this->db->get($table);
            return $query->num_rows();
        }
        return $this->db->count_all($table);
    }

    public function listingByWhere($table, $where, $param) {
        $this->db->where($where, $param);
        $query = $this->db->get($table);
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function details($table, $column, $code) {
        $this->db->where($column, $code);
        $query = $this->db->get($table);
        $query = $query->result();

        if ($query) {
            return $query[0];
        }
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);

        return $this->db->insert_id();
    }

    public function update($table, $column, $code, $data) {
        $this->db->where($column, $code);
        $this->db->update($table, $data);
    }

    public function delete($table, $column, $code) {
        $this->db->where($column, $code);
        $this->db->delete($table);
    }

    public function deleteIMG($code) {
        $this->db->where("ad_id", $code);
        $query = $this->db->get("ads_images");
        $query = $query->result();
        if ($query):
            foreach ($query as $key => $value) {
                unlink($query[$key]->ads_img_path);

                $this->db->where("ads_img_id", $query[$key]->ads_img_id);
                $this->db->delete("ads_images");
            }
        endif;
    }

    public function login($user, $pass) {
        $this->db->where('adm_use_login', $user);
        $this->db->where('adm_use_pass', $pass);
        $query = $this->db->get('admin_users');
        $query = $query->result();

        if ($query) {
            return $query[0]->adm_use_id;
        } else {
            return false;
        }
    }

    public function count($table, $column, $code) {
        $this->db->where($column, $code);
        $count = $this->db->count_all_results($table);

        return $count;
    }

    public function countAdsByUser($user) {
        $this->db->where('use_id', $user);
        $count = $this->db->count_all_results("ads");

        return $count;
    }

    public function uploadImage($name, $folder, $max_size = '10000', $max_width = '10240', $max_height = '7680') {
        $config['upload_path'] = "./uploads/" . $folder . "/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = $max_size;
        $config['max_width'] = $max_width;
        $config['max_height'] = $max_height;
        $config['encrypt_name'] = true;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($name)) {
            return $this->upload->display_errors();
        } else {
            $upload = $this->upload->data();

            chmod($upload['full_path'], 0777);

            return $upload;
        }
    }

    public function adsAreaVerify($ad, $area) {
        $this->db->where('ad_id', $ad);
        $this->db->where('area_id', $area);
        $query = $this->db->get('ads_areas');
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function enviarEmail($code, $email_id = 12) {
        $item = $this->details('ads', 'ad_id', $code);
        $user = $this->details('users', 'use_id', $item->use_id);

        /* Email Variables */
        $name = $user->use_name;
        $email = $user->use_email;
        $ad_name = $item->ad_name;
        $ad_link = "https://your-site.com.br/" . str_replace(ADMIN_PATH, "", base_url('anuncio/' . $item->ad_slug));
        $datetime = date('d/m/Y H:i:s');

        /* Email Details */
        $email_details = $this->details('emails', 'email_id', $email_id);

        /* Message */
        $content = $email_details->email_content;

        if (preg_match_all('/({\$+\w+})/', $content, $matches)) {

            foreach ($matches[0] as $key => $value) {
                $variable = str_replace('{', '', $value);
                $variable = str_replace('}', '', $variable);
                $string = eval('return ' . $variable . ';');

                $content = str_replace($value, $string, $content);
            }
        }

        $email_message = $content;

        /* Subject */
        $email_subject = $email_details->email_subject;

        /* To */
        $email_to = $email;

        /* Send Email */
        $this->email($email_to, $email_subject, $email_message);
    }

    public function email($to, $subject, $message, $bcc = false) {
        $admin = $this->details('config', 'cfg_id', 1);

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $admin->cfg_smtp_host;
        $config['smtp_user'] = $admin->cfg_smtp_user;
        $config['smtp_pass'] = $admin->cfg_smtp_pass;
        $config['smtp_port'] = $admin->cfg_smtp_port;
        $config['smtp_crypto'] = 'ssl';
        $config['mailtype'] = 'html';
        $config['charset'] = 'UTF-8';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
//$this->email->set_newline("\r\n");

        $message = $this->emailTemplate($message);

        $this->email->from('contato@your-site.com.br', 'your-site classificados');
        $this->email->to($to);

        if ($bcc) {
            $this->email->bcc($bcc);
        }

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
        }
    }

    public function emailTemplate($contents) {
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
                    <a href="#" target="_blank">
                        <img src="https://your-site.com.br/assets/img/email-header.jpg" width="768" height="130" border="0">
                    </a>
                </td>
              </tr>
              <tr>
                <td width="768" align="left" valign="top" style="font: 12px Verdana, Geneva, sans-serif; padding: 10px;">
                    {$contents}
                </td>
              </tr>
              <tr>
                <td bgcolor="#1E2648" height="55" align="center" valign="middle">
                  <p>
                    <span style="font: 15px Arial, Verdana, sans-serif; font-weight: bold; color: #ffffff;"><strong>contato@your-site.com.br</strong></span><br />
                    <span style="font: 12px Arial, Verdana, sans-serif; color: #ffffff;"></span>
                  </p>
                </td>
              </tr>
            </table>
            <p style="color: #666666; font: 10px Arial, Verdana, sans-serif; margin: 5px;">
                <a href="https://your-site.com.br/" title="Tookad" target="_blank" style="color: #666666; text-decoration: none;">your-site Classificados | {$year}</a>
            </p>
            </td>
        </tr>
    </table>
</body>
</html>
                
BODY;

        return $body;
    }

}

/* End of file Panamerico_model.php */
/* Location: ./application/models/Panamerico_model.php */
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main_model extends CI_Model {

    public function __construct() {
        parent::__construct();
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

    public function cities($state) {
        $this->db->where("sta_id", $state);
        $this->db->order_by('cit_name', 'ASC');
        $query = $this->db->get('cities');
        $query = $query->result();

        return $query;
    }

    public function citiesDetails($code) {
        $this->db->where("cit_id", $code);
        $query = $this->db->get('cities');
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function states($order_by = false, $order_how = false) {
        if ($order_by) {
            $this->db->order_by($order_by, $order_how);
        } else {
            $this->db->order_by('sta_name', 'ASC');
        }

        $query = $this->db->get('states');
        $query = $query->result();

        return $query;
    }

    public function statesDetails($code) {
        $this->db->where("sta_id", $code);
        $query = $this->db->get('states');
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function regionsDetails($code) {
        $this->db->where("regiao_id", $code);
        $query = $this->db->get('regiao');
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function countTestimonials() {
        $this->db->where('tes_status', 1);
        $query = $this->db->get('testimonials');
        return $query->num_rows();
    }

    public function testimonials($limit = false, $offset = null) {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('tes_id', 'DESC');
        $this->db->where('tes_status', 1);
        $query = $this->db->get('testimonials');
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function contall($table) {
        return $this->db->count_all('testimonials');
    }

    public function testimonyInsert($data) {
        $this->db->insert('testimonials', $data);
    }

    public function pages() {
        $this->db->order_by('page_id', 'ASC');
        $this->db->where('page_status', 1);
        $query = $this->db->get('pages');
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function pagesDetails($code) {
        $this->db->where('page_id', $code);
        $query = $this->db->get('pages');
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            redirect('/');
        }
    }

    public function pageBySlug($slug) {
        $this->db->limit(1);
        $this->db->where("page_slug", $slug);
        $query = $this->db->get("pages");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function pagesFaq($code) {
        $this->db->where('page_id', $code);
        $query = $this->db->get('pages_faq');
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function uploadImage($name, $folder, $max_size = '10000', $max_width = '10240', $max_height = '7680') {
        $config['upload_path'] = "./admin/uploads/" . $folder . "/";
        $config['allowed_types'] = 'jpg|png';
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

    public function uploadImages($name, $folder, $max_size = '10000', $max_width = '10240', $max_height = '7680') {
        $images = $this->input->post($name . "[]");
        $count = count($_FILES[$name]['size']);

        foreach ($_FILES as $key => $value) {

            for ($s = 0; $s <= $count - 1; $s++) {
                $_FILES['userfile']['name'] = $value['name'][$s];
                $_FILES['userfile']['type'] = $value['type'][$s];
                $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
                $_FILES['userfile']['error'] = $value['error'][$s];
                $_FILES['userfile']['size'] = $value['size'][$s];

                $config['upload_path'] = "./admin/uploads/" . $folder . "/";
                $config['allowed_types'] = 'jpg|png';
                $config['max_size'] = $max_size;
                $config['max_width'] = $max_width;
                $config['max_height'] = $max_height;
                $config['encrypt_name'] = true;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {

                    echo $_FILES['userfile']['name'];

                    echo $this->upload->display_errors();
                } else {
                    $upload = $this->upload->data();

                    chmod($upload['full_path'], 0777);

                    $data[$upload['file_name']]['path'] = $upload['full_path'];
                    $data[$upload['file_name']]['file'] = $upload['file_name'];
                }
            }
        }

        if (@$data) {
            return $data;
        } else {
            return false;
        }
    }

    public function returnDetails($name) {
        $this->db->limit(1);
        $this->db->where("ret_name", $name);
        $query = $this->db->get('returns');
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function email($to, $subject, $message, $bcc = false, $from_email = "contato@your-site.com.br", $from_name = "your-site Classificados") {
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


        $this->email->initialize($config);
        //$this->email->set_newline("\r\n");
        //$message = mb_convert_encoding($message, "UTF-8");

        $message = $this->emailTemplate($message);

        // $from_name = utf8_encode($from_name);
        // $subject   = utf8_encode($subject);

        $this->email->from($from_email, $from_name);
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

    public function emailsDetails($code) {
        $this->db->where('email_id', $code);
        $query = $this->db->get("emails");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function customFields($category) {
        $this->db->where('ads_cat_id', $category);
        $this->db->where('cat_fie_status', 1);
        $query = $this->db->get("categories_fields");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function customSelectOptions($code) {
        $this->db->where('cat_fie_id', $code);
        $query = $this->db->get("fields_select_options");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function customCheckboxOptions($code) {
        $this->db->where('cat_fie_id', $code);
        $query = $this->db->get("fields_checkbox_options");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function advertisingBox($position, $width = FALSE, $height = FALSE) {
        $this->db->limit(1);
        $this->db->order_by('adv_id', 'RANDOM');
        $this->db->where('adv_position', $position);
        $this->db->where('adv_status', 1);

        $query = $this->db->get("advertising");
        $query = $query->result();
        
        if ($query) {
            $item = $query[0];
            $largura = ($width !== FALSE) ? 'width: '.$width.';':'';
            $altura = ($height !== FALSE) ? 'height: '.$height.';':'';
            $box = '';
            $box .= '<div data-id="' . $item->adv_id . '"  class="advertising-box ab-' . $position . '">';
            $box .= $item->adv_content;
            $box .= '</div>';

            return $box;
        } else {
            return false;
        }
    }

    /** Prints JSON formated $array and ends execution */
    public function printJson($array) {
        header('Content-Type: application/json');
        echo json_encode($array);
        die;
    }

}

/* End of file Main_model.php */
/* Location: ./application/models/Main_model.php */
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('paginacao')) {

    function paginacao() {
        $ci = & get_instance();
        $ci->load->library('paginacao');
        return $ci->paginacao;
    }

}



<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// --------------------------------------------------------------------

if (!function_exists('no_results')) {

    function no_results() {
        return '<tr class="no-results"><td colspan="100%">Nenhum registro encontrado</td></tr>';
    }

}

// --------------------------------------------------------------------

if (!function_exists('status')) {

    function status($code) {
        if ($code == 1) {
            return '<span class="label label-success">Ativado</span>';
        } elseif ($code == 2) {
            return '<span class="label label-warning">Em Análise</span>';
        } else {
            return '<span class="label label-danger">Desativado</span>';
        }
    }

}

// --------------------------------------------------------------------

if (!function_exists('message_status')) {

    function message_status($code) {
        if ($code == 1) {
            return '<span class="label label-success">Não Lida</span>';
        } else {
            return '<span class="label label-default">Lida</span>';
        }
    }

}

// --------------------------------------------------------------------

if (!function_exists('ads_status')) {

    function ads_status($code) {
        if ($code == 1) {
            return '<span class="label label-warning">Aprovação Pendente</span>';
        } elseif ($code == 2) {
            return '<span class="label label-success">Ativo</span>';
        } elseif ($code == 3) {
            return '<span class="label label-info">Pausado</span>';
        } elseif ($code == 4) {
            return '<span class="label label-primary">Vendido</span>';
        } elseif ($code == 5) {
            return '<span class="label label-danger">Excluído</span>';
        }else{
            return '<span class="label label-danger">(Aprovação Pendente, Ativo, Pausado, Vendido)</span>';
        }
    }

}

// ------------------------------------------------------------------------

if (!function_exists('resume')) {

    function resume($string, $max) {
        $return = strip_tags($string);

        $size = strlen($return);
        if ($size > $max) {
            $return = substr($return, 0, strrpos(substr($return, 0, $max), ' ')) . '...';
        }

        return $return;
    }

}

// --------------------------------------------------------------------

if (!function_exists('string_money')) {

    function string_money($num, $prefix = "R$ ") {

        $r = (($prefix) ? $prefix : '') . number_format($num, 2, ',', '.');

        return $r;
    }

}

// --------------------------------------------------------------------

if (!function_exists('db_money')) {

    function db_money($num) {
        $a = str_replace(".", "", $num);
        $b = str_replace(",", ".", $a);

        return $b;
    }

}

// --------------------------------------------------------------------

if (!function_exists('string_date')) {

    function string_date($db_date, $dot = false) {
        if ($dot) {
            $format = "d.m.Y";
        } else {
            $format = "d/m/Y";
        }

        $r = date($format, strtotime($db_date));
        return $r;
    }

}

// --------------------------------------------------------------------

if (!function_exists('string_date_time')) {

    function string_date_time($db_date_time) {
        $r = date("d/m/Y H:i:s", strtotime($db_date_time));
        return $r;
    }

}

// --------------------------------------------------------------------

if (!function_exists('string_time_interval')) {

    function string_time_interval($db_time_initial, $db_time_end) {
        $initial_time = str_replace(":00:00", "", $db_time_initial);
        $final_time = str_replace(":00:00", "", $db_time_end);

        $r = $db_time_initial . " - " . $db_time_end;
        return $r;
    }

}

// --------------------------------------------------------------------

if (!function_exists('thumbnail')) {

    function thumbnail($img, $folder, $width, $height, $zc = false) {

        if ($img) {
            $path = base_url('uploads/' . $folder . '/' . $img);
        } else {
            $path = base_url('assets/img/no-image.png');
        }

        $r = base_url('assets/php/image.php') . "?src=" . $path . "&w=" . $width . "&h=" . $height;

        if ($zc) {
            $r .= "&zc=" . $zc;
        }

        return $r;
    }

}
<?php

// ------------------------------------------------------------------------

if (!function_exists('label_ads_status')) {

    /**
     * Label Ads Status
     */
    function label_ads_status($status) {
        if ($status == 0) {
            $type = 'default';
            $string = 'Desativado <i class="fa fa-ban" aria-hidden="true"></i>';
        }

        if ($status == 1) {
            $type = 'warning';
            $string = 'Aprovação Pendente <i class="fa fa-hourglass-half" aria-hidden="true"></i>';
        }

        if ($status == 2) {
            $type = 'success';
            $string = 'Ativo <i class="fa fa-check" aria-hidden="true"></i>';
        }

        if ($status == 3) {
            $type = 'info';
            $string = 'Pausado <i class="fa fa-pause" aria-hidden="true"></i>';
        }

        if ($status == 4) {
            //$type = 'primary';
            //$string = 'Vendido <i class="fa fa-check" aria-hidden="true"></i>';
        }
        if ($status != 4) {
            $r = '<span class="' . $type . ' label">' . $string . '</span>';
        }

        return $r;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('ads_price_range')) {

    /**
     * Ads Price Range
     */
    function ads_price_range($price) {
        if ($price < 1) {
            $range = "0";
        }

        if ($price >= 1 && $price <= 50) {
            $range = "1_50";
        }

        if ($price >= 51 && $price <= 150) {
            $range = "51_150";
        }

        if ($price >= 151 && $price <= 300) {
            $range = "151_300";
        }

        if ($price >= 301 && $price <= 800) {
            $range = "301_800";
        }

        if ($price >= 801) {
            $range = "801";
        }

        return $range;
    }

}
<?php

function getDescAds($ad, $ads_cat_id = FALSE){
    if($ads_cat_id == 114){
        $desc = 'Doação';
    }elseif($ad->ad_service){
        $desc = 'Serviço';
    }else if($ad->adote){
        $desc = 'Me adote?';
    }else{
        $desc = string_money($ad->ad_price);
    }
    
    return $desc;
    
}

// ------------------------------------------------------------------------
if (!function_exists('isMobile')) {

    function isMobile() {
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $ipad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'], "webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $symbian = strpos($_SERVER['HTTP_USER_AGENT'], "Symbian");
        if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian === TRUE) {
            return TRUE;
        }

        return FALSE;
    }

}

if (!function_exists('selected')) {

    function selected($db, $atual) {
        if ($db == $atual) {
            return 'selected="selected"';
        }
    }

}
if (!function_exists('disabilita')) {

    function disabilita($get) {
        if (!isset($_GET[$get])) {
            return 'disabled="disabled"';
        }
    }

}
if (!function_exists('string_date_time')) {

    /**
     * String Date
     *
     * Turning the date that comes from the database in a readable string.
     *
     */
    function string_date($db_date) {
        $r = date("d/m/y", strtotime($db_date));
        return $r;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('string_date_time')) {

    /**
     * String Date Time
     *
     * Turning the date and time that comes from the database in a readable string.
     *
     */
    function string_date_time($db_date_time) {
        $r = date("d/m/Y \à\s H:i", strtotime($db_date_time));
        return $r;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('string_money')) {

    /**
     * String Date Time
     *
     * Turning the date and time that comes from the database in a readable string.
     *
     */
    function string_money($num) {
        $r = "R$ " . number_format($num, 2, ',', '.');
        return $r;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('db_money')) {

    /**
     * DB Money
     *
     * Transforms the amount of money that comes from the form to the database.
     *
     */
    function db_money($num) {
        $r = str_replace(',', '.', str_replace('.', '', $num));
        return $r;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('validate_name')) {

    /**
     * Validade Name
     *
     * Checks the integrity of the entered string and leaves the major elements with the first letter capitalized and the rest lowercase.
     *
     */
    function validate_name($name) {
        $nnDot = '\.';
        $nnDotSpace = '. ';
        $nnSpace = ' ';
        $nnRegexMultipleSpaces = '\s+';
        $nnRegexRomanNumber = '^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$';

        $name = mb_ereg_replace($nnDot, $nnDotSpace, $name);
        $name = mb_ereg_replace($nnRegexMultipleSpaces, $nnSpace, $name);
        $name = mb_convert_case($name, MB_CASE_TITLE, mb_detect_encoding($name));
        $nameParts = mb_split($nnSpace, $name);
        $exceptions = array(
            'de', 'di', 'do', 'da', 'dos', 'das', 'dello', 'della',
            'dalla', 'dal', 'del', 'e', 'em', 'na', 'no', 'nas', 'nos', 'van', 'von',
            'y'
        );
        for ($i = 0; $i < count($nameParts); ++$i) {

            foreach ($exceptions as $exception)
                if (mb_strtolower($nameParts[$i]) == mb_strtolower($exception))
                    $nameParts[$i] = $exception;
            if (mb_ereg_match($nnRegexRomanNumber, mb_strtoupper($nameParts[$i])))
                $nameParts[$i] = mb_strtoupper($nameParts[$i]);
        }

        return implode($nnSpace, $nameParts);
    }

}

// ------------------------------------------------------------------------

if (!function_exists('first_name')) {

    /**
     * First Name
     *
     * Take only the first element of a string.
     *
     */
    function first_name($string) {
        $divided_name = explode(" ", $string);
        $f = $divided_name[0];

        return $f;
    }

}


if (!function_exists('resumeCidade')) {

    /**
     * Resume Text
     *
     * Resume a text last size by an integer.
     * Putting 3 points at the end, should spend the maximum size
     *
     */
    function resumeCidade($string, $max) {
        $return = strip_tags($string);

        $size = strlen($return);
        if ($size > $max) {
            return substr($return, 0, strrpos(substr($return, 0, $max), ' ')) . '...';
        }

        return $return.' - ';
    }

}
// ------------------------------------------------------------------------

if (!function_exists('resume')) {

    /**
     * Resume Text
     *
     * Resume a text last size by an integer.
     * Putting 3 points at the end, should spend the maximum size
     *
     */
    function resume($string, $max) {
        $return = strip_tags($string);

        $size = strlen($return);
        if ($size > $max) {
            $return = substr($return, 0, strrpos(substr($return, 0, $max), ' ')) . '...';
             $str = explode(' ', $string);
             if(count($str) == 1 and strlen($str[0]) >= 40){
                 $return = substr($string, 0, 40).'...';
             }
        }

        return $return;
    }

}

// ------------------------------------------------------------------------

if (!function_exists('thumbnail')) {

    /**
     * Thumbnail
     *
     * Cuts and repositions an image in size and so set up.
     *
     */
    function thumbnail($img, $folder, $width, $height, $zc = false) {

        if ($img) {
            $path = UPLOADS . '/' . $folder . '/' . $img;
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

// ------------------------------------------------------------------------

if (!function_exists('strip_accents')) {

    /**
     * Strip Accents
     *
     *
     *
     */
    function strip_accents($string) {
        $res = strtr($string, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

        return strtolower($res);
    }

}
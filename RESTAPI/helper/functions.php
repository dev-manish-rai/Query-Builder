<?php

//get Base url
if (!function_exists('getBaseURL')) {
    function getBaseURL($url = '')
    {
        if ($url == '') {
            return BASE_URL;
        } else {
            return BASE_URL . $url;
        }
    }
}
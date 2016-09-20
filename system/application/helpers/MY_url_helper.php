<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('admin_url'))
{
    function admin_url($uri='')
    {
        return site_url(SITE_AREA . '/' . $uri);
    }
}
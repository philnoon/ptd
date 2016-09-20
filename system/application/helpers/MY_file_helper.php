<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('rename_upload_file') )
{
    function rename_upload_file($file_name){
        return md5(time().rand(0,100000)).'.'.pathinfo($file_name, PATHINFO_EXTENSION);
    }
}

if ( !function_exists('create_dir_upload') )
{
    function create_dir_upload($parent_link)
    {
        $date_string = date("Y-n-j");
        $year_string = date("Y");
        $dir = $parent_link.date("W", strtotime($date_string)) . '_' . $year_string;
        if (!is_dir($dir)) 
        { 
            mkdir($dir, 0777);
        }
        return $dir;
    }
}


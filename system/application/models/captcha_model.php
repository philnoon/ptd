<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends BF_Model
{
    protected $table        = 'captcha';
    protected $key          = 'captcha_id';
    protected $date_format  = 'datetime';
    protected $set_created  = FALSE;
    protected $set_modified = FALSE;

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
        
        //$this->set_alias();
    }
}//end Settings_model

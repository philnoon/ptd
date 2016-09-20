<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Area_model extends BF_Model
{
    protected $table        = 'areas';
    protected $key          = 'area_id';
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

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request_model extends BF_Model
{
    protected $table        = 'requests';
    protected $key          = 'req_id';
    protected $date_format  = 'datetime';
    protected $set_created  = TRUE;
    protected $set_modified = TRUE;
    protected $created_field   = 'req_created_at';
    protected $modified_field  = 'req_updated_at';

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
}//end Settings_model

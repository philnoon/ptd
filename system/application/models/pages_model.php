<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends BF_Model
{
    protected $table        = 'pages';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = FALSE;
    protected $set_modified = TRUE;
    protected $created_field   = 'created_at';
    protected $modified_field  = 'updated_at';

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
}//end Settings_model
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mediauploads_model extends BF_Model
{
    protected $table        = 'media_uploads';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = TRUE;
    protected $set_modified = FALSE;
    protected $created_field   = 'created_at';
    protected $modified_field  = 'updated_at';

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
}//end Settings_model
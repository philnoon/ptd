<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request_quote_model extends BF_Model
{
    protected $table        = 'request_quotes';
    protected $key          = 'quote_id';
    protected $date_format  = 'datetime';
    protected $created_field= 'quote_created_at';
    protected $modified_field = 'quote_updated_at';

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
}//end Settings_model

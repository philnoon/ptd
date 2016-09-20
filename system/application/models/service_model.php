<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends BF_Model
{
	protected $table		= 'services';
	protected $key			= 'service_id';
	protected $date_format  = 'datetime';
    protected $set_created  = FALSE;
    protected $set_modified = FALSE;

	//--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
}//end Settings_model

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trainer_model extends BF_Model
{
    protected $table        = 'users';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = FALSE;
    protected $set_modified = FALSE;

    //--------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_services($trainer_id)
    {
        $result = $this->db       
            ->where('trainer_id', $trainer_id)
            ->get('trainer_service')
            ->result_array();  
        
        return array_column($result, 'service_id');
    }
    
    public function get_areas($trainer_id)
    {
        $result = $this->db
            ->where('trainer_id', $trainer_id)
            ->get('trainer_area')
            ->result_array();
        
        return array_column($result, 'area_id');
    }
    
    public function update($trainer_id, $services, $areas)
    {
        //delete current srevices from trainer_service and areas from trainer_area
        $where['trainer_id'] = $trainer_id;
        $this->db->delete('trainer_service', $where);
        $this->db->delete('trainer_area', $where);
        
        //insert new sercvices
        $data = array();
        foreach($services as $s)
        {
            $item = array();
            $item['trainer_id'] = $trainer_id;
            $item['service_id'] = $s;
            
            $data[] = $item;
        }        
        $this->db->insert_batch('trainer_service', $data);
        
        //insert new areas
        $data = array();
        foreach($areas as $a)
        {
            $item = array();
            $item['trainer_id'] = $trainer_id;
            $item['area_id'] = $a;
            
            $data[] = $item;
        }        
        $this->db->insert_batch('trainer_area', $data);
        
        return TRUE;
    }
}//end Settings_model

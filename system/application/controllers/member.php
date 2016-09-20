<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Authenticated_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if($this->current_user->user_type != USER_MEMBER)
        {
            redirect('/');
        }
        
        $this->load->model('request_model');
        $this->load->model('request_quote_model');
        $this->load->model('area_model');
    }
    
    //--------------------------------------------------------------------
	public function index()
	{
        $this->requests();    
	}//end index()

    //--------------------------------------------------------------------
    public function requests($offset = 0)
    {
        $this->load->model('request_model');
        $this->request_model->set_alias();            
            
        //get my requests 
        $totals = $this->request_model
            ->where('member_id', $this->current_user->id)
            ->count_all();
                    
        $requests = $this->request_model
            ->join('services t3', 't3.service_id=t1.req_service_id', 'left')
            ->where('member_id', $this->current_user->id)
            ->limit($this->limit, $offset)
            ->order_by('req_created_at', 'desc')
            ->find_all();
        
        Template::set('requests', $requests);        
        $this->setup_pagination('member/requests', $totals);
        
        $this->render();
        
    }
    
    //--------------------------------------------------------------------
    public function request($code)
    {
        //get quote row
        $this->request_model->set_alias();
        $where = array('md5(t1.req_id)' => $code);                      
        $request = $this->request_model
            ->join('services t2', 't2.service_id=t1.req_service_id', 'left')
            ->find_by($where);  
        if(empty($request))
        {
            //Template::set_message('This link is not for you.', 'danger');
            redirect('member/requests');
        }
        Template::set('request', $request);
        
        echo '';
        
        //get area
        $area = $this->area_model->find_by('area_code', $request->req_area_code);
        Template::set('area', $area);
        
        //get quotes for this request
        $this->request_quote_model->set_alias();
        $quotes = $this->request_quote_model
            ->join('users t2', 't2.id=t1.trainer_id', 'left')
            ->where('MD5(req_id)', $code)
            ->order_by('quote_created_at', 'desc')
            ->find_all();
        Template::set('quotes', $quotes);
        
        $this->render();
    }
    
    //--------------------------------------------------------------------
    public function review($code)
    {
        //get quote row
        $this->load->model('request_model');
        $this->request_model->set_alias();
        
        $where = array('md5(t1.req_id)' => $code);                      
        $request = $this->request_model->join('services t2', 't2.service_id=t1.req_service_id', 'left')->find_by($where);  
        if(empty($request))
        {
            redirect('member/requests');
        }
        Template::set('request', $request);                            
        $this->render();        
                    
        //form fields array
        //save to requets
        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('req_rating_time', 'req_rating_time', 'required|trim|numeric|greater_than[0]');
            $this->form_validation->set_rules('req_rating_professional', 'req_rating_professional', 'required|trim|numeric|greater_than[0]');
            $this->form_validation->set_rules('req_rating_consult', 'req_rating_consult', 'required|trim|numeric|greater_than[0]');
            $this->form_validation->set_rules('req_rating_all', 'req_rating_all', 'required|trim|numeric|greater_than[0]');
            
            if ($this->form_validation->run($this) !== FALSE)
            {
                $data = array(
                    'req_id'        => $request->req_id,
                    'req_rating_time'    => $this->input->post('req_rating_time'),
                    'req_rating_professional'   => $this->input->post('req_rating_professional'),
                    'req_rating_consult' => $this->input->post('req_rating_consult'),
                    'req_rating_all' => $this->input->post('req_rating_all'),
                );                
                $this->request_model->update($request->req_id, $data);
                                
                //update the trainer rating
                //get number of req_trainer_id_accepted
                $sessionno = $this->request_model->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)->count_all();
                
                /*
                $rating_time_total = $this->request_model->where('req_trainer_id_accepted', $request->req_rating_time)->count_all();
                $rating_prof_total = $this->request_model->where('req_trainer_id_accepted', $request->req_rating_professional)->count_all();
                $rating_consult_total = $this->request_model->where('req_trainer_id_accepted', $request->req_rating_consult)->count_all();
                $rating_all_total = $this->request_model->where('req_trainer_id_accepted', $request->req_rating_all)->count_all();
                
                echo $sessionno;
                
                echo $rating_time_total;
                echo $rating_prof_total;
                echo $rating_consult_total;
                echo $rating_all_total;
                */
                
                //update the trainer rating
                    //get number of req_trainer_id_accepted
                    $sessionno = $this->request_model->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)->count_all();
                    
                    $rating_all_total = $this->request_model
                   	->select('req_rating_all')
                   	->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)
                   	->find_all();              
                   
                    // this is for the rating all
                    $array_tot1 = array();       
                    $obj = $rating_all_total[0]->{'req_rating_all'};
                    $objToArray1 = array($obj); 
                    $objToVal1 = $objToArray1[0];       
                    //print_r($objToVal1);       
                    //$array_tot.push($objToArray1);       
                    array_push($array_tot1, $objToVal1);
                    
                    /*
                    $obj = $rating_all_total[1]->{'req_rating_all'};
                    $objToArray2 = array($obj); 
                    $objToVal2 = $objToArray2[0];
                    //print_r($objToVal2);
                    //$array_tot.push($objToArray2);
                    array_push($array_tot1, $objToVal2);
                    
                    
                    $obj = $rating_all_total[2]->{'req_rating_all'};
                    $objToArray3 = array($obj); 
                    $objToVal3 = $objToArray3[0];
                    //print_r($objToVal3);
                    //$array_tot.push($objToArray3);
                    array_push($array_tot1, $objToVal3);
                    
                    
                    $obj = $rating_all_total[3]->{'req_rating_all'};
                    $objToArray4 = array($obj);
                    $objToVal4 = $objToArray4[0]; 
                	//print_r($objToVal4);
                	//$array_tot.push($objToArray4);
                	array_push($array_tot1, $objToVal4);	   
                	   
                	//print_r(sizeof($array_tot));
                	//var_dump($array_tot);
                		
                	$rating_all_tot = array_sum($array_tot1);
                	//echo 'rating_all_tot: '.$rating_all_tot;
                	//echo '<br />';
                	*/
                	$rating_all_tot = array_sum($array_tot1);
                	/*
                	--
                	*/
                	
                	$rating_consult_total = $this->request_model
                	->select('req_rating_consult')
                	->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)
                	->find_all();
                	
                	// this is for the rating all
                	$array_tot2 = array();       
                	$obj = $rating_consult_total[0]->{'req_rating_consult'};
                	$objToArray1a = array($obj); 
                	$objToVal1a = $objToArray1a[0];       
                	//print_r($objToVal1);       
                	//$array_tot.push($objToArray1);       
                	array_push($array_tot2, $objToVal1a);
                	
                	/*
                	$obj = $rating_consult_total[1]->{'req_rating_consult'};
                	$objToArray2a = array($obj); 
                	$objToVal2a = $objToArray2a[0];
                	//print_r($objToVal2);
                	//$array_tot.push($objToArray2);
                	array_push($array_tot2, $objToVal2a);
                	
                	
                	$obj = $rating_consult_total[2]->{'req_rating_consult'};
                	$objToArray3a = array($obj); 
                	$objToVal3a = $objToArray3a[0];
                	//print_r($objToVal3);
                	//$array_tot.push($objToArray3);
                	array_push($array_tot2, $objToVal3a);
                	
                	
                	$obj = $rating_consult_total[3]->{'req_rating_consult'};
                	$objToArray4a = array($obj);
                	$objToVal4a = $objToArray4a[0]; 
                	//print_r($objToVal4);
                	//$array_tot.push($objToArray4);
                	array_push($array_tot2, $objToVal4a);	   
                	   
                	//print_r(sizeof($array_tot));
                	//var_dump($array_tot);
                		
                	$rating_consult_tot = array_sum($array_tot2);
                	//echo 'rating_consult_tot: '.$rating_consult_tot;
                	//echo '<br />';
                	*/
                	$rating_consult_tot = array_sum($array_tot2);
                	/*
                	--
                	*/
                	
                		
                	$rating_prof_total = $this->request_model
                	->select('req_rating_professional')
                	->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)
                	->find_all();
                	
                	//var_dump($rating_prof_total);			
                	// this is for the rating all
                	$array_tot3 = array();       
                	$obj = $rating_prof_total[0]->{'req_rating_professional'};
                	$objToArray1b = array($obj); 
                	$objToVal1b = $objToArray1a[0];       
                	//print_r($objToVal1);       
                	//$array_tot.push($objToArray1);       
                	array_push($array_tot3, $objToVal1b);
                	
                	/*
                	$obj = $rating_prof_total[1]->{'req_rating_professional'};
                	$objToArray2b = array($obj); 
                	$objToVal2b = $objToArray2b[0];
                	//print_r($objToVal2);
                	//$array_tot.push($objToArray2);
                	array_push($array_tot3, $objToVal2b);
                	
                	
                	$obj = $rating_prof_total[2]->{'req_rating_professional'};
                	$objToArray3b = array($obj); 
                	$objToVal3b = $objToArray3b[0];
                	//print_r($objToVal3);
                	//$array_tot.push($objToArray3);
                	array_push($array_tot3, $objToVal3b);
                	
                	
                	$obj = $rating_prof_total[3]->{'req_rating_professional'};
                	$objToArray4b = array($obj);
                	$objToVal4b = $objToArray4b[0]; 
                	//print_r($objToVal4);
                	//$array_tot.push($objToArray4);
                	array_push($array_tot3, $objToVal4b);	   
                	   
                	//print_r(sizeof($array_tot));
                	//var_dump($array_tot);
                		
                	$rating_prof_tot = array_sum($array_tot3);
                	//echo 'rating_prof_total: '.$rating_prof_tot;
                	//echo '<br />';
                	*/
                	$rating_prof_tot = array_sum($array_tot3);
                	/*
                	--
                	*/
                	
                	       	
                	$rating_time_total = $this->request_model
                	->select('req_rating_time')
                	->where('req_trainer_id_accepted', $request->req_trainer_id_accepted)
                	->find_all();
                	
                	//var_dump($rating_time_total);			
                	// this is for the rating all
                	$array_tot4 = array();       
                	$obj = $rating_time_total[0]->{'req_rating_time'};
                	$objToArray1c = array($obj); 
                	$objToVal1c = $objToArray1c[0];       
                	//print_r($objToVal1);       
                	//$array_tot.push($objToArray1);       
                	array_push($array_tot4, $objToVal1c);
                	
                	/*
                	$obj = $rating_time_total[1]->{'req_rating_time'};
                	$objToArray2c = array($obj); 
                	$objToVal2c = $objToArray2c[0];
                	//print_r($objToVal2);
                	//$array_tot.push($objToArray2);
                	array_push($array_tot4, $objToVal2c);
                	
                	
                	$obj = $rating_time_total[2]->{'req_rating_time'};
                	$objToArray3c = array($obj); 
                	$objToVal3c = $objToArray3c[0];
                	//print_r($objToVal3);
                	//$array_tot.push($objToArray3);
                	array_push($array_tot4, $objToVal3b);
                	
                	
                	$obj = $rating_time_total[3]->{'req_rating_time'};
                	$objToArray4c = array($obj);
                	$objToVal4c = $objToArray4c[0]; 
                	//print_r($objToVal4);
                	//$array_tot.push($objToArray4);
                	array_push($array_tot4, $objToVal4c);	   
                	   
                	//print_r(sizeof($array_tot));
                	//var_dump($array_tot);
                		
                	$rating_time_tot = array_sum($array_tot4);
                	//echo 'rating_time_tot: '.$rating_time_tot;
                	//echo '<br />';
                	*/
                $rating_time_tot = array_sum($array_tot4);
                
                
                $rating_time_update  = $rating_time_tot/$sessionno;
                $rating_prof_update  = $rating_prof_tot/$sessionno;
                $rating_consult_update  = $rating_consult_tot/$sessionno;
                $rating_all_update  = $rating_all_tot/$sessionno;  
                
                /*
                echo 'rating_time_update '.$rating_time_update;     
                echo 'rating_prof_update '.$rating_prof_update; 
                echo 'rating_consult_update '.$rating_consult_update;
                echo 'rating_all_update '.$rating_all_update;
                */
                
                $ratingdata = array(
                    'rating_time'    => $rating_time_update,
                    'rating_prof'   => $rating_prof_update,
                    'rating_consult' => $rating_consult_update,
                    'rating_all' => $rating_all_update,
                );                
                $this->user_model->update($request->req_trainer_id_accepted, $ratingdata);                
                redirect('member/requests');                
            }
        
        }
        
    }
   
    
    //--------------------------------------------------------------------
    public function quote($code)
    {        
        //get quote row
        $this->request_quote_model->set_alias();
        $where = array(
            'md5(t1.quote_id)'  => $code,
            't2.member_id'      => $this->current_user->id,
        );                      
        $record = $this->request_quote_model
            ->join('requests t2', 't2.req_id=t1.req_id', 'left')
            ->join('services t3', 't3.service_id=t2.req_service_id', 'left')
            ->join('users t4', 't4.id=t1.trainer_id', 'left')
            ->find_by($where);  
        if(empty($record))
        {
            //Template::set_message('This link is not for you.', 'danger');
            redirect('member/requests');
        }
        
        $hidebtn='N';
        if($record->req_status == 2){        
        Template::set_message('A quote for this request has already been accepted by you.', 'warning');        
        //$hidebtn='hide';
        }        
        Template::set('hidebtn', $hidebtn);        
        //$record->quote_status != QUOTE_ACCEPTED && $record->req_status == 1
                
        //Template::set('request', $request);
        Template::set('record', $record);        
        
        
        //get area
        $area = $this->area_model->find_by('area_code', $record->req_area_code);
        Template::set('area', $area);        
        Template::set('quote_code', $code);
        $this->render();        
        
    }
}//end class

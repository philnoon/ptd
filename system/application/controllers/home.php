<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Front_Controller
{
    public function __construct()
        {
            parent::__construct();
            
            $this->load->library('emailer');
            
            $this->load->model('request_model');
            
            if (!class_exists('User_model'))
    		{
    			$this->load->model('user_model');
    		}
    
            if (!class_exists('Pages_model'))
            {
            	$this->load->model('pages_model');
            }
            
        }
	/**
	 * Displays the homepage
	 *
	 * @return void
	 */
	public function index()
		{
	        Assets::add_css('plugins/growl/jquery.growl.css');
	        Assets::add_js('plugins/growl/jquery.growl.js');
	        Assets::add_js('plugins/jquery.blockUI.js');
	        Assets::add_js('request.js');
	        
	        $startDate = date('Y-m-d', strtotime('+2 days'));
	        Assets::add_js("$('#training_date').datepicker({autoclose:true, startDate:'{$startDate}',});", 'inline');
	        
		//Template::render();			
			$pagecontents1 = $this->pages_model->find_all_by('id',7);
			Template::set('pagecontents1', $pagecontents1);
			
			$pagecontents2 = $this->pages_model->find_all_by('id',8);
			Template::set('pagecontents2', $pagecontents2); 
			
			$pagecontents3 = $this->pages_model->find_all_by('id',9);
			Template::set('pagecontents3', $pagecontents3); 
			
			$pagecontents4 = $this->pages_model->find_all_by('id',10); 
			Template::set('pagecontents4', $pagecontents4);
			
			$pagecontents5 = $this->pages_model->find_all_by('id',12); 
			Template::set('pagecontents5', $pagecontents5);
						
			//Template::set('page_title', 'Workout Guide');
		    //Template::set_view('users/index');	
		    Template::render();
		}//end index()

	//--------------------------------------------------------------------
    
    public function submit_request()
    {
        $status = 0;
        $msg = 'This service is unavailable right now. Please try again later.';    
        
        //check validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('service_type', 'Service Type', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('training_type', 'Service', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('training_time', 'Training Time', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('area_code', 'Area Code', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('training_date', 'Training Date', 'required|trim|strip_tags|xss_clean|valid_date');
        
        //check user is logged in
        if(!isset($this->current_user->id))
        {
            $this->form_validation->set_rules('requestor_name', 'Name', 'required|trim|strip_tags|xss_clean');
            $this->form_validation->set_rules('requestor_email', 'Email', 'required|trim|strip_tags|xss_clean|valid_email');
        }
        
        if ($this->form_validation->run($this) !== FALSE)
        {
            //check if email exist in user table and if not, then insert user to user table
            $member_id = 0;
            $user = FALSE;
            if(isset($this->current_user->id))
            {
                $user = $this->current_user;
            }
            else
            {
                $user = $this->user_model->find_by('email', $this->input->post('requestor_email'));
            }
            
            if(empty($user))
            {
                $data = array();
                $data['user_type']  = USER_MEMBER;
                $data['email']      = $this->input->post('requestor_email');
                $data['full_name'] = $this->input->post('requestor_name');
                $data['password']     = random_string();
                
                $member_id = $this->_register_member($data);
            }
            else
            {
                if($user->user_type == USER_MEMBER) 
                {
                    $member_id = $user->id;
                }
                else 
                {
                    $msg = 'This email is already registerd.';
                }
            }
            
            //findout one or insert successfully
            if($member_id)
            {
                $request_id = $this->_insert_request($member_id);
                if($request_id !== FALSE)
                {
                    //trainer_nums = $this->_sent_request_email_to_trainer($request_id);
                    if($trainer_nums = $this->_sent_request_email_to_trainer($request_id))
                    {
                        $status = 1;
                        $msg = "Your request has been sent to ({$trainer_nums}) trainers.";
                    } 
                    else
                    {
                        $msg = 'Sorry, there arent any trainers in this area.';
                    }                    
                }
            }
        }
        
        //return result    
        $result = array(
            'status' => $status,
            'msg'    => $msg,
        );
        echo json_encode($result);
        
        exit;
    }

    
    private function _insert_request($member_id)
    {
        //insert request        
        $areanumber = explode(" - ", $this->input->post('area_code'));
        $area_code = $areanumber[1]; 
        $suburb_name = $areanumber[0]; 
        
        $data = array();
        $data['member_id']        = $member_id;    
        $data['req_area_code']    = $area_code;
        $data['req_suburb_name']  = $suburb_name;
        $data['req_require_date'] = date('Y-m-d', strtotime($this->input->post('training_date')));
        $data['req_require_time'] = $this->input->post('training_time');
        $data['req_service_id']   = $this->input->post('training_type');
        $data['req_service_type'] = $this->input->post('service_type');
        //$data['req_status'] = REQUEST_PENDING;
        $data['req_expiration_date'] = strtotime("+5 days");
        
        return $this->request_model->insert($data); 
    }
    
    private function _register_member($data)
    {
        $user_id = FALSE;
        if($user_id = $this->user_model->insert($data))
        {
            // Prepare user messaging vars
            $subject = '';
            $email_mess = '';
            $message = lang('us_email_thank_you');
            $type = 'success';
            $site_title = $this->settings_lib->item('site.title');
            $error = false;			
			
						
            // Email Activiation.
            // Create the link to activate membership
            // Run the account deactivate to assure everything is set correctly
            // Switch on the login type to test the correct field
            $activation_code = $this->user_model->deactivate($data['email']);            
            $activate_link   = site_url('activate/'. str_replace('@', ':', $data['email']) .'/'. $activation_code);                        
            $subject         = lang('us_email_subj_activate');
            
            $this->user_model->insertactivate($user_id, array('active'=>1, 'activate_hash' => $activation_code));
            
            $email_message_data = array(
                'title' => $site_title,
                'code'  => $activation_code,
                'link'  => $activate_link,
                'temp_password' => $data['password'],
            );
            $email_mess = $this->load->view('_emails/activate', $email_message_data, true);
            $message   .= lang('us_check_activate_email');

            // Now send the email
            $data = array(
                'to'         => $data['email'],
                'subject'    => $subject,
                'message'    => $email_mess
            );
            
            $this->emailer->send($data);
            
            //email ben a new user notifcation
            // Now send the email
            $datatoben = array(
                'to'         => 'ben@ptondemand.com.au',
                'subject'    => 'New signup',
                'message'    => 'You have a new PTD user'
            );
            
            $this->emailer->send($datatoben);
            
        }
        
        return $user_id;       
    }
    
    private function _sent_request_email_to_trainer($request_id)
    {
        $this->load->model('area_model');
        $this->area_model->set_alias();
        
        //insert request        
        $areanumber = explode(" - ", $this->input->post('area_code'));
        //Array to String
        $area_code = $areanumber[1]; 
        
        //select trainers
        $service_type   = $this->input->post('service_type'); 
        $area_code      = $area_code;
        $require_time   = $this->input->post('training_time');

        $trainers = $this->area_model
               ->distinct()
               ->select('t2.trainer_id, t3.email trainer_email, t3.full_name trainer_name, area_name, t5.service_name')
               ->join('trainer_area t2', 't2.area_id=t1.area_id', 'inner')
               ->join('users t3', 't3.id=t2.trainer_id', 'inner')
               ->join('trainer_service t4', 't4.trainer_id=t2.trainer_id', 'inner')
               ->join('services t5', 't5.service_id=t4.service_id', 'inner')
               ->where('area_code', $area_code)
               ->where('t4.service_id', $this->input->post('training_type'))
               ->find_all();
        
        //$trainers = array_map("unserialize", array_unique(array_map("serialize",$trainers)));    
                          
        if(!empty($trainers))
        {
            $time = time();
            $req_trainers = array();
            $email_message_data = array(
                //'service_name' => $this->input->post('training_type'),
                'request_name' => $this->input->post('requestor_name'),
                'request_email'=> $this->input->post('requestor_email'),
                'request_date' => $this->input->post('training_date'),
                'request_time' => get_service_time($require_time),
                'request_service_type' => get_service_type($service_type),
                'quote_link'   => site_url('trainer/request/'.md5($request_id)),
            );
            
            foreach($trainers as $tr)
            {
                $email_message_data['service_name'] = $tr->service_name;
                $email_message_data['trainer_name'] = $tr->trainer_name;
                $email_message_data['request_area'] = $tr->area_name . "({$area_code})";                
                
                $email_mess = $this->load->view('_emails/request', $email_message_data, true);
                
                $data = array(
                    'to'         => $tr->trainer_email,
                    'subject'    => 'Training Request',
                    'message'    => $email_mess,
                );
                
                $this->emailer->send($data, TRUE, $time);
                
                //to insert request_trainer table
                $req_trainers[] = array('req_id' => $request_id, 'trainer_id' => $tr->trainer_id);
                
                //find duplicate trainer_id
                //issue with the saving multiple trainers
                
            }
            
            //$req_trainers_unq = array_unique($req_trainers);
            //insert to request_trainer table
            $this->request_model->db->insert_batch('request_trainer', $req_trainers);
            
            //execute queue by shell
            /*$this->load->library('PHPBackgroundProcesser');
            $proc = new BackgroundProcess();
            $proc->setCmd("exec php {$_SERVER['DOCUMENT_ROOT']}/index.php queue send {$time}");
            $proc->start();*/
            
            //return true;
            return count($trainers);
        } 
        
        //return false;
        //return true;
        return 0;
    }
}//end class
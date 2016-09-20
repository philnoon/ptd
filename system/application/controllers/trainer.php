<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trainer extends Authenticated_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if($this->current_user->user_type != USER_TRAINER)
        {
            redirect('/');
        }
    }
    
	public function index()
	{
        $this->load->model('service_model');
        $this->load->model('area_model');
        $this->load->model('trainer_model');
        
        if($this->input->post('submit')) 
        {
            $mservices = $this->input->post('my_services');
            $mareas = $this->input->post('my_areas');
            $this->trainer_model->update($this->current_user->id, $mservices, $mareas); 
            
            Template::set_message('Service items and areas are updated.', 'success');
            redirect('trainer');
        }
        
        //get all services
        $services = $this->service_model->format_dropdown('service_id', 'service_name');
        Template::set('services', $services);
        
        //get all areas
        //show the area code only        
        // possibly remove all duplicate suburbs with the same area name form DB 
        
        $areas = $this->area_model->format_dropdown('area_id', 'area_code');
        Template::set('areas', $areas);
        
        //get the suburb name
        
        //get my services
        $my_services = $this->trainer_model->get_services($this->current_user->id);
        Template::set('my_services', $my_services);

        //get my areas
        $my_areas = $this->trainer_model->get_areas($this->current_user->id);
        Template::set('my_areas', $my_areas);
        
        Assets::add_css('plugins/chosen/chosen.min.css');
        Assets::add_js('plugins/chosen/chosen.jquery.min.js');
        Assets::add_js('$(".chosen-select").chosen();', 'inline');
        
        $this->render();
	}//end index()

    //--------------------------------------------------------------------
    public function requests($offset = 0)
    {
        $this->load->model('request_model');
        $this->request_model->set_alias();
        
        //get requests to me
        $totals = $this->request_model
            ->join('request_trainer t2', 't2.req_id=t1.req_id', 'left')
            ->where('trainer_id', $this->current_user->id)
            ->count_all();
        
        $requests = $this->request_model
            ->distinct()
            ->join('request_trainer t2', 't2.req_id=t1.req_id', 'right')
            ->join('services t3', 't3.service_id=t1.req_service_id', 'right')
            ->join('users t4', 't4.id=t1.member_id', 'right')
            ->where('trainer_id', $this->current_user->id)
            ->limit($this->limit, $offset)
            ->order_by('req_created_at', 'desc')
            ->find_all();
            
        Template::set('requests', $requests);
        
        $this->setup_pagination('trainer/requests', $totals);
        
        $this->render();
    }
    
	//--------------------------------------------------------------------
	//sends out a quote
	// this it the quote form
    public function request($code)
    {
        $this->load->model('area_model');
        $this->load->model('request_model');
        $this->load->model('request_quote_model');
        $this->request_model->set_alias();
        
        //check request is for this trainer
        $where = array(
            'MD5(t1.req_id)' => $code,
            'trainer_id'  => $this->current_user->id,
        );                
        
        //count number of A's
        //if 6 then show quote btn
        $vcount=0;
        $verified = '';
        
        if ($this->current_user->qual34_st == 'A') {
        	$vcount ++;
        }
        
        if ($this->current_user->qualother_st == 'A') {
        	$vcount ++;
        }
        
        if ($this->current_user->pli_st == 'A') {
        	$vcount ++;
        }
        
        if ($this->current_user->fae_st == 'A') {
        	$vcount ++;
        }
        
        if ($this->current_user->faid_st == 'A') {
        	$vcount ++;
        }
        
        if ($this->current_user->cpr_st == 'A') {
        	$vcount ++;
        }
        
        //$q34 =  $this->current_user->qual34_st;
        //$q34 =  $this->current_user->qual34_st;
        
        if($vcount == 6){
        $verified = 'verified';
        }
        
        //check if trainer has paidup
        //if ($this->current_user->trainer_status_paid == 'Y') {
        // 	$feepaid = ;
        // }        
        
        Template::set('verified', $verified);
        Template::set('vcount', $vcount);
        
         
        if ($verified != 'verified'){
        Template::set_message('You need to upload and have all your certifications verified before you can quote on training requests.', 'danger');
        }
        
        if($this->current_user->trainer_status_paid != 'Y'){
        Template::set_message('You need to pay the annual membership fee before you can quote on training requests.', 'danger');      
        }        
        
        //check if trainer is approved
        $request = $this->request_model
            ->join('request_trainer t2', 't2.req_id=t1.req_id', 'left')
            ->join('services t3', 't3.service_id=t1.req_service_id', 'left')
            ->join('users t4', 't4.id=t1.member_id', 'left')
            ->find_by($where);
        if(empty($request)) 
        {
            //Template::set_message('This request is invalid for you.', 'danger');
            redirect('trainer/requests');
        }
        Template::set('request', $request);
        
        //get area
        $area = $this->area_model->find_by('area_code', $request->req_area_code);
        Template::set('area', $area);
        
        //save quote to table
        //max length 240 words
        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('price', 'Price', 'required|trim|numeric|greater_than[9.99]');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim|max_length[240]');
            
            if ($this->form_validation->run($this) !== FALSE)
            {
                $expire_date = strtotime('+5 days');
                $data = array(
                    'req_id'        => $request->req_id,
                    'trainer_id'    => $this->current_user->id,
                    'quote_price'   => $this->input->post('price'),
                    'quote_address' => $this->input->post('address'),
                    'quote_message' => $this->input->post('message'),
                    'quote_expiration_date' => $expire_date,
                );
                $quote_id = $this->request_quote_model->insert($data);
                
                if($quote_id != FALSE)
                {
                    //get member's email
                    $member = $this->user_model->find($request->member_id);
                    
                    //send email to member that submitted reuqest
                    $email_message_data = array(
                        'member_name'   => $member->full_name,
                        'trainer_name'  => $this->current_user->full_name,
                        'price'         => $this->input->post('price'),
                        'address'       => $this->input->post('address'),
                        'message'       => $this->input->post('message'),
                        'closing_date'  => $expire_date,
                        'accept_link'   => site_url('member/quote/'.md5($quote_id)),
                    );                                                                           
                    $email_mess = $this->load->view('_emails/quote', $email_message_data, true);
                    
                    // Now send the email
                    $this->load->library('emailer');
                    $data = array(
                        'to'         => $member->email,
                        'subject'    => 'Quote for training request',
                        'message'    => $email_mess
                    );
                    
                    $this->emailer->send($data);
                    
                    //success
                    Template::set_message('Your quote has been submitted to member.', 'success');
                    
                    redirect($this->uri->uri_string());
                }
                else
                {
                    Template::set_message('There is an error.', 'danger');
                }
            }
        }
        
        //get number of quotes of this request
        $quote_nums = $this->request_quote_model->where('req_id', $request->req_id)->count_all();
        Template::set('quote_nums', $quote_nums);
        
        //check i have already quote
        $where = array(
            'req_id' => $request->req_id,
            'trainer_id' => $this->current_user->id,           
        );
        $myquote = $this->request_quote_model->find_by($where);
        Template::set('myquote', $myquote);
        
        $this->render();
    }
    
    public function certification()
    {
        $this->render();
    }
    
    public function update_certification()
    {
        if($this->input->post('submit'))
        {
            $certs = array(
                'qual34'    => 'Certificate III/IV', 
                'qualother' => 'Other Qualifications', 
                'pli'   => 'Personal Liability Insurance', 
                'fae'   => 'Fitness Australia/Essa', 
                'faid'  => 'First Aid', 
                'cpr'   => 'CPR'
            );  
            
            foreach($certs as $key => $value)
            {
                if(isset($_FILES[$key]) && !empty($_FILES[$key]['tmp_name']))
                {
                    $filename=$_FILES[$key]['name'];
                    $_FILES[$key]['name'] = rename_upload_file($filename);
                    $dir = create_dir_upload('uploads/certifications/');
                    $config['allowed_types'] = 'JPEG|jpg|JPG|png|PDF|pdf';
                    $config['max_size'] = '3000';
                    $config['upload_path'] = $dir;
                    $this->load->library('upload',$config);

                    if (!$this->upload->do_upload($key))
                    {
                        Template::set_message($this->upload->display_errors(), 'danger');
                        redirect('trainer/update_certification');
                    } 
                    else
                    {
                        if($this->current_user->$key != null)
                        {
                            try 
                            {
                                unlink($this->current_user->$key);
                            } 
                            catch (Exception $e) 
                            {
                                //echo $e;
                            }
                        }

                        $config = array();
                        $config = array("source_image" => $dir.'/'.$_FILES[$key]['name'],"new_image" => $dir);
                        $this->load->library('image_lib',$config);
                        $this->image_lib->resize();    
                        
                        $data = array(
                            $key => $dir.'/'.$_FILES[$key]['name'], 
                            $key.'_st' => 'W',
                        );
                        $this->user_model->update($this->current_user->id, $data);
                    }
                }
            }
            
            Template::set('Certifications were uploaded successfully.', 'success');
            redirect('trainer/certification');
        }
        
        $this->render();
    }
}//end class

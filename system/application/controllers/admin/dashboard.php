<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function index()
	{
        $certs = $this->config->item('certification');
        $where = '';
        $index = 0;
        
        //qual_34_st - W: waiting / A: Approved
        foreach($certs as $key => $value)
        {
            if($index == 0) $where .= "{$key}_st='W'";
            else $where .= " OR {$key}_st='W'";
            $index++;
        }
        
        $trianers = $this->user_model
            ->where('user_type', USER_TRAINER)
            ->where($where,  NULL, FALSE)
            ->order_by('created_at', 'desc')
            ->find_all(); 
        Template::set('trainers', $trianers);
        
        
        //count number of W/A
        //this just shows and overview not individual trainer
        //$xcount=5;
        //Template::set('xcount', $index);
        
        $this->set_view('dashboard/index');
        $this->render();
	}//end index()

	//--------------------------------------------------------------------
    
    public function view_trainer($user_code)
    {
        if($this->input->post('submit'))
        {
            $certs = $this->config->item('certification');

            $data = array();
            foreach($certs as $key => $value)
            {
                $data[$key.'_st'] = 'A';
            }            
            $this->user_model->update_where('MD5(id)', $user_code, $data);
            
            Template::set_message('Trainer\'s certifications were approved.', 'success');
            redirect(admin_url());
        }
        
        $user = $this->user_model->find_by('MD5(id)', $user_code);
        Template::set('user', $user);
        
        $this->set_view('dashboard/view_trainer');
        $this->render();
    }
}//end class

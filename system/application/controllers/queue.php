<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Queue extends Front_Controller {

    //public function send($time='')
    public function send()
    {
        $this->load->library('emailer');
        //$this->emailer->process_queue_time($time);
        $this->emailer->process_queue2();
        
        exit;
    }//end index()

    //--------------------------------------------------------------------
}//end class

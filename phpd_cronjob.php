<?php

include_once(__DIR__ . '/phpd_4353434234.php');

class Queue extends Base_Controller {

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

$instance = new Queue();
$instance->send();
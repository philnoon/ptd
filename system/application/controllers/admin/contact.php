<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Admin_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Sets up the require permissions and loads required classes
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// restrict access - View and Manage
		Template::set('toolbar_title', 'Site Settings');

		$this->load->helper('config_file');
                                  
        $this->top_menu_item = 'contact';
		
		if (!class_exists('Contactform_model'))
		{
			$this->load->model('contactform_model');
		}

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays a form with various site setings including site name and
	 * registration settings
	 *
	 * @access public
	 *
	 * @return void
	 */
	
	public function index()
	{		
        $contacts = $this->contactform_model->find_all(); 
        Template::set('contacts', $contacts);
        
        $this->set_view('contact/index');
        $this->render();
	}//end index()
    
    //--------------------------------------------------------------------
    
}//end Settings()
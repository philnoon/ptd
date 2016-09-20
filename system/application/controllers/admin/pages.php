<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Admin_Controller
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
		
		if (!class_exists('Pages_model'))
		{
			$this->load->model('pages_model');
		}
		
		$this->top_menu_item = 'pages';

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
        $pagecontents = $this->pages_model->find_all(); 
        Template::set('pagecontents', $pagecontents);        
        $this->set_view('pages/index');
        $this->render();
	}//end index()
    
    //--------------------------------------------------------------------
	
	/**
	 * Edit a user
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function edit($id='')
	{
		
		if (empty($id))
		{
			redirect(admin_url('pages'));
		}
		
        if ($this->input->post('submit'))
        {
           // $id = $this->current_user->id;
            if ($this->_save_pages($id))
            {
                Template::set_message('Updated successfully ', 'success');

                // redirect to make sure any language changes are picked up
               // Template::redirect('admin/pages');
                //exit;
            }  
            else
            {
                Template::set_message(lang('us_profile_updated_error'), 'danger');
            }//end if
        }

        $page = $this->pages_model->find($id);
		if (isset($page))
		{
			Template::set('page', $page);
		}
		else
		{
			redirect('admin/pages');
		}

        Template::set('toolbar_title', lang('us_edit_user'));
		$this->set_view('pages/page_form');
		$this->render();

	}//end edit()

	//--------------------------------------------------------------------
	
	//--------------------------------------------------------------------
    /**
     * Save pages
     *
     * @access private
     *
     * @param int   $id          The id of the user in the case of an edit operation
     * @param array $meta_fields Array of meta fields fur the user
     *
     * @return bool
     */
    private function _save_pages($id=0)
    {

        $_POST['id'] = $id;        
        $data = array(
            'pagecontent' => $this->input->post('pagecontent')
        );

        return $this->pages_model->update($id, $data); 

    }//end save_pages()

    
}//end Settings()
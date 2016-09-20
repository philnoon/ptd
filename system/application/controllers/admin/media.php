<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Admin_Controller
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
                                  
        $this->top_menu_item = 'media';
		
		if (!class_exists('Mediauploads_model'))
		{
			$this->load->model('mediauploads_model');
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
		if ($this->input->post('submit'))
		{
			$user_id = $this->current_user->id;
			if ($this->_save_media($user_id))
			{
				Template::set_message('File Uploaded', 'success');
				exit;
			}  
		}
		
        $media = $this->mediauploads_model->find_all(); 
        Template::set('media', $media);
        
        $this->set_view('media/index');
        $this->render();
		
	}//end index()
    
    //--------------------------------------------------------------------
	
	
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------

    /**
     * Save the user
     *
     * @access private
     *
     * @param int   $id          The id of the user in the case of an edit operation
     * @param array $meta_fields Array of meta fields fur the user
     *
     * @return bool
     */
    private function _save_media($id=0)
    {        
        if ( $id == 0 )
        {
            $id = $this->current_user->id;
        }

        $_POST['id'] = $id;
		
        //upload media
        if (!empty($_FILES['mediafile']['tmp_name'])) {
            $filename                = $_FILES['mediafile']['name'];
           // $_FILES['mediafile']['name']   = rename_upload_file($filename);
 $_FILES['mediafile']['name']   =$filename;
            $dir                     = create_dir_upload('uploads/media/');
            $config['allowed_types'] = 'JPEG|jpg|JPG|png|PNG|pdf|PDF';
            $config['max_size']      = '3000';
            //$config['width']         = 100;
            //$config['height']        = 100;
            $config['upload_path']   = $dir;
            $this->load->library('upload', $config);
			
            if (!$this->upload->do_upload('mediafile')) {    
                Template::set_message($this->upload->display_errors(), 'danger');
            } else {			
				
				$config = array();
				$config = array("source_image" => $dir.'/'.$_FILES['mediafile']['name'],"new_image" => $dir);
				$this->load->library('image_lib',$config);
				$this->image_lib->resize();    
				
				$data = array(
				'mediafile' => $dir.'/'.$_FILES['mediafile']['name']
				);
				
				$this->mediauploads_model->insert($data);
				Template::set_message('File saved', 'success');
            }
        }
		
		//return $return;

    }//end save_user()

	
}//end Settings()
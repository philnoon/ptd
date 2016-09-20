<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();        
    }
	/**
	 * Displays the homepage
	 *
	 * @return void
	 */
	public function index()
	{
        if ($this->input->post('submit'))
        {
            $user_id = $this->current_user->id;
            if ($this->_save_profile($user_id))
            {
                Template::set_message(lang('us_profile_updated_success'), 'success');

                // redirect to make sure any language changes are picked up
                Template::redirect('admin/profile');
                exit;
            }  
            else
            {
                Template::set_message(lang('us_profile_updated_error'), 'danger');
            }//end if
        }
        else if($this->input->post('delete_photo'))
        {
            $this->user_model->update($this->current_user->id, array('avt'=>null));
            if ($this->current_user->avt != null) {
                try {
                    unlink($this->current_user->avt);
                }
                catch (Exception $e) {
                    
                }
            }
            Template::set_message('You avatar image was removed.', 'success');
            redirect('admin/profile');
        }
        //end if

        // get the current user information
        $user = $this->user_model->find($this->current_user->id);
        Template::set('user', $user);

        $this->set_view('profile/index');
        $this->render();        
	}//end index()

    public function password()
    {
        if ($this->auth->is_logged_in() === FALSE)
        {
            $this->auth->logout();
            redirect('login');
        }

        if ($this->input->post('submit'))
        {
            $user_id = $this->current_user->id;
            if ($this->_save_password($user_id))
            {
                Template::set_message(lang('us_password_updated_success'), 'success');

                // redirect to make sure any language changes are picked up
                Template::redirect('admin/profile/password');
                exit;
            }
            else
            {
                Template::set_message(lang('us_password_updated_error'), 'danger');
            }//end if
        }//end if

        // get the current user information
        $user = $this->user_model->find($this->current_user->id);
        Template::set('user', $user);

        $this->set_view('profile/password');
        $this->render();        
    }
    
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
    private function _save_profile($id=0)
    {        
        if ( $id == 0 )
        {
            $id = $this->current_user->id; /* ( $this->input->post('id') > 0 ) ? $this->input->post('id') :  */
        }

        $_POST['id'] = $id;

        //upload avatar
        if (!empty($_FILES['avt']['tmp_name'])) {
            $filename                = $_FILES['avt']['name'];
            $_FILES['avt']['name']   = rename_upload_file($filename);
            $dir                     = create_dir_upload('uploads/photo/');
            $config['allowed_types'] = 'JPEG|jpg|JPG|png';
            $config['max_size']      = '1000';
            $config['width']         = 100;
            $config['height']        = 100;
            $config['upload_path']   = $dir;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('avt')) {    
                Template::set_message($this->upload->display_errors(), 'danger');
                redirect(base_url() . 'profile');
            } else {
                if ($this->current_user->avt != null) {
                    try {
                        unlink($this->current_user->avt);
                    }
                    catch (Exception $e) {
                        
                    }
                }
                $config = array();
                $config = array(
                    "source_image" => $dir . '/' . $_FILES['avt']['name'], //get original image
                    "new_image" => $dir, //save as new image //need to create thumbs first
                    "width" => 100,
                    "height" => 100,
                    'master_dim' => 'height'
                );
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->user_model->update($this->current_user->id, array('avt' => $dir . '/' . $_FILES['avt']['name']));
            }
        }
        
        // Simple check to make the posted id is equal to the current user's id, minor security check
        if ( $_POST['id'] != $this->current_user->id )
        {
            $this->form_validation->set_message('email', 'lang:us_invalid_userid');
            return FALSE;
        }

        $this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|valid_email|max_length[120]|unique_email[users.email,users.id]|xss_clean');
        $this->form_validation->set_rules('full_name', 'lang:bf_full_name', 'trim|strip_tags|max_length[255]|xss_clean');
        if ($this->form_validation->run($this) === FALSE)
        {
            return FALSE;
        }

        // Compile our core user elements to save.
        $data = array(
            'email'         => $this->input->post('email'),
            'full_name'  => $this->input->post('full_name'),
            'phone'         => $this->input->post('phone'),
            'address'       => $this->input->post('address'),
        );

        return $this->user_model->update($id, $data);

    }//end save_user()
    
    private function _save_password($id)
    {
        $_POST['id'] = $id;

        // Simple check to make the posted id is equal to the current user's id, minor security check
        if ( $_POST['id'] != $this->current_user->id )
        {
            $this->form_validation->set_message('email', 'lang:us_invalid_userid');
            return FALSE;
        }

        $this->form_validation->set_rules('old_password', 'Old password', 'required|trim|strip_tags|min_length[4]|max_length[120]|check_old_password');
        $this->form_validation->set_rules('password', 'lang:bf_password', 'required|trim|strip_tags|min_length[4]|max_length[120]|valid_password');
        $this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|trim|strip_tags|matches_password[password]');
        if ($this->form_validation->run($this) === FALSE)
        {
            return FALSE;
        }
        
        // Compile our core user elements to save.
        $data = array(
            'password'      => $this->input->post('password'),
            'pass_confirm'  => $this->input->post('pass_confirm'),
        );

        return $this->user_model->update($id, $data);

    }//end save_user()
}//end class
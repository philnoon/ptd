<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Front_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Setup the required libraries etc
	 *
	 * @retun void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

		if (!class_exists('User_model'))
		{
			$this->load->model('user_model');
		}
		
		if (!class_exists('Contactform_model'))
		{
			$this->load->model('contactform_model');
		}
		
		if (!class_exists('Pages_model'))
		{
			$this->load->model('pages_model');
		}
		
		
		if (!class_exists('Questionnaire_model'))
		{
			$this->load->model('questionnaire_model');
		}

		$this->load->database();

		$this->load->library('auth');

		$this->lang->load('users');
        
        Assets::add_js('slimscroll/jquery.slimscroll.min.js');
        Assets::add_js('scripts.min.js');
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Presents the login function and allows the user to actually login.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function login()
	{                     
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE)
		{
			if ($this->input->post('submit'))
			{
				$remember = $this->input->post('remember_me') == '1' ? TRUE : FALSE;

				// Try to login
				if ($this->auth->login($this->input->post('username'), $this->input->post('password'), $remember) === TRUE)
				{
					if (!empty($this->requested_page))
					{
						Template::redirect($this->requested_page);
					}
					else                
					{
                        $login_dest = $this->auth->login_dest;
                        Template::redirect($login_dest);
					}
				}//end if
				
                else
                {
                    
                }
			}//end if
            
            
            Assets::add_css('login.css');
            Template::set_view('users/login');
            Template::set('page_title', 'Login');
            Template::render();
            
            //Assets::add_css('login.css');            
			//Template::set('page_title', 'Login');
			//Template::render('login');
		}
		else
		{
			Template::redirect('/');
		}//end if

	}//end login()

	//--------------------------------------------------------------------

	/**
	 * Calls the auth->logout method to destroy the session and cleanup,
	 * then redirects to the home page.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->auth->logout();

		redirect('/');

	}//end  logout()

	//--------------------------------------------------------------------

	/**
	 * Allows a user to start the process of resetting their password.
	 * An email is allowed with a special temporary link that is only valid
	 * for 24 hours. This link takes them to reset_password().
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function forgot_password()
	{
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE)
		{
			if (isset($_POST['submit']))
			{
				$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|strip_tags|valid_email|xss_clean');

				if ($this->form_validation->run() !== FALSE)
                {
					// We validated. Does the user actually exist?
					$user = $this->user_model->find_by('email', $_POST['email']);

					if ($user !== FALSE)
					{
						// User exists, so create a temp password.
						$this->load->helpers(array('string', 'security'));

						$pass_code = random_string('alnum', 40);

						$hash = do_hash($pass_code . $user->salt . $_POST['email']);

						// Save the hash to the db so we can confirm it later.
						$this->user_model->update_where('email', $_POST['email'], array('reset_hash' => $hash, 'reset_by' => strtotime("+24 hours") ));

						// Create the link to reset the password
						$pass_link = site_url('reset_password/'. str_replace('@', ':', $_POST['email']) .'/'. $hash);
                        //echo $pass_link;
						// Now send the email
						$this->load->library('emailer');

						$data = array(
								'to'	=> $_POST['email'],
								'subject'	=> lang('us_reset_pass_subject'),
								'message'	=> $this->load->view('_emails/forgot_password', array('link' => $pass_link), TRUE)
						 );
                        
						if ($this->emailer->send($data))
						{
                            
							Template::set_message(lang('us_reset_pass_message'), 'success');
						}
						else
						{
							Template::set_message(lang('us_reset_pass_error'). $this->emailer->errors, 'danger');
						}
					}//end if
                    else
                    {
                        Template::set_message(lang('us_invalid_email'), 'danger');
                    }
				}//end if
			}//end if
			
			
			/*
			Assets::add_css('login.css');
			Template::set_view('users/login');
			Template::set('page_title', 'Contact Us');
			Template::render();
			*/
			

            Assets::add_css('login.css');
            Template::set('page_class', 'register');
            
			Template::set_view('users/forgot_password');
			Template::set('page_title', 'Password Reset');
			//Template::render('login');
			Template::render();
		}
		else
		{
			Template::redirect('/');
		}//end if

	}//end forgot_password()

	//--------------------------------------------------------------------

	/**
	 * Allows a user to edit their own profile information.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function profile()
	{
		if ($this->auth->is_logged_in() === FALSE)
		{
			$this->auth->logout();
			redirect('login');
		}
        
        if($this->current_user->user_type === USER_ADMIN)
        {
            redirect('/');
        }

		if ($this->input->post('submit'))
		{
			$user_id = $this->current_user->id;
			if ($this->_save_profile($user_id))
			{
				Template::set_message(lang('us_profile_updated_success'), 'success');

				// redirect to make sure any language changes are picked up
				Template::redirect('profile');
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
            redirect('profile');
        }
        //end if

		// get the current user information
		$user = $this->user_model->find($this->current_user->id);
        Template::set('user', $user);

		Template::set_view('users/profile');
		Template::render();

	}//end profile()
    
    public function password()
    {
        if ($this->auth->is_logged_in() === FALSE)
        {
            $this->auth->logout();
            redirect('login');
        }
        
        if($this->current_user->user_type === USER_ADMIN)
        {
            redirect('/');
        }

        if ($this->input->post('submit'))
        {
            $user_id = $this->current_user->id;
            if ($this->_save_password($user_id))
            {
                Template::set_message(lang('us_password_updated_success'), 'success');

                // redirect to make sure any language changes are picked up
                Template::redirect('password');
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

        Template::set_view('users/password');
        Template::render();        
    }

	//--------------------------------------------------------------------

	/**
	 * Allows the user to create a new password for their account. At the moment,
	 * the only way to get here is to go through the forgot_password() process,
	 * which creates a unique code that is only valid for 24 hours.
	 *
	 * @access public
	 *
	 * @param string $email The email address to check against.
	 * @param string $code  A randomly generated alphanumeric code. (Generated by forgot_password() ).
	 *
	 * @return void
	 */
	public function reset_password($email='', $code='')
	{
		// if the user is not logged in continue to show the login page
		if ($this->auth->is_logged_in() === FALSE)
		{
			// If there is no code, then it's not a valid request.
			if (empty($code) || empty($email))
			{
				Template::set_message(lang('us_reset_invalid_email'), 'danger');
				Template::redirect('/login');
			}

			// Handle the form
			if ($this->input->post('submit'))
			{
				$this->form_validation->set_rules('password', 'lang:bf_password', 'required|trim|strip_tags|min_length[4]|max_length[120]|valid_password');
				$this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|trim|strip_tags|matches[password]');

				if ($this->form_validation->run() !== FALSE)
				{
					// The user model will create the password hash for us.
					$data = array('password'        => $this->input->post('password'),
					              'pass_confirm'	=> $this->input->post('pass_confirm'),
					              'reset_by'		=> 0,
					              'reset_hash'	    => '');

					if ($this->user_model->update($this->input->post('user_id'), $data))
					{
                        Template::set_message(lang('us_reset_password_success'). $this->user_model->error, 'success');
                        
						Template::redirect('/login');
					}
					else
					{
						Template::set_message(lang('us_reset_password_error'). $this->user_model->error, 'danger');

					}
				}
			}//end if

			// Check the code against the database
			$email = str_replace(':', '@', $email);
			$user = $this->user_model->find_by(array(
                                        'email' => $email,
										'reset_hash' => $code,
										'reset_by >=' => time()
                                   ));

			// It will be an Object if a single result was returned.
			if (!is_object($user))
			{
				Template::set_message( lang('us_reset_invalid_email'), 'danger');
				Template::redirect('/login');
			}

            // If we're here, then it is a valid request....
			Template::set('user', $user);

            Assets::add_css('login.css');            
			Template::set_view('users/reset_password');
			//Template::render('login');
			Template::render();
		}
		else
		{
			Template::redirect('/');
		}//end if

	}//end reset_password()

	//--------------------------------------------------------------------

	/**
	 * Display the registration form for the user and manage the registration process
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function register_member($sign_with='')
	{
		$this->_register_process(USER_MEMBER);

        ////////////////////////////////////////////////////
        //facebook
        //load facebook lib 
        $this->load->library('facebook', 'users/register_member/facebook');
        
        // Get Login Url
        Template::set('loginUrl', $this->facebook->login_url());
        
        if($sign_with === 'facebook')
        {
             $fuser = $this->facebook->get_user(); 
             $fuser['username'] = explode('@', $fuser['email'])[0];
             
             print_r($fuser);
             
             Template::set('fuser', $fuser);
        }            
        //facebook
        ////////////////////////////////////////////////////
        
        $pagecontents = $this->pages_model->find_all_by('id',13);
        Template::set_block('left_block', 'users/register/member');
        Template::set_view('users/register');
        Template::set('pagecontents', $pagecontents); 
		Template::set('page_title', 'Register as Member');
		Template::render();

	}//end register()
    
    public function register_trainer($sign_with='')
    {
        $this->_register_process(USER_TRAINER);

        ////////////////////////////////////////////////////
        //facebook
        //load facebook lib 
        $this->load->library('facebook', 'users/register_trainer/facebook');
        
        // Get Login Url
        Template::set('loginUrl', $this->facebook->login_url());
        
        if($sign_with === 'facebook')
        {
             $fuser = $this->facebook->get_user();
             $fuser['user_name'] = explode('@', $fuser['email'])[0];
             
             Template::set('fuser', $fuser);
        }            
        //facebook
        ////////////////////////////////////////////////////
        
        $pagecontents = $this->pages_model->find_all_by('id',14);
        Template::set_block('left_block', 'users/register/trainer');
        Template::set_view('users/register');
        Template::set('pagecontents', $pagecontents);
        Template::set('page_title', 'Register as Trainer');
        Template::render();

    }//end register()
	
	
	//--------------------------------------------------------------------
	//--------------------------------------------------------------------
	// CONTENT CONTROLLERS
	//------------------------------------------------------------------
	
	public function how_it_works()
    {
        
        //Template::set_block('left_block', 'users/register/trainer');
		
		$pagecontents = $this->pages_model->find_all_by('id',1); 
        Template::set('page_title', 'How It Works');
		Template::set('pagecontents', $pagecontents); 		
        Template::set_view('users/how_it_works');
        Template::render();

    }
	
	public function training_safety()
    {
        
        $pagecontents = $this->pages_model->find_all_by('id',2); 
        Template::set('page_title', 'Training Safety');
		Template::set('pagecontents', $pagecontents); 	
        Template::set_view('users/training_safety');		
        Template::render();

    }
	
	public function pricing()
    {
        
        //Template::set_block('left_block', 'users/register/trainer');
        Template::set_view('users/pricing');
        Template::set('page_title', 'Pricing');
        Template::render();

    }
	
	public function rewards()
    {
        
        //Template::set_block('left_block', 'users/register/trainer');
        Template::set_view('users/rewards');
        Template::set('page_title', 'Rewards');
        Template::render();

    }
	
	public function contact_us()
    {
        if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules('name', 'lang:bf_name', 'required|trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('emailaddress', 'lang:bf_email', 'required|trim|strip_tags|valid_email|xss_clean');
			$this->form_validation->set_rules('message', 'lang:bf_message', 'required|trim|strip_tags|xss_clean');
			
			if ($this->form_validation->run() !== FALSE)
			{
				// save the user...
				$data = array(
					'name' => $this->input->post('name'),
					'emailaddress' => $this->input->post('emailaddress'),
					'message' => $this->input->post('message')
				);
				
				$this->contactform_model->insert($data);
				//Template::set_message(lang('us_contact_form_success'), 'success');				

				$email_mess = $this->load->view('_emails/general', $data, true);
				
				$this->load->library('emailer');
				$data = array(
					'to'        => 'ben@ptondemand.com.au',
					'subject'    => 'PTD - Contact form',
					'message'    => $email_mess
				);
				
				$this->emailer->enable_debug(true);
				if ($this->emailer->send($data))
				{
					Template::set_message(lang('us_contact_form_success'), 'success');
				}
				else
				{
					if (isset($this->emailer->errors))
					{
						$errors = '';
						if (is_array($this->emailer->errors))
						{
							foreach ($this->emailer->errors as $error)
							{
								$errors .= $error."<br />";
							}
						}
						else
						{
							$errors = $this->emailer->errors;
						}
						Template::set_message(lang('us_err_no_email').$errors.", ".$this->emailer->debug, 'danger');
					}
				}
				
				
				
			}
			//end if
		}//end if
        //Template::set_block('left_block', 'users/register/trainer');
        Template::set_view('users/contact_us');
        Template::set('page_title', 'Contact Us');
        Template::render();

    }
	
	public function workout_guide()
    {		
		$pagecontents = $this->pages_model->find_all_by('id',3);
		Template::set('pagecontents', $pagecontents); 	
		Template::set('page_title', 'Workout Guide');
        Template::set_view('users/workout_guide');	
        Template::render();
    }
	
	public function nutrition_guide()
    {
    	$pagecontents = $this->pages_model->find_all_by('id',4); 
        Template::set('pagecontents', $pagecontents); 	
		Template::set('page_title', 'Nutrition Guide');
        Template::set_view('users/nutrition_guide');	
        Template::render();
    }
	
	public function terms_of_use()
    {
        
        $pagecontents = $this->pages_model->find_all_by('id',5); 
        Template::set('pagecontents', $pagecontents);
        Template::set_view('users/terms_of_use');
        Template::set('page_title', 'Terms Of Use');
        Template::render();

    }
	
	public function privacy_policy()
    {
        
        $pagecontents = $this->pages_model->find_all_by('id',6); 
        Template::set('pagecontents', $pagecontents);
        Template::set_view('users/privacy_policy');
        Template::set('page_title', 'Privacy Policy');
        Template::render();

    }
    
    
	public function trainers()
    {
        
        $pagecontents = $this->pages_model->find_all_by('id',11); 
        Template::set('pagecontents', $pagecontents);
        Template::set_view('users/trainers');
        Template::set('page_title', 'Trainers');
        Template::render();

    }
    
    	
//--------------------------------------------------------------------
//--------------------------------------------------------------------
// ACTIVATION METHODS
//--------------------------------------------------------------------
/*
	questionnaire user.

	Checks a passed activation code and if verified, enables the user
	account. If the code fails, an error is generated and returned.

*/


public function questionnaire()
    {
        if ($this->auth->is_logged_in() === FALSE)
        {
            $this->auth->logout();
            redirect('login');
        }

        if ($this->input->post('submit'))
        {
            $user_id = $this->current_user->id;
            if ($this->_save_questionnaire($user_id))
            {
                Template::set_message(lang('us_password_updated_success'), 'success');

                // redirect to make sure any language changes are picked up
                Template::redirect('users/questionnaire');
                exit;
            }
            else
            {
                Template::set_message(lang('us_password_updated_error'), 'danger');
            }//end if
        }//end if

        // get the current user information
        $user = $this->user_model->find($this->current_user->id);
        
		//Questionare_model
        Template::set('user', $user);
        Template::set_view('users/questionnaire');
        Template::render(); 		
    }
    
    
    private function _save_questionnaire($id)
        {
            $_POST['id'] = $id;
    
            // Simple check to make the posted id is equal to the current user's id, minor security check
            if ( $_POST['id'] != $this->current_user->id )
            {
                $this->form_validation->set_message('q1_exc_freq', 'lang:us_invalid_userid');
                return FALSE;
            }
    
            $this->form_validation->set_rules('q1_exc_freq', 'lang:bf_password', 'required');
    		$this->form_validation->set_rules('q2_fitness_rating', 'lang:bf_password', 'required');
    		
            if ($this->form_validation->run($this) === FALSE)
            {
                return FALSE;
            }
            
            // Compile our core user elements to save.
            $data = array(
    			'user_id' => $this->input->post('id'),
                'q1_exc_freq' => $this->input->post('q1_exc_freq'),
    			'q2_fitness_rating' => $this->input->post('q2_fitness_rating')
            );
    
            return $this->questionnaire_model->insert($data);
    		
    		Template::set_message(lang('us_contact_form_success'), 'success');	
    
        }//end save_questionnaire()
    	
    	
    	
    	
    	
	
		
	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// ACTIVATION METHODS
	//--------------------------------------------------------------------
	/*
		Activate user.

		Checks a passed activation code and if verified, enables the user
		account. If the code fails, an error is generated and returned.

	*/
	public function activate($email = FALSE, $code = FALSE)
	{

		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('code', 'Verification Code', 'required|trim|xss_clean');
			if ($this->form_validation->run() == TRUE) {
				$code = $this->input->post('code');
			}
		} else {
			if ($email === FALSE)
			{
				$email = $this->uri->segment(2);
			}
			if ($code === FALSE)
			{
				$code = $this->uri->segment(3);
			}
		}

		// fix up the email
		if (!empty($email))
		{
			$email = str_replace(":", "@", $email);
		}

		if (!empty($code))
		{
			$activated = $this->user_model->activate($email, $code);
			if ($activated)
			{
				// Now send the email
				$this->load->library('emailer');

				$site_title = $this->settings_lib->item('site.title');

				$email_message_data = array(
					'title' => $site_title,
					'link'  => site_url('login')
				);
				$data = array
				(
					'to'		=> $this->user_model->find($activated)->email,
					'subject'	=> lang('us_account_active'),
					'message'	=> $this->load->view('_emails/activated', $email_message_data, TRUE)
				);

				if ($this->emailer->send($data))
				{
					Template::set_message(lang('us_account_active'), 'success');
				}
				else
				{
					Template::set_message(lang('us_err_no_email'). $this->emailer->errors, 'danger');
				}
				Template::redirect('/login');
			}
			else
			{
				Template::set_message(lang('us_activate_error_msg'), 'danger');
			}
		}
        
        Assets::add_css('login.css');        
		Template::set_view('users/activate');
		Template::set('page_title', 'Account Activation');
		//Template::render('login');
		Template::render();
		
	}

	//--------------------------------------------------------------------

	/*
		   Method: resend_activation

		   Allows a user to request that their activation code be resent to their
		   account's email address. If a matching email is found, the code is resent.
	   */
	public function resend_activation()
	{
		if (isset($_POST['submit']))
		{
			$this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|strip_tags|valid_email|xss_clean');

			if ($this->form_validation->run() !== FALSE)
            {
				// We validated. Does the user actually exist?
				$user = $this->user_model->find_by('email', $_POST['email']);

				if ($user !== FALSE)
				{
					// User exists, so create a temp password.
					$this->load->helpers(array('string', 'security'));

					$pass_code = random_string('alnum', 40);

					$activation_code = do_hash($pass_code . $user->salt . $_POST['email']);

					$site_title = $this->settings_lib->item('site.title');

					// Save the hash to the db so we can confirm it later.
					$this->user_model->update_where('email', $_POST['email'], array('activate_hash' => $activation_code ));

					// Create the link to reset the password
					$activate_link = site_url('activate/'. str_replace('@', ':', $_POST['email']) .'/'. $activation_code);

					// Now send the email
					$this->load->library('emailer');

					$email_message_data = array(
						'title' => $site_title,
						'code'  => $activation_code,
						'link'  => $activate_link
					);

					$data = array
					(
						'to'		=> $_POST['email'],
						'subject'	=> 'Activation Code',
						'message'	=> $this->load->view('_emails/activate', $email_message_data, TRUE)
					);
					$this->emailer->enable_debug(true);
					if ($this->emailer->send($data))
					{
						Template::set_message(lang('us_check_activate_email'), 'success');
					}
					else
					{
						if (isset($this->emailer->errors))
						{
							$errors = '';
							if (is_array($this->emailer->errors))
							{
								foreach ($this->emailer->errors as $error)
								{
									$errors .= $error."<br />";
								}
							}
							else
							{
								$errors = $this->emailer->errors;
							}
							Template::set_message(lang('us_err_no_email').$errors.", ".$this->emailer->debug, 'danger');
						}
					}
				}
                else
                {
                    Template::set_message('Cannot find that email in our records.', 'danger');    
                }
			}
		}
        
        Assets::add_css('login.css');
        
		Template::set_view('users/resend_activation');
		Template::set('page_title', 'Activate Account');
		//Template::render('login');
		Template::render();
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
        $this->form_validation->set_rules('full_name', 'lang:bf_full_name', 'required|trim|strip_tags|max_length[255]|xss_clean');
        if($this->current_user === USER_TRAINER)
        {
            $this->form_validation->set_rules('paypal_email', 'paypal email', 'required|trim|valid_email|max_length[120]|xss_clean');
        }
        
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
            'abn'           => $this->input->post('abn'),
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

    //--------------------------------------------------------------------
    
    private function _register_process($user_type=USER_MEMBER)
    {
        if ($this->auth->is_logged_in() === TRUE)
        {
            redirect('/');
        }
        
        if ($this->input->post('submit'))
        {
            // Validate input
            $this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|strip_tags|valid_email|max_length[120]|unique_email[users.email]|xss_clean');
            //$this->form_validation->set_rules('username', 'lang:bf_username', 'required|trim|strip_tags|max_length[30]|unique_username[users.username]|xss_clean');

            $this->form_validation->set_rules('password', 'lang:bf_password', 'required|trim|strip_tags|min_length[4]|max_length[120]|valid_password');
            $this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|trim|strip_tags|matches_password[password]');

            $this->form_validation->set_rules('full_name', 'lang:bf_full_name', 'required|trim|strip_tags|max_length[255]|xss_clean');
            
            $this->form_validation->set_rules('accept', 'terms and conditions agreement', 'required|isset');

            if ($this->form_validation->run($this) !== FALSE)
            {
                // Time to save the user...
                $data = array(
                    'user_type' => $user_type,
                    'email'     => $this->input->post('email'),
                    'password'  => $this->input->post('password'),
                    'full_name' => $this->input->post('full_name'),
                    'fb_id'     => $this->input->post('fb_id'),
                    'paypal_email' => $this->input->post('email'),
                );

                if ($user_id = $this->user_model->insert($data))
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
                    $id_val = $this->input->post('email');
                    $activation_code = $this->user_model->deactivate($id_val);
                    $activate_link   = site_url('activate/'. str_replace('@', ':', $this->input->post('email')) .'/'. $activation_code);
                    $subject         =  lang('us_email_subj_activate');
                    
                    $email_message_data = array(
                        'title' => $site_title,
                        'code'  => $activation_code,
                        'link'  => $activate_link
                    );
                    $email_mess = $this->load->view('_emails/activate', $email_message_data, true);
                    $message   .= lang('us_check_activate_email');

                    // Now send the email
                    $this->load->library('emailer');
                    $data = array(
                        'to'        => $_POST['email'],
                        'subject'    => $subject,
                        'message'    => $email_mess
                    );
                    
                    if (!$this->emailer->send($data))
                    {
                        $message .= lang('us_err_no_email'). $this->emailer->errors;
                        $error    = true;
                    }

                    if ($error)
                    {
                        $type = 'error';
                    }
                    else
                    {
                        $type = 'success';
                    }

                    Template::set_message($message, $type);

                    Template::redirect('login');
                }
                else
                {
                    Template::set_message(lang('us_registration_fail'), 'danger');
                    redirect('/register');
                }//end if
            }//end if
        }//end if
    }
}//end Users

/* Front-end Users Controller */
/* End of file users.php */
/* Location: ./application/core_modules/users/controllers/users.php */

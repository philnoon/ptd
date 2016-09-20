<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller
{

	//--------------------------------------------------------------------

	/**
	 * Setup the required permissions
	 *
	 * @return void
	 */
	public function __construct()
    {
		parent::__construct();
        
        $this->base_uri = 'users/index';
        $this->top_menu_item = 'users';
        
		$this->lang->load('users');

	}//end __construct()

	//--------------------------------------------------------------------

	/*
	 * Display the user list and manage the user deletions/banning/purge
	 *
	 * @access public
	 *
	 * @return  void
	 */
	public function index($offset=0)
	{
		// Do we have any actions?
		$action = $this->input->post('submit').$this->input->post('delete').$this->input->post('purge').$this->input->post('restore').$this->input->post('activate').$this->input->post('deactivate');

		if (!empty($action))
		{
			$checked = $this->input->post('checked');

			if (!empty($checked))
			{
				foreach($checked as $user_id)
				{
					switch(strtolower($action))
					{
						case 'activate':
							$this->_activate($user_id);
							break;
						case 'deactivate':
							$this->_deactivate($user_id);
							break;
						case 'delete':
							$this->_delete($user_id);
							break;
						case 'restore':
							$this->_restore($user_id);
							break;
					}
				}
			}
			else
			{
				Template::set_message(lang('us_empty_id'), 'danger');
			}
		}

		$where = array();
		$show_deleted = FALSE;

		// Filters
		$filter = $this->input->get('filter');
		switch($filter)
		{
			case 'inactive':
				$where['users.active'] = 0;
				break;
			case 'deleted':
				$where['users.deleted'] = 1;
				$show_deleted = TRUE;
				break;
            case 'role':
                $role_id = $this->input->get('role_id');
                $where['users.user_type'] = $role_id;

                Template::set('filter_role', get_user_type_name($role_id));
                break;
			default:
				$where['users.deleted'] = 0;
				$this->user_model->where('users.deleted', 0);
				break;
		}

		$this->user_model->limit($this->limit, $offset)->where($where);
		$this->user_model->select('users.id, full_name, user_type, email, last_login, active, users.deleted');

		Template::set('users', $this->user_model->find_all($show_deleted));

		// Pagination
		$this->load->library('pagination');

		$this->user_model->where($where);
		$total_users = $this->user_model->count_all();

        $this->setup_pagination($total_users);
		
		Template::set('total_users', $total_users);
		Template::set('current_url', current_url());
        Template::set('filter', $filter);

		Template::set('toolbar_title', lang('us_user_management'));
        $this->set_view('users/index');
		$this->render();

	}//end index()

	//--------------------------------------------------------------------

	/**
	 * Manage creating a new user
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function create()
	{
		if ($this->input->post('submit'))
		{
			if ($id = $this->save_user('insert', NULL, $meta_fields))
			{
                Template::set_message(lang('us_user_created_success'), 'success');
				Template::redirect(SITE_AREA .'/settings/users');
			}
		}

		Template::set('toolbar_title', lang('us_create_user'));
		Template::set_view('settings/user_form');
		Template::render();

	}//end create()

	//--------------------------------------------------------------------

	/**
	 * Edit a user
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function edit($user_id='')
	{
		// if there is no id passed in edit the current user
		// this is so we don't have to pass the user id in the url for editing the current users profile
		if (empty($user_id))
		{
			$user_id = $this->current_user->id;
		}

		if (empty($user_id))
		{
			Template::set_message(lang('us_empty_id'), 'danger');
			redirect(admin_url('users'));
		}
        
		if ($this->input->post('submit'))
		{
			if ($this->save_user('update', $user_id))
			{
                Template::set_message(lang('us_user_update_success'), 'success');

				// redirect back to the edit page to make sure that a users password change
				// forces a login check
				Template::redirect($this->uri->uri_string());
			}
		}

        $user = $this->user_model->find($user_id);
		if (isset($user))
		{
			Template::set('user', $user);
		}
		else
		{
			redirect('admin/users');
		}

        Template::set('toolbar_title', lang('us_edit_user'));
		$this->set_view('users/user_form');
		$this->render();

	}//end edit()

	//--------------------------------------------------------------------

	/**
	 * Delete a user or group of users
	 *
	 * @access private
	 *
	 * @param int $id User to delete
	 *
	 * @return void
	 */
	private function _delete($id)
	{
		$user = $this->user_model->find($id);
		//isset($user) && has_permission('Permissions.'.$user->role_name.'.a') &&
		if ( $user->id != $this->current_user->id)
		{
			if ($this->user_model->delete($id))
			{
				Template::set_message(lang('us_action_deleted'), 'success');
			}
			else
			{
				Template::set_message(lang('us_action_not_deleted'). $this->user_model->error, 'danger');
			}
		}
		else
		{
			if ($user->id == $this->current_user->id)
			{
				Template::set_message(lang('us_self_delete'), 'danger');
			}
			else
			{
				Template::set_message(sprintf(lang('us_unauthorized'),$user->role_name), 'danger');
			}
		}//end if

	}//end _delete()

	//--------------------------------------------------------------------

	/**
	 * Restore the deleted user
	 *
	 * @access private
	 *
	 * @return void
	 */
	private function _restore($id)
	{
		if ($this->user_model->update($id, array('users.deleted'=>0)))
		{
			Template::set_message(lang('us_user_restored_success'), 'success');
		}
		else
		{
			Template::set_message(lang('us_user_restored_error'). $this->user_model->error, 'danger');
		}

	}//end restore()

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save the user
	 *
	 * @access private
	 *
	 * @param string $type          The type of operation (insert or edit)
	 * @param int    $id            The id of the user in the case of an edit operation
	 * @param array  $meta_fields   Array of meta fields fur the user
	 * @param string $cur_role_name The current role for the user being edited
	 *
	 * @return bool
	 */
	private function save_user($type='insert', $id=0)
	{

		if ($type == 'insert')
		{
			$this->form_validation->set_rules('email', lang('bf_email'), 'required|trim|unique[users.email]|valid_email|max_length[120]|xss_clean');
			$this->form_validation->set_rules('password', lang('bf_password'), 'required|trim|strip_tags|min_length[8]|max_length[120]|valid_password|xss_clean');
			$this->form_validation->set_rules('pass_confirm', lang('bf_password_confirm'), 'required|trim|strip_tags|matches[password]|xss_clean');
		}
		else
		{
			$_POST['id'] = $id;
			$this->form_validation->set_rules('email', lang('bf_email'), 'required|trim|unique[users.email,users.id]|valid_email|max_length[120]|xss_clean');
			$this->form_validation->set_rules('password', lang('bf_password'), 'trim|strip_tags|min_length[8]|max_length[120]|valid_password|matches[pass_confirm]|xss_clean');
			$this->form_validation->set_rules('pass_confirm', lang('bf_password_confirm'), 'trim|strip_tags|xss_clean');
		}

		$use_usernames = $this->settings_lib->item('auth.use_usernames');

		if ($use_usernames)
		{
			$extra_unique_rule = $type == 'update' ? ',users.id' : '';

			$this->form_validation->set_rules('username', lang('bf_username'), 'required|trim|strip_tags|max_length[30]|unique[users.username'.$extra_unique_rule.']|xss_clean');
		}

		$this->form_validation->set_rules('full_name', lang('bf_full_name'), 'trim|strip_tags|max_length[255]|xss_clean');

		if ($this->form_validation->run($this) === FALSE)
		{
			return FALSE;
		}

		// Compile our core user elements to save.
		$data = array(
			'email'		=> $this->input->post('email'),
			'username'	=> $this->input->post('username'),
			'language'	=> $this->input->post('language'),
			'timezone'	=> $this->input->post('timezones'),
		);

		if ($this->input->post('password'))
		{
			$data['password'] = $this->input->post('password');
		}

		if ($this->input->post('pass_confirm'))
		{
			$data['pass_confirm'] = $this->input->post('pass_confirm');
		}

		if ($this->input->post('role_id'))
		{
			$data['role_id'] = $this->input->post('role_id');
		}

		if ($this->input->post('restore'))
		{
			$data['deleted'] = 0;
		}

		if ($this->input->post('unban'))
		{
			$data['banned'] = 0;
		}

		if ($this->input->post('full_name'))
		{
			$data['full_name'] = $this->input->post('full_name');
		}

		// Activation
		if ($this->input->post('activate'))
		{
			$data['active'] = 1;
		}
		else if ($this->input->post('deactivate'))
		{
			$data['active'] = 0;
		}

		if ($type == 'insert')
		{
			$activation_method = $this->settings_lib->item('auth.user_activation_method');

			// No activation method
			if ($activation_method == 0)
			{
				// Activate the user automatically
				$data['active'] = 1;
			}

			$return = $this->user_model->insert($data);
		}
		else	// Update
		{
			$return = $this->user_model->update($id, $data);
		}

		// Any modules needing to save data?
		Events::trigger('save_user', $this->input->post());

		return $return;

	}//end save_user()

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// ACTIVATION METHODS
	//--------------------------------------------------------------------
	/**
	 * Activates selected users accounts.
	 *
	 * @access private
	 *
	 * @param int $user_id
	 *
	 * @return void
	 */
	private function _activate($user_id)
	{
		$this->user_status($user_id,1,0);

	}//end _activate()

	//--------------------------------------------------------------------
	/**
	 * Deactivates selected users accounts.
	 *
	 * @access private
	 *
	 * @param int $user_id
	 *
	 * @return void
	 */
	private function _deactivate($user_id)
	{
		$this->user_status($user_id,0,0);

	}//end _deactivate()

	//--------------------------------------------------------------------

	/**
	 * Activates or deavtivates a user from the users dashboard.
	 * Redirects to /settings/users on completion.
	 *
	 * @access private
	 *
	 * @param int $user_id       User ID int
	 * @param int $status        1 = Activate, -1 = Deactivate
	 * @param int $supress_email 1 = Supress, All others = send email
	 *
	 * @return void
	 */
	private function user_status($user_id = false, $status = 1, $supress_email = 0)
	{
		$supress_email = (isset($supress_email) && $supress_email == 1 ? true : false);

		if ($user_id !== false && $user_id != -1)
		{
			$result = false;
			$type = '';
			if ($status == 1)
			{
				$result = $this->user_model->admin_activation($user_id);
				$type = lang('bf_action_activate');
			}
			else
			{
				$result = $this->user_model->admin_deactivation($user_id);
                $type = lang('bf_action_deactivate');
			}

			$user = $this->user_model->find($user_id);
			if ($result)
			{
				$message = lang('us_active_status_changed');
				if (!$supress_email)
				{
					// Now send the email
					$this->load->library('emailer');

					$settings = $this->settings_lib->find_by('name','site.title');

					$data = array
					(
						'to'		=> $this->user_model->find($user_id)->email,
						'subject'	=> lang('us_account_active'),
					);
                    
                    if($status == 1)
                    {
                        $data['message'] = $this->load->view('_emails/activated', array('link'=>site_url(),'title'=>$settings->value), true);
                    }
                    else
                    {
                        $data['message'] = $this->load->view('_emails/deactivated', array('link'=>site_url(),'title'=>$settings->value), true);
                    }

					if ($this->emailer->send($data))
					{
						$message = lang('us_active_email_sent');
					}
					else
					{
						$message=lang('us_err_no_email'). $this->emailer->errors;
					}
				}
				Template::set_message($message, 'success');
			}
			else
			{
				Template::set_message(lang('us_err_status_error').$this->user_model->error,'error');
			}//end if
		}
		else
		{
			Template::set_message(lang('us_err_no_id'),'error');
		}//end if
        
		Template::redirect(admin_url('users'));

	}//end user_status()

	//--------------------------------------------------------------------

}//end Settings

// End of Admin User Controller
/* End of file settings.php */
/* Location: ./application/core_modules/controllers/settings.php */

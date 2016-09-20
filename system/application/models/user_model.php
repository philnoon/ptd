<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends BF_Model
{

	/**
	 * Name of the table
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Use soft deletes or not
	 *
	 * @access protected
	 *
	 * @var bool
	 */
	protected $soft_deletes = TRUE;

	/**
	 * The date format to use
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $date_format = 'datetime';

	//--------------------------------------------------------------------
    protected $created_field = 'created_at';
    protected $modified_field = 'updated_at';
    
    
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Creates a new user in the database.
	 *
	 * Required parameters sent in the $data array:
	 * * password
	 * * A unique email address
	 *
	 * If no _role_id_ is passed in the $data array, it will assign the default role from <Roles> model.
	 *
	 * @access public
	 *
	 * @param array $data An array of user information.
	 *
	 * @return bool|int The ID of the new user.
	 */
	public function insert($data=array())
	{
		if (!$this->_function_check(FALSE, $data))
		{
			return FALSE;
		}

		if (!isset($data['password']) || empty($data['password']))
		{
			$this->error = lang('us_no_password');
			return FALSE;
		}

		if (!isset($data['email']) || empty($data['email']))
		{
			$this->error = lang('us_no_email');
			return FALSE;
		}

		// Is this a unique email?
		if ($this->is_unique('email', $data['email']) == FALSE)
		{
			$this->error = lang('us_email_taken');
			return FALSE;
		}

		// Display Name
		if (!isset($data['full_name']) || (isset($data['full_name']) && empty($data['full_name'])))
		{
		    $data['full_name'] = $data['email'];
		}

		list($password, $salt) = $this->hash_password($data['password']);

		unset($data['password'], $data['pass_confirm'], $data['submit']);

		$data['password_hash'] = $password;
		$data['salt'] = $salt;

		$id = parent::insert($data);
        
        return $id;

	}//end insert()
	
	public function insertactivate($id=null, $data=array())
	{
		
		$return = parent::update($id, $data);
        
        return $id;

	}//end insert()

	//--------------------------------------------------------------------

	/**
	 * Updates an existing user. Before saving, it will:
	 * * generate a new password/salt combo if both password and pass_confirm are passed in.
	 * * store the country code
	 *
	 * @access public
	 *
	 * @param int   $id   An INT with the user's ID.
	 * @param array $data An array of key/value pairs to update for the user.
	 *
	 * @return bool TRUE/FALSE
	 */
	public function update($id=null, $data=array())
	{
		if (empty($data['pass_confirm']) && isset($data['password']))
		{
			unset($data['pass_confirm'], $data['password']);
		}
		else if (!empty($data['password']) && !empty($data['pass_confirm']) && $data['password'] == $data['pass_confirm'])
		{
			list($password, $salt) = $this->hash_password($data['password']);

			unset($data['password'], $data['pass_confirm']);

			$data['password_hash'] = $password;
			$data['salt'] = $salt;
		}

		$return = parent::update($id, $data);

		return $return;

	}//end update()

	//--------------------------------------------------------------------

	/**
	 * Returns all user records, and their associated role information.
	 *
	 * @access public
	 *
	 * @param bool $show_deleted If FALSE, will only return non-deleted users. If TRUE, will return both deleted and non-deleted users.
	 *
	 * @return bool An array of objects with each user's information.
	 */
	public function find_all($show_deleted=FALSE)
	{
		if ($show_deleted === FALSE)
		{
			$this->db->where('users.deleted', 0);
		}

		return parent::find_all();

	}//end find_all()

	//--------------------------------------------------------------------

	/**
	 * Counts all users in the system.
	 *
	 * @access public
	 *
	 * @param bool $get_deleted If FALSE, will only return active users. If TRUE, will return both deleted and active users.
	 *
	 * @return int An INT with the number of users found.
	 */
	public function count_all($get_deleted = FALSE)
	{
		if ($get_deleted)
		{
			// Get only the deleted users
			$this->db->where('users.deleted !=', 0);
		}
		else
		{
			$this->db->where('users.deleted', 0);
		}

		return $this->db->count_all_results('users');

	}//end count_all()

	//--------------------------------------------------------------------

	/**
	 * Performs a standard delete, but also allows for purging of a record.
	 *
	 * @access public
	 *
	 * @param int  $id    An INT with the record ID to delete.
	 * @param bool $purge If FALSE, will perform a soft-delete. If TRUE, will permanently delete the record.
	 *
	 * @return bool TRUE/FALSE
	 */
	public function delete($id=0, $purge=FALSE)
	{
		if ($purge === TRUE)
		{
			// temporarily set the soft_deletes to TRUE.
			$this->soft_deletes = FALSE;
		}

		return parent::delete($id);

	}//end delete()

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !AUTH HELPER METHODS
	//--------------------------------------------------------------------

	/**
	 * Generates a new salt and password hash for the given password.
	 *
	 * @access public
	 *
	 * @param string $old The password to hash.
	 *
	 * @return array An array with the hashed password and new salt.
	 */
	public function hash_password($old='')
	{
		if (!function_exists('do_hash'))
		{
			$this->load->helper('security');
		}

		$salt = $this->generate_salt();
		$pass = do_hash($salt . $old);

		return array($pass, $salt);

	}//end hash_password()

	//--------------------------------------------------------------------

	/**
	 * Create a salt to be used for the passwords
	 *
	 * @access private
	 *
	 * @return string A random string of 7 characters
	 */
	private function generate_salt()
	{
		if (!function_exists('random_string'))
		{
			$this->load->helper('string');
		}

		return random_string('alnum', 7);

	}//end generate_salt()

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !HMVC METHOD HELPERS
	//--------------------------------------------------------------------

	/**
	 * Returns the most recent login attempts and their description.
	 *
	 * @access public
	 *
	 * @param int $limit An INT which is the number of results to return.
	 *
	 * @return bool|array An array of objects with the login information.
	 */
	public function get_login_attempts($limit=15)
	{
		$this->db->limit($limit);
		$this->db->order_by('login', 'desc');
		$query = $this->db->get('login_attempts');

		if ($query->num_rows())
		{
			return $query->result();
		}

		return FALSE;

	}//end get_login_attempts()

	//--------------------------------------------------------------------
	// !ACTIVATION
	//--------------------------------------------------------------------

	/**
	 * Count Inactive users.
	 *
	 * @access public
	 *
	 * @return int Inactive user count.
	 */
	public function count_inactive_users()
	{
        $this->db->where('active',-1);
        return $this->count_all(FALSE);

    }//end count_inactive_users()


	/**
	 * Accepts an activation code and validates is against a matching entry int eh database.
	 *
	 * There are some instances where we want to remove the activation hash yet leave the user
	 * inactive (Admin Activation scenario), so leave_inactive handles this use case.
	 *
	 * @access public
	 *
	 * @param string $email          The email address to be verified
	 * @param string $code           The activation code to be verified
	 * @param bool   $leave_inactive Flag whether to remove the activate hash value, but leave active = 0
	 *
	 * @return int User Id on success, FALSE on error
	 */
	public function activate($email = FALSE, $code = FALSE, $leave_inactive = FALSE)
	{

		if ($code === FALSE)
		{
	        $this->error = lang('us_err_no_activate_code');
			return FALSE;
	    }

		if (!empty($email))
		{
			$this->db->where('email', $email);
		}

	    $query = $this->db->select('id')
               	      ->where('activate_hash', $code)
               	      ->limit(1)
               	      ->get($this->table);

		if ($query->num_rows() !== 1)
		{
		    $this->error = lang('us_err_no_matching_code');
	        return FALSE;
		}

	    $result = $query->row();
		$active = ($leave_inactive === FALSE) ? 1 : 0;
		if ($this->update($result->id, array('activate_hash' => '','active' => $active)))
		{
			return $result->id;
		}

	}//end activate()


	/**
	 * This function is triggered during account set up to assure user is not active and,
	 * if not supressed, generate an activation hash code. This function can be used to
	 * deactivate accounts based on public view events.
	 *
	 * @param int    $user_id    The email to match to deactivate
	 * @param string $login_type Login Method
	 * @param bool   $make_hash  Create a hash
	 *
	 * @return mixed $activate_hash on success, FALSE on error
	 */
	public function deactivate($user_id = FALSE, $make_hash = TRUE)
	{
	    if ($user_id === FALSE)
		{
	        return FALSE;
	    }

		// create a temp activation code.
        $activate_hash = '';
		if ($make_hash === true)
		{
			$this->load->helpers(array('string', 'security'));
			$activate_hash = do_hash(random_string('alnum', 40) . time());
		}

		$this->update($user_id, array('active'=>0, 'activate_hash' => $activate_hash));
		
        
        return ($this->db->affected_rows() == 1) ? $activate_hash : FALSE;
	}//end deactivate()


	/**
	 * Admin specific activation function for admin approvals or re-activation.
	 *
	 * @access public
	 *
	 * @param int $user_id The user ID to activate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function admin_activation($user_id = FALSE)
	{

		if ($user_id === FALSE)
		{
			$this->error = lang('us_err_no_id');
	        return FALSE;
	    }

		$query = $this->db->select('id')
               	      ->where('id', $user_id)
               	      ->limit(1)
               	      ->get($this->table);

		if ($query->num_rows() !== 1)
		{
		    $this->error = lang('us_err_no_matching_id');
	        return FALSE;
		}

		$result = $query->row();
		$this->update($result->id, array('activate_hash' => '','active' => 1));

		if ($this->db->affected_rows() > 0)
		{
			return $result->id;
		}
		else
		{
			$this->error = lang('us_err_user_is_active');
			return FALSE;
		}

	}//end admin_activation()


	/**
	 * Admin only deactivation function.
	 *
	 * @access public
	 *
	 * @param int $user_id The user ID to deactivate
	 *
	 * @return bool TRUE on success, FALSE on error
	 */
	public function admin_deactivation($user_id = FALSE)
	{
		if ($user_id === FALSE)
		{
			$this->error = lang('us_err_no_id');
	        return FALSE;
	    }

		if ($this->deactivate($user_id, FALSE))
		{
			return $user_id;
		}
		else
		{
			$this->error = lang('us_err_user_is_inactive');
			return FALSE;
		}

	}//end admin_deactivation()

	//--------------------------------------------------------------------

}//end User_model
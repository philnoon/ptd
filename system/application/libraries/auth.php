<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{

	/**
	 * An array of errors generated.
	 *
	 * @access public
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 * Stores the logged in value after the first test to improve performance.
	 *
	 * @access private
	 *
	 * @var NULL
	 */
	private $logged_in = NULL;

	/**
	 * Stores the ip_address of the current user for performance reasons.
	 *
	 * @access private
	 *
	 * @var string
	 */
	private $ip_address;

	/**
	 * A pointer to the CodeIgniter instance.
	 *
	 * @access private
	 *
	 * @var object
	 */
	private $ci;

    public $login_dest = '';
	//--------------------------------------------------------------------

	/**
	 * Grabs a pointer to the CI instance, gets the user's IP address,
	 * and attempts to automatically log in the user.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->ci =& get_instance();

		$this->ip_address = $this->ci->input->ip_address();

		// We need the users language file for this to work
		// from other modules.
		$this->ci->lang->load('users');

		log_message('debug', 'Auth class initialized.');

		if (!class_exists('CI_Session'))
		{
			$this->ci->load->library('session');
		}

		// Try to log the user in from session/cookie data
		$this->autologin();

	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Attempt to log the user in.
	 *
	 * @access public
	 *
	 * @param string $login    The user's login credentials (email/username)
	 * @param string $password The user's password
	 * @param bool   $remember Whether the user should be remembered in the system.
	 *
	 * @return bool
	 */
	public function login($login=NULL, $password=NULL, $remember=FALSE)
	{
		if (empty($login) || empty($password))
		{
			$error = lang('bf_email');
			Template::set_message(sprintf(lang('us_fields_required'), $error), 'danger');
			return FALSE;
		}

		if (!class_exists('User_model'))
		{
			$this->ci->load->model('user_model');
		}

		// Grab the user from the db
		$selects = 'id, user_type, email, salt, password_hash, users.deleted, users.active';
        $user = $this->ci->user_model->select($selects)->find_by('email', $login);

		// check to see if a value of FALSE came back, meaning that the username or email or password doesn't exist.
		if($user == FALSE)
		{
			Template::set_message(lang('us_bad_email_pass'), 'danger');
			return FALSE;
		}

		if (is_array($user))
		{
			$user = $user[0];
		}

		// check if the account has been activated.
		if ($user->active == 0) // in case we go to a unix timestamp later, this will still work.
		{
		    Template::set_message(lang('us_account_not_active'), 'danger');
			return FALSE;
		}

		// check if the account has been soft deleted.
		if ($user->deleted >= 1) // in case we go to a unix timestamp later, this will still work.
		{
			Template::set_message(sprintf(lang('us_account_deleted'), settings_item("site.system_email")), 'danger');
			return FALSE;
		}

		if ($user)
		{
			// Validate the password
			if (!function_exists('do_hash'))
			{
				$this->ci->load->helper('security');
			}

			// Try password
			if (do_hash($user->salt . $password) == $user->password_hash)
			{
				$this->clear_login_attempts($login);

				// We've successfully validated the login, so setup the session
				$this->setup_session($user->id, $user->email, $user->password_hash, $remember,'');

				// Save the login info
				$data = array(
					'last_login'			=> date('Y-m-d H:i:s', time()),
					'last_ip'				=> $this->ip_address,
				);
				$this->ci->user_model->update($user->id, $data);

                //save our redirect location
                if($user->user_type == USER_ADMIN) $this->login_dest = 'admin';
                
				return TRUE;
			}

			// Bad password
			else
			{
				Template::set_message(lang('us_bad_email_pass'), 'danger');
				$this->increase_login_attempts($login);
			}
		}
		else
		{
			Template::set_message(lang('us_bad_email_pass'), 'danger');
		}//end if

		return FALSE;

	}//end login()

	//--------------------------------------------------------------------

	/**
	 * Destroys the autologin information and the current session.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function logout()
	{
		$data = array(
			'user_id'	=> $this->user_id(),
		);

		// Destroy the autologin information
		$this->delete_autologin();

		// Destroy the session
		$this->ci->session->sess_destroy();

	}//end logout()

	//--------------------------------------------------------------------

	/**
	 * Checks the session for the required info, then verifies against the database.
	 *
	 * @access public
	 *
	 * @return bool|NULL
	 */
	public function is_logged_in()
	{
		// If we've already checked this session,
		// return that.
		if (!is_null($this->logged_in))
		{
			return $this->logged_in;
		}

		if (!class_exists('CI_Session'))
		{
			$this->ci->load->library('session');
		}

		// Is there any session data we can use?
		if ($this->ci->session->userdata('identity') && $this->ci->session->userdata('user_id'))
		{
			// Grab the user account
			$user = $this->ci->user_model->select('id, email, salt, password_hash')->find($this->ci->session->userdata('user_id'));

			if ($user !== FALSE)
			{
				if (!function_exists('do_hash'))
				{
					$this->ci->load->helper('security');
				}

				// Ensure user_token is still equivalent to the SHA1 of the user_id and password_hash
				if (do_hash($this->ci->session->userdata('user_id') . $user->password_hash) === $this->ci->session->userdata('user_token'))
				{
					$this->logged_in = TRUE;
					return TRUE;
				}
			}
		}//end if

		$this->logged_in = FALSE;
		return FALSE;

	}//end is_logged_in()

	//--------------------------------------------------------------------

	/**
	 * Checks that a user is logged in (and, optionally of the correct role)
	 * and, if not, send them to the login screen.
	 *
	 * If no permission is checked, will simply verify that the user is logged in.
	 * If a permission is passed in to the first parameter, will check the user's role
	 * and verify that role has the appropriate permission.
	 *
	 * @access public
	 *
	 * @param string $permission (Optional) A string representing the permission to check for.
	 * @param string $uri        (Optional) A string representing an URI to redirect, if FALSE
	 *
	 * @return bool TRUE if the user has the appropriate access permissions. Redirect to the previous page if the user doesn't have permissions. Redirect '/login' page if the user is not logged in.
	 */
	public function restrict($permission=NULL, $uri=NULL)
	{
		// If user isn't logged in, don't need to check permissions
		if ($this->is_logged_in() === FALSE)
		{
			$this->logout();
			Template::set_message($this->ci->lang->line('us_must_login'), 'danger');
			Template::redirect('login');
		}

		// Check to see if the user has the proper permissions
		if (!empty($permission) && !$this->has_permission($permission))
		{
			// set message telling them no permission THEN redirect
			Template::set_message( lang('us_no_permission'), 'attention');

			if ($uri)
			{
				Template::redirect($uri);
			}
			else
			{
				Template::redirect($this->ci->session->userdata('previous_page'));
			}
		}

		return TRUE;

	}//end restrict()

	//--------------------------------------------------------------------



	//--------------------------------------------------------------------
	// !UTILITY METHODS
	//--------------------------------------------------------------------

	/**
	 * Retrieves the user_id from the current session.
	 *
	 * @access public
	 *
	 * @return int
	 */
	public function user_id()
	{
		return (int) $this->ci->session->userdata('user_id');

	}//end user_id()

	//--------------------------------------------------------------------

	/**
	 * Retrieves the logged identity from the current session.
	 * Built from the user's submitted login.
	 *
	 * @access public
	 *
	 * @return string The identity used to login.
	 */
	public function identity()
	{
		return $this->ci->session->userdata('identity');

	}//end identity()

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !LOGIN ATTEMPTS
	//--------------------------------------------------------------------

	/**
	 * Records a login attempt into the database.
	 *
	 * @access protected
	 *
	 * @param string $login The login id used (typically email or username)
	 *
	 * @return void
	 */
	protected function increase_login_attempts($login=NULL)
	{
		if (empty($this->ip_address) || empty($login))
		{
			return;
		}

		$this->ci->db->insert('login_attempts', array('ip_address' => $this->ip_address, 'login' => $login));

	}//end increase_login_attempts()

	//--------------------------------------------------------------------

	/**
	 * Clears all login attempts for this user, as well as cleans out old logins.
	 *
	 * @access protected
	 *
	 * @param string $login   The login credentials (typically email)
	 * @param int    $expires The time (in seconds) that attempts older than will be deleted
	 *
	 * @return void
	 */
	protected function clear_login_attempts($login=NULL, $expires = 86400)
	{
		if (empty($this->ip_address) || empty($login))
		{
			return;
		}

		$this->ci->db->where(array('ip_address' => $this->ip_address, 'login' => $login));

		// Purge obsolete login attempts
		$this->ci->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expires);

		$this->ci->db->delete('login_attempts');

	}//end clear_login_attempts()

	//--------------------------------------------------------------------

	/**
	 * Get number of attempts to login occurred from given IP-address and/or login
	 *
	 * @param null $login (Optional) The login id to check for (email/username). If no login is passed in, it will only check against the IP Address of the current user.
	 *
	 * @return int An int with the number of attempts.
	 */
	function num_login_attempts($login=NULL)
	{
		$this->ci->db->select('1', FALSE);
		$this->ci->db->where('ip_address', $this->ip_address);
		if (strlen($login) > 0) $this->ci->db->or_where('login', $login);

		$query = $this->ci->db->get('login_attempts');
		return $query->num_rows();

	}//end num_login_attempts()

	//--------------------------------------------------------------------
	// !AUTO-LOGIN
	//--------------------------------------------------------------------

	/**
	 * Attempts to log the user in based on an existing 'autologin' cookie.
	 *
	 * @access private
	 *
	 * @return void
	 */
	private function autologin()
	{
		if ($this->ci->settings_lib->item('auth.allow_remember') == FALSE)
		{
			return;
		}

		$this->ci->load->helper('cookie');

		$cookie = get_cookie('autologin', TRUE);

		if (!$cookie) {	return;	}

		// We have a cookie, so split it into user_id and token
		list($user_id, $test_token) = explode('~', $cookie);

		// Try to pull a match from the database
		$this->ci->db->where( array('user_id' => $user_id, 'token' => $test_token) );
		$query = $this->ci->db->get('user_cookies');

		if ($query->num_rows() == 1)
		{
			// Save logged in status to save on db access later.
			$this->logged_in = TRUE;

			// If a session doesn't exist, we need to refresh our autologin token
			// and get the session started.
			if (!$this->ci->session->userdata('user_id'))
			{
				// Grab the current user info for the session
				$this->ci->load->model('user_model');
				$user = $this->ci->user_model->select('id, email, password_hash')->find($user_id);

				if (!$user) { return; }

				$this->setup_session($user->id, $user->email, $user->password_hash, TRUE, $test_token);
			}
		}

		unset($query, $user);

	}//end autologin()

	//--------------------------------------------------------------------


	/**
	 * Create the auto-login entry in the database. This method uses
	 * Charles Miller's thoughts at:
	 * http://fishbowl.pastiche.org/2004/01/19/persistent_login_cookie_best_practice/
	 *
	 * @access private
	 *
	 * @param int    $user_id    An int representing the user_id.
	 * @param string $old_token The previous token that was used to login with.
	 *
	 * @return bool Whether the autologin was created or not.
	 */
	private function create_autologin($user_id=0, $old_token=NULL)
	{
		if (empty($user_id) || $this->ci->settings_lib->item('auth.allow_remember') == FALSE)
		{
			return FALSE;
		}

		// Generate a random string for our token
		if (!function_exists('random_string')) { $this->load->helper('string'); }

		$token = random_string('alnum', 128);

		// If an old_token is presented, we're refreshing the autologin information
		// otherwise we're creating a new one.
		if (empty($old_token))
		{
			// Create a new token
			$data = array(
				'user_id'		=> $user_id,
				'token'			=> $token,
				'created_on'	=> date('Y-m-d H:i:s')
			);
			$this->ci->db->insert('user_cookies', $data);
		}
		else
		{
			// Refresh the token
			$this->ci->db->where('user_id', $user_id);
			$this->ci->db->where('token', $old_token);
			$this->ci->db->set('token', $token);
			$this->ci->db->set('created_on', date('Y-m-d H:i:s'));
			$this->ci->db->update('user_cookies');
		}

		if ($this->ci->db->affected_rows())
		{
			// Create the autologin cookie
			$this->ci->input->set_cookie('autologin', $user_id .'~'. $token, $this->ci->settings_lib->item('auth.remember_length'));

			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}//end create_autologin()()

	//--------------------------------------------------------------------

	/**
	 * Deletes the autologin cookie for the current user.
	 *
	 * @access private
	 *
	 * @return void
	 */
	private function delete_autologin()
	{
		if ($this->ci->settings_lib->item('auth.allow_remember') == FALSE)
		{
			return;
		}

		// First things first.. grab the cookie so we know what row
		// in the user_cookies table to delete.
		if (!function_exists('delete_cookie'))
		{
			$this->ci->load->helper('cookie');
		}

		$cookie = get_cookie('autologin');
		if ($cookie)
		{
			list($user_id, $token) = explode('~', $cookie);

			// Now we can delete the cookie
			delete_cookie('autologin');

			// And clean up the database
			$this->ci->db->where('user_id', $user_id);
			$this->ci->db->where('token', $token);
			$this->ci->db->delete('user_cookies');
		}

		// Also perform a clean up of any autologins older than 2 months
		$this->ci->db->where('created_on', '< DATE_SUB(CURDATE(), INTERVAL 2 MONTH)');
		$this->ci->db->delete('user_cookies');

	}//end delete_autologin()

	//--------------------------------------------------------------------

	/**
	 * Creates the session information for the current user. Will also create an autologin cookie if required.
	 *
	 * @access private
	 *
	 * @param int $user_id          An int with the user's id
     * @param string $email         The user's email address
     * @param string $password_hash The user's password hash. Used to create a new, unique user_token.
	 * @param bool   $remember      A boolean (TRUE/FALSE). Whether to keep the user logged in.
	 * @param string $old_token     User's db token to test against
	 * @param string $user_name     User's made name for displaying options
	 *
	 * @return bool TRUE/FALSE on success/failure.
	 */
	private function setup_session($user_id=0, $email='', $password_hash=NULL, $remember=FALSE, $old_token=NULL)
	{

		if (empty($user_id) || (empty($email) ))
		{
			return FALSE;
		}

		// What are we using as login identity?
		//Should I use _identity_login() and move bellow code?
        $login = $email;

		// Save the user's session info
		if (!class_exists('CI_Session'))
		{
			$this->ci->load->library('session');
		}

		if (!function_exists('do_hash'))
		{
			$this->ci->load->helper('security');
		}

		$data = array(
			'user_id'		=> $user_id,
			'user_token'	=> do_hash($user_id . $password_hash),
			'identity'		=> $login,
			'logged_in'		=> TRUE,
		);

		$this->ci->session->set_userdata($data);

		// Should we remember the user?
		if ($remember === TRUE)
		{
			return $this->create_autologin($user_id, $old_token);
		}

		return TRUE;

	}//end setup_session

	//--------------------------------------------------------------------

	/**
	 * Returns the identity to be used upon user registration.
	 *
	 * @access private
	 * @todo Decision to be made with this method.
	 *
	 * @return void
	 */
	private function _identity_login()
	{
		//Should I move indentity conditional code from setup_session() here?
		//Or should conditional code be moved to auth->identity(),
		//  and if Optional TRUE is passed, it would then determine wich identity to store in userdata?

	}//end _identity_login()

	//--------------------------------------------------------------------

}//end Auth

//--------------------------------------------------------------------

if (!function_exists('auth_errors'))
{
	/**
	 * A utility function for showing authentication errors.
	 *
	 * @access public
	 *
	 * @return string A string with a <ul> tag of any auth errors, or an empty string if no errors exist.
	 */
	function auth_errors()
	{
		$ci =& get_instance();

		$errors = $ci->auth->errors;

		if (count($errors))
		{
			$str = '<ul>';
			foreach ($errors as $e)
			{
				$str .= "<li>$e</li>";
			}

			$str .= "</ul>";

			return $str;
		}

		return '';

	}//end auth_errors()
}

//--------------------------------------------------------------------

if (!function_exists('abbrev_name'))
{
	/**
	 * Retrieves first and last name from given string.
	 *
	 * @access public
	 *
	 * @param string $name Full name
	 *
	 * @return string The First and Last name from given parameter.
	 */
	function abbrev_name($name = '')
	{
		if (is_string($name))
		{
			list( $fname, $lname ) = explode( ' ', $name, 2 );
			if (is_null($lname)) // Meaning only one name was entered...
			{
				$lastname = ' ';
			}
			else
			{
				$lname = explode( ' ', $lname );
				$size = sizeof($lname);
				$lastname = $lname[$size-1]; //
			}

			return trim($fname.' '.$lastname) ;

		}

		/*
			TODO: Consider an optional parameter for picking custom var session.
				Making it auth private, and using auth custom var
		*/

		return $name;

	}//end abbrev_name()
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller
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
		$this->lang->load('settings');
        $this->lang->load('emailer');
                                  
        $this->top_menu_item = 'settings';

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
		$this->general();
	}//end index()

	//--------------------------------------------------------------------
    public function general()
    {
        if ($this->input->post('submit'))
        {
            if ($this->_save_general_settings())
            {
                Template::set_message(lang('settings_saved_success'), 'success');
                redirect(admin_url('settings'));
            }
            else
            {
                Template::set_message(lang('settings_error_success'), 'error');
            }
        }
        
        // Read our current settings
        $settings = $this->settings_lib->find_all();
        Template::set('settings', $settings);

        $this->sub_menu_item = 'general_setting';
        $this->set_view('settings/general');
        $this->render();
    }
    
    //--------------------------------------------------------------------
    public function paypal()
    {
        if ($this->input->post('submit'))
        {
            if ($this->_save_paypal_settings())
            {
                Template::set_message(lang('settings_saved_success'), 'success');
                redirect(admin_url('settings/paypal'));
            }
            else
            {
                Template::set_message(lang('settings_error_success'), 'error');
            }
        }
        
        // Read our current settings
        $settings = $this->settings_lib->find_all();
        Template::set('settings', $settings);

        $this->sub_menu_item = 'paypal_setting';
        $this->set_view('settings/paypal');
        $this->render();    
    }
    
    //--------------------------------------------------------------------
    public function email()
    {
        if ($this->input->post('submit'))
        {
            $this->form_validation->set_rules('sender_email', 'System Email', 'required|trim|valid_email|max_length[120]|xss_clean');
            $this->form_validation->set_rules('protocol', 'Email Server', 'trim|xss_clean');

            if ($this->input->post('protocol') == 'sendmail')
            {
                $this->form_validation->set_rules('mailpath', 'Sendmail Path', 'required|trim|xss_clean');
            }
            elseif ($this->input->post('protocol') == 'smtp')
            {
                $this->form_validation->set_rules('smtp_host', 'SMTP Server Address', 'required|trim|strip_tags|xss_clean');
                $this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim|strip_tags|xss_clean');
                $this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|strip_tags|matches_pattern[[A-Za-z0-9!@#\%$^&+=]{2,20}]');
                $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|strip_tags|numeric|xss_clean');
                $this->form_validation->set_rules('smtp_timeout', 'SMTP timeout', 'trim|strip_tags|numeric|xss_clean');
            }

            if ($this->form_validation->run() !== FALSE)
            {
                $data = array(
                        array('name' => 'sender_email', 'value' => $this->input->post('sender_email')),
                        array('name' => 'mailtype', 'value' => $this->input->post('mailtype')),
                        array('name' => 'protocol', 'value' => strtolower($_POST['protocol'])),
                        array('name' => 'mailpath', 'value' => $_POST['mailpath']),
                        array('name' => 'smtp_host', 'value' => isset($_POST['smtp_host']) ? $_POST['smtp_host'] : ''),
                        array('name' => 'smtp_user', 'value' => isset($_POST['smtp_user']) ? $_POST['smtp_user'] : ''),
                        array('name' => 'smtp_pass', 'value' => isset($_POST['smtp_pass']) ? $_POST['smtp_pass'] : ''),
                        array('name' => 'smtp_port', 'value' => isset($_POST['smtp_port']) ? $_POST['smtp_port'] : ''),
                        array('name' => 'smtp_timeout', 'value' => isset($_POST['smtp_timeout']) ? $_POST['smtp_timeout'] : '5')
                     );

                $updated = FALSE;
                // save the settings to the db
                $updated = $this->settings_model->update_batch($data, 'name');

                if ($updated)
                {
                    // Success, so reload the page, so they can see their settings
                    Template::set_message('Email settings successfully saved.', 'success');
                    redirect(admin_url('settings/email'));
                }
                else
                {
                    Template::set_message('There was an error saving your settings.', 'error');
                }
            }
            else
            {
                Template::set_message('There was an error saving your settings.', 'error');
            }
        }//end if

        // Load our current settings
        $settings = $this->settings_model->select('name,value')->find_all_by('module', 'email');
        Template::set($settings);

        Assets::add_js('setting_email.js');

        Template::set('toolbar_title', 'Email Settings');
        $this->sub_menu_item = 'email_setting';
        $this->set_view('settings/email');
        $this->render();   
    }
    
    /**
     * Send a test email
     *
     * @access public
     *
     * @return void
     */
    public function email_test()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->security->csrf_show_error();
        }

        $this->load->library('emailer');
        $this->emailer->enable_debug(TRUE);

        $data = array(
                'to'        => $this->input->post('email'),
                'subject'    => lang('em_test_mail_subject'),
                'message'    => lang('em_test_mail_body')
             );

        $results = $this->emailer->send($data, FALSE);
        Template::set('results', $results);
        $this->set_view('settings/email_test');
        $this->render();

    }//end test()
    
	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------
    private function _save_general_settings()
    {
        $this->form_validation->set_rules('title', 'lang:bf_site_name', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('system_email', 'lang:bf_site_email', 'required|trim|strip_tags|valid_email|xss_clean');
        $this->form_validation->set_rules('list_limit','Items <em>p.p.</em>', 'required|trim|strip_tags|numeric|xss_clean');
        $this->form_validation->set_rules('address','Address', 'required|trim|strip_tags');
        $this->form_validation->set_rules('author', 'Autor', 'required|trim|strip_tags');
        $this->form_validation->set_rules('description', 'description', 'required|trim|strip_tags');
        $this->form_validation->set_rules('keywords', 'keywords', 'required|trim|strip_tags');
        $this->form_validation->set_rules('copyright', 'copyright', 'required|trim|strip_tags');

        if ($this->form_validation->run() === FALSE)
        {
            return FALSE;
        }

        $data = array(
            array('name' => 'site.title', 'value' => $this->input->post('title')),
            array('name' => 'site.system_email', 'value' => $this->input->post('system_email')),
            array('name' => 'site.list_limit', 'value' => $this->input->post('list_limit')),
            
            array('name' => 'site.address', 'value' => $this->input->post('address')),
            array('name' => 'site.author', 'value' => $this->input->post('author')),
            array('name' => 'site.description', 'value' => $this->input->post('description')),
            array('name' => 'site.keywords', 'value' => $this->input->post('keywords')),
            array('name' => 'site.copyright', 'value' => $this->input->post('copyright')),
            
        );

        // save the settings to the DB
        $updated = $this->settings_model->update_batch($data, 'name');

        return $updated;    
    }
    
    private function _save_paypal_settings()
    {
        $this->form_validation->set_rules('username', 'username', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('signature','signature', 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('test_mode','test mode', 'trim|strip_tags');

        if ($this->form_validation->run() === FALSE)
        {
            return FALSE;
        }

        $data = array(
            array('name' => 'paypal.username', 'value' => $this->input->post('username')),
            array('name' => 'paypal.password', 'value' => $this->input->post('password')),
            array('name' => 'paypal.signature', 'value' => $this->input->post('signature')),
            array('name' => 'paypal.test_mode', 'value' => $this->input->post('test_mode')),
        );

        // save the settings to the DB
        $updated = $this->settings_model->update_batch($data, 'name');

        return $updated;    
    }
    
}//end Settings()

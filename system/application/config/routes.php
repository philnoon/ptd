<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';
// Authorization
$route['login']					= 'users/login';
$route['logout']				= 'users/logout';
$route['profile']               = 'users/profile';
$route['account']               = 'users/account';
$route['password']              = 'users/password';
$route['register-member']       = 'users/register_member';
$route['register-trainer']      = 'users/register_trainer';
$route['forgot_password']		= 'users/forgot_password';
$route['trainers']				= 'users/trainers';
$route['faq']				= 'users/faq';
$route['reset_password/(:any)/(:any)']	= "users/reset_password/$1/$2";
$route['activate/(:any)/(:any)']        = 'users/activate/$1/$2';
$route[SITE_AREA] = SITE_AREA . '/dashboard';

//$route['admin/users'] = 'admin/users';
//$route['admin/users/(:any)'] = 'admin/users/$1';

// Activation
$route['activate']		        = 'users/activate';
$route['resend_activation']		= 'users/resend_activation';
// Content
$route['how-it-works'] = 'users/how_it_works';
$route['training-safety'] = 'users/training_safety';
$route['pricing'] = 'users/pricing';
$route['rewards'] = 'users/rewards';
$route['contact-us'] = 'users/contact_us';
$route['workout-guide'] = 'users/workout_guide';
$route['nutrition-guide'] = 'users/nutrition_guide';
$route['terms-of-use'] = 'users/terms_of_use';
$route['privacy-policy'] = 'users/privacy_policy';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( session_status() == PHP_SESSION_NONE ) {
  session_start();
}
 
require_once('Facebook/FacebookSession.php');
require_once('Facebook/FacebookRedirectLoginHelper.php');
require_once('Facebook/FacebookRequest.php');
require_once('Facebook/FacebookResponse.php');
require_once('Facebook/FacebookSDKException.php');
require_once('Facebook/FacebookRequestException.php');
require_once('Facebook/FacebookAuthorizationException.php');
require_once('Facebook/GraphObject.php');
require_once('Facebook/HttpClients/FacebookCurl.php');
require_once('Facebook/HttpClients/FacebookHttpable.php');
require_once('Facebook/HttpClients/FacebookCurlHttpClient.php');
require_once('Facebook/Entities/AccessToken.php');
require_once('Facebook/GraphUser.php');
require_once('Facebook/GraphSessionInfo.php');
 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;

class Facebook {
  var $ci;
  var $helper;
  var $session;
  var $permissions;
  public function __construct($return_uri='') {
    $this->ci =& get_instance();
    $this->permissions = $this->ci->config->item('permissions', 'facebook');
    // Initialize the SDK
    FacebookSession::setDefaultApplication( $this->ci->config->item('api_id', 'facebook'), $this->ci->config->item('app_secret', 'facebook') );
    // Create the login helper and replace REDIRECT_URI with your URL
    // Use the same domain you set for the apps 'App Domains'
    // e.g. $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' );
    $this->helper = new FacebookRedirectLoginHelper( base_url($return_uri) );
    if ( $this->ci->session->userdata('fb_token') ) {
      $this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );
      // Validate the access_token to make sure it's still valid
      try {
        if ( ! $this->session->validate() ) {
          $this->session = null;
        }
      } catch ( Exception $e ) {
        // Catch any exceptions
        $this->session = null;
      }
    } else {
      // No session exists
      try {
        $this->session = $this->helper->getSessionFromRedirect();
      } catch( FacebookRequestException $ex ) {
        // When Facebook returns an error
      } catch( Exception $ex ) {
        // When validation fails or other local issues
      }
    }
    if ( $this->session ) {
      $this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );
      $this->session = new FacebookSession( $this->session->getToken() );
    }
  }
  /**
   * Returns the login URL.
   */
  public function login_url() {
    return $this->helper->getLoginUrl( $this->permissions );
  }
  /**
   * Returns the current user's info as an array.
   */
  public function get_user() {
    if ( $this->session ) {
      /**
       * Retrieve User’s Profile Information
       */
      // Graph API to request user data
      $request = ( new FacebookRequest( $this->session, 'GET', '/me?locale=en_US&fields=name,email' ) )->execute();
      // Get response as an array
      $user = $request->getGraphObject()->asArray();
      return $user;
    }
    return false;
  }
}
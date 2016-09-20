<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paypal
{
    private $test_mode = false;
    
    public function __construct()
    {
        
    }
    
    public function setTestMode($flag = true)
    {
        $this->test_mode = $flag;
    }
    
    public function sendRequest($params)
    {
        $default = array(
            'cmd'       => '_xclick',
            'business'  => '',
            'first_name'=> '',
            'last_name' => '',
            'item_name' => '',
            'item_number' => '',
            'amount'    => 0,
            'currency_code' => 'USD',
            'lc'        => '',
            'bn'        => '',
            'return'    => '',
            'no-shipping' => 0,
            'no-note'   => 1,
            'cancel_return' => '',
            'notify_url'=> '',
        );
        $params = array_merge($default, $params);
        $url = $this->_get_url();
        
        header("location:https:{$url}?" . $this->_get_query_string($params));
        exit;   
    }
    
    public function completeCheckout()
    {
        if(empty($_POST)) return FALSE;
    
        if(!isset($_POST['txn_id'])
            || !isset($_POST['payer_id'])
            || !isset($_POST['receiver_id'])
            || !isset($_POST['payment_date'])
            || !isset($_POST['auth']))
        {
            return FALSE;
        }
        
        return TRUE;
        // Response from Paypal
        // read the post from PayPal system and add 'cmd'
        /*$req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
            $req .= "&$key=$value";
        }  */
        
        // assign posted variables to local variables
        /*$data['item_name']          = $_POST['item_name'];
        $data['item_number']        = $_POST['item_number'];
        $data['payment_status']     = $_POST['payment_status'];
        $data['payment_amount']     = $_POST['mc_gross'];
        $data['payment_currency']   = $_POST['mc_currency'];
        $data['txn_id']             = $_POST['txn_id'];
        $data['receiver_email']     = $_POST['receiver_email'];
        $data['payer_email']        = $_POST['payer_email'];
        $data['custom']             = $_POST['custom'];
        
        // post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        
        $url = $this->_get_url();
        $fp = fsockopen ("ssl:{$url}", 443, $errno, $errstr, 30);
        print_r($fp); exit;
        if (!$fp) return FALSE;
        
        fputs($fp, $header . $req);
        while (!feof($fp)) 
        {
            $res = fgets ($fp, 1024);
            if (strcmp($res, "VERIFIED") == 0) {
                return TRUE;
            }
        }
        fclose ($fp); */
    }
    
    public function getResponse()
    {
        return $_POST;
    }
    
    private function _get_url()
    {
        if($this->test_mode)
        {
            return '//www.sandbox.paypal.com/cgi-bin/webscr';
        }
        
        return '//www.paypal.com/cgi-bin/webscr';
    }
    
    private function _get_query_string($params)
    {
        if(!is_array($params))
        {
            $params = array($params);
        }
        
        $result = '';
        foreach($params as $key => $value)
        {
            $value = urlencode(stripslashes($value));
            $result .= "$key=$value&";
        }
        
        return $result;
    }
}//end class
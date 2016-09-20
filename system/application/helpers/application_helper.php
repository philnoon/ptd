<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('gravatar_link'))
{
	/**
	 * Creates an image link based on Gravatar for the specified email address.
	 * It will default to the site's generic image if none is found for
	 * the user.
	 *
	 * Note that if gravatar does not have an image that matches the criteria,
	 * it will return a link to an image under *your_theme/images/user.png*.
	 * Also, by explicity omitting email you're denying http-req to gravatar.com.
	 *
	 * @param $email string The email address to check for. If NULL, defaults to theme img.
	 * @param $size int The width (and height) of the resulting image to grab.
	 * @param $alt string Alt text to be put in the link tag.
	 * @param $title string The title text to be put in the link tag.
	 * @param $class string Any class(es) that should be assigned to the link tag.
	 * @param $id string The id (if any) that should put in the link tag.
	 *
	 * @return string The resulting image tag.
	 */
	function gravatar_link($email=NULL, $size=48, $alt='', $title='', $class=NULL, $id=NULL)
	{
		// Set our default image based on required size.
		$default_image = Template::theme_url('images/user.png');

		// Set our minimum site rating to PG
		$rating = 'PG';

		// Border color
		$border = 'd6d6d6';

		// If email null, means we don't want gravatar.com HTTP request
		if ( $email ) {

			// Check if HTTP or HTTPS Request should be used

			if(isset($_SERVER['HTTPS'])){ $http_protocol = "https://secure.";} else { $http_protocol = "http://www.";}

			// URL for Gravatar
			$gravatarURL =  $http_protocol . "gravatar.com/avatar.php?gravatar_id=%s&amp;default=%s&amp;size=%s&amp;border=%s&amp;rating=%s";
			$avatarURL = sprintf
			(
				$gravatarURL,
				md5($email),
				$default_image,
				$size,
				$border,
				$rating
			);
		}
		else
		{
			$avatarURL = $default_image ;
		}

		$alt = htmlentities($alt, ENT_QUOTES, 'UTF-8');
		$title = htmlentities($title, ENT_QUOTES, 'UTF-8');
		
		$id = ($id !== NULL) ? ' id="' .$id .'" ' : ' ';
		$class = ($class !== NULL) ? ' class="' .$class .'"' : ' ';

		return '<img src="'. $avatarURL .'" width="'.	$size .'" height="'. $size . '" alt="'. $alt .'" title="'. $title .'" ' . $class . $id. ' />';
	}
}

if ( ! function_exists('logit'))
{
	/**
	 * Logs an error to the Console (if loaded) and to the log files.
	 *
	 * @param $message string The string to write to the logs.
	 * @param $level string The log level, as per CI log_message method.
	 *
	 * @return void
	 */
	function logit($message='', $level='debug')
	{
		if (empty($message))
		{
			return;
		}

		if (class_exists('Console'))
		{
			Console::log($message);
		}

		log_message($level, $message);
	}
}

if ( ! function_exists('dump'))
{
	/**
	 * Outputs the given variables with formatting and location. Huge props
	 * out to Phil Sturgeon for this one (http://philsturgeon.co.uk/blog/2010/09/power-dump-php-applications).
	 * To use, pass in any number of variables as arguments.
	 *
	 * @return void
	 */
	function dump()
	{
		list($callee) = debug_backtrace();
		$arguments = func_get_args();
		$total_arguments = count($arguments);

		echo '<fieldset style="background: #fefefe !important; border:2px red solid; padding:5px">';
	    echo '<legend style="background:lightgrey; padding:5px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';

	    $i = 0;
	    foreach ($arguments as $argument)
	    {
			echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';

			if ( (is_array($argument) || is_object($argument)) && count($argument))
			{
				print_r($argument);
			}
			else
			{
				var_dump($argument);
			}
		}

		echo '</pre>' . PHP_EOL;
		echo '</fieldset>' . PHP_EOL;
	}
}
if (!function_exists('e'))
{
	/*
		Function: e()

		A convenience function to make sure your output is safe to display.
		Helps to defeat XSS attacks by running the text through htmlentities().

		Should be used anywhere you are displaying user-submitted text.
	*/
	function e($str)
	{
		echo htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
}

//--------------------------------------------------------------------

if (!function_exists('array_implode'))
{
	/**
	 * Implode an array with the key and value pair giving a glue,
	 * a separator between pairs and the array to implode.
	 *
	 * Encode Query Strings
	 * @example $query = url_encode( array_implode( '=', '&', $array ) );
	 *
	 * @param string $glue      The glue between key and value.
	 * @param string $separator Separator between pairs.
	 * @param array  $array     The array to implode.
	 *
	 * @return string A string with the combined elements.
	 */
	function array_implode($glue, $separator, $array)
	{
		if ( ! is_array( $array ) )
		{
			return $array;
		}

		$string = array();

		foreach ( $array as $key => $val )
		{
			if ( is_array( $val ) )
			{
				$val = implode( ',', $val );
			}

			$string[] = "{$key}{$glue}{$val}";
		}

		return implode( $separator, $string );

	}//end array_implode()
}
//--------------------------------------------------------------------

if ( !function_exists('obj_value') )
{
	/**
	 *
	 * @param object $obj   Object
	 * @param string $key   Name of the object element
	 * @param string $type  Input type
	 * @param int    $value Value to check the key against
	 *
	 * @return null|string
	 */
	function obj_value($obj, $key, $type='text', $value=0)
	{
		if (isset($obj->$key))
		{
			switch ($type)
			{
				case 'checkbox':
				case 'radio':
					if ($obj->$key == $value)
					{
						return 'checked="checked"';
					}
					break;
				case 'select':
					if ($obj->$key == $value)
					{
						return 'selected="selected"';
					}
					break;
				case 'text':
				default:
					return $obj->$key;
			}
		}

		return null;

	}//end obj_value()
}
//--------------------------------------------------------------------

if ( !function_exists('iif') )
{
	/**
	* If then Else Statement wrapped in one function, If $expression = true then $returntrue else $returnfalse
	*
	* @param mixed $expression    IF Statement to be checked
	* @param mixed $returntrue    What to Return on True
	* @param mixed $returnfalse   What to Return on False
	* @param bool  $echo          Defaults to false, if set to true will echo instead of return
	*
	* @return mixed    If echo is set to true will echo the value of the expression, defaults to returning the value
	*/
	function iif($expression, $returntrue, $returnfalse = '', $echo = false )
	{
		if ( $echo === false )
		{
			return ( $expression == 0 ) ? $returnfalse : $returntrue;
		}
		else
		{
			echo ( $expression == 0 ) ? $returnfalse : $returntrue;
		}
	}//end iif()
}
//--------------------------------------------------------------------

if ( !function_exists('format_money') )
{
    function format_money( $number, $dec_point = ".", $thousands_sep = ",")
    {
        $data = preg_replace( "/\\" . $dec_point . "00$/", "", number_format($number, 2, $dec_point, $thousands_sep));
        return '$' . $data;
    }
}

if ( !function_exists('user_photo') )
{
    function user_photo($file)
    {
        return ($file!=null) ? base_url($file) : base_url('uploads/photo/ic_avatar.png');
    }
}

if ( !function_exists('certification_img') )
{
    function certification_img($file)
    {
        return ($file!=null) ? base_url($file) : '';
    }
}

if ( !function_exists('get_service_type') )
{
    function get_service_type($type=SERVICE_TYPE_SINGLE)
    {
        return $type == SERVICE_TYPE_SINGLE ? 'Single' : 'Group';
    }
}

if ( !function_exists('get_service_time') )
{
    function get_service_time($type=TRAIN_TIME_MORNING)
    {
        $result = '';
        switch($type)
        {
            case TRAIN_TIME_MORNING:
                $result = 'Morning Time';
                break;
            case TRAIN_TIME_MID:
                $result = 'Mid Time';
                break;
            case TRAIN_TIME_EVENING:
                $result = 'Evening Time';
                break;
            default:
                $result = 'Morning Time';
                break;                
        }
        return $result;
    }
}

if ( !function_exists('get_quote_status') )
{
    function get_quote_status($quote)
    {
        if($quote->quote_status == QUOTE_ACCEPTED) 
        {
            return 'Accepted';
        }
        else 
        {
            if($quote->quote_expiration_date <= time()) return 'Expired';
        }
        
        return 'Pending';
    }
}

if ( !function_exists('get_user_type_name') )
{
    function get_user_type_name($user_type)
    {
        $result = '';
        switch($user_type)
        {
            case USER_ADMIN:
                $result = 'Admin';
                break;
            case USER_TRAINER:
                $result = 'Trainer';
                break;           
            case USER_MEMBER:
            default:
                $result = 'Member';
                break;
        }
        return $result;
    }
}
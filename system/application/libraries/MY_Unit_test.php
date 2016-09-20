<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Unit_test extends CI_Unit_test
{

	/**
	 * Clears the results array so multiple files don't
	 * bleed over into each other.
	 *
	 * @return void
	 */
	public function reset()
	{
		$this->results = array();
	}//end reset()

	//--------------------------------------------------------------------


}//end class
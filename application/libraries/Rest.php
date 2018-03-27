<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rest
{
	protected $CI = null;
	private $params = [];
	private $method = "";

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->method = strtolower( $this->CI->input->method() );
		$data = $this->CI->input->raw_input_stream;
		$this->params[ $this->method ] = 	$this->isValidJSON($data) ?
											json_decode($this->CI->input->raw_input_stream,true):
											$this->CI->input->input_stream();
	}

	private function isValidJSON( $string )
	{
    	json_decode($string);
    	return (json_last_error() == JSON_ERROR_NONE);
	}

	public function put( $key=null )
	{
		return $this->from_method('put', $key);
	}

	public function delete( $key=null )
	{
		return $this->from_method('delete', $key);
	}

	public function patch( $key=null )
	{
		return $this->from_method('patch', $key);
	}

	public function post( $key=null )
	{
		return $this->from_method('post', $key);
	}
	
	public function get( $key=null )
	{
		return $this->from_method('get', $key);
	}

	private function from_method($method, $key)
	{
		if( in_array( $method, ['get','cookie']) )
		{
			return $this->CI->input->{$method}( $key );
		}
		else
		{
			if( isSet($this->params[ $method ]) )
			{
				if( is_null($key) )
					return $this->params[ $method ];
				else
					return (
						isSet($this->params[ $method ][ $key ]) ?
						$this->params[ $method ][ $key ] :
						null
					);
			}
			else
				throw new Exception('Not received '.strToUpper($method).' method.');
		}
	}

}
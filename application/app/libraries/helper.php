<?php

class Helper {

    public static function slugify($str) {
		// replace non letter or digits by -
		if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
		$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
		$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
		$str = strtolower( trim($str, '-') );

		if (empty($str))
		{
			return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
		}
		   
		return $str;
	}

	public static function array_strip_tags($array)
	{
	    $result = array();
	    foreach ($array as $key => $value) {
	        $key = strip_tags($key);
	        if (is_array($value)) {
	            $result[$key] = array_strip_tags($value);
	        }
	        else {
	            $result[$key] = strip_tags($value);
	        }
	    }
	    return $result;
	}

}
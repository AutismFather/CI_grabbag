<?php
/**
 * Debugging function to output array data
 * 
 * @param $x mixed, either a value or an array
 * @param $bool boolean - if true, return output to caller. if false, echo output immediate. Default is false.
 **/
if( !function_exists('pr') ){
	function pr($x = null, $bool = false){
		if( empty($x) ) return null;
		$output = null;

		// If this is a db result, convert to an array and then proceed to displaying it
		if( is_object($x) ){
			foreach( $x->result() as $row ){
				$output[] = (array)$row;
			}
			$x = $output;
			$output = null;
		}

		if( is_array($x) ){
			$output = '<pre>';
			$output.= print_r($x, true);
			$output.= '</pre>';
		}
		else {
			$output = $x;
		}

		if( $bool )
			return $output;
		else
			echo $output;
	}
}

if( !function_exists('config') ){
	function config($x = ''){
		$CI =& get_instance();

		return $CI->config->item($x);
	}
}

if( !function_exists('lang') ){
	/**
	 * lang()
	 * Uses the language files to return the proper string in the proper language
	 * 
	 * @param string $x
	 * @param mixed $string
	 * @return
	 */
	function lang($x = '', $string = null){
		$CI =& get_instance();
		// If it's just a simple string
		if( empty($string) ){
			return $CI->lang->line($x);
		}

		// If string is just a string and not an array
		if( !is_array($string) ){
			return sprintf($CI->lang->line($x), $string);
		}
		else{
			return vsprintf($CI->lang->line($x), $string);
		}
	}
}

if( !function_exists('js') ){
	function js($js){
		$output = null;

		if( empty($js) ){
			$js = $CI->js;
			$CI =& get_instance();
		}

		if( is_array($js) ){
			foreach( $js as $j ){
				if( substr($j, 0, 4) == 'http' ){
					$output.= '<script type="text/javascript" src="' . $j . '"></script>' . "\n";
				}
				else {
					$output.= '<script type="text/javascript" src="/js/' . $j . '.js"></script>' . "\n";
				}
			}
		}
		else {
			if( substr($js, 0, 4) == 'http' ){
				$output.= '<script type="text/javascript" src="' . $js . '"></script>' . "\n";
			}
			else {
				$output.= '<script type="text/javascript" src="/js/' . $js . '.js"></script>' . "\n";
			}
		}
	    echo $output;
	}
}

if( !function_exists('css') ){
	/**
	 * css()
	 * Outputs the CSS files
	 * 
	 * @param string $css
	 * @return void
	 */
	function css($css = ''){
		$output = null;

		// Function can be called with no param, in which case it checks the CI variable.
		if( empty($css) ){
			$CI =& get_instance();
			$css = $CI->css;
		}

		if( is_array($css) ){
			foreach( $css as $c ){
				if( substr($c, 0, 4) == 'http' ){
					$output.= '<link type="text/css" href="' . $c . '" rel="stylesheet" />' . "\n";
				}
				else {
					$output.= '<link type="text/css" href="/css/' . $c . '.css" rel="stylesheet" />' . "\n";
				}
			}
		}
		else {
			if( substr($css, 0, 4) == 'http' ){
				$output.= '<link type="text/css" href="' . $css . '" rel="stylesheet" />' . "\n";
			}
			else {
				$output.= '<link type="text/css" href="/css/' . $css . '.css" rel="stylesheet" />' . "\n";
			}
		}
	    echo $output;
	}
}

if( !function_exists('site_name') ){
	function site_name(){
		return _config('site_name');
	}
}




if( !function_exists('element') ){
	/**
	 * element()
	 * Calls a template from the "elements" folder and passes $data as $data to the view
	 * 
	 * @param string $element
	 * @param mixed $data
	 * @return string/html elements
	 */
	function element($element = ''){
		$CI =& get_instance();

		return $CI->load->view('elements/' . $element, $CI->data, true);
	}
}
?>
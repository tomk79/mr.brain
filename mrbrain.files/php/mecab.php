<?php

class cont_mecab{
	private $px;
	private $path_mecab = '/usr/local/bin/mecab';

	public function __construct($px){
		$this->px = $px;
	}

	/**
	 * 形態素解析	
	 */
	public function parse( $text ){
		$cmd = 'echo '.t::data2text($text).' | '.$this->path_mecab.' -E ""';
		ob_start();
		passthru($cmd);
		$mecab_answer = ob_get_clean();
		$parsed_text = trim($mecab_answer);

		$parsed_text = preg_split( '/\r\n|\r|\n/', $parsed_text );
		$rtn = array();
		foreach( $parsed_text as $word ){
			$tmp = array();
			list($tmp['word'],$tmp['property']) = preg_split('/\t/',$word);
			$tmp['property'] = preg_split('/\,/',$tmp['property']);
			array_push( $rtn, $tmp );
		}

		return $rtn;
	}//parse()
}

?>
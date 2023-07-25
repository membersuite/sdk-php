<?php

class Curl{
   
	public $url = '';
	public $method = 'post'; // post or get
	public $returnval = true;
	public $debug = false;
	public $header = ''; // array
	public $post = true; // true or false
	public $postdata='';
	
	public function init(){
		
		// cURL initilization 
		$curl = curl_init();
		
		$certPath = $_SERVER['DOCUMENT_ROOT'].'/ms_sdk/lib/mozilla.pem';
		curl_setopt($curl, CURLOPT_CAINFO, $certPath);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		// setting up the cURL URL
		$this->curlurl($curl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, $this->returnval);
		$this->setheader($curl);
		curl_setopt ($curl, CURLOPT_POST, $this->post);
		// setting the postdata in the cURL that needs to be posted
		$this->curlpostdata($curl);
		$result= curl_exec($curl);
		// Show curl errors
	        if($this->debug){
		    $response = curl_error($curl);
		    return $response;
		}
		curl_close ($curl);
		return $result;
	}
	
	private function curlpostdata($curl){
	
		$retpostdata = curl_setopt ($curl, CURLOPT_POSTFIELDS, $this->postdata);
		return $retpostdata;
	}
	private function curlurl($curl){
	
		$returl = curl_setopt ($curl, CURLOPT_URL, $this->url);
		return $returl;
	}
	
	// Set cURL headers
	private function setheader($curl){
	
		$retheader = curl_setopt($curl,CURLOPT_HTTPHEADER,$this->header);
		return $retheader;
	}
    
}
?>
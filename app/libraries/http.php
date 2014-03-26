<?php

class Http {
  
  function request($url, $postfields, $method = 'POST'){
  		$ci = curl_init();
  		/* Curl settings */
  		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
  		curl_setopt($ci, CURLOPT_USERAGENT, 'DuoshuoPhpSdk/0.3.0');
  		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
  		curl_setopt($ci, CURLOPT_TIMEOUT, 60);
  		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
  		curl_setopt($ci, CURLOPT_ENCODING, "");
  		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
  		curl_setopt($ci, CURLOPT_HEADER, FALSE);

  		switch ($method) {
  			case 'POST':
  				curl_setopt($ci, CURLOPT_POST, TRUE);
  				if (!empty($postfields)) {
  					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
  					$this->postdata = $postfields;
  				}
  				break;
  			case 'DELETE':
  				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
  				if (!empty($postfields)) {
  					$url = "{$url}?{$postfields}";
  				}
  		}
  		curl_setopt($ci, CURLOPT_URL, $url );

  		curl_setopt($ci, CURLINFO_HEADER_OUT, FALSE );

  		$response = curl_exec($ci);

  		if($response === false){
  			$response->curlErr = curl_error($ci);
  		}

  		return $response;
  	}
}
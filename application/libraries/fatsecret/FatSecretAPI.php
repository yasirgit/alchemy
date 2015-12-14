<?php
class FatSecretAPI
{
	static public $base = 'http://platform.fatsecret.com/rest/server.api?';
	
	/* Private Data */
	private $_consumerKey;
	private $_consumerSecret;
	
	/* Constructors */	
    function FatSecretAPI($consumerKey, $consumerSecret)
    {
		$this->_consumerKey = $consumerKey;
		$this->_consumerSecret = $consumerSecret;
		return $this;
	}
	
	/* Properties */
	function GetKey(){
		return $this->_consumerKey;
	}
	
	function SetKey($consumerKey){
		$this->_consumerKey = $consumerKey;
	}

	function GetSecret(){
		return $this->_consumerSecret;
	}
	
	function SetSecret($consumerSecret){
		$this->_consumerSecret = $consumerSecret;
	}

//	/* 
//	* 
//	*/
//	public function apiBuild($method,$params)
//	{
//		$this->apiURL = false;
//		$this->error = '';
//		switch($method)
//		{
//		default:
//			break;
//		case "foods.search":
//			if ($params['ingredient'] && is_numeric($params['page']) && $params['page'] >= 0)
//			{
//				$this->apiURL = 'method=foods.search&max_results=10&page_number='.$params['page'].'&search_expression='.$params['ingredient'];//&format=json';
//			}
//			else
//			{
//				$this->error = "Invalid ingredient (".$params['ingredient'].") or page (".$params['page'].") requested";
//			}
//			break;
//		case "food.get":
//			if (is_numeric($params['food_id']) && $params['food_id'] >= 0)
//			{
//				$this->apiURL = 'method=food.get&food_id='.$params['food_id'];
//			}
//			else
//			{
//				$this->error = "Invalid food_id - ".$params['food_id'];
//			}
//			break;
//		}
//	}
//	/* 
//	* 
//	*/
//	public function apiExececute()
//	{
////		$url = FatSecretAPI::$base . 'max_results=10&page_number='.$page_number.'&method=foods.search&search_expression='.$search_expression;//&format=json';
//		if ($this->apiURL)
//		{
//			$url = FatSecretAPI::$base . $this->apiURL;
//
//			$oauth = new OAuthBase();
//
//			$normalizedUrl;
//			$normalizedRequestParameters;
//
//			$signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, null, null, $normalizedUrl, $normalizedRequestParameters);
//
//			$response = $this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature));
//
//			$doc = new SimpleXMLElement($response);
//
//			$this->ErrorCheck($doc);
//
//			return $doc;
//		}
//		else
//		{
//			$this->error = "Invalid apiURL";
//		}
//		return false;
//	}

	function request($url, $token=null, $secret=null) {
		$oauth = new OAuthBase();

		$normalizedUrl;
		$normalizedRequestParameters;

		$signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, $token, $secret, $normalizedUrl, $normalizedRequestParameters);

		$doc = new SimpleXMLElement($this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature)));

		$this->ErrorCheck($doc);

		return $this->getArray($doc);
	}
	
	//////////////////////////////////////////write omar
	function requestapi($url, $token=null, $secret=null) 
	{
		$oauth = new OAuthBase();
		$normalizedUrl;
		$normalizedRequestParameters;
		
		$signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, $token, $secret, $normalizedUrl, $normalizedRequestParameters);		
		$doc = simplexml_load_string($this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature)));
		return $this->getArray($doc);
	}
	//////////////////////////////////////////
	
	/* Private Methods */
	
	private function getArray($data)
	{
		if (count($data) == 0) {
			return $data;
		} else {
			$result = array();
			foreach($data->children() as $k => $v) {
				if (count($v) == 0)
				{
					$result[$k] = strip_tags($v);
				}
				else
				{
					$result[$k][] = $this->getArray($v);
				}
			}
			return $result;
		}
	}

	private function GetQueryResponse($requestUrl, $postString) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
        $response = curl_exec($ch);

        curl_close($ch);
		
		return $response;
	}
	
	private function ErrorCheck($doc){
		if($doc->getName() == 'error')
		{
			throw new FatSecretException((int)$doc->code, $doc->message);
		}
	}
}

class FatSecretException extends Exception{
	
    public function FatSecretException($code, $message)
    {
        parent::__construct($message, $code);
    }
}

/* OAuth */
class OAuthBase {
	/* OAuth Parameters */
	static public $OAUTH_VERSION_NUMBER = '1.0';
	static public $OAUTH_PARAMETER_PREFIX = 'oauth_';
	static public $XOAUTH_PARAMETER_PREFIX = 'xoauth_';
	static public $PEN_SOCIAL_PARAMETER_PREFIX = 'opensocial_';

	static public $OAUTH_CONSUMER_KEY = 'oauth_consumer_key';
	static public $OAUTH_CALLBACK = 'oauth_callback';
	static public $OAUTH_VERSION = 'oauth_version';
	static public $OAUTH_SIGNATURE_METHOD = 'oauth_signature_method';
	static public $OAUTH_SIGNATURE = 'oauth_signature';
	static public $OAUTH_TIMESTAMP = 'oauth_timestamp';
	static public $OAUTH_NONCE = 'oauth_nonce';
	static public $OAUTH_TOKEN = 'oauth_token';
	static public $OAUTH_TOKEN_SECRET = 'oauth_token_secret';
	
	protected $unreservedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.~';
	
	function GenerateSignature($url, $consumerKey, $consumerSecret, $token, $tokenSecret, &$normalizedUrl, &$normalizedRequestParameters){
		$signatureBase = $this->GenerateSignatureBase($url, $consumerKey, $token, 'POST', $this->GenerateTimeStamp(), $this->GenerateNonce(), 'HMAC-SHA1', $normalizedUrl, $normalizedRequestParameters);
        $secretKey = $this->UrlEncode($consumerSecret) . '&' . $this->UrlEncode($tokenSecret);
		return base64_encode(hash_hmac('sha1', $signatureBase, $secretKey, true));
	}
	
	private function GenerateSignatureBase($url, $consumerKey, $token, $httpMethod, $timeStamp, $nonce, $signatureType, &$normalizedUrl, &$normalizedRequestParameters){		
		$parameters = array();
		
		$elements = explode('?', $url);
		$parameters = $this->GetQueryParameters($elements[1]);
		
		$parameters[OAuthBase::$OAUTH_VERSION] = OAuthBase::$OAUTH_VERSION_NUMBER;
		$parameters[OAuthBase::$OAUTH_NONCE] = $nonce;
		$parameters[OAuthBase::$OAUTH_TIMESTAMP] = $timeStamp;
		$parameters[OAuthBase::$OAUTH_SIGNATURE_METHOD] = $signatureType;
		$parameters[OAuthBase::$OAUTH_CONSUMER_KEY] = $consumerKey;
		
		if(!empty($token)){
			$parameters[ OAuthBase::$OAUTH_TOKEN] = $token;
		}
		
		$normalizedUrl = $elements[0];
		$normalizedRequestParameters = $this->NormalizeRequestParameters($parameters);
		
		return $httpMethod . '&' . UrlEncode($normalizedUrl) . '&' . UrlEncode($normalizedRequestParameters);
	}
	
    private function GetQueryParameters($paramString) {
    //    $elements = split('&',$paramString);
        $elements = explode('&',$paramString);
        $result = array();
        foreach ($elements as $element)
        {
    //        list($key,$token) = split('=',$element);
            list($key,$token) = explode('=',$element);
            if($token)
                $token = urldecode($token);
            if(!empty($result[$key]))
            {
                if (!is_array($result[$key]))
                    $result[$key] = array($result[$key],$token);
                else
                    array_push($result[$key],$token);
            }
            else
                $result[$key]=$token;
        }

        return $result;
    }

    private function NormalizeRequestParameters($parameters) {
        $elements = array();
        ksort($parameters);

        foreach ($parameters as $paramName=>$paramValue) {
            array_push($elements,$this->UrlEncode($paramName).'='.$this->UrlEncode($paramValue));
        }
        return join('&',$elements);
    }
	
    private function UrlEncode($string) {
        $string = urlencode($string);
        $string = str_replace('+','%20',$string);
        $string = str_replace('!','%21',$string);
        $string = str_replace('*','%2A',$string);
        $string = str_replace('\'','%27',$string);
        $string = str_replace('(','%28',$string);
        $string = str_replace(')','%29',$string);
        return $string;
    }

	private function GenerateTimeStamp(){
		return time();
	}
	
	private function GenerateNonce(){
		return md5(uniqid());
	}
}

?>

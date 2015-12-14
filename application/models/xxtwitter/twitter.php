<?php
require_once(APPPATH.'libraries/twitter/TwitterAPI.php');

class Twitter extends Model
{
	private	$twitterAPI	= false;
	public	$apiURL		= false;
	public	$error		= false;

	public function __construct()
	{
		parent::Model();
//		$this->twitterAPI = new TwitterAPI();
	}

	public function execute()
	{
		$query = "SELECT	oauth_token,oauth_token_secret" .
				" FROM		users" .
				" WHERE		oauth_token IS NOT NULL AND oauth_token_secret IS NOT NULL AND id=".$this->session->userdata('id');
		if (!($access_token = $this->db->query($query)->result()))
		{	// need authentication for this user
			$this->authenticate();
		}
		else
		{		
			/* Create a TwitterAPI object with consumer/user tokens. */
			$connection = new TwitterAPI(_TWITTER_CONSUMER_KEY_, _TWITTER_CONSUMER_SECRET_, $access_token[0]->oauth_token, $access_token[0]->oauth_token_secret);
			
			/* If method is set change API call made. Test is called by default. */
			//$content = $connection->get('account/verify_credentials');
			
			/* Some example calls */
			//$content = $connection->get('users/show', array('screen_name' => 'abraham')));
			//$content = $connection->post('statuses/update', array('status' => date(DATE_RFC822)));
			//$content = $connection->post('statuses/destroy', array('id' => 5437877770));
			//$content = $connection->post('friendships/create', array('id' => 9436992)));
			//$content = $connection->post('friendships/destroy', array('id' => 9436992)));
			
			$this->result = $connection->post('statuses/update', array('status' => "MY NEW MEAL"));
		//	$content = $connection->post('statuses/update', array('status' => "MY NEW MEAL"));
		//	
		//	/* Include HTML to display on the page */
		//	include('html.inc');
		}
	}

	private function authenticate()
	{
		/* Build TwitterAPI object with client credentials. */
		$connection = new TwitterAPI(_TWITTER_CONSUMER_KEY_, _TWITTER_CONSUMER_SECRET_);

		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken(_TWITTER_OAUTH_CALLBACK_);

		/* Save temporary credentials to session. */
		$this->session->set_userdata('oauth_token',			$request_token['oauth_token'] );
		$this->session->set_userdata('oauth_token_secret',	$request_token['oauth_token_secret'] );

		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code)
		{
		case 200:
			/* Build authorize URL and redirect user to Twitter. */
			$url = $connection->getAuthorizeURL($request_token['oauth_token']);
			header('Location: ' . $url); 
			break;
		default:
			/* Show notification if something went wrong. */
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
			return false;
		}
	}

	public function callBack()
	{
		/* If the oauth_token is old redirect to the connect page. */
	//	if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token'])
		if (isset($_REQUEST['oauth_token']) && $this->session->userdata('oauth_token') !== $_REQUEST['oauth_token'])
		{
	//		$_SESSION['oauth_status'] = 'oldtoken';
	//		header('Location: ./clearsessions.php');
			echo "bad oauth_token";
			return false;
		}

		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(_TWITTER_CONSUMER_KEY_, _TWITTER_CONSUMER_SECRET_, $this->session->userdata('oauth_token'),$this->session->userdata('oauth_token_secret'));
		
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;
		$this->db_update("users",$access_token, array("id" => $this->session->userdata('id')));
		
//		/* Remove no longer needed request tokens */
//		unset($_SESSION['oauth_token']);
//		unset($_SESSION['oauth_token_secret']);
		
		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {
			/* The user has been verified and the access tokens can be saved for future use */
//			$_SESSION['status'] = 'verified';
//			header('Location: ./index.php');
			echo "TWITTER OK";
		}
		else
		{
			/* Save HTTP status for error dialog on connnect page.*/
//			header('Location: ./clearsessions.php');
			echo "ERROR";
		}
	}

	public function apiBuild($method,$params)
	{
		$this->apiURL	= false;
		$this->error	= false;
		switch($method)
		{
		default:
			break;
		case "foods.search":
			if ($params['ingredient'] && is_numeric($params['page']) && $params['page'] >= 0)
			{
				$this->apiURL = 'method=foods.search&max_results='.PAGECNT_SMALL.'&page_number='.$params['page'].'&search_expression='.$params['ingredient'];//&format=json';
			}
			else
			{
				$this->error = "Invalid ingredient (".$params['ingredient'].") or page (".$params['page'].") requested";
			}
			break;
		case "food.get":
			if (is_numeric($params['food_id']) && $params['food_id'] >= 0)
			{
				$this->apiURL = 'method=food.get&food_id='.$params['food_id'];
			}
			else
			{
				$this->error = "Invalid food_id - ".$params['food_id'];
			}
			break;
		}
	}

//	public function execute()
//	{
//		try
//		{
//			$this->result = $this->twitterAPI->request(BASE_URL . $this->apiURL, $this->session->userdata('auth_token'), $this->session->userdata('auth_secret'));
//		}
//		catch (Exception $ex)
//		{
//			$this->error = "TWITTER API ERROR (".$this->apiURL.") - ".$ex->getMessage();
//			return false;
//		}
//		return true;
//	}

/*	function foodCreate($token, $secret, $data=array()) {
		$url = BASE_URL . 'method=food.create';
		foreach($data as $k => $v) {
			$url .= '&'.$k.'='.$v;
		}
		try {
			$result = $this->twitterAPI->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}
	
	function foodGet($token, $secret, $food_id) {
		$url = BASE_URL . 'method=food.get&food_id='.$food_id;
		
		try {
			$result = $this->twitterAPI->request($url, $token, $secret);
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}
		return $result;
	}

	public function foodSearch($token, $secret, $params)
	{
		$url = BASE_URL . 'method=foods.search&max_results='.PAGECNT_SMALL.'&page_number='.$params['page'].'&search_expression='.$params['ingredient'];

		try
		{
			$this->result = $this->twitterAPI->request($url, $token, $secret);
		}
		catch (Exception $ex)
		{
			$this->error = $ex->getMessage();
			return false;
		}
		return true;
	}
*/
}
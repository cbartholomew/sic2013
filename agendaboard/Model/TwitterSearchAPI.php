<?php
	/**
	 * TwitterSearchAPI.php
	 *
	 * Christopher Bartholomew
	 * cbartholomew@gmail.com
	 *
	 * Using consume key and consumer secrets, this library will build and set an access token
	 * for a user, then it will do a search for a specific hash tag and then return the results
	 *
	 * TODO: Comment Below.
	 */

	// constants
	define("AUTH_TOKEN_URL" ,"https://api.twitter.com/oauth2/token");
	define("API_SEARCH_ENDPOINT","https://api.twitter.com/1.1/search/tweets.json");
	define("HEADER" ,"header");
	define("METHOD" ,"method");
	define("CONTENT","content");
	define("HTTP"   ,"http");
	define("QUERY", "q");
	

	class TwitterSearchAPI 
	{			
		// enum
		const BASIC   = "Basic";
		const BEARER  = "Bearer";
		const REQUEST_TOKEN  = 0;
		const REQUEST_SEARCH = 1;
		
		// private variables
		protected $_credentials;
		protected $_accessToken;
		protected $_accessType;
		protected $_basicToken;
		protected $_searchTag;
		protected $_requestBody;
		protected $_tweets;
		protected $_refreshURL;
	
	
		function __construct($_consumerKey, $_consumerSecret) 
		{
			$this->_credentials = array(
				"CONSUMER_KEY" 	  => $_consumerKey,
				"CONSUMER_SECRET" => $_consumerSecret
			);
		
			// creates the basic auth token to get back access token
			$this->setBasicToken();
		
			// override refresh url
			$this->setRefreshURL(null);
		}
		
		function doRequest($requestType)
		{
			switch($requestType)
			{
				case TwitterSearchAPI::REQUEST_TOKEN:
					$this->requestToken();
				break;	
				case TwitterSearchAPI::REQUEST_SEARCH:
					$this->requestSearch();
				break;
			}
			
		}
	
		private function requestToken()
		{
			try
			{
				// set content
				$this->setContent("grant_type","client_credentials");
		
				// build request
				$url  = AUTH_TOKEN_URL;
				$data = $this->getContent();
				$options = array(
					HTTP => array(
						HEADER  => $this->getHeader(TwitterSearchAPI::BASIC),
						METHOD  => "POST",
						CONTENT => http_build_query($this->getContent())
						)			
				); 
		
				// create stream context
				$context = stream_context_create($options);
				
				// read in stream
				$result = file_get_contents($url, false, $context);
		
				// set token
				$tokenResponse = json_decode($result);
		
				// set access token
				$this->setAccessToken($tokenResponse->access_token);
		
				// set token type
				$this->setAccessTokenType($tokenResponse->token_type);	
			}
			catch(Exception $e)
			{
				$tokenResponse = array("token_type" => "403", "access_token" => -1);
				// set access token
				$this->setAccessToken($tokenResponse);		
				$this->setAccessTokenType($tokenResponse);
				print($e);
			}
		}
	
		private function requestSearch()
		{
			try
			{	
				// set content
				$this->setContent(QUERY,$this->getSearchTag());
			
				// set default url sceheme
				$default_url = API_SEARCH_ENDPOINT;
				
				// check for a refresh url
				$refresh_url = GetRefreshURLDictionary($this->getSearchTag());
				
				// build a url based on the previous data set
				$url  = ($refresh_url == "") ? $default_url . "?" . http_build_query($this->getContent()) 
											   : $default_url . $refresh_url;
							
				$options = array(
					HTTP => array(
						HEADER  => $this->getHeader(TwitterSearchAPI::BEARER),
						METHOD  => "GET"
						)			
				); 
		
				// create stream context
				$context = stream_context_create($options);
		
				// read in stream
				$result = file_get_contents($url, false, $context);
		
				// set token
				$searchResponse = json_decode($result);
			
				// set refresh url
				$this->setRefreshURL($searchResponse->search_metadata->refresh_url);
			
				// set tweets
				$this->setTweets($searchResponse);
		
			}
			catch(Exception $e)
			{
				print($e);
			}
		}
	
		private function getHeader($authType)
		{	
			// determine the payload type
			$payload = ($authType == TwitterSearchAPI::BASIC) ? 
						$this->getBasicToken(CONSUMER_KEY,CONSUMER_SECRET) : 
						$this->getAccessToken();
		
			// build auth header
			$headers = array(
				"Authorization" => "Authorization: " . $authType . " " . $payload,
				"Content-Type"  => "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
			);	
		
			return $headers["Authorization"] . "\r\n" . $headers["Content-Type"] . "\r\n";
		}	
	
		private function setRefreshURL($url)
		{
			$this->_refreshURL = $url;
			
			SetRefreshURLDictionary($this->getSearchTag(),$this->getRefreshURL());
		}
	
		function getRefreshURL()
		{
			return $this->_refreshURL;		
		}
	
		private function setTweets($tweets)
		{
			$this->_tweets = $tweets;	
		}
	
	    function getTweets()
		{
			return $this->_tweets;	
		}
	
		private function getContent()
		{
			return $this->_requestBody;
		}
	
		function setContent($key, $value)
		{
			$this->_requestBody = array($key => $value);		
		}

		function getAccessTokenType()
		{		
			return 	$this->_accessType;
		}
	
		private function setAccessTokenType($token_type)
		{
			$this->_accessType  = $token_type;
		}
	
		function getAccessToken()
		{
			return $this->_accessToken;
		}

		function setAccessToken($token)
		{	
			$this->_accessToken = $token;
		}
		
		private function getBasicToken()
		{
			return $this->_basicToken;
		}
	
		private function setBasicToken()
		{
			$this->_basicToken = base64_encode(urlencode($this->_credentials["CONSUMER_KEY"]) . ":" . 
										   	   urlencode($this->_credentials["CONSUMER_SECRET"]));
		}
	
		function getSearchTag()
		{		
			return $this->_searchTag;		
		}
	
	    function setSearchTag($searchTag)
		{	
			$this->_searchTag = $searchTag;	
		}	
	
	}
?>
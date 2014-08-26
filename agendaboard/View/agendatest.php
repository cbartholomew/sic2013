<?php	

	$twitter = new TwitterSearchAPI(CONSUMER_KEY,CONSUMER_SECRET);
	$twitter->doRequest(TwitterSearchAPI::REQUEST_TOKEN);
	
	if($twitter->getAccessToken() != -1)
	{
		$_SERVER["ACCESS_TOKEN"] = $twitter->getAccessToken();
		
		$twitter->setSearchTag("#sicEmailLies");
		
		$twitter->doRequest(TwitterSearchAPI::REQUEST_SEARCH);
		
		$tweets = $twitter->getTweets()->statuses;
		
		foreach ($tweets as $tweet)
		{
			print_r($tweet->user->name);			
		}

	}
	

?>
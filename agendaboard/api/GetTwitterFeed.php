<?php
	require("../includes/config.php");
	require("../Model/TwitterSearchAPI.php");
	require("../Model/ViewManager.php");
	
	// get hash tag
	$hashTag 	= (isset($_GET["hashtag"]))  ? $_GET["hashtag"]  : -1;
	$roomNo 	= (isset($_GET["room"]))	 ? $_GET["room"]	 : -1;
	$eventid 	= (isset($_GET["eventid"]))	 ? $_GET["eventid"]	 : -1;
	if($hashTag == -1 || $roomNo == -1 || $eventid == -1)
	{
		$twitterPanelHtml = "problem with loading tweets";
	}
	else
	{
		// make new view manager
		$viewManager = new ViewManager("../View/");
		
		// render tweets by hashtag - function is called in helpers
		$tweets = GetTweetsByHashEventTag($hashTag);
		
		// set up the tweet html variable
		$tweetHtml = "";
		
		// get the max tweets
		$tweetMax  = 3;
		
		// set up the index
		$currentTweetIndex = 0;
		
		// set up the background cls
		$backgroundCls = "";
		
		// tweet max
		foreach($tweets as $tweet)
		{	
			if($currentTweetIndex < $tweetMax)
			{
				// build view arguments
				$tweetArguments = array(
				 	ViewManager::MakeViewArgument("TWITTER_HANDLE","@" . $tweet->user->screen_name),
				 	ViewManager::MakeViewArgument("TWITTER_TEXT",$tweet->text),
					ViewManager::MakeViewArgument("TWITTER_TWEET_ID", $tweet->id_str)
				);									
				
				// render each tweet via html
				$tweetHtml .= $viewManager->renderViewHTML("tweet",$tweetArguments, false, false);	
				
				// increase the index
				$currentTweetIndex++;
			}
			
		}
		
		print($hashTag);
		// make the twitter panel, which holds tweets
		$twitterArguments = array(
			ViewManager::MakeViewArgument("TWEETS",		 $tweetHtml),
			ViewManager::MakeViewArgument("TWITTER_HASH",$hashTag),
			ViewManager::MakeViewArgument("ROOM", 		 $roomNo),
			ViewManager::MakeViewArgument("EVENT_ID", 	 $eventid)
		);
		
		// make html that creates a panel of tweets
		$twitterPanelHtml = $viewManager->renderViewHTML("twitterpanel",$twitterArguments, false, false);
	
	}
	
	// return the json
	print($twitterPanelHtml);

?>
<?php

    function IsRoomInactiveOnDay($room, $day)
    {
    	$overrideDayCount = count($room["ActiveDayOverride"]["DayNos"]);

		// active day override
		if($overrideDayCount){
			for($j=0,$o=$overrideDayCount;$j<$o;$j++)
			{
				// if current day is suppose ot be inactive continue
				if($day == $room["ActiveDayOverride"]["DayNos"][$j])
				{
					return true;
				}
			}
		}

		return false;
    }

	/* GetHeader($dayNo)
	 *
 	 * Accepts the day number, and returns the image path for the header
	 */
	function GetHeader($dayNo)
	{
		$imagePath = "";

		switch($dayNo)
		{
			case "0":
				$imagePath = "Static/Images/SIC2014-WED.png";
				break;
			case "1":
				$imagePath = "Static/Images/SIC2014-THUR.png";
				break;
			case "2":
				$imagePath = "Static/Images/SIC2014-branding.png";
				break;
			default:
				$imagePath = "Static/Images/SIC2014-branding.png";
				break;
		}
		return $imagePath;
	}

	/* GetStatusCSS($input)
	 *
 	 * Determines which CSS should be used for the status
	 */
	function GetStatusHTML($input)
	{
		$output = "";
		switch($input)
		{
			case "Cancelled":
				$output = "<label class='label label-danger statusLabelCancelledTrue'><i class='glyphicon glyphicon-exclamation-sign'></i>&nbsp;Event Cancelled!</label>";
			break;
			case "Moved":
				$output = "<label class='label label-danger statusLabelMovedTrue'><i class='glyphicon glyphicon-transfer'></i>&nbsp;Event Moved!</label>";
			break;
			default:
				$output = "";
			break;
		}
		return $output;
	}

	/* GetIsRoomFullText($input)
	 *
 	 * Determines  which css and message to use based on if the room is full
	 */
	function GetIsRoomFullText($input)
	{
		return ($input != "false") ?
			array( "CSS"  =>"statusLabelFullTrue",
				   "HTML" => "<label class='label label-danger roomFull'><i class='glyphicon glyphicon-ban-circle'></i>&nbsp;Room Full</label>") :
			array( "CSS"  =>"statusLabelFullFalse",
				   "HTML" => "<label class='label label-success' ><i class='glyphicon glyphicon-thumbs-up'></i>&nbsp;Room Open</label>") ;
	}

	/* GetTweetsByHashEventTag($roomHashTag)
	 *
 	 * Acts as a controller to call my custom TwitterSearchAPI,
  	 * It will return a list of a "tweets", based on a specific
 	 * search tag.
	 */
	function GetTweetsByHashEventTag($roomHashTag)
	{
		$tweets = NULL;
		// make new twitter api
		$twitter = new TwitterSearchAPI(CONSUMER_KEY,CONSUMER_SECRET);
		// do request to get token

		if(!isset($_SESSION["ACCESS_TOKEN"]))
		{
			$twitter->doRequest(TwitterSearchAPI::REQUEST_TOKEN);
			$_SESSION["ACCESS_TOKEN"] = $twitter->getAccessToken();
		}
		else
		{
			// $twitter->doRequest(TwitterSearchAPI::REQUEST_TOKEN);
			$twitter->setAccessToken($_SESSION["ACCESS_TOKEN"]);
		}

		// if we get a token - search for room hash
		if($twitter->getAccessToken() != -1)
		{
			// set hash tag
			$twitter->setSearchTag($roomHashTag);

			// do request
			$twitter->doRequest(TwitterSearchAPI::REQUEST_SEARCH);

			// get tweets
			$tweets = $twitter->getTweets()->statuses;
		}

		return $tweets;
	}

	function SetRefreshURLDictionary($hastag, $refreshURL)
	{
		$_SESSION[$hastag] = $refreshURL;
	}

	function GetRefreshURLDictionary($hastag)
	{
		if(isset($_SESSION[$hastag]) && !empty($_SESSION[$hastag]))
		{
			return "";
			// disabled because only rendering one tweet
			//return $_SESSION[$hastag];
		}

		return "";
	}

	/*  GetTopicMultiHtml($items)
	 *
     *  Builds some html for the variety of topics passed in
	 */
	function GetTopicMultiHtml($items)
	{
		$html = "";

		foreach($items as $item)
		{
			$html .= "<span class='label label-default'>" . $item["Name"]. "</span>&nbsp;";
		}

		return $html;
	}

	/* [DEPRICIATED] SplitAndReplace($input, $dilimiter, $returnIndex)
	 *
     *  used to do a split and replace for sepcific character sets
	 *  Depriciated when JSON data was setup.
	 */
	function SplitAndReplace($input, $dilimiter, $returnIndex)
	{
		try
		{
			$outputArr = array();

			// parse out input based on the dilimeter
			$outputArr = explode($dilimiter, $input);

			// once we have an array, pull the index that you want
			$output = $outputArr[$returnIndex];

			// scrub the characters that you don't want
			$output = ScrubBrackets($output);

			return $output;

		}
		catch(Exception $e)
		{
			return $output;
		}
	}
	/* [DEPRICIATED] function ScrubBrackets($items)
	 *
     *  used to do a split and replace for sepcific character sets
	 *  Depriciated when JSON data was setup.
	 */
	function ScrubBrackets($input)
	{
		$input = str_replace("[", "" , $input);
		$input = str_replace("]", "" , $input);

		$output = $input;

		return $output;
	}

	/* ConvertDayNoToDayStr($input)
	 *
     *  When reading from Agenda.JSON config
	 *  this function will translate the day number
	 *  to the specific string day
	 */
	function ConvertDayNoToDayStr($input)
	{
		$output = "Day One";
		switch($input)
		{
			case "0":
				$output = "Day One";
			break;
			case "1":
				$output = "Day Two";
			break;
			case "2":
				$output = "Day Three";
			break;
		}
		return $output;
	}

	/*	ConvertDayStrToDayNo($input)($input)
	 *
	 *	Converts the day string to the actual day number
	 */
	function ConvertDayStrToDayNo($input)
	{
		$output = 0;
		switch($input)
		{
			case "Day One":
				$output = 0;
			break;
			case "Day Two":
				$output = 1;
			break;
			case "Day Three":
				$output = 2;
			break;
		}
		return $output;
	}

	function GetDayNo($date)
	{
		// copy date values
		$month = $date["mon"];
		$day   = $date["mday"];
		$year  = $date["year"];

		// build full date
		$date = $month . "-" . $day . "-" . $year;

		$dayNo = 0;
		// return day no
		switch($date)
		{
			case "10-15-2014":
				$dayNo = 0;
			break;
			case "10-16-2014":
				$dayNo = 1;
			break;
			case "":
				$dayNo = 2;
			break;
			default:
				$dayNo = 0;
			break;
		}

		return $dayNo;
	}

	/*	ConvertSecondsToTime($seconds)
	 *
	 *	Converts the amount of time in sections to
	 *  to standard time.
	 */
	function ConvertSecondsToTime($seconds)
	{
		$hours = floor($seconds / 3600);
		$mins  = floor(($seconds - ($hours*3600)) / 60);
		$mins  = ($mins == 0) ? "00" : $mins;
		return $hours . ":" . $mins;
	}

	/* ConvertTimeToSeconds($time)
	 *
	 * Converts 12 hour string time to
	 * seconds
	 */
	function ConvertTimeToSeconds($time)
	{

		$time = str_replace("am","",$time);
		$time = str_replace("pm","",$time);
		$timeArr = explode(":", $time);
		return (int) $timeArr[0] * 3600 + (int) $timeArr[1] * 60;
	}

	/* IsCurrentSlotTime($localTimeInSeconds, $start, $end)
	 *
	 * Checks if it's the current timeslot so that the agenda
	 * will display custom CSS.
	 */
	function IsCurrentSlotTime($localTime, $agendaStartTime, $agendaEndTime)
	{
		return ($localTime >= $agendaStartTime && $localTime<= $agendaEndTime);
	}

	/* cmpDisplayOrder($a, $b)
	 *
	 * Compare function, sorts by display orders
	 */
	function cmpDisplayOrder($a_room, $b_room)
	{
		$a_room = $a_room["DisplayOrder"];
		$b_room = $b_room["DisplayOrder"];

		if ($a_room == $b_room)
		{
	        return 0;
	    }
	    return ($a_room < $b_room) ? -1 : 1;
	}

	/* SortObjectByProperty($input)
	 *
	 * sorts the array of rooms by room no, returns
	 * array of rooms
	 */
	function SortObjectByProperty($input, $sortType)
	{
		$output = $input;

		usort($output, $sortType);

		return $output;
	}

	/* GetMultiSpeakerHTML($items, $publicOnly)
	 *
	 * Builds HTML to be handled by agenda.php.
	 * Will only display public, if specified
	 */
	function GetMultiSpeakerHTML($items, $publicOnly)
	{
		$html = "";
    $html .= "<ul class='sessionSpeakers'>";

		foreach($items as $item)
		{
			if($publicOnly)
				if($item["Public"] == "false")
					continue;

			$html .= "<li class='sessionSpeaker'><p class='speakerName'>" . $item["First Name"] . " " . $item["Last Name"] . "</p>";
			$html .= "<p class='speakerCompany'>" . iconv("UTF-8", "CP1252", $item["Company"]) . "</p></li>";
		}
    $html .= "</ul>";
		return $html;
	}

	/* GetMultiSpeakerHTMLFull($items, $publicOnly)
	 *
	 * Builds HTML to be handled by agenda.php.
	 * Will only display public, if specified.
	 * Will also insert speakers in a unordered list
	 */
	function GetMultiSpeakerHTMLFull($items, $publicOnly)
	{
		$html = "";

		$html .= "<ul>";

		foreach($items as $item)
		{
			if($publicOnly)
				if(!$item["Public"])
					continue;

			$html .= "<li class='sessionSpeaker'>";
			$html .= "<p class='speakerName'>" . $item["First Name"] . " " . $item["Last Name"] . "</p>";
			$html .= "<p class='speakerCompany'>" . iconv("UTF-8", "CP1252", $item["Company"]) . " <span class='speakerTitle'>" . $item["Job Title"] . "</span></p>";
			$html .= "</li>";
		}

		$html .= "</ul>";

		return $html;
	}

	/* [DEPRICIATED] GetBackgroundCSS($roomNumber)
	 *
	 * <!-- THIS CSS IS NOW SPECIFIC TO THE ROOM IN AGENDA.JSON -->
	 * based on input roomNumber, will return
	 * the specific CSS to be applied to agenda.php
	 */
	function GetBackgroundCSS($roomNumber)
	{
		switch($roomNumber)
		{
			case "Room 202":
				return "room202";
			break;
			case "Room 204":
				return "room204";
			break;
		   	case "Room 205":
		  		return "room205";
		  	break;
			case "Room 301":
				return "room301";
			break;
			case "Room 302":
				return "room302";
			break;
			case "Room 303":
				return "room303";
			break;
			case "Room LL5":
				return "roomLL5";
			break;
			case "Room LL2":
				return "roomLL2";
			break;

			case "tbd":
			default:
				return "roomNotActive";
			break;
		}
	}

	/* [DEPRICIATED] GetBackgroundHeaderCSS($roomNumber)
	 *
	 * <!-- THIS CSS IS NOW SPECIFIC TO THE ROOM IN AGENDA.JSON -->
	 * based on input roomNumber, will return
	 * the specific CSS to be applied to the table header
	 * in agenda.php
	 */
	function GetBackgroundHeaderCSS($roomNumber)
	{
		switch($roomNumber)
		{
			case "Room 202":
				return "room202Header";
			break;
			case "Room 204":
				return "room204Header";
			break;
			case "Room 205":
				return "room205Header";
			break;
			case "Room 301":
				return "room301Header";
			break;
			case "Room 302":
				return "room302Header";
			break;
			case "Room 303":
				return "room303Header";
			break;
			case "Room LL2":
				return "roomLL2Header";
			break;
			case "Room LL5":
				return "roomLL5Header";
			break;
			case "tbd":
			default:
				return "defaultHeaderBackground";
			break;
		}
	}
	/* GetTrackLabelCSS($trackType)
	 *
	 * Will provide the specific CSS to use
	 * for the variety of different tracks.
	 * Mostly used by agenda.php
	 */
	function GetTrackLabelCSS($trackType)
	{
		switch($trackType)
		{
				case "Develop":
					return "trackDevelop";
				break;
				case "Digital":
					return "trackDigital";
				break;
				case "Design":
					return "trackDesign";
				break;
				default:
					return "trackNoTrack";
				break;
		}

	}
?>
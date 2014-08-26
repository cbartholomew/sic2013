<?php
	// usage ~/agendaboard/api/GetSpeakers.php?site=2&channel=17
	require("../includes/config.php");
	require("../Controller/Speaker.php");
	
	$site_id 	= (isset($_GET["site"]))    ? $_GET["site"]    : -1 ;
	$channel_id = (isset($_GET["channel"])) ? $_GET["channel"] : -1 ;
	
	if($site_id == -1 && $channel_id == -1)
	{
		$speakers = array("Error" => 400, "Type" => "Bad Request", "Message" => "parameters site or channel are null, both these parameters are required!");
	}
	else
	{
		// call the static method
		$speakers = Speaker::get($site_id,$channel_id);
	}

	// return the json
	print(json_encode($speakers));
	
?>
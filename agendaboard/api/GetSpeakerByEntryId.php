
<?php
	// usage ~/agendaboard/api/GetSpeakerByEntryId.php?entry=600
	require("../includes/config.php");
	require("../Controller/Speaker.php");
	
	$entry_id 	= (isset($_GET["entry"]))    ? $_GET["entry"]    : -1 ;
	
	if($entry_id == -1)
	{
		$speakers = array("Error" => 400, "Type" => "Bad Request", "Message" => "parameters entry is null, this parameter is required!");
	}
	else
	{
		// call the static method
		$speakers = Speaker::getByEntryId($entry_id);
	}

	// return the json
	print(json_encode($speakers));
?>
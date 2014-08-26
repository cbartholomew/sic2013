<?php
	/**
	 * Index.php
	 *
	 * Christopher Bartholomew
	 * cbartholomew@gmail.com
	 * 
	 * Main index controller
	 */
	require("includes/config.php");
	require("Model/ViewManager.php");
	require("Model/TwitterSearchAPI.php");
	require("Controller/Session.php");
		
	// get date from query string - if it's set manually, it will over ride current date 
	$dayNo =  (isset($_GET["dayno"])) ? $_GET["dayno"] : GetDayNo(getdate());
		
	// make new view manager
	$viewManager = new ViewManager("View/");
	
	// get the agenda board configuration
	$agenda_uri  = (IS_PROD) ? JSON_AGENDA_PROD_URI : JSON_AGENDA_URI;
		
	$agenda_json = file_get_contents($agenda_uri);
	
	// make json object
	$agenda      = json_decode($agenda_json,true);
	
	// run sort on rooms by display order
	$agenda["Rooms"] = SortObjectByProperty($agenda["Rooms"],"cmpDisplayOrder");
	
	// get the sessions via json
	$session_uri  = (IS_PROD) ? JSON_SESSION_PROD_URI : JSON_SESSION_TEST_URI;
	
	// get file contents
	$session_json = file_get_contents($session_uri);
	// decode the contents
	$sessions     = json_decode($session_json, true);
	
	$session 	  = new Session(count($sessions["Sessions"]));

	// get current header
	$headerImage = GetHeader($dayNo);
	
	// pass the arguments to the view
	$arguments = array(
				"sessions"   		=> $sessions["Sessions"],
				"agenda"			=> $agenda,
				"headerImage"		=> $headerImage,
				"day"				=> $dayNo,
				"session"			=> $session,
				"viewManager"		=> $viewManager				
			);
	// render view
	$viewManager->renderView("agenda",$arguments);
	
	// test agenda
	//$viewManager->renderView("agendatest",$arguments);	
?>
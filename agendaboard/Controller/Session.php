<?php		
	/**
	 * Session.php
	 *
	 * Christopher Bartholomew
	 * cbartholomew@gmail.com
	 *
	 * Controller / Class to search for sessions
	 * 
	 */
	class Session
	{	
		// set public variables
		public $start_time,$end_time,$day_no,$room_no,$max,$index,$item;	    
		
		// contrusct session object, max items 
		function __construct($MaxItems) 
		{	 
			try
			{	
		   		$this->max		 = $MaxItems;
		   		$this->index 	 = 0;
		   		$this->item 	 = null;	
			}
			catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
	   	}
		
		/* set($StartTime, $EndTime, $Day, $RoomNo)
		 *
		 * Sets the search criteria for what I'm searching for exactly
		 * in terms of rooms. Also resets index and item properties
		 * for multiple usage
		 */
		public function set($StartTime, $EndTime, $Day, $RoomNo)
		{
		  	$this->start_time = $StartTime;
		  	$this->end_time	  = $EndTime;
		  	$this->day_no 	  = $Day;
		  	$this->room_no    = $RoomNo;
			$this->index = 0;
			$this->item = null;
		}
		
		/* get($sessions)
		 *
		 * Accepts an array of "session" objects.
		 * will run a recursive search based on the search criteria.
		 * If search critera is met by base case, will set to $this->item
		 * otherwise, it will return null
		 */
		public function get($sessions)
		{			
			try
			{
				if($this->index >= $this->max)
					return;
				
				if(isset($this->item))
					return;
					
				$session = $sessions[$this->index];
				
				if($session["Day"] == $this->day_no)
				{		
					if($session["Start Time"] == $this->start_time)
					{				
						if($session["End Time"] == $this->end_time)
						{
							if($session["Room"] == $this->room_no)
							{								
									$this->item = $session;	
									return;					
							}							
						}						
					}
				}
								
				$this->index++;
				$this->get($sessions);
								
			}
			catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
            }	
		}
				
	}
?>
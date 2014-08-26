<?php
	/**
	 * ViewManager.php
	 *
	 * Christopher Bartholomew
	 * cbartholomew@gmail.com
	 *
	 * Used to render views, the bread and butter of my application, who needs a cms?
	 * 
	 */
	
	class ViewManager 
	{		
		protected $viewPath;
		
		/* __construct() 
		 *
		 * construct will load a dictionary of views
		 * with a configured base view path.
		 * this is used for each access to the view
		 */
		function __construct($baseView) 
		{
			// constant for base view path
			$BASE_VIEW_PATH = $baseView; 
			
			$this->viewPath = array(
				"header" 		=> $BASE_VIEW_PATH . "header.php",
				"footer" 		=> $BASE_VIEW_PATH . "footer.php",
				"agenda" 		=> $BASE_VIEW_PATH . "agenda.php",
				"panel"  		=> $BASE_VIEW_PATH . "panel.php",
				"panelmodal"  	=> $BASE_VIEW_PATH . "panelmodal.php",
				"twitterpanel" 	=> $BASE_VIEW_PATH . "twitterpanel.php",
				"tweet"		   	=> $BASE_VIEW_PATH . "tweet.php",
				"agendatest" 	=> $BASE_VIEW_PATH . "agendatest.php"
			);
		}
		
		/* renderView($view, $arguments)
		 *
   		 * Used to render a view within the $this->viewPath
 		 * array. It will always render a header and footer.
         * When you pass in the dictionary of arguments, it 
         * will also make those arguments avaliable to all views
 		 * which will be rendered.
		 */		
		public function renderView($view, $arguments)
		{
			// if template exists, render it
			if (file_exists($this->viewPath[$view]))
			{
			    // extract variables into local scope
			    extract($arguments);
			
			    // render header
			    require($this->viewPath["header"]);
			
			    // render template
			    require($this->viewPath[$view]);
			
			    // render footer
			    require($this->viewPath["footer"]);
			}			
			// else err
			else
			{
			    trigger_error("Invalid View: $view", E_USER_ERROR);
			}	
		}
		
		/* renderViewHTML($view, $arguments, $includeHeader, $includeFooter)
		 *
   		 * Used to render a view within the $this->viewPath
 		 * array. It will always render a header and footer, IF YOU SPECIFY.
         * When you pass in the dictionary of arguments, it 
         * will also make those arguments avaliable to all views
 		 * which will be rendered.
		 * This will actually return post rendered html, and it will look for specific
		 * #KEYWORDS# to replace those arguments. 
		 */
		public function renderViewHTML($view, $arguments, $includeHeader, $includeFooter)
		{
			$html = "";
			
			// if template exists, render it
			if (file_exists($this->viewPath[$view]))
			{
				if($arguments >= 1)
			    	// extract variables into local scope
			    	extract($arguments);
				
				if($includeHeader)
			    	// get header
			    	$html .= file_get_contents($this->viewPath["header"]);
				
			    // get template
			    $html .= file_get_contents($this->viewPath[$view]);
			
				foreach($arguments as $argument)
				{
					$html = str_replace("#" . $argument["key"] . "#", $argument["value"], $html);				
				}
				
				if($includeFooter)
			    	// get footer
			    	$html .= file_get_contents($this->viewPath["footer"]);
			}			
			// else err
			else
			{
			    trigger_error("Invalid View: $view", E_USER_ERROR);
			}
			
			return $html;
						
		}
		
		/* MakeViewArgument($key, $value)
		 *
		 * Simple model static function to create an array[key][value]
		 * used for passing arguments to renderViewHtml
		 */
		public static function MakeViewArgument($key, $value)
		{
			return array(
				"key"   => $key, 
				"value" => $value			
			); 
		}
		
		
	}
?>
<?php
class modules_pdfreports {

	/**
	 * @brief The base URL to the datepicker module.  This will be correct whether it is in the 
	 * application modules directory or the xataface modules directory.
	 *
	 * @see getBaseURL()
	 */
	private $baseURL = null;
	/**
	 * @brief Returns the base URL to this module's directory.  Useful for including
	 * Javascripts and CSS.
	 *
	 */
	public function getBaseURL(){
		if ( !isset($this->baseURL) ){
			$this->baseURL = Dataface_ModuleTool::getInstance()->getModuleURL(__FILE__);
		}
		return $this->baseURL;
	}
	
	public function addPaths(){
		Dataface_JavascriptTool::getInstance()->addPath(dirname(__FILE__).'/js', $this->getBaseURL().'/js');
		Dataface_CSSTool::getInstance()->addPath(dirname(__FILE__).'/css', $this->getBaseURL().'/css');
	}
	
	
	
	public function __construct(){
		Dataface_Table::setBasePath('xf_pdfreports_reports', dirname(__FILE__));
		Dataface_Application::getInstance()->addHeadContent('<script> XATAFACE_MODULES_PDFREPORTS_URL='.json_encode($this->getBaseURL()).';</script>');
		// This module requires the html reports module for some components
		$htmlReports = Dataface_ModuleTool::getInstance()->loadModule('modules_htmlreports');
		if ( PEAR::isError($htmlReports) ){
			throw new Exception("The PDF Reports Module requires the HTML reports module to be installed.  Please either disable the PDF reports module, or install the HTML reports module.  You can find out more about the htmlreports module at http://xataface.com/dox/modules/htmlreports/latest");
			
		}

		
		
		
	}
}
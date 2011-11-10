<?php
class actions_pdfreports_pdfeditor_demo {
	function handle($params){
		$mod = Dataface_ModuleTool::getInstance()->loadModule('modules_pdfreports');
		$hmod = Dataface_ModuleTool::getInstance()->loadModule('modules_htmlreports');
		$hmod->addPaths(); // Add javascript and CSS paths for htmlreports
		$mod->addPaths();  // Add javascript and CSS paths for pdfreports
		$jt = Dataface_JavascriptTool::getInstance();
		$jt->import('xataface/modules/pdfreports/pdfeditor-demo.js');
		
		Dataface_Application::getInstance()
			->addHeadContent('<script>XF_PDF_REPORTS_URL='.json_encode(df_absolute_url($mod->getBaseURL())).';</script>');
		
		df_register_skin('pdfreports', dirname(__FILE__).'/../templates');
		df_display(array(), 'xataface/modules/pdfreports/pdfeditor-demo.html');
	}

}
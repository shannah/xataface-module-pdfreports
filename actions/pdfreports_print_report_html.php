<?php
class actions_pdfreports_print_report_html {

	function handle($params){
		session_write_close();
		header('Connection:close');
		$app = Dataface_Application::getInstance();
		
		$query = $app->getQuery();
		if ( !@$query['--templateContent'] ){
			
			if ( @$query['--report-id'] ){
			
				$report = df_get_record('xf_pdfreports_reports', array('report_id'=>'='.$query['--report-id']));
				if ( !$report ){
					throw new Exception("Could not find report with id specified");
				}
				$query['--templateContent'] = $report->val('report_template');
			} else if ( @$query['--report-name'] ){
				$report = df_get_record('xf_pdfreports_reports', array('action_name'=>'='.$query['--report-name']));
				if ( !$report ){
					throw new Exception("Could not find report with name specified");
				}
				$query['--templateContent'] = $report->val('report_template');
			
			}
			
			
		}
		
		if ( !@$query['--templateContent'] ){
			throw new Exception("No report template provided");
		}
		
		$template = $query['--templateContent'];
		
		$records = df_get_selected_records($query);
		if ( !$records ){
			$records = df_get_records_array($query['-table'], $query);
		}
		if ( !$records ) throw new Exception("No records found to run report with.");
		
		import('modules/pdfreports/inc/XFPDFReportRenderer.php');
		$renderer = new XFPDFReportRenderer($records, $template);
		$html = $renderer->toHtml();
		
		$mod = Dataface_ModuleTool::getInstance()->loadModule('modules_pdfreports');
		$jt = Dataface_JavascriptTool::getInstance();
		$jt->addPath(dirname(__FILE__).'/../js', $mod->getBaseURL().'/js');
		
		$ct = Dataface_CSSTool::getInstance();
		$ct->addPath(dirname(__FILE__).'/../css', $mod->getBaseURL().'/css');
		
		$jt->import('xataface/modules/pdfreports/pdfreports_print_report_html.js');
		
		Dataface_Application::getInstance()
			->addHeadContent('<script>XF_PDF_REPORTS_URL='.json_encode(df_absolute_url($mod->getBaseURL())).';</script>');
		
		df_register_skin('pdfreports', dirname(__FILE__).'/../templates');
		df_display(array('reportHtml'=>$html), 'xataface/modules/pdfreports/pdfreports_print_report_html.html');
		
	}
}
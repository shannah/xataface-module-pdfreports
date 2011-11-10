<?php
class actions_pdfreports_jquery_pdf {

	function handle($params){
		session_write_close();
		$app = Dataface_Application::getInstance();
		$query = $app->getQuery();
		if ( @$query['report_id'] ){
		
				
			
			//echo "Report ID passed";exit;
			$report = df_get_record('xf_pdfreports_reports', array('report_id'=>'='.$query['report_id']));
			if ( !$report ){
				throw new Exception("Could not find report with specified report id.");
			}
			if ( !$report->checkPermission('view') ){
				throw new Exception("Permission denied");
			}
			
			$res = mysql_query("select background_pdf from xf_pdfreports_reports where report_id='".addslashes($query['report_id'])."' limit 1", df_db());
			if ( !$res ) throw new Exception(mysql_error(df_db()));
			
			$temp = tempnam(sys_get_temp_dir(), 'pdfreports_jquery_');
			file_put_contents($temp, mysql_result($res,0));
			@mysql_free_result($res);
			$_REQUEST['--template'] = $_GET['--template'] = $query['--template'] = $temp;
		}
			
		
		
		include 'modules/pdfreports/jquery-pdf/jquery.pdf.php';
		
		if ( @$query['report_id']){
			@unlink($temp);
		}
		
		
		
	}
}
<?php
class tables_xf_pdfreports_reports {
	
	function valuelist__tablenames(){
		return Dataface_Table
			::loadTable('dataface__htmlreports_reports')
				->getValuelist('tablenames');
		
	}
	
	
	function valuelist__action_categories(){
		return Dataface_Table
			::loadTable('dataface__htmlreports_reports')
				->getValuelist('action_categories');
	}
	
	function valuelist__action_permissions(){
		return Dataface_Table
			::loadTable('dataface__htmlreports_reports')
				->getValuelist('action_permissions');
	
	}
}
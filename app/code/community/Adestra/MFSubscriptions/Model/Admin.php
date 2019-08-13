<?php
/*
* Adestra_MFSubscriptions_Model
*/

class Adestra_MFSubscriptions_Model_Admin extends Mage_Core_Model_Config_Data {

   	public function _afterSave() {
		
		
		$html = '<pre>';
		$html = var_export($_POST,TRUE);
		$html .= '<pre>';
		Mage::getSingleton('adminhtml/session')->addNotice('This is my error message.'.$html);
 	
		return parent::_afterSave();
	}
			
} 
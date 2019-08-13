<?php

class Adestra_MFSubscriptions_Model_Adminhtml_Validate {


	public function mfApiCheck(Varien_Event_Observer $observer) {
		
		// Adestra login details and return workspace name for core tale ID.
		
		$event = $observer->getEvent();		 
		if (isset($_POST['config_state']['adestra_mfsubscriptions'])) {
			
			$config = array('enabled');
			$config = Mage::helper('mfsubscriptions')->getConfigData($config);
			if($config['enabled']) {
			
				$core_table = Mage::helper('mfsubscriptions')->adestra_get_core_table();
				if ($core_table['id']) {				
					Mage::getSingleton('adminhtml/session')->addNotice('Successfully connected to MessageFocus: '.$core_table['name']);
				}
			
			}
			
		}
		
		
	}
	
}
	

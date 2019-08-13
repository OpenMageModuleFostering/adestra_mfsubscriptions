<?php

class Adestra_MFSubscriptions_Model_Adminhtml_Customer_Edit {


	public function saveCustomer(Varien_Event_Observer $observer) {
		
		// Save customer check/update Adestra MF email subscriptions.
					Mage::Log('OLD: '.__FUNCTION__);

//		$event = $observer->getEvent();	
//		if (Mage::getStoreConfig('adestra/mfsubscriptions/enabled')) {
//			//if (isset($_POST['subscription_lists'])) {
//				
//				$customer = Mage::registry('current_customer');
//				$contact_id = Mage::helper('mfsubscriptions')->updateMFContact($customer->getId()); // create or update contact
//				
//				// Contact exists.
//				if (isset($contact_id)) {					
//					
//					//$subscribed_lists = Mage::helper('mfsubscriptions')->adestra_fetch_contact_lists($contact['id']);
//					$subscribed_to_lists = array();						
//					$unsubscribe_from_lists = array();	
//					$unsub_lists = array();
//					if (isset($_POST['subscription_lists'])) {
//						foreach($_POST['subscription_lists'] as $key => $value) {	
//							$subscribed_to_lists[] = $key;
//						}
//					}
//
//					$collection = Mage::getResourceModel('mfsubscriptions/lists_collection')
//								  ->addFieldToFilter('scope_id',$customer->getWebsiteId())
//								  ->addFieldToFilter('status',1);
//					
//					foreach($collection as $list) {
//						if (in_array($list->getListId(),$subscribed_to_lists) !== TRUE) {
//							$unsubscribe_from_lists[] = $list->getListId();
//						}
//						if ($list->getUnsubListId()) $unsub_lists[] = $list->getUnsubListId();
//					}
//					
//					// Subscribe user to lists
//					if (!empty($subscribed_to_lists)) {
//						Mage::helper('mfsubscriptions')->adestra_subscribe_contact_multiple($contact_id,$subscribed_to_lists, $unsub_lists);
//					}
//					
//					// Unsubscribe user from lists
//					if (!empty($unsubscribe_from_lists)) {
//						Mage::helper('mfsubscriptions')->adestra_unsubscribe_contact_multiple($contact_id,$unsubscribe_from_lists, $unsub_lists);
//					}
//													  
//				}								
//			//}
//		 
//		}		
		
	}
	
}

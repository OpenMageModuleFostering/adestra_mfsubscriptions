<?php


class Adestra_MFSubscriptions_Model_Customer_Observer {
	
	
	public function saveCustomer(Varien_Event_Observer $observer) {
		
		// Save customer: check/update Adestra MF subscription account.		
		if (Mage::getStoreConfig('adestra/mfsubscriptions/enabled')) {
			$post_data = Mage::app()->getRequest()->getPost();			
						
			//$customer = Mage::registry('current_customer');
			$customer = $observer->getEvent()->getCustomer();
			$contact_id = Mage::helper('mfsubscriptions')->updateMFContact($customer->getId()); // create or update contact
						
		}
	}
	
	
	public function subscribeCustomer(Varien_Event_Observer $observer) {

		// Save customer: update Adestra MF subscriptions.		
		if (Mage::getStoreConfig('adestra/mfsubscriptions/enabled')) {
			
			$customer = $observer->getEvent()->getCustomer();
			$post_data = Mage::app()->getRequest()->getPost();
			$contact = Mage::helper('mfsubscriptions')->getMFContactFromCustomer($customer);
Mage::Log(__FUNCTION__);

			// Contact exists && subscription lists available.
			if (isset($contact['id']) && isset($post_data['subscription_lists'])) {					
				Mage::helper('mfsubscriptions')->updateMFSubscriptions($contact['id'],$customer, $post_data['subscription_lists']);													  
			}								
			
		}
			
	}

	public function checkoutSubscribeCustomer(Varien_Event_Observer $observer) {

		// Save customer: update Adestra MF subscriptions.		
		if (Mage::getStoreConfig('adestra/mfsubscriptions/enabled')) {
			
			$order = $observer->getEvent()->getOrder();
			$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
			$post_data = Mage::app()->getRequest()->getPost();
			$contact = Mage::helper('mfsubscriptions')->getMFContactFromCustomer($customer);
			
			// Contact exists && subscription lists available.
			if (isset($contact['id']) && isset($post_data['subscription_lists'])) {					
				Mage::helper('mfsubscriptions')->updateMFSubscriptions($contact['id'],$customer, $post_data['subscription_lists']);													  
			}								
			
		}
			
	}	
}
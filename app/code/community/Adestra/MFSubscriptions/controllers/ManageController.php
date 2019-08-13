<?php

class Adestra_MFSubscriptions_ManageController extends Mage_Core_Controller_Front_Action {
	
	public function indexAction() {

		if( !Mage::getSingleton('customer/session')->isLoggedIn() ) {
				Mage::getSingleton('customer/session')->authenticate($this);
				return;
		}
			 
		$this->loadLayout();
		$navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
		if ($navigationBlock) {
			$navigationBlock->setActive('mfsubscriptions/manage/index');
		}
	 
		$this->renderLayout();
	}

	public function saveAction() {

		if( !Mage::getSingleton('customer/session')->isLoggedIn() ) {
				Mage::getSingleton('customer/session')->authenticate($this);
				return;
		}
		
		if ($post_data = $this->getRequest()->getPost()) {
			
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			$contact_id = $post_data['contact_id'];
			if (!isset($post_data['subscription_lists'])) $post_data['subscription_lists'] = array();
			Mage::helper('mfsubscriptions')->updateMFSubscriptions($contact_id, $customer, $post_data['subscription_lists']);	
								
			Mage::getSingleton('core/session')->addNotice('Successfully updated subscription lists.');
			
		}

		$this->_redirect('*/*/index'); 
		return;					
	}

} 


?>
<?php

require_once 'Mage/Checkout/controllers/OnepageController.php';

class Adestra_MFSubscriptions_OnepageController extends Mage_Checkout_OnepageController

{

	/**

     * Rewrite checkout subscriber subscription changes

     */
	 
    /**
     * save checkout billing address
     */
    public function saveBillingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {

			$mf_subscription_data = $this->getRequest()->getPost('mf_subscription_lists', array());
			$mf_subscription_id = $this->getRequest()->getPost('mf_subscription_id');
			$customer = Mage::getSingleton('customer/session')->getCustomer();
			if (isset($mf_subscription_id) && isset($mf_subscription_data)) {					
				Mage::helper('mfsubscriptions')->updateMFSubscriptions($mf_subscription_id,$customer, $mf_subscription_data);													  
			}								
			  
//Mage::Log(__FUNCTION__);
//Mage::Log($mf_subscription_data);

            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            if (isset($data['email'])) {
                $data['email'] = trim($data['email']);
            }
            $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

            if (!isset($result['error'])) {
                /* check quote for virtual */
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

                    $result['allow_sections'] = array('shipping');
                    $result['duplicateBillingInfo'] = 'true';
                } else {
                    $result['goto_section'] = 'shipping';
                }
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
	 

}

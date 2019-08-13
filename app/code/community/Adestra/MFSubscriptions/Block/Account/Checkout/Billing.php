<?php
class Adestra_MFSubscriptions_Block_Account_Checkout_Billing extends Mage_Customer_Block_Account_Dashboard // Mage_Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('mfsubscriptions/checkout/form/billing.phtml');
        parent::__construct();
    }
	

}

?>

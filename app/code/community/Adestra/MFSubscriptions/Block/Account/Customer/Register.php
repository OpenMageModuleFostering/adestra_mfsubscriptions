<?php
class Adestra_MFSubscriptions_Block_Account_Customer_Register extends Mage_Customer_Block_Account_Dashboard // Mage_Core_Block_Template
{

    public function __construct()
    {
        $this->setTemplate('mfsubscriptions/customer/form/register.phtml');
        parent::__construct();
    }
	

}

?>

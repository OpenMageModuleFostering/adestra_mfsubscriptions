<?php
class Adestra_MFSubscriptions_Block_Account_Customer_Subscriptions extends Mage_Customer_Block_Account_Dashboard // Mage_Core_Block_Template
{

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('mfsubscriptions/customer/form/subscriptions.phtml');
    }

    public function getIsSubscribed()
    {
        return $this->getSubscriptionObject()->isSubscribed();
    }

    public function getAction()
    {
        return $this->getUrl('*/*/save');
    }

}

?>
